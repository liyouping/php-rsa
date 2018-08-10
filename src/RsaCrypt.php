<?php
namespace lyp\rsa;

//PHP错误等级
error_reporting(0);

/**RSA加密解密 单例类
 * Class RsaCrypt
 * @package lyp\rsa
 */
class RsaCrypt
{
    //公钥和私钥的一些配置
    private $options = array();

    //保存单例对象
    private static $_instance;

    /** 私有构造函数，防止外界实例化对象
     * RsaCrypt constructor.
     * @param $options
     * @throws \Exception
     */
    private function __construct($options)
    {
        if(empty($options) || !is_array($options)){
            throw new \Exception('配置不能为空');
        }
        $this->options = $options;
    }

    /**
     * 私有克隆函数，防止外界克隆对象
     */
    private function __clone()
    {
    }

    /** 静态方法 单例统一访问入口
     * @param array $options
     * @return RsaCrypt
     * @throws \Exception
     */
    public static function getInstance($options = array())
    {
        if(is_null(self::$_instance) || !isset(self::$_instance)) {
            self::$_instance = new self($options);
        }
        return self::$_instance;
    }

    /**获取私钥内容
     * @return mixed
     * @throws \Exception
     */
    private function getPrivateKey()
    {
        if(empty($this->options['private_key'])){
            throw new \Exception('私钥为空');
        }
        extension_loaded('openssl') or die('php需要openssl扩展支持');
        return $this->options['private_key'];
    }

    /** 获取公钥内容
     * @return mixed
     * @throws \Exception
     */
    public function getPublicKey()
    {
        if(empty($this->options['public_key'])){
            throw new \Exception('公钥不能为空');
        }
        extension_loaded('openssl') or die('php需要openssl支持');
        return $this->options['public_key'];
    }

    /** 私钥加密
     * @param string $data 要加密的数据
     * @return bool|string 加密后的字符串
     * @throws \Exception
     */
    public function privateKeyEncode($data)
    {
        $encrypted = '';
        $private_key = openssl_pkey_get_private(self::getPrivateKey());
        try{
            openssl_private_encrypt($data, $encrypted, $private_key); //私钥加密
            return base64_encode($encrypted); //使用base64对加密后的字符串进行编码
        }catch (\Exception $exception){
            return false;
        }
    }

    /** 公钥加密
     * @param string $data 要加密的数据
     * @return bool|string 加密后的字符串
     * @throws \Exception
     */
    public function publicKeyEncode($data)
    {
        $encrypted = '';
        $public_key = openssl_pkey_get_private(self::getPublicKey());
        try{
            openssl_public_encrypt($data, $encrypted, $public_key); //公钥加密
            return base64_encode($encrypted); //使用base64对加密后的字符串进行编码
        }catch (\Exception $exception){
            return false;
        }
    }

    /** 用公钥解密私钥加密内容
     * @param string $data 要解密的数据
     * @return bool|string 解密后的字符串
     * @throws \Exception
     */
    public function decodePrivateEncode($data)
    {
        $decrypted = '';
        $public_key = openssl_pkey_get_public(self::getPublicKey());
        try{
            openssl_public_decrypt(base64_decode($data), $decrypted, $public_key); //私钥加密内容通过公钥可以解密出来
            return $decrypted;
        }catch (\Exception $exception){
            return false;
        }
    }

    /** 用私钥解密公钥加密内容
     * @param string $data 要解密的数据
     * @return bool|string 解密后的数据
     * @throws \Exception
     */
    public function decodePublicEncode($data)
    {
        $decrypted = '';
        $private_key = openssl_pkey_get_private(self::getPrivateKey());
        try{
            openssl_private_decrypt(base64_decode($data), $decrypted, $private_key); //公钥加密内容通过私钥可以解密出来
            return $decrypted;
        }catch (\Exception $exception){
            return false;
        }
    }
}