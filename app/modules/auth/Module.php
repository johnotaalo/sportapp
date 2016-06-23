<?php

namespace Sport\Auth;

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
			'Sport\Auth'	=>	APP_PATH . 'app/modules/auth/classes/',
			'Sport\Common'	=>	APP_PATH . 'app/common/classes'
		]);

		$loader->register();
	}

	public function registerServices(DiInterface $di)
	{
		$di->set('dispatcher', function(){
			$dispatcher = new Dispatcher();

			$dispatcher->setDefaultNamespace('Sport\Auth\Controllers');

			return $dispatcher;
		});

		$di->set('view', function(){
			$view = new View();

			$view->setViewsDir(APP_PATH .'app/modules/auth/views/');
			$view->setLayoutsDir(APP_PATH . 'app/common/views/template/');
			$view->setTemplateAfter('base');

			return $view;
		});

		$commonv = $di->get("commonv");

		$di->set('commonv', function() use ($commonv){
			$commonv->setViewsDir(APP_PATH . 'app/modules/auth/views/');
			$commonv->setPartialsDir('partials/');

			return $commonv;
		});
	}
}