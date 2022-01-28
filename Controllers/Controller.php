<?php

namespace Controllers;

class Controller
{
	/**
	 * View folder path
	 */


	/**
	 * Where the user is redirected if not connected
	 */
	const REDIRECT_GUEST = 'login.php';

	/**
	 * Check if the session has been started
	 * @var bool
	 */
	static protected $session = false;

	/**
	 * Check if the user is connected
	 * See isAuth() function under
	 * @var null
	 */
	static protected $isAuth = null;

	/**
	 * Check if the user is an admin
	 * See isAdmin() function under
	 * @var null
	 */
	static protected $isAdmin = null;

	/**
	 * Import a view file
	 *
	 * @param string $fileName
	 * @param array $data Contain datas given throught the controller
	 * @return void
	 */
	protected function view(string $fileName, array $data = []): void
	{
		$filePath = VIEW_PATH . $fileName;

		if (file_exists($filePath)) { // If the file exist we import it, else we import a 404
			require $filePath;
		} else {
			require VIEW_PATH . "404.php"; //Custom 404
		}
	}

	/**
	 * Redirect the user if not connected
	 * @return void
	 */
	protected function authRequired(): void
	{
		if (!$this->isAuth()) {
			header('Location: ' . self::REDIRECT_GUEST . '?err=1');
			exit();
		}
	}
	/**
	 * Redirect the user if not an admin
	 * @return void
	 */
	protected function adminRequired(): void //Same as authRequired, but can be redirected with a custom message for personnalisation
	{
		if (!$this->isAuthorised()) {
			header('Location: ' . self::REDIRECT_GUEST . '?err=1');
			exit();
		}
	}

	/**
	 * Check if the user is an admin through the session data
	 * @return bool
	 */
	protected function isAuthorised()
	{
		return in_array("admin", $this->getCurrentUserRole());
	}

	/**
	 * Check is the user is connecter though the session data
	 * @return bool
	 */
	protected function isAuth()
	{
		return empty(self::$isAuth) //if the variable is not set we check the session and the user ID
			? (self::$isAuth = !empty($this->getCurrentUserId()))
			: self::$isAuth;
	}

	/**
	 * @return int|string|null
	 */
	protected function getCurrentUserId() //Get the id from the user in session
	{
		return $this->session()['id'] ?? null;
	}

	/**
	 * @return array
	 */
	protected function getCurrentUserRole() //Get the roles from the user in session
	{
		return json_decode($this->session()['user']->getRole()) ?? null;
	}

	/**
	 * The function return the instance of $_SESSION
	 * We can use it like $_SESSION
	 * Can also set new values into the session
	 * @return array
	 */
	protected function session($key = null, $value = null)
	{
		if (!self::$session) { //If the session isn't started we start it
			session_start();
			self::$session = true;
		}
		if ($key) { //If we pass paramaters we set them in the session
			$_SESSION[$key] = $value;
		}
		return $_SESSION;
	}

	/**
	 * Generate a CSRF token
	 * @return void
	 */
	protected function setToken() //CSRF Token creation
	{
		if (isset($this->session()["token"])) { //We check if the token already exist
			if ($this->session()["token"] === null) {
				$token = hash_hmac("sha256", "tralala", bin2hex(random_bytes(32)));
				$this->session('token',$token);
				return $token;
			}else{
				return $this->session()["token"];
			}
		} else {
			$token = hash_hmac("sha256", "tralala", bin2hex(random_bytes(32)));
			$this->session('token',$token);
			return $token;
		}
	}

	/**
	 * Get the actual CSRF token of the user
	 * @return string
	 */
	protected function getToken() //CSRF Token recuperation
	{
		if (isset($this->session()["token"])) {
			return $this->session()["token"];
		} else {
			return $this->setToken(); //if the token do not exist yet we create one
		}
	}

	/**
	* Compare form and session token
	*
	* @param string $token The session token
	* @return bool
	*/
	protected function csrfCheck($token) // We check the token between the form and the one in session
	{
		try {
			if (!empty($_POST)) {
				if (isset($_POST['token']) && !hash_equals($_POST['token'], $token)) {
					return false;
				}
				return true;
			}
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}
	/**
	* Check if user account is disabled
	*
	* @param object $user Instance of the user
	* @return bool
	*/
	protected function isDisabled($user) //Check if the user account is disabled (User deleted his own account)
	{
		try {
			if (is_array(json_decode($user->getRole()))) { //The user is considered disabled when his 'user' role is stripped
				return in_array("user", json_decode($user->getRole())); 
			} else {
				return false;
			}
		} catch (\Exception $e) {
			echo $e->getMessage();
			die();
		}
	}
}
