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
	 * Show a view
	 * Index, Default method of the controller
	 */
	public function index()
	{
		$this->view('dashboard.php', [
			'user' => $_SESSION['user'],
		]);
	}

	public function add($text, $id) //Function that add a new board
	{
		$f_text = trim($text);
		$bm = new BoardsManager();
		$id = $bm->addBoard($f_text, $id);
		return $id;
	}
}
