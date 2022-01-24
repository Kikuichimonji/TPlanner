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

	/**
	* Redirect to a custom 404 page
	*/
	public function notFound() //If Controller.php do not find the view we redirect  it on a custom 404
	{
		$this->view('404.php', []);
	}

	/**
	* Check if all login parameters are validn save datas in session, then redirect the user on the dashboard
	*
	* @param array $data POST data from form
	*/	
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
						"token" => $this->session()["token"],
						'error' => "Your account is disabled"
					]);
					die();
				}
				if (!password_verify($data['password'], $user->getPassword())) { //If the passwords do not match
					$this->view('login.php', [
						"token" => $this->session()["token"],
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
					"token" => $this->session()["token"],
					'error' => "This email does not match any account on this website"
				]);
				die();
			}
		} else { //If the mail is not valid
			$this->view('login.php', [
				"token" => $this->session()["token"],
				'error' => "You must enter a valid email"
			]);
		}
	}

	/**
	* Show the register view
	*/
	public function showRegister() //Redirect to the register page with a token
	{
		$token = $this->session()['token'];
		$this->view('register.php', [
			"token" => $token,
		]);
	}

	/**
	* Redirect to the resepPassword view
	*/
	public function showReset()
	{
		$this->view('resetPassword.php', [
			"token" => $this->session()["token"]
		]);
	}

	/**
	* Register the user
	*
	* @param array $data Data table from database
	* @param object $object Object to hydrate
	* @return void
	*/
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

			$f_username = trim(filter_var($data["pseudo"], FILTER_SANITIZE_SPECIAL_CHARS)); //We remove all special chars
			$f_mail = trim(filter_var($data['mail'], FILTER_VALIDATE_EMAIL)); //We check if the email is valid
			$f_password1 = filter_var($data["password"], FILTER_VALIDATE_REGEXP, [  //if the password match the regex
				"options" => array("regexp" => '/[A-Za-z0-9]{8,32}/')
			]);
			$f_password2 = filter_var($data["password2"], FILTER_VALIDATE_REGEXP, [
				"options" => array("regexp" => '/[A-Za-z0-9]{8,32}/')
			]);
			if($f_mail) { //Si le mail est correct
				if ($f_username) { // Si le nom de l'utilisateur n'est pas vide
					if ($f_password1 && $f_password2) { //Si le mot de passe et la vérification ne sont pas vide
						if ($f_password1 === $f_password2) { //Si le mot de passe et la vérification ne sont les mêmes
							$um = new UsersManager();
							$f_password = password_hash($f_password1, PASSWORD_ARGON2I); //We encrypt the password with argon2I
							if (!$um->getOneByMail($f_mail)) { //If a user does not exist
								$um->newUser($f_username, $f_password, $f_mail);
								$user = $um->getOneByMail($f_mail); //If everything does well we add the user to the session and relocate him to the dashboard
								$this->session("id", $user->getId());
								$this->session('user', $user);
								$this->session('auth', true);
								header("Location:dashboard.php");
								die();
							} else {
								$error = "Cet email est déjà utilisé";
							}
						} else {
							$error = "Les mots de passes ne coresspondent pas";
						}
					} else {
						$error = "Le mot de passe n'est pas valide";
					}
				} else {
					$error = "Le pseudo n'est pas valide";
				}
			} else {
				$error = "L'email n'est pas valide";
			}
			if (isset($error)) { //Si une erreur existe, we send him back to the form with the message and old datas
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

	
	/**
	* Logout the user by destroying his SESSION 
	* @return void
	*/
	public function logout() //We redirect the user to the index
	{
		if (isset($this->session()['auth'])) {
			session_destroy();
			header("Location:index.php");
			die();
		}
	}

	/**
	* Reset the user password and send a mail with the new one
	*
	* @param array $data Data table from database
	* @param object $object Object to hydrate
	* @return void
	*/
	public function resetPassword($mail)
	{
		$um = new UsersManager();
		if (trim($mail) != "") { //if the mail is not empty
			$user = $um->getOneByMail($mail);
			if ($user) { //if the user exist
				$newpass = $this->generatePassword(); // We generate a random password
				$hashPass = password_hash($newpass, PASSWORD_ARGON2I); 
				if ($this->sendPassMail($mail, $newpass)) { //if the mail is successfully sent
					$um->updatePassword($user->getId(), $hashPass); //we save the new password in the db
					$this->view('login.php', [
						"token" => $this->session()["token"],
						'success' => "Vous allez reçevoir un nouveau mot de passe sur votre boite mail",
					]);
				} else {
					$this->view('resetPassword.php', [
						"token" => $this->session()["token"],
						'error' => "Un problème est survenu lors de l'envoi du mail",
					]);
				}
			} else {
				$this->view('resetPassword.php', [
					"token" => $this->session()["token"],
					'error' => "Désolé, cet email n'est pas lié à un compte utilisateur",
				]);
			}
		} else {
			$this->view('resetPassword.php', [
				"token" => $this->session()["token"],
				'error' => "Veuillez entrer un email",
			]);
		}
	}

	public function generatePassword() //Random password generator (found on stack overflow)
	{
		$keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$pass = '';
		$max = strlen($keyspace) - 1;
		for ($i = 0; $i < 12; ++$i) { //I set the new password at 12 char
			$pass .= $keyspace[random_int(0, $max)]; //We take a random char from the list
		}
		return $pass;
	}

	public function sendPassMail($mail, $pass) //Function that send a formated mail with the password
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
