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
		$this->LayOutView->render($this->testUserInput(), $this->LoginView, $this->DateTimeView);
	}

	// returns bool to se if user input matches data username and password
	public function testUserInput(){
		if($_SERVER['REQUEST_METHOD'] == 'POST' &&
			!$this->LoginView->getRequestView() &&
			$this->LoginView->getRequestUserName() === $this->User->getUserName() &&
			$this->LoginView->getRequestPassword() === $this->User->getPassword()) {
			return true;
		} else if(isset($_SESSION["PHPSESSID"])) {
			return true;
		}
		return false;
	}
	
}