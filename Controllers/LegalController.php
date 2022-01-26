<?php

namespace Controllers;

class legalController extends Controller
{
	/**
	 * Show index view
	 * @return void
	 */
	public function legal()
	{
		$this->setToken(); //We set a token when we land on the first page
		$this->view('legal.php', [
		]);
	}
}
