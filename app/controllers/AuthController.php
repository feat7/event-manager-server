<?php

namespace app\controllers;

use system\controllers\Controller;
use app\models\User;
use \app\libs\Auth;


/**
* EventController
*/
class AuthController extends Controller
{
	// REST APIs first

	/**
	* Request POST
	*/
	public function register() {
		if($this->isPost()) {
			return $this->registerUser();
		}
		echo json_encode(['success' => false, 'message' => 'Check method type!']);
	}

	public function registerUser()
	{
		$this->startValidator();
		$validate = $this->validator;
		$name = $this->post('name');
		$email = $this->post('email');
		$mobile = $this->post('mobile');
		$password = $this->post('password');


		if($this->isPost())
		{
			//Register user now
			if(!$validate->validate($email, 'required|unique=email')) {
				echo json_encode(['success' => false, 'message' => 'Email already registered']);
				return false;
			}
			if(!$validate->validate($mobile, 'required|unique=mobile')) {
				echo json_encode(['success' => false, 'message' => 'Mobile already registered']);
				return false;
			}
			if($id_card = $this->uploadIdCard()) {
				// Id card uploaded
			} else {
				echo json_encode(['success' => false, 'message' => 'ID Card not uploaded.']);
				return false;
			}

			$userModel = new User;
			$data = [
				'name' => $name,
				'id_card' => $id_card,
				'email' => $email,
				'mobile' => $mobile,
				'password' => password_hash($password, PASSWORD_BCRYPT),
			];
			if($user = $userModel::create($data)) {
				$json = [
					'success' => true,
					'message' => 'Input Validated. User Registered',
					'user' => $user->toArray()
				];
				// Registered! now login
				Auth::login($user);
			} else {
				
				$json = [
					'success' => false,
					'message' => 'Error. Unable to save in database',
				];
			}
			//Return json now
			echo json_encode($json);
		} else {
			echo json_encode(['success' => false, 'message' => 'Validation Error.']);
		}
	}

	/**
	* Request POST
	*/
	public function login() 
	{
		if($this->isPost()) {
			return $this->loginUser();
		}
		echo json_encode(['success' => false, 'message' =>'Check method type!']);
	}


	public function loginUser()
	{
		$validate = new \app\libs\Validation;
		$email = $this->post('email');
		$password = $this->post('password');
		if($this->isPost())
		{
			$user = User::where('email', $email)->first();
			if(!$user) $user = User::where('mobile', $email)->first();
			if($user && password_verify($password, $user->password)) {
				$json = [
					'success' => true,
					'message' => 'Logged in',
					'user' => $user->toArray(),
				];
				Auth::login($user);
	
			} else {
				$json = [
					'success' => false,
					'message' => 'Wrong credentials',
				];	
			}
		} else {
			
			// return view('auth/login.tpl', ['error' => 2, 'message' => 'Wrong Captcha']);
		}
		
		echo json_encode($json);
		//user login logic
	}


	// Image upload

	public function uploadIdCard()
	{
		$target_dir = "UploadedIDCards/";
	    $target_file = $target_dir . basename($_FILES["id_card"]["name"]);
	    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	    $time = time();
	    $target_file = $target_dir.md5($time).".$imageFileType";
	    $uploadOk = 1;
	    $errors = 0;
	    // Check if image file is a actual image or fake image
	    $check = getimagesize($_FILES["id_card"]["tmp_name"]);
	    if($check !== false) {
	        $uploadOk = 1;
	    } else {
	        $uploadOk = 0;
	        $errors++;
	        $message = "Error while uploading. Fake Image.";
	    }
	    // Check if file already exists
	    if (file_exists($target_file)) {
		    $uploadOk = 0;
		    $errors++;
		    $message = "File already exist";
	    }
	    // Check file size
	    if ($_FILES["id_card"]["size"] > 5*1024000) {
		    $uploadOk = 0;
		    $errors++;
		    $message = "Image file too large. (More than 5 Mb)";
	    } 
	    // Allow certain file formats
	    
	    //type to lower case
	    
	    $imageFileType = strtolower($imageFileType);
	    
	    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		    $errors++;
		    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
	    }
	    // Check if $uploadOk is set to 0 by an error
	    if ($uploadOk == 0) {
	    	$errors++;
	        //    echo "Sorry, your file was not uploaded.";
	        // if everything is ok, try to upload file
	    } else {
	    if($errors==0) {
	      if (move_uploaded_file($_FILES["id_card"]["tmp_name"], $target_file)) {
	        return $target_file;
	        } else return false;
	      }  
	    }
	}
}