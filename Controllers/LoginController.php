<?php

namespace Controllers;

use Models\UsersManager;

class LoginController extends Controller
{
	/**
	 * Affiche une vue.
	 * "index" (convention d'écriture) Méthode par défaut d'appel d'un controleur
	 *
	 * @return void
	 */
	public function index()
	{
		if (isset($this->session()['auth'])) {
			header("Location: dashboard.php");
			die();
		}
		//$this->session();
		//var_dump($this->getToken());die();
		$token = hash_hmac("sha256", "tralala", $this->getToken());
		$this->view('login.php', [
			'test' => 'Mon login !',
			'token' => $token,
		]);
	}

	public function login($data)
	{
		if (!$this->csrfCheck($data['token'])) {
			header("Location:index.php");
			die();
		}

		$f_mail = trim(filter_var($data['mail'], FILTER_SANITIZE_EMAIL));
		if ($f_mail) {
			$um = new UsersManager();
			$user = $um->getOneByMail($f_mail);

			if (!$this->isDisabled($user)) {
				$this->view('login.php', [
					'error' => "Your account is disabled"
				]);
				die();
			}
			if ($user !== null) {
				if (!password_verify($data['password'], $user->getPassword())) {
					$this->view('login.php', [
						'error' => "Login error"
					]);
					die();
				} else {
					$this->session("id", $user->getId());
					$this->session('user', $user);
					$this->session('auth', true);
					header("Location:dashboard.php");
				}
			} else {
				$this->view('login.php', [
					'error' => "Login error"
				]);
				die();
			}
			$this->view('login.php', [
				'error' => "Login error"
			]);
			die();
		}

		//header("Location:dashboard.php");
		/* $this->view('dashboard.php', [
      'test' => 'Mon dasboard !',
      'user' => $this->session('user'),
    ]);*/
	}

	public function showRegister()
	{
		$token = hash_hmac("sha256", "tralala", $this->getToken());
		$this->view('register.php', [
			"token" => $token,
		]);
	}

	public function showReset()
	{
		$this->view('resetPassword.php', [
		]);
	}

	public function register($data)
	{
		$token = hash_hmac("sha256", "tralala", $this->getToken());
		if (isset($data)) {
			//var_dump($data);
			
			$f_username = trim(filter_var($data["pseudo"], FILTER_SANITIZE_SPECIAL_CHARS));
			$f_mail = trim(filter_var($data['mail'], FILTER_SANITIZE_EMAIL));
			$f_password1 = filter_var($data["password"], FILTER_VALIDATE_REGEXP, [
				"options" => array("regexp" => '/[A-Za-z0-9]{8,32}/')
			]);
			$f_password2 = filter_var($data["password2"], FILTER_VALIDATE_REGEXP, [
				"options" => array("regexp" => '/[A-Za-z0-9]{8,32}/')
			]);
			if (filter_var($f_mail, FILTER_VALIDATE_EMAIL)) {
				if ($f_username) {
					if ($f_password1 && $f_password2) {
						if ($f_password1 === $f_password2) {
							$um = new UsersManager();
							$f_password = password_hash($f_password1, PASSWORD_ARGON2I);
							$result = $um->getOneByMail($f_mail);
							if ($result === null) {
								$um->newUser($f_username, $f_password, $f_mail);
								$user = $um->getOneByMail($f_mail);
								$this->session("id", $user->getId());
								$this->session('user', $user);
								$this->session('auth', true);
								header("Location:dashboard.php");
							} else {
								$error = "Cet email est déjà utilisé";
							}
						} else {
							//var_dump($f_password1,$f_password2);die();
							$error = "Password doesn't match";
						}
					} else {
						$error = "Invalid Password";
					}
				} else {
					$error = "Invalid Username";
				}
			} else {
				$error = "Invalid Email";
			}
			if (isset($error)) {
				$this->view('register.php', [
					'error' => $error,
					"token" => $token,
					"pseudo" => $data["pseudo"],
					"mail" => $data["mail"],
				]);
				die();
			}
		}
	}

	public function logout()
	{
		if (isset($this->session()['auth'])) {
			session_destroy();
			header("Location:index.php");
			die();
		}
	}

	public function resetPassword($mail)
	{
		$um = new UsersManager();
		if($mail != ""){
			$user = $um->getOneByMail($mail);
			if($user){
				$newpass = $this->generatePassword();
				$hashPass = password_hash($newpass, PASSWORD_ARGON2I);
				if($this->sendPassMail($mail,$newpass)){
					$um->updatePassword($user->getId(),$hashPass);
					$this->view('login.php', [
						'success' => "Vous allez reçevoir un nouveau mot de passe sur votre boite mail",
					]);
				}else{
					$this->view('resetPassword.php', [
						'error' => "Un problème est survenu lors de l'envoi du mail",
					]);
				}
				
			}else{
				$this->view('resetPassword.php', [
					'error' => "Désolé, cet email n'est pas lié à un compte utilisateur",
				]);
			}
		}else{
			$this->view('resetPassword.php', [
				'error' => "Veuillez entrer un email",
			]);
		}
		
	}

	public function generatePassword() {
		$keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$pass = '';
		$max = strlen($keyspace) - 1;
		for ($i = 0; $i < 12; ++$i) {
			$pass .= $keyspace[random_int(0, $max)];
		}
		return $pass;
	}

	public function sendPassMail($mail,$pass)
	{
		$to_email = $mail;
		$subject = "TPlanner : Votre nouveau mot de passe";
		$message = '<html><body>'.
					'<h1 style="color:#f40;">Votre nouveau mot de passe!</h1>'.
					"Voici votre nouveau mot de passe généré aléatoirement : <strong>$pass</strong>".
					'</body></html>';
		$headers = "From: admin@thomas-roess.fr"."\r\n".
					"Reply-To: admin@thomas-roess.fr\r\n".
					'X-Mailer: PHP/'.phpversion();;

		return mail($to_email,$subject,$message,$headers);
	
	}
}
