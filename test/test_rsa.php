<?php

header("Content-type:text/html; charset=utf-8");
require  '../src/RsaCrypt.php';

$options = array(
    'public_key' => '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC/j8Hhgy8YJSeML7XFAaPIOjKB
SryDeHqgH7r78bccRWpq0ORoRChTpiSM/105E42XukKZ4nbiTndMI1C6l/wwF6XQ
SayKaq6Gj/uMBJIxainGmif+isXrjCstpIOejKMOJDZoP3zuBzSAm1TumIx+wObG
d6FHwfIuZZsgXg2MyQIDAQAB
-----END PUBLIC KEY-----',
    'private_key' => '-----BEGIN RSA PRIVATE KEY-----
MIICWwIBAAKBgQC/j8Hhgy8YJSeML7XFAaPIOjKBSryDeHqgH7r78bccRWpq0ORo
RChTpiSM/105E42XukKZ4nbiTndMI1C6l/wwF6XQSayKaq6Gj/uMBJIxainGmif+
isXrjCstpIOejKMOJDZoP3zuBzSAm1TumIx+wObGd6FHwfIuZZsgXg2MyQIDAQAB
AoGAafOBMNH2AkzKiub4inZVuDE4LfrAOZcxe88RBLi0ppZePaY8Ls9D3sBOBw5W
6XK/JeSHYcW4K4NqyFngFNRrTtf0Buku4MbtZNEHzR4Eo1P3X9cLAZZh3tuKInsR
mMzYRBSGfhHlGmq4VFSx8svzoyJZECSBS9Z9dG+x60GiOAECQQD19a1E+maNyJQp
E01meohmRXwsCr1/5K2mlqCe9je3BeKdw8NiwlGn+97YjLjb4bXshTzAe3vL8F9m
TX4iDQ6pAkEAx2GcOtaRi1NcPKtZ3aRkMcAapIDbyQiHTuN+sMYoEwWEtE6xHrK6
F49sDPpxE5MeGhJruzSY4wOYjT32ZNABIQJAY3kVt2Tx3vu0+BvHXN/HlF0byBAb
7cKFfG9EzKVViR7HNPj8Z0+hiKezy662AK97TQnhtRL70VIIsy46Cflv6QJAV7MU
wEC/VlR9fuY0Kiz0MXn5fiB8DIpm0gl5IZKX7/3+aD0w5XriJhjdAzxp3p1YoUk2
/+pb0Yc0Y/Q8XA2uYQJALGqGdBBDdGlAPgRTreY2eoCTqPxKicLTvau/1iTn8k4d
XPk3W5/lIb5FMQP8ZfnT4tJqRxW35qs8cIdk6EqL2A==
-----END RSA PRIVATE KEY-----'
);

//实例化单例类
$rsa = \lyp\rsa\RsaCrypt::getInstance($options);

//原始数据
$data = md5('123456');
echo '原始数据：'.$data . PHP_EOL;

//私钥加密
$encode_data = $rsa->privateKeyEncode($data);
if($encode_data){
    echo '私钥加密后的数据：'. $encode_data . PHP_EOL;
}else{
    echo '私钥加密失败'.PHP_EOL;
}


//公钥解密
$decode_data = $rsa->decodePrivateEncode($encode_data);
if($decode_data){
    echo '公钥解密后的数据：'. $decode_data . PHP_EOL;
}else{
    echo '公钥解密失败'.PHP_EOL;
}

$data = md5('456789');
echo  '================='.PHP_EOL;
echo '原始数据：'.$data . PHP_EOL;
