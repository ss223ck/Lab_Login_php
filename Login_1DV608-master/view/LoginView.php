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
			if($_SERVER['REQUEST_METHOD'] == 'POST' && !$this->getRequestView()) {
				if($this->getRequestUserName() === "") {
					$message = 'Username is missing';
				} else if($this->getRequestPassword() === "") {
					$message = 'Password is missing';
				} else {
					$message = 'Wrong name or password';
				}
			}
			$response = $this->generateLoginFormHTML($message);
		}
		else if ($isLoggedIn){
			$message = 'Welcome';
			$response = $this->generateLogoutButtonHTML($message);
			$_SESSION["LoggedIn"] = "true";
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
		if($_SERVER['REQUEST_METHOD'] == 'POST' && !$this->getRequestView())
			return $_REQUEST[self::$name];
		else
			return "";
	}
	public function getRequestPassword() {
		return $_REQUEST[self::$password];
	}
	public function getRequestView(){
		if(array_key_exists(self::$logout, $_REQUEST))
			return true;
		return false;
	}

	public function testUserInput($User){
		if($_SERVER['REQUEST_METHOD'] == 'POST' &&
			!$this->getRequestView() &&
			$this->getRequestUserName() === $User->getUserName() &&
			$this->getRequestPassword() === $User->getPassword()) {
			return true;
		} else if(isset($_SESSION["PHPSESSID"])) {
			return true;
		}
		return false;
	}

	//Skapa metoder som anvgör response eller skapar medelande
}