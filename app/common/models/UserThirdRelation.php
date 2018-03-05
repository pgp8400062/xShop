<?php
namespace XShop\Models;

class UserThirdRelation extends \Phalcon\Mvc\Model
{
    //微信通道
    const VIA_WECHAT = 1;

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="relation_id", type="integer", length=11, nullable=false)
     */
    public $relation_id;

    /**
     *
     * @var integer
     * @Column(column="user_id", type="integer", length=10, nullable=false)
     */
    public $user_id;

    /**
     *
     * @var integer
     * @Column(column="third_id", type="integer", length=10, nullable=false)
     */
    public $third_id;

    /**
     *
     * @var integer
     * @Column(column="third_id", type="integer", length=10, nullable=false)
     */
    public $via;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("xShop");
        $this->setSource("user_third_relation");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_third_relation';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserThirdRelation[]|UserThirdRelation|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserThirdRelation|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
