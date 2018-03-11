<?php
namespace XShop\Models;

class Product extends \Phalcon\Mvc\Model
{
    const STATUS_ON = 'ON';
    const STATUS_OFF = 'OFF';

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="product_id", type="integer", length=11, nullable=false)
     */
    public $product_id;

    /**
     *
     * @var integer
     * @Column(column="mall_id", type="integer", length=10, nullable=false)
     */
    public $mall_id;

    /**
     *
     * @var string
     * @Column(column="product_type", type="string", nullable=false)
     */
    public $product_type;

    /**
     *
     * @var string
     * @Column(column="subject", type="string", length=100, nullable=false)
     */
    public $subject;

    /**
     *
     * @var string
     * @Column(column="intro", type="string", length=500, nullable=false)
     */
    public $intro;

    /**
     *
     * @var integer
     * @Column(column="maket_price", type="integer", length=11, nullable=false)
     */
    public $maket_price;

    /**
     *
     * @var integer
     * @Column(column="sale_price", type="integer", length=11, nullable=false)
     */
    public $sale_price;

    /**
     *
     * @var string
     * @Column(column="cover_image", type="string", nullable=false)
     */
    public $cover_image;

    /**
     *
     * @var integer
     * @Column(column="stock", type="integer", length=10, nullable=false)
     */
    public $stock;

    /**
     *
     * @var integer
     * @Column(column="stock_enable", type="integer", length=3, nullable=false)
     */
    public $stock_enable;

    /**
     *
     * @var string
     * @Column(column="status", type="string", nullable=false)
     */
    public $status;

    /**
     *
     * @var string
     * @Column(column="create_at", type="string", nullable=false)
     */
    public $create_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("xShop");
        $this->setSource("product");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'product';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Product[]|Product|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Product|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function isValid()
    {
        return $this->status = self::STATUS_ON;
    }
}
