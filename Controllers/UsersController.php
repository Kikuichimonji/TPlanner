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

		$this->view('user.php', [
			'user' => $user,
		]);
	}

	public function updateUsername($id, $text)
	{
		$f_text = trim($text);
		$id = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();
		$um->updateUsername($id, $f_text);
	}

	public function updatePassword($id, $pass, $nPass1, $nPass2)
	{
		$id = $id ? $id : $this->session()['user']->getId();
		$um = new UsersManager();

		if(password_verify($pass, $this->session()['user']->getPassword())) {
			if(strlen($nPass1) < 8 || strlen($nPass2) < 8){
				$this->view('user.php', [
					'error' => "Password must be at least 8 characters long",
					'user' => $this->session()['user']
				  ]);
				die();
			}else{
				if($nPass1 == $nPass2){
					$nPass = password_hash($nPass1, PASSWORD_ARGON2I);
					$um->updatePassword($id,$nPass);

					$this->view('user.php', [
						'success' => "You password has been updated",
						'user' => $this->session()['user']
					  ]);
					die();
				}else{
					$this->view('user.php', [
						'error' => "Your new passwords do not match",
						'user' => $this->session()['user']
					  ]);
					die();
				}
			}
		}else{
			$this->view('user.php', [
				'error' => "Your password is incorrect",
				'user' => $this->session()['user']
			  ]);
			  die();
		}
	}
}
