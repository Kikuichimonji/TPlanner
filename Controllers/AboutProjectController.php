<?php

namespace Controllers;

class aboutProjectController extends Controller
{
	/**
	 * Show aboutProject view
	 * @return void
	 */
	public function aboutProject()
	{
		$this->setToken(); //We set a token when we land on the first page
		$this->view('aboutProject.php', [
		]);
	}
}
