<?php

namespace Controllers;

use Models\BoardsManager;
use Models\UsersManager;


class AdminController extends Controller
{
	/**
	 * Admincontroller constructor.
	 */
	public function __construct() // check if the user is connected then check if the user is an admin
	{

		$this->authRequired();
		$this->adminRequired();
	}

	/**
	 * Show a view
	 * Index, Default method of the controller
	 */
	public function index() //By default we show all Users and orphan Boards
	{
		$um = new UsersManager();
		$users = $um->findAll();
		$bm = new BoardsManager();
		$boards = $bm->getOrphan();

		$this->view('admin.php', [ //Then we send all the datas to the admin page
			'users' => $users,
			'boards' => $boards,
		]);
	}

	public function deleteUser($id) //Only the admin can delete a User
	{
		$um = new UsersManager();
		if ($id != "null") {
			$result = $um->deleteUser($id);
		}
		header("Location: admin~LP9fsDOQnEuHPRbTHfn5.php"); //we need to reload all users again
	}
}
