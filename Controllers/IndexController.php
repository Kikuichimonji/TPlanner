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
	/**
	 * @return void
	 */
	public function aboutProject()
	{
		$this->setToken(); //We set a token when we land on the first page
		$this->view('aboutProject.php', [
		]);
	}
	/**
	 * @return void
	 */
	public function legal()
	{
		$this->setToken(); //We set a token when we land on the first page
		$this->view('legal.php', [
		]);
	}
	/**
	 * @return void
	 */
	public function privacy()
	{
		$this->setToken(); //We set a token when we land on the first page
		$this->view('privacy.php', [
		]);
	}
}

