<?php

class Controller{
	private $User;
	private $LoginView;
	private $LayOutView;
	private $DateTimeView;
	private $MemberHandelingBLL;

	public function __construct($User){
		$this->User = $User;
		$this->LoginView = new LoginView();
		$this->LayOutView = new LayOutView();
		$this->DateTimeView = new DateTimeView();
		$this->MemberHandelingBLL = new MemberHandelingBLL();
		$this->LoginView->InitiateSessionVariables();
	}
	public function doLogin(){
		//Kolla vilken form av post och gör redirect då
		if($this->isUserLoggedIn()){
			$this->OptionsForLoggedIn();
		}
		else if($this->LoginView->checkIfRequestIsFromLoginForm()){
			$this->isUserCorrect();
		}
		$this->LayOutView->render($this->isUserLoggedIn(), $this->LoginView, $this->DateTimeView);
	}

	// returns bool to se if user input matches data username and password when login attempt tried.
	public function isUserCorrect(){
		if($this->LoginView->testRequestType()){
			if($this->MemberHandelingBLL->testUserInput($this->User, $this->createMemberFromUserInput())) {
				$this->LoginView->SetUserToLoggedIn();
				$this->LoginView->DisplayWelcomeMessage();
			}
		}
	}
	//Kolla om användare har är inloggad genom session
	public function isUserLoggedIn(){
		return $this->LoginView->CheckUserLoginStatus();
	}

	public function isUserLogginOut(){
		return $this->LoginView->isLogoutPressed();
	}
	public function createMemberFromUserInput(){
		//Gets user input and password and creates a member from that.
		return new User($this->LoginView->getRequestUserName(), $this->LoginView->getRequestPassword());
	}
	public function OptionsForLoggedIn(){
		$this->isUserLogginOut();
	}
}