<?php

namespace Controllers;

use Models\UsersManager;

class LoginController extends Controller
{
	/**
	 * Show a view
	 * Index, Default controller's method 
	 */
	public function index()
	{
		if (isset($this->session()['auth'])) { //If the user already have an auth token, we redirect him to the dashboard
			header("Location: dashboard.php");
			die();
		}
		$token = hash_hmac("sha256", "tralala", $this->getToken()); //We send the token in the login form (CSRF)
		$this->view('login.php', [
			'token' => $token,
		]);
	}

	public function notFound() //If Controller.php do not find the view we redirect  it on a custom 404
	{
		$this->view('404.php', []);
	}

	public function login($data)
	{
		if (!$this->csrfCheck($data['token'])) { //If the token we sent to the form is not the same that the user, we kick him out
			header("Location:index.php");
			die();
		}

		$f_mail = filter_var(trim($data['mail']), FILTER_VALIDATE_EMAIL); //We check if the mail is valid (return the mail if valid, else return false)
		if ($f_mail) {
			$um = new UsersManager();
			$user = $um->getOneByMail($f_mail); //If the mail is valid we get the user info corresponding to the mail

			if ($user !== null) { //If the user exist
				if (!$this->isDisabled($user)) { //We check if the account is disabled
					$this->view('login.php', [
						'error' => "Your account is disabled"
					]);
					die();
				}
				if (!password_verify($data['password'], $user->getPassword())) { //If the passwords do not match
					$this->view('login.php', [
						'error' => "Login error"
					]);
					die();
				} else { //If the user password match, we save the user in the session and we set auth to true
					$this->session("id", $user->getId());
					$this->session('user', $user);
					$this->session('auth', true);
					header("Location:dashboard.php");
					die();
				}
			} else { //If no user exist with the mail
				$this->view('login.php', [
					'error' => "This email does not match any account on this website"
				]);
				die();
			}
		} else { //If the mail is not valid
			$this->view('login.php', [
				'error' => "You must enter a valid email"
			]);
		}
	}

	public function showRegister() //Redirect to the register page with a token
	{
		$token = $this->session()['token'];
		$this->view('register.php', [
			"token" => $token,
		]);
	}

	public function showReset()
	{
		$this->view('resetPassword.php', []);
	}

	public function register($data)
	{
		if (!$this->csrfCheck($this->session()["token"])) { //If the token we sent to the form is not the same that the user, we kick him out
			
			$this->view('register.php', [
				'error' => "Problem CSRF",
				"token" => $this->session()["token"],
				"pseudo" => $data["pseudo"] ?? null,
				"mail" => $data["mail"] ?? null,
			]);
			die();
		}
		if (isset($data)) { //if we got data from the form

			$f_username = trim(filter_var($data["pseudo"], FILTER_SANITIZE_SPECIAL_CHARS));
			$f_mail = trim(filter_var($data['mail'], FILTER_VALIDATE_EMAIL));
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
					"token" => $this->session()["token"],
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
		if ($mail != "") {
			$user = $um->getOneByMail($mail);
			if ($user) {
				$newpass = $this->generatePassword();
				$hashPass = password_hash($newpass, PASSWORD_ARGON2I);
				if ($this->sendPassMail($mail, $newpass)) {
					$um->updatePassword($user->getId(), $hashPass);
					$this->view('login.php', [
						'success' => "Vous allez reçevoir un nouveau mot de passe sur votre boite mail",
					]);
				} else {
					$this->view('resetPassword.php', [
						'error' => "Un problème est survenu lors de l'envoi du mail",
					]);
				}
			} else {
				$this->view('resetPassword.php', [
					'error' => "Désolé, cet email n'est pas lié à un compte utilisateur",
				]);
			}
		} else {
			$this->view('resetPassword.php', [
				'error' => "Veuillez entrer un email",
			]);
		}
	}

	public function generatePassword()
	{
		$keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$pass = '';
		$max = strlen($keyspace) - 1;
		for ($i = 0; $i < 12; ++$i) {
			$pass .= $keyspace[random_int(0, $max)];
		}
		return $pass;
	}

	public function sendPassMail($mail, $pass)
	{
		$to_email = $mail;
		$subject = "TPlanner : Votre nouveau mot de passe";
		$message = '<html><body>' .
			'<h2 style="color:#f40;">Votre nouveau mot de passe TPlanner!</h1>' .
			"Voici votre nouveau mot de passe généré aléatoirement : <strong>$pass</strong>" .
			'</body></html>';
		$headers = "From: admin@thomas-roess.fr" . "\r\n" .
			"Reply-To: admin@thomas-roess.fr\r\n" .
			"X-Mailer: PHP/" . phpversion() . "\r\n" .
			"Content-type: text/html\r\n";

		return mail($to_email, $subject, $message, $headers);
	}
}
