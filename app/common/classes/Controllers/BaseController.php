<?php

namespace Sport\Common\Controllers;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
	public $response;

	public function initialize()
	{
		$this->response = new \Phalcon\Http\Response();
	}
}