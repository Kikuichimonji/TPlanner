<?php

namespace Controllers;

use Models\UsersManager;


class UsersController extends Controller
{
	/**
	 * HomeController constructor.
	 */
	public function __construct()
	{
		// Vérifie si l'utilisateur est connecté sinon redirection
		$this->authRequired();
	}

	/**
	 * Affiche une vue.
	 * "index" (convention d'écriture) Méthode par défaut d'appel d'un controleur
	 */
	public function index($id = null)
	{
		$um = new UsersManager();
		$id = $this->isAuthorised() ? ($id ? $id : $_SESSION['user']->getId()) : $_SESSION['user']->getId(); //$id only exist if the user is an admin, we also check if the admin check it's profile from the menu
		//dd($id);
		$user = $um->getOneById($id);

		$token = hash_hmac("sha256", "tralala", $this->getToken());
		$this->view('user.php', [
			'user' => $user,
			"token" => $token,
		]);
	}

	public function updateUsername($id, $name)
	{
		$f_name = trim($name);
		$id = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();
		$um->updateUsername($id, $f_name) ? $this->session()['user']->setUsername($f_name) : null;
	}

	public function updateColor($id, $color)
	{
		$id = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();
		$um->updateColor($id, $color) ? $this->session()['user']->setColor($color) : null;
	}

	public function updatePassword($id, $pass, $nPass1, $nPass2, $token)
	{
		$id = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();

		if (!$this->csrfCheck($token)) {
			$this->view('index.php', [
				'error' => "WSRF ERROR",
				'user' => $this->session()['user']
			]);
			die();
		}

		if (password_verify($pass, $this->session()['user']->getPassword())) {
			if (strlen($nPass1) < 8 || strlen($nPass2) < 8) {
				$this->view('user.php', [
					'error' => "Password must be at least 8 characters long",
					'user' => $this->session()['user']
				]);
				die();
			} else {
				if ($nPass1 == $nPass2) {
					$nPass = password_hash($nPass1, PASSWORD_ARGON2I);
					$um->updatePassword($id, $nPass);

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

	public function disableAccount($id)
	{
		$id = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();
		$role = json_decode($this->session()['user']->getRole());
		if(array_search("user",$role) !== false){
			unset($role[array_search("user",$role)]) ;
			if($um->updateRole($id,json_encode($role))){
				$this->session()['user']->setRole(json_encode($role));
				$this->view('user.php', [
					'error' => "Your password is incorrect",
					'user' => $this->session()['user']
				]);
			} 
		}
	}

	public function updateEmail($id, $mail)
	{
		$f_mail = trim($mail);
		$id = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();
		$um->updateEmail($id, $f_mail) ? $this->session()['user']->setMail($f_mail) : null;
	}
}
