<?php
namespace XShop\Models;

class Cart extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="item_id", type="integer", length=11, nullable=false)
     */
    public $item_id;

    /**
     *
     * @var integer
     * @Column(column="user_id", type="integer", length=11, nullable=false)
     */
    public $user_id;

    /**
     *
     * @var integer
     * @Column(column="mall_id", type="integer", length=11, nullable=false)
     */
    public $mall_id;

    /**
     *
     * @var integer
     * @Column(column="product_id", type="integer", length=11, nullable=false)
     */
    public $product_id;

    /**
     *
     * @var integer
     * @Column(column="sku_id", type="integer", length=11, nullable=false)
     */
    public $sku_id;

    /**
     *
     * @var integer
     * @Column(column="quantity", type="integer", length=11, nullable=false)
     */
    public $quantity;

    /**
     *
     * @var string
     * @Column(column="create_time", type="string", nullable=false)
     */
    public $create_time;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("xShop");
        $this->setSource("cart");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'cart';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cart[]|Cart|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Cart|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
