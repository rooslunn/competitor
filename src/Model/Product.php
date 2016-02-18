<?php
/**
 * Created by PhpStorm.
 * User: russ
 * Date: 17.02.16
 * Time: 3:09 PM
 */

namespace SV\Model;


class Product
{
    /**
     * @var string
     */
    protected $mpu;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var
     */
    protected $brand;

    /**
     * @var double
     */
    protected $price;

    /**
     * @var string
     */
    protected $url;

    /**
     * @return string
     */
    public function getMpu()
    {
        return $this->mpu;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $mpu
     */
    public function setMpu(string $mpu)
    {
        $this->mpu = $mpu;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $brand
     */
    public function setBrand(string $brand)
    {
        $this->brand = $brand;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    public static function createBase(string $mpu, string $brand, string $name): Product
    {
        $product = new self();
        $product->setMpu($mpu);
        $product->setBrand($brand);
        $product->setName($name);
        return $product;
    }
}