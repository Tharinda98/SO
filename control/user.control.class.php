<?php 
session_start();


class UserControl {

	public $querryDAO;

	public $email;
	public $pwd;
	public $field;
	public $error = array();

	public function __construct(){
		$this->querryDAO = new QuerryDAO();
		
	}

	public function setEmailPass($email,$password)
	{
		$this->email = $email;
		$this->pwd = $password;
		//$this->run_user();
	}
	
	//save user sesson and switch related view page
	public function run_user(){
		if ($this->require_validity()) {

			if ($this->can_login()) {

				$result=$this->getResult();
				
				$_SESSION['userId'] = $result['id'];
				$_SESSION['first_name'] = $result['first_name'];
				$_SESSION['designation'] = $result['designation'];
				
				switch ($_SESSION['designation']) {
					case 'transporter':
						header("location: transporter.view.php");
						break;
					case 'so':
						header("location: so.view.php");
						break;
					case 'addmin':
						header("location: addmin.view.php");
						break;
					case 'chashier':
						header("location: cashier.view.php");
						break;
					case 'clerk':
						header('location: clerk.view.php');
						break;
					case 'engineer':
						header('location: engineer.view.php');
						break;
					default:
						header("location:index.php?sessionError=yes");						
						break;
				}
				

			}
			else{
				$err = " Invalid User ";
				return $err;
			}
		}
		else{
			$err =" Plz fill all fields";
			return $err;
		}
	}

	// function for validate user
	public function can_login(){
		$user1 = $this->querryDAO->getUser($this->email,$this->pwd);
		if (!empty($user1)) {
			return true;
		}
		else{
			return $user1;
		}
	}

	// function for check empty fields
	public function require_validity(){
		if (empty($this->email)) {
			return false;
		}
		else if(empty($this->pwd)){
			return false;
		}
		else{
			return true;
		}		
	}


	// get user from data base
	public function getResult(){
		$user2 = $this->querryDAO->getUser($this->email,$this->pwd);
		return $user2;
	}




}//end class