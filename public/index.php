<?php

namespace Sport;

error_reporting(E_ALL);

define('APP_PATH', realpath('..') . '/');

date_default_timezone_set('Africa/Nairobi');

use Phalcon\Mvc\Application as BaseApplication;
use Phalcon\Loader;
use Phalcon\Mvc\Router;
use Phalcon\DI\FactoryDefault;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher as PhDispatcher;
use Phalcon\Mvc\View;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlAdapater;

class Application extends BaseApplication
{

	// Registering services here to make them globally accessible by the application

	protected function registerServices()
	{
		$di = new FactoryDefault();

		$loader = new Loader();

		//register namespaces here

		$loader->registerNamespaces(array(
			'Sport\Library'	=>	APP_PATH . 'app/library/',
			'Sport\Common'	=>	APP_PATH . 'app/common/classes/',
			'Sport\Auth'	=>	APP_PATH . 'app/modules/auth/classes',
			'Sport\News'	=>	APP_PATH . 'app/modules/news/classes'
		));

		//	add config to $di => dependancy injection
		$config = new \Phalcon\Config\Adapter\Php(APP_PATH . 'app/config/config.php');
		$di->set('config', $config);

		//	register the directories
		$loader->registerDirs(array(
			APP_PATH . 'app/library/',
			APP_PATH . 'app/config',
			APP_PATH . 'app/common/controllers'
		))->register();

		//	register the MVC dispatcher
		$di->setShared('dispatcher', function(){
			$eventsmanager = new EventsManager;

			$dispatcher = new PhDispatcher;

			$dispatcher->setEventsManager($eventsmanager);

			return $dispatcher;
		});

		$di->set('view', function(){
			$view = new View();
			return $view;
		}, true);

		$di->set('commonv', function(){
			$view = new View();
			return $view;
		}, true);

		//	register a router
		$di->set('router', function(){
			$router = new Router();

			$router->removeExtraSlashes(true);

			$router->setDefaultModule('main');

			$router->add('/', [
				'module'		=>	'main',
				'controller'	=>	'home',
				'action'		=>	'index'
			]);

			$router->add('/:module', [
				'module'		=>	1,
				'controller'	=>	'home',
				'action'		=>	'index'
			]);

			$router->add('/:module/:controller', [
				'module'		=>	1,
				'controller'	=>	2,
				'action'		=>	'index'
			]);

			$router->add('/:module/:controller/:action/:params', [
				'module'		=>	1,
				'controller'	=>	2,
				'action'		=>	3,
				'params'		=>	4
			]);

			return $router;
		});

		//	register assets

		$di->set('assets', function(){
			$assets = new \Phalcon\Assets\Manager();
			$assets
				->collection('js')
				->addJs('semantic/semantic.min.js')
				;
			$assets
				->collection('css')
				->addCss('semantic/semantic.min.css')
				->addCss('css/custom.css')
			;

			return $assets;
		});

		$di->set('url', function() use ($config){
			$url = new \Phalcon\Mvc\Url();
			$url->setBaseUri($config->app->baseUrl );
			return $url;
		});

		$di->set('flash', function(){
			return new FlashDirect();
		});

		$di->setShared('session', function(){
			$session = new SessionAdapter();

			$session->start();

			return $session;
		});

		$di->set('db', function() use ($config){
			$db = new MysqlAdapater([
				"host"		=>	$config->database->host,
				"username"	=>	$config->database->username,
				"password"	=>	$config->database->password,
				"dbname"	=>	$config->database->name,
				"options"	=> [
					\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
				]
			]);

			return $db;
		});

		$this->setDI($di);
	}

	public function main()
	{
		try {

			$this->registerServices();

			$this->registerModules([
				'main' 	=> [
					'className' => 'Sport\Main\Module',
					'path'		=>	APP_PATH . 'app/main/Module.php'
				],
				'auth'	=>	[
					'className'	=>	'Sport\Auth\Module',
					'path'		=>	APP_PATH . 'app/modules/auth/Module.php'
				],
				'news'	=>	[
					'className'	=>	'Sport\News\Module',
					'path'		=>	APP_PATH . 'app/modules/news/Module.php'
				]
			]);

			echo $this->handle()->getContent();
			
		} catch (\Exception $e) {
			echo "Exception: ", $e->getMessage();
			echo "<pre>" . $e->getTraceAsString() . "</pre>";
		}
		
	}

}

$application = new Application();
$application->main();
