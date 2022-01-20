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

	public function inviteUser($idBoard, $mail) //Function that add someone to a board after a user clicked on "inviter"
	{
		$f_mail = trim($mail);
		$um = new UsersManager();
		$bm = new BoardsManager();
		$user = $um->getOneByMail($f_mail); //We check if the user exist in the database
		$isInvited = false;
		if ($user !== null && $user->getId() != $this->session()['user']->getId()) { //if the user exist and is different than the one that invite
			$boards = $user->getInvitedBoards();
			foreach ($boards as $board) { //We check if the user is already invited to this board
				if (!$isInvited) {
					$isInvited = $board->getId() == $idBoard ? true : false;
				}
			}
			if (!$isInvited) { //If the user is not invited , we add him to the board
				$bm = new BoardsManager();
				return $bm->inviteUser($idBoard, $user->getId()) ? "success:L'utilisateur ".$user->getUsername()." a bien été invité" : "error:Une erreur est survenu lors de l'invitation" ;
			} else {
				return "error:Cet utilisateur à déjà été invité"; //I send the error this way because i didn't have enough time to fetch the whole documents as json
			}
		} else {
			if ($user !== null) {
				if ($user->getId() == $_SESSION['user']->getId()) {
					return "error:Vous ne pouvez pas vous inviter vous même";
				}
			} else {
				return "error:Cet utilisateur n'existe pas";
			}
		}
	}

	public function reload($id) //We reload the board content (either for some operation or when the fetch find new content)
	{
		$user = $this->session()['user'];
		$bm = new BoardsManager();
		$board = $bm->getOneById($id); //We have to call the board again to fetch the new content

		$this->view('boardContent.php', [
			'user' => $user,
			'board' => $board,
		]);
	}
}
