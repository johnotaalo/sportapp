<?php

namespace Sport\Main\Controllers;

use Sport\Common\Controllers\BaseController as Controller;

class HomeController extends Controller
{
	public function indexAction()
	{
		return $this->response->redirect('news');
	}
}