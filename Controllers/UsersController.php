<?php

namespace Controllers;

use Models\UsersManager;


class UsersController extends Controller
{
	/**
	 * UsersController constructor.
	 */
	public function __construct() // check if the user is connected then check if the user is an admin
	{
		$this->authRequired();
	}

	/**
	 * Show a user profil, only admin can see other users profile 
	 * @param int $id User's ID
	 * @return void
	 */
	public function index($id = null) //Check the profil of the user or any other user if he is admin
	{
		$um = new UsersManager();
		$id = $this->isAuthorised() ? ($id ? $id : null) : null; //$id only exist if the user is an admin, we also check if the admin check it's own profile from the menu
		$user = $id ? $um->getOneById($id) : $this->session()['user']; //If the id is null, it means the user check his own profile

		$this->view('user.php', [
			'user' => $user,
			"token" => $this->session()["token"],
		]);
	}

	/**
	 * Update a user's username
	 * @param int $id User's ID
	 * @param string $name New username
	 * @return void
	 */
	public function updateUsername($id, $name)
	{
		$id = $this->isAuthorised() ? $id : null;
		$f_name = trim($name);
		if ($f_name == "") { //Will trigger only if JS failed for some reason
			$this->view('user.php', [
				'error' => "Le nom ne peux pas être vide",
				'user' => $this->session()['user']
			]);
			die();
		} else {
			if (strlen($f_name) > 50) {
				$this->view('user.php', [
					'error' => "Le nom ne peux pas être dépasser 50 charactères",
					'user' => $this->session()['user']
				]);
				die();
			}
		}
		$idUser = $id ? $id : $this->session()['user']->getId(); //if the id is null we take it from the session
		$um = new UsersManager();

		if ($um->updateUsername($idUser, $f_name)) {
			$id ? null : $this->session()['user']->setUsername($f_name);
			$this->view('user.php', [
				'success' => "Le nom à bien été modifié",
				'user' => $this->session()['user']
			]);
			die();
		}
	}

	/**
	 * Update user's Color
	 * @param int $id User ID
	 * @param string $color New color, hexa format
	 * 
	 * @return void
	 */
	public function updateColor($id, $color) // Function that update the color
	{
		$id = $this->isAuthorised() ? $id : null;
		$idUser = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();
		$um->updateColor($idUser, $color) 
		? ($id 
			? null
			: $this->session()['user']->setColor($color)) 
		: null;
	}

	/**
	 * Update user's Password
	 * @param int $id User ID
	 * @param string $pass Old password
	 * @param string $nPass1 New password
	 * @param string $nPass2 New password double check
	 * 
	 * @return void
	 */
	public function updatePassword($id, $pass, $nPass1, $nPass2)
	{
		$id = $this->isAuthorised() ? $id : null;
		$idUser = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();

		if (!$this->csrfCheck($this->session()["token"])) { //we make sure that the CSRF token is okay
			$this->view('index.php', [
				'error' => "CSRF ERROR",
				'user' => $this->session()['user']
			]);
			die();
		}

		if (password_verify($pass, $this->session()['user']->getPassword())) { //we check if the old password match
			if (strlen($nPass1) < 8 || strlen($nPass2) < 8) {
				$this->view('user.php', [
					'error' => "Password must be at least 8 characters long",
					'user' => $this->session()['user']
				]);
				die();
			} else {
				if ($nPass1 == $nPass2) { //if both password matches we hash them and save them
					$nPass = password_hash($nPass1, PASSWORD_ARGON2I); 
					$um->updatePassword($idUser, $nPass)  //If the password have been successfuly changed in DB, we update it in session
					? ($id 
						? null
						: $this->session()['user']->setPassword($nPass)) 
					: null;

					$this->view('user.php', [
						'success' => "You password has been updated",
						'user' => $this->session()['user']
					]);
					die();
				} else {
					$this->view('user.php', [
						'error' => "Your new passwords do not match",
						'user' => $this->session()['user']
					]);
					die();
				}
			}
		} else {
			$this->view('user.php', [
				'error' => "Your password is incorrect",
				'user' => $this->session()['user']
			]);
			die();
		}
	}

	/**
	 * Disable user account by stripping his "user" role, then logout
	 * @param int $id User ID
	 * 
	 * @return void
	 */
	public function disableAccount($id) //Strip the user from his "user" role, making him unable to log in
	{
		$id = $this->isAuthorised() ? $id : null;
		$idUser = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();
		$role = json_decode($id ? $um->getOneById($id)->getRole() : $this->session()['user']->getRole()); //we get the user roles in an array
		if (array_search("user", $role) !== false) {
			array_splice($role,array_search("user", $role),1); //we remove the role
			if ($um->updateRole($idUser, json_encode($role))) { //we update the new roles
				$id ? null : $this->session()['user']->setRole(json_encode($role)); 
				$lc = new LoginController();
				$id ? null : $lc->logout(); //we force the logout
			}
		}
	}


	/**
	 * Update user email
	 * @param int $id User's ID
	 * @param string $mail User's mail
	 * 
	 * @return void
	 */
	public function updateEmail($id, $mail) //we save the new mail TODO : mail confirmation
	{
		$id = $this->isAuthorised() ? $id : null;
		$f_mail = trim($mail);
		$idUser = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();
		$user = $um->getOneByMail($f_mail);
		if($user){
			$this->view('user.php', [
				'error' => "Cet email est déjà utilisé",
				'user' => $this->session()['user']
			]);
			die();
		}else{
			$um->updateEmail($idUser, $f_mail) ? ($id ? null : $this->session()['user']->setMail($f_mail)) : null; //if the mail is saved in DB we update it in session
		}
		
	}
}
