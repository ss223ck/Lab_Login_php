<?php

class MemberHandelingBLL {
	
	public function testUserInput($User, $UserInputValues){
		if( 
			$User->getUserName() === $UserInputValues->getUserName() &&
			$User->getPassword() === $UserInputValues->getPassword()) {
			return true;
		}
		return false;
	}
}