<?php

namespace Classes;

class Logged
{
	function __construct()
	{
		if(!isset($_SESSION)){
			session_start();
		}
	}
	
	public function setLogged()
	{
		$_SESSION['logged'] = array(
			'logged' => true,
			'expire' => time() + 900 
		);
	}
	
	private function isLogged()
	{
		$logged = false;
		
		if($_SESSION['logged']['logged']){
			$logged = true;
		}
		
		return $logged;
	}
	
	private function isExpired()
	{
		$expired = false;
		
		if(time() > $_SESSION['logged']['expire']){
			$expired = true;
			
		}
		
		$_SESSION['logged']['expire'] += 900;
		
		return $expired;
	}
	
	public function logout()
	{
		unset($_SESSION['logged']);
		$_SESSION['logged'] = array(
				'logged' => false,
				'expire' => 0
		);
	}
	
	public function isValidLogin($redirectTo)
	{
		$valid = true;
		
		if(!$this->isLogged() || $this->isExpired()){
			$valid = false;
			$this->logout();
			header('location:'.$redirectTo);
		}
		
		return $valid;
	}
	
}