<?php

namespace Sport\Dashboard;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\DiInterface;
use Phalcon\Mvc\View;

class Module
{
	public function registerAutoloaders()
	{
		$loader = new Loader();

		$loader->registerNamespaces([
			'Sport\Dashboard'	=>	APP_PATH . 'app/modules/dashboard/classes/',
			'Sport\Common'		=>	APP_PATH . 'app/common/classes'
		]);

		$loader->register();
	}

	public function registerServices(DiInterface $di)
	{
		$di->set('dispatcher', function(){
			$dispatcher = new Dispatcher();

			$dispatcher->setDefaultNamespace('Sport\Dashboard\Controllers');

			return $dispatcher;
		});

		$di->set('view', function(){
			$view = new View();
			$view->setViewsDir(APP_PATH .'app/modules/dashboard/views/');
			$view->setLayoutsDir(APP_PATH . 'app/common/views/template/');
			$view->setTemplateAfter('base');

			return $view;
		});

		$di->set('module_view', function(){
			$view = new \Phalcon\Mvc\View();
			$view->setViewsDir(APP_PATH .'app/common/views/template/layout/');
			// $view->setLayoutsDir(APP_PATH . 'app/common/template/layout/');
			// $view->setTemplateAfter('dashboard');
			return $view;
		}, true);

		$commonv = $di->get("commonv");

		$di->set('commonv', function() use ($commonv){
			$commonv->setViewsDir(APP_PATH . 'app/modules/dashboard/views/');
			$commonv->setPartialsDir('partials/');

			return $commonv;
		});
	}
}