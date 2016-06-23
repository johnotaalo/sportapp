<?php

namespace Sport\Dashboard\Controllers;

use Sport\Common\Controllers\BaseController as Controller;

class HomeController extends Controller
{
	function indexAction()
	{
		$inner_page = $this->view->getPartial('dashboard/home');

		$outer_page = $this->module_view
						->setParamToView('content', $inner_page);

		$this->view->content = $outer_page;

		$custom_js =  [
			'partial'	=>	'dashboard_js',
			'params'	=>	[]
		];

		$this->addJavascript($custom_js);
	}
}