<?php

namespace Controllers;

use Models\BoardsManager;
use Models\UsersManager;

class BoardsController extends Controller
{
	/**
	 * BoardsController constructor.
	 */
	public function __construct() // check if the user is connected
	{
		$this->authRequired();
	}

	/**
	 * Show a view
	 * Index, Default method of the controller
	 */
	public function index($idBoard = null) //redirect to the dashboard if there is a problem, otherwise redirect to the specific board
	{
		$user = $this->session()["user"];  //We get back the user from the session
		if ($idBoard !== null) { //If we don't have a board id we get redirected to the dashboard
			$bm = new BoardsManager();
			$board = $bm->getOneById($idBoard); //We get the board from the id
			if ($board) { //we send the user to the board in question if the id actually exist, else we get thrown back to the dashboard
				$this->view('board.php', [
					'user' => $user,
					'board' => $board,
				]);
			} else {
				$this->view('dashboard.php', [
					'user' => $user
				]);
			}
		} else {
			$this->view('dashboard.php', [
				'user' => $user
			]);
		}
	}

	public function updateTitle($id, $text) //Function that update the title of the board
	{
		$f_text = trim($text);
		$bm = new BoardsManager();
		$bm->updateTitle($id, $f_text);
	}

	public function inviteUser($idBoard, $mail)
	{
		$f_mail = trim($mail);
		$um = new UsersManager();
		$bm = new BoardsManager();
		$user = $um->getOneByMail($f_mail);
		$isInvited = false;
		if ($user !== null && $user->getId() != $_SESSION['user']->getId()) {
			$boards = $user->getInvitedBoards();
			foreach ($boards as $board) {
				$isInvited = $board->getId() == $idBoard ? true : false;
			}
			if (!$isInvited) {
				$bm = new BoardsManager();
				$bm->inviteUser($idBoard, $user->getId());
			} else {
				return "errorSameUser";
			}
		} else {
			if ($user !== null) {
				if ($user->getId() == $_SESSION['user']->getId()) {
					return "errorSameUser";
				}
			} else {
				return "errorNoUser";
			}
		}
	}

	public function reload($id)
	{
		$um = new UsersManager();
		$user = $um->getOneById($_SESSION['user']->getId());
		$bm = new BoardsManager();
		$board = $bm->getOneById($id);

		$this->view('boardContent.php', [
			'user' => $user,
			'board' => $board,
		]);
	}
}
