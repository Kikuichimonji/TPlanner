<?php

namespace Controllers;

class privacyController extends Controller
{
	/**
	 * Show privacy view
	 * @return void
	 */
	public function privacy()
	{
		$this->setToken(); //We set a token when we land on the first page
		$this->view('privacy.php', [
		]);
	}
}
