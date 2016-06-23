<?php

namespace Sport\Common\Controllers;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
	public $response;

	private $javascript = array();

	public function initialize()
	{
		$this->response = new \Phalcon\Http\Response();
	}
	
	public function addJavaScript($script)	
	{
		array_push($this->javascript, $script);
		$this->view->javascript = $this->javascript;
	}

	public function getJavaScript()
	{
		return $this->javascript;
	}

}