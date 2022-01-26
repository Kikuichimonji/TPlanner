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
	public function aboutProject()
	{
		$this->setToken(); //We set a token when we land on the first page
		$this->view('aboutProject.php', [
		]);
	}
	public function legal()
	{
		$this->setToken(); //We set a token when we land on the first page
		$this->view('legal.php', [
		]);
	}
	public function privacy()
	{
		$this->setToken(); //We set a token when we land on the first page
		$this->view('privacy.php', [
		]);
	}
}

