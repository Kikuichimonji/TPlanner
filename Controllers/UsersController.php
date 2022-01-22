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
	 * Show a view
	 * Index, Default controller's method 
	 */
	public function index($id = null) //Check the profil of the user or any other user if he is admin
	{
		$um = new UsersManager();
		$id = $this->isAuthorised() ? ($id ? $id : $_SESSION['user']->getId()) : $_SESSION['user']->getId(); //$id only exist if the user is an admin, we also check if the admin check it's own profile from the menu
		$user = $um->getOneById($id);

		$this->view('user.php', [
			'user' => $user,
			"token" => $this->session()["token"],
		]);
	}

	public function updateUsername($id, $name) // Function that update the username to a new one
	{
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
		$id = $id ? $id : $this->session()['user']->getId(); //if the id is null we take it from the session
		$um = new UsersManager();
		if ($um->updateUsername($id, $f_name)) {
			$this->session()['user']->setUsername($f_name);
			$this->view('user.php', [
				'success' => "Le nom à bien été modifié",
				'user' => $this->session()['user']
			]);
			die();
		}
	}

	public function updateColor($id, $color) // Function that update the color
	{
		$id = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();
		$um->updateColor($id, $color) ? $this->session()['user']->setColor($color) : null;
	}

	public function updatePassword($id, $pass, $nPass1, $nPass2)
	{
		$id = $id ? $id : $this->session()['user']->getId();
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
					$um->updatePassword($id, $nPass) ? $this->session()['user']->setPassword($nPass) : null;

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

	public function disableAccount($id) //Strip the user from his "user" role, making him unable to log in
	{
		$id = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();
		$role = json_decode($this->session()['user']->getRole()); //we get the user roles in an array
		if (array_search("user", $role) !== false) {
			array_splice($role,array_search("user", $role),1); //we remove the role
			if ($um->updateRole($id, json_encode($role))) { //we update the new roles
				$this->session()['user']->setRole(json_encode($role)); 
				$lc = new LoginController();
				$lc->logout(); //we force the logout
			}
		}
	}

	public function updateEmail($id, $mail) //we save the new mail TODO : mail confirmation
	{
		$f_mail = trim($mail);
		$id = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();
		$um->updateEmail($id, $f_mail) ? $this->session()['user']->setMail($f_mail) : null;
	}
}
