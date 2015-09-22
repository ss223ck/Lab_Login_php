<?php

class User {
	private $userName = '';
	private $password = '';

	public function __construct($username, $password){
		$this->userName = $username;
		$this->password = $password;
	}

	public function getUserName(){
		return $this->userName;
	}

	public function getPassword(){
		return $this->password;
	}
}