<?php
/**
 * Created by PhpStorm.
 * User: russ
 * Date: 14.02.16
 * Time: 12:39 PM
 */

namespace SV\Parser;

use Symfony\Component\DomCrawler\Crawler;
use SV\Model\Product;

class FocusCameraParser extends BaseParser
{
    const CATEGORY_BASE_URL = 'http://www.focuscamera.com/catalog/seo_sitemap/category/?p=';

    const SEL_TOTAL_PAGES = 'div.pager > div.pages > ol > li > a.last';
    const SEL_CATEGORIES = 'ul.sitemap > li';
    const SEL_PRICE = [
        'div.price-box > span.price',
        'div.price-box > span.regular-price > span.price',
    ];
    const SEL_PRODUCT_PAGES = 'div.pager > div.pages > ol > li > a.last';
    const SEL_PRODUCT_INFO = 'ul.productlist > li.item > div.product-info';
    const SEL_PRODUCT_NAME = 'h2.product-name > a';
    const SEL_PRODUCT_MPU = 'div.ratings_bazaar > div';

    protected function getCategoriesPageCount(): int
    {
        $this->screen('Getting category page count');
        $crawler = $this->goutteClient->request('GET', self::CATEGORY_BASE_URL . '1');
        return (int) $crawler->filter(self::SEL_TOTAL_PAGES)->text();
    }

    protected function getCategoryUrls(int $categoryCount): array
    {
        $categoryUrls = [];
        foreach (range(1, $categoryCount) as $pageNumber) {
            $categoryUrl = self::CATEGORY_BASE_URL . $pageNumber;
            $crawler = $this->goutteClient->request('GET', $categoryUrl);
            $this->screen('Parsing categories page', $pageNumber);
            $crawler->filter(self::SEL_CATEGORIES)->each(function (Crawler $node) use (&$categoryUrls) {
                $categoryNode = $node->filter('a');
                $href = $categoryNode->attr('href');
                $categoryUrls[] = $href;
            });
        }
        return $categoryUrls;
    }

    public function getProducts(array $categoryUrls): \ArrayObject
    {
        $products = new \ArrayObject();

        foreach ($categoryUrls as $url) {
            $this->screen('Parsing product page', $url);
            $crawler = $this->goutteClient->request('GET', $url);

            $productPagesCount = 1;
            $productPagesCountNode = $crawler->filter(self::SEL_PRODUCT_PAGES);
            if ($productPagesCountNode->count() > 0) {
                $productPagesCount = (int)$productPagesCountNode->eq(0)->text();
                $this->screen('Product pages found', $productPagesCountNode->eq(0)->text());
            }
            /** @noinspection AdditionOperationOnArraysInspection */
            $productPages = [0] + array_map(function ($v) {
                    return '?ajax=true&p=' . $v;
                }, range(1, $productPagesCount));

            foreach ($productPages as $productNextPage) {
                if ($productNextPage !== 0) {
                    $nextPage = $url . $productNextPage;
                    $this->screen('Parsing product page', $nextPage);
                    $crawler = $this->goutteClient->request('GET', $nextPage);
                }
                $crawler->filter(self::SEL_PRODUCT_INFO)->each(
                    function (Crawler $node) use ($products) {
                        $prodNameNode = $node->filter(self::SEL_PRODUCT_NAME);
                        $productName = html_entity_decode(trim($prodNameNode->text()));
                        $productBrand = explode(' ', $productName)[0] ?? self::ENTITY_NOT_FOUND;
                        $prodUrl = $prodNameNode->attr('href');
                        $prodPrice = 0;
                        foreach (self::SEL_PRICE as $priceVariantSelector) {
                            $priceNode = $node->filter($priceVariantSelector);
                            if ($priceNode->count() > 0) {
                                $prodPrice = trim($priceNode->text());
                                break;
                            }
                        }
                        $prodMpu = $node->filter(self::SEL_PRODUCT_MPU)->attr('id');
                        $prodMpu = str_replace('BVRRInlineRating-', '', $prodMpu);

                        $product = new Product();
                        $product->setMpu($prodMpu);
                        $product->setBrand($productBrand);
                        $product->setName($productName);
                        $product->setPrice((float) str_replace('$', '', $prodPrice));
                        $product->setUrl($prodUrl);

                        $products->append($product);
                        $this->screen($product->getMpu(), $product->getPrice(), $product->getName());
                    }
                );
            }
        }
        return $products;
    }

    public function run()
    {
        $categoryUrls = $this->getCategoryUrls($this->getCategoriesPageCount());
        $products = $this->getProducts($categoryUrls);
        $this->screen('Total products parsed', $products->count());
    }
}

