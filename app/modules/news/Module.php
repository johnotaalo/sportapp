<?php

namespace Sport\News;

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
			'Sport\News'	=>	APP_PATH . 'app/modules/auth/classes/',
			'Sport\Common'	=>	APP_PATH . 'app/common/classes'
		]);

		$loader->register();
	}

	public function registerServices(DiInterface $di)
	{
		$di->set('dispatcher', function(){
			$dispatcher = new Dispatcher();

			$dispatcher->setDefaultNamespace('Sport\News\Controllers');

			return $dispatcher;
		});

		$di->set('view', function(){
			$view = new View();

			$view->setViewsDir(APP_PATH .'app/modules/news/views/');
			$view->setLayoutsDir(APP_PATH . 'app/common/views/template/');
			$view->setTemplateAfter('base');

			return $view;
		});
	}
}