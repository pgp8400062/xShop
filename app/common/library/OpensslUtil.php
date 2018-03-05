<?php
namespace XShop\Library;

/**
 * openssl的加解密封装
 * Class OpensslUtil
 * @package XShop\Library
 */
class OpensslUtil
{
    const KEY = 'for_enc_!@#YUI';

    /**
     * 加密
     * @param $str
     * @return string
     */
    public static function encrypt($str)
    {
        $str = serialize($str);
        $data['iv']=base64_encode(substr('fdakinel;injajdji',0,16));
        $data['value'] = openssl_encrypt($str, 'AES-256-CBC',self::KEY,0,base64_decode($data['iv']));
        $encrypt = base64_encode(json_encode($data));
        return $encrypt;
    }

    /**
     * 解密
     * @param $encrypt
     * @return mixed
     */
    public static function decrypt($encrypt)
    {
        $encrypt = json_decode(base64_decode($encrypt), true);
        $iv = base64_decode($encrypt['iv']);
        $decrypt = openssl_decrypt($encrypt['value'], 'AES-256-CBC', self::KEY, 0, $iv);
        return unserialize($decrypt);
    }
}