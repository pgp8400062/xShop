<?php
namespace XShop\Models;

class ProductSku extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="sku_id", type="integer", length=11, nullable=false)
     */
    public $sku_id;

    /**
     *
     * @var integer
     * @Column(column="product_id", type="integer", length=10, nullable=false)
     */
    public $product_id;

    /**
     *
     * @var string
     * @Column(column="sku_code", type="string", length=255, nullable=false)
     */
    public $sku_code;

    /**
     *
     * @var integer
     * @Column(column="sale_price", type="integer", length=10, nullable=false)
     */
    public $sale_price;

    /**
     *
     * @var integer
     * @Column(column="stock", type="integer", length=10, nullable=false)
     */
    public $stock;

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
        $this->setSource("product_sku");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'product_sku';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProductSku[]|ProductSku|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ProductSku|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function isValid()
    {
        return true;
    }
}
