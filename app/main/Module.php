<?php

namespace Sport\Main;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\DiInterface;
use Phalcon\Mvc\View;

class Module
{
	public function registerAutoloaders()
	{
		$loader = new Loader();

		$loader->registerNamespaces(array(
			'Sport\Main'	=>	APP_PATH . 'app/main/classes/'
		));

		$loader->register();
	}

	public function registerServices(DiInterface $di)
	{
		$di->set('dispatcher', function(){
			$dispatcher = new Dispatcher();
			$dispatcher->setDefaultNamespace("Sport\Main\Controllers");
			return $dispatcher;
		});

		$di->set('view', function(){
			$view = new View();

			$view->setViewsDir(APP_PATH . 'app/main/views/');

			return $view;
		}, true);
	}
}