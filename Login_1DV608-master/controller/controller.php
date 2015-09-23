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

		$this->LayOutView->render($this->isUserCorrect(), $this->LoginView, $this->DateTimeView);
	}

	// returns bool to se if user input matches data username and password
	public function isUserCorrect(){
		$this->testUserInput($this->User),
	}
	public function isUserLoggedIn(){
		return null;
	}
	public function 
}