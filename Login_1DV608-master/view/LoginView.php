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
	private static $message = 'MessageForOutPut';
	
	public function InitiateSessionVariables(){
			if(!isset($_SESSION[self::$loginStatus])){
				$_SESSION[self::$loginStatus] = false;
			}
			if(!isset($_SESSION[self::$message])){
				$_SESSION[self::$message] = null;
			}
		}



	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	//Skapa breakout funktioner.
	public function response() {
		$message = $this->GenerateOutPutMessage();
		$response = '';
		if($_SESSION[self::$loginStatus] == false ){
			if($this->testRequestType() && array_key_exists(self::$login, $_POST)) {
				$message = $this->testInputValues();
			}
			$response = $this->generateLoginFormHTML($message);
		}
		//generear output om man är inloggad
		else if ($_SESSION[self::$loginStatus]){
			$response = $this->generateLogoutButtonHTML($message);
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
	//need to test if request is post otherwise generateLoginForm tries to get a variable that isnt set
	public function getRequestUserName() {
		if($this->testRequestType() && array_key_exists(self::$login, $_POST))
		{
			return $_REQUEST[self::$name];
		}
		return "";
	}
	public function getRequestPassword() {
		return $_REQUEST[self::$password];
	}
	
	public function testRequestType(){
		return $_SERVER['REQUEST_METHOD'] == 'POST';
	}
	//Skapa metoder som anvgör response eller skapar medelande
	public function isLogoutPressed(){
		if(isset($_POST[self::$logout]) && $_SESSION[self::$loginStatus] == true) {
			$_SESSION[self::$loginStatus] = false;
			$_SESSION[self::$message] = "Bye bye!";
		}
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
	public function SetUserToLoggedIn(){
		$_SESSION[self::$loginStatus] = true;
	}
	public function CheckUserLoginStatus(){
		return $_SESSION[self::$loginStatus];
	}
	
	public function DisplayWelcomeMessage(){
		$_SESSION[self::$message] = "Welcome";
	}
	public function GenerateOutPutMessage(){
		$returnMessage = $_SESSION[self::$message];
		$_SESSION[self::$message] = null;
		return $returnMessage;
	}
	public function checkIfRequestIsFromLoginForm(){
		return isset($_POST[self::$login]);
	}
}