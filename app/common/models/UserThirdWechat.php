<?php
namespace XShop\Models;

class UserThirdWechat extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="third_id", type="integer", length=11, nullable=false)
     */
    public $third_id;

    /**
     *
     * @var string
     * @Column(column="open_id", type="string", length=60, nullable=false)
     */
    public $open_id;

    /**
     *
     * @var string
     * @Column(column="union_id", type="string", length=60, nullable=false)
     */
    public $union_id;

    /**
     *
     * @var string
     * @Column(column="scope", type="string", length=30, nullable=false)
     */
    public $scope;

    /**
     *
     * @var string
     * @Column(column="extra", type="string", nullable=true)
     */
    public $extra;

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
        $this->setSource("user_third_wechat");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user_third_wechat';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserThirdWechat[]|UserThirdWechat|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return UserThirdWechat|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
