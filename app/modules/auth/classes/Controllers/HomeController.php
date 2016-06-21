<?php

namespace Sport\Auth\Controllers;

use Sport\Common\Controllers\BaseController as Controller;

class HomeController extends Controller
{
	public function indexAction()
	{
		$this->view->disable();
		echo "We are at auth";
	}
}