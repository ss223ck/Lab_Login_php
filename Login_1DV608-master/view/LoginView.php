<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $loginStatus = 'LoggedIn';
	

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */

	//Skapa breakout funktioner.
	public function response($isLoggedIn) {
		$message = '';
		$response = '';

		if(!$isLoggedIn){
			if($this->testRequestType() && isset($_POST[self::$login])) {
				$message = $this->testInputValues();
			} else if($this->testRequestType()){
				$message = "Bye bye!";
			}
			$response = $this->generateLoginFormHTML($message);
		}
		else if ($isLoggedIn){
			if($this->testRequestType()){
				$message = "welcome";
			}
			$response = $this->generateLogoutButtonHTML($message);
			$_SESSION[self::$loginStatus] = "true";
		}
		
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. $this->getRequestUserName() .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function getRequestUserName() {
		if($this->testRequestType() && isset($_POST[self::$login]))
			return $_REQUEST[self::$name];
		else
			return "";
	}
	public function getRequestPassword() {
		return $_REQUEST[self::$password];
	}
	//Kolla med session om man är inloggad
	public function getRequestLoggedInStatus(){
		if(!isset($_SESSION[self::$loginStatus])) {
			return false;
		}
		return $_SESSION[self::$loginStatus] == "true";
	}

	public function testUserInput($User){
		if( $this->testRequestType() &&
			$this->getRequestUserName() === $User->getUserName() &&
			$this->getRequestPassword() === $User->getPassword()) {
			return true;
		}
		return false;
	}

	public function testRequestType(){
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}
	//Skapa metoder som anvgör response eller skapar medelande

	public function isLogoutPressed(){
		if(isset($_POST[self::$logout])) {
			$_SESSION[self::$loginStatus] = "false";
		}
		return false;
	}

	public function testInputValues(){
		if($this->getRequestUserName() === "") {
			$message = 'Username is missing';
		} else if($this->getRequestPassword() === "") {
			$message = 'Password is missing';
		} else {
			$message = 'Wrong name or password';
		}
		return $message;
	}
}