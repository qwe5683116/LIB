<?php

class AdminController{

	//一个对称加密(对称加密使用同一套密码加密解密 非对称加密一般来讲使用公钥加密使用私钥解密)
	function crypt(){

		//该方法显示支持的算法
		//$arr = openssl_get_cipher_methods();

		//加密算法类型
		$encryptMethod = 'aes-256-cbc';
		//加密明文
		$data = 'Hello World';
		//生成加密向量
		$ivLength = openssl_cipher_iv_length($encryptMethod);
		$iv = openssl_random_pseudo_bytes($ivLength, $isStrong);
		//加密解密的秘钥
		$key = 'master';

		if (false === $iv && false === $isStrong) {
				die('IV generate failed');
		}
		//加密
		$encrypted = openssl_encrypt($data, $encryptMethod, $key, 0, $iv);
		//解密
		$decrypted = openssl_decrypt($encrypted, $encryptMethod, $key, 0, $iv);

		echo $decrypted;
	}

	



}