<?php

/**
 * Created by PhpStorm.
 * User: zhoulin
 * Date: 2017/3/14
 * Time: 15:08
 * Email: zhoulin@mapgoo.net
 */
class Aes_Xcrypt
{
    private $mothod;
    private $key;
    private $vi;
    private $options = 0;
    private $tag = 'jeemu';

    public function __construct(string $key, string $method = 'AES-128-ECB')
    {
       // var_dump(openssl_get_cipher_methods());
        $this->mothod = $method;
        $this->key = $key;
        $this->vi = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->mothod));
    }


    public function encode(string $str): string
    {
        return openssl_encrypt($str, $this->mothod, $this->key, $this->options, $this->vi);
    }

    public function decode(string $str): string
    {
        return openssl_decrypt($str, $this->mothod, $this->key, $this->options, $this->vi);
    }

    public function getError(): string
    {
        return openssl_error_string();
    }
}