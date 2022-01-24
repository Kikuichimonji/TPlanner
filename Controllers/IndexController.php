<?php

namespace Controllers;

class IndexController extends Controller
{
	/**
	 * Show index view
	 * @return void
	 */
	public function index()
	{
		$this->setToken(); //We set a token when we land on the first page
		$this->view('index.php', [
		]);
	}
}
