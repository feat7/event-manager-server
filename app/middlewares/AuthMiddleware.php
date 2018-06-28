<?php
namespace app\middlewares;
use \system\middlewares\Middleware;
/**
* 
*/
class AuthMiddleware extends Middleware
{
	public function check()
	{	
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true) {
			return true;
		} else {		
			return false;
		}
	}

	public function isAdmin()
	{
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "Admin" ) {
			return true;
		} else {		
			return false;
		}
	}

	public function isUser()
	{
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true && isset($_SESSION['user_type']) && $_SESSION['user_type'] == "User") {
			return true;
		} else {		
			return false;
		}
	}
}