<?php

namespace App;

use App\Theme\Scripts;
use App\Theme\Setup;
use Symfony\Component\HttpFoundation\Request;

class App {

	/**
	 * @var Request
	 */
	private $request;

	/**
	 * App constructor.
	 */
	public function __construct() {
		new Setup();
		new Scripts();

		$this->request = Request::createFromGlobals();
	}

	/**
	 * @return Request
	 */
	public function getRequest() {
		return $this->request;
	}
}