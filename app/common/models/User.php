<?php
namespace XShop\Models;

class User extends \Phalcon\Mvc\Model
{
    //未知性别
    const GENDER_UNKNOWN = 'UNKNOWN';
    //男性
    const GENDER_MALE = 'MALE';
    //女性
    const GENDER_FEMALE = 'FEMALE';
    //所有性别集合
    const GENDER_ALL = [self::GENDER_UNKNOWN, self::GENDER_FEMALE, self::GENDER_MALE];

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="user_id", type="integer", length=11, nullable=false)
     */
    public $user_id;

    /**
     *
     * @var string
     * @Column(column="nickname", type="string", length=32, nullable=false)
     */
    public $nickname;

    /**
     *
     * @var string
     * @Column(column="gender", type="string", nullable=false)
     */
    public $gender;

    /**
     *
     * @var string
     * @Column(column="phone", type="string", length=11, nullable=false)
     */
    public $phone;

    /**
     *
     * @var string
     * @Column(column="avatar", type="string", length=255, nullable=false)
     */
    public $avatar;

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
        $this->setSource("user");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]|User|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
