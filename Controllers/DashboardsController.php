<?php

namespace Controllers;

use Models\BoardsManager;

class DashboardsController extends Controller
{
	/**
	 * DashboardsController constructor.
	 */
	public function __construct() // check if the user is connected
	{
		$this->authRequired();
	}

	/**
	 * Show dashboard view
	 */
	public function index()
	{
		$this->view('dashboard.php', [
			'user' => $_SESSION['user'],
		]);
	}
	/**
	* Create a new board
	*
	* @param int $id ID if the user
	* @param string $text Board title
	* @return bool
	*/
	public function add($text, $id)
	{
		$f_text = trim($text);
		$bm = new BoardsManager();
		return $bm->addBoard($f_text, $id);
	}
}
