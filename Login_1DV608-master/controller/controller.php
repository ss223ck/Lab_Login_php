<?php

class Controller{
	private $User;
	private $LoginView;
	private $LayOutView;
	private $DateTimeView;

	public function __construct($User){
		$this->User = $User;
		$this->LoginView = new LoginView();
		$this->LayOutView = new LayOutView();
		$this->DateTimeView = new DateTimeView();
	}
	public function doLogin(){
		$userLoggedIn = false;
		if( $this->isUserLoggedIn() || $this->isUserLogginOut() || $this->isUserCorrect()) {
			$userLoggedIn = true;
		}
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			echo('något är jävla fel');
		}
		$this->LayOutView->render($userLoggedIn, $this->LoginView, $this->DateTimeView);
	}

	// returns bool to se if user input matches data username and password
	public function isUserCorrect(){
		return $this->LoginView->testUserInput($this->User);
	}
	//Kolla om användare har är inloggad genom session
	public function isUserLoggedIn(){
		return $this->LoginView->getRequestLoggedInStatus();
	}

	public function isUserLogginOut(){
		return $this->LoginView->isLogoutPressed();
	}
}