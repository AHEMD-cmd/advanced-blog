<?php

namespace System;

class Application
{
	 /**
	  * container
	  * @var container
	  */

	  private $container = [];
	 /**
	  * constructor
	  * @param \System\File $file
	  */

	  private static $instance;

	  private function __construct(File $file) {
		  $this->share('file', $file);

		  $this->registerClasses();

		  $this->loadHelper();

	  }

	  public static function getInstance($file = null){
		if(is_null(static::$instance)){
			// static::$instance  = new self;  // the two lines are the same
			static::$instance  = new static($file);
		}
		return static::$instance;
	}


	  public function run(){
		$this->session->start();

		$this->request->prepareUrl();

		$this->file->call('App/index.php');

		list($controller, $method, $arguments) = $this->route->getProperRoute();
	
		// $this->loader->controller($controller);
		$this->loader->action($controller, $method, $arguments);
	}



	  public function registerClasses(){
		  spl_autoload_register([$this, 'load']);
	  }


	  public function load($class){
		  if(strpos($class, 'App') === 0){
			  
			  $file = $class.'.php';
		  }else{
			$file = 'vendor/'. $class . '.php';
		  }
		  if($this->file->exists($file)){
				$this->file->call($file);
		  }
	  }

	  public function get($key){
		if(!$this->isSharing($key)){
			if($this->isCoreAlias($key)){

				$this->share($key, $this->createNewCoreObject($key));
			}else{
				die('<b>'. $key . '</b> not found in application class');
			}
		}
		return $this->container[$key] ;
	  }

	  public function __get($key)
	  {
		return $this->get($key);
	  }

	  public function isSharing($key)
	  {
		return isset($this->container[$key]);
	  }
 
	  public function createNewCoreObject($alias)
	  {
		$coreClasses = $this->coreClasses();
		$object = $coreClasses[$alias];
		return new $object($this);
	  }

	  public function isCoreAlias($key)
	  {
		$coreClasses = $this->coreClasses();
		return isset($coreClasses[$key]);
	  }

	  public function coreClasses()
	  {
		return [
			'request' => 'System\\Http\\Request',
			'response' => 'System\\Http\\Response',
			'session' => 'System\\Session',
			'cookie' => 'System\\Cookie',
			'route' => 'System\\Route',
			'loader' => 'System\\Loader',
			'html' => 'System\\Html',
			'db' => 'System\\Database',
			'view' => 'System\\View\\VeiwFactory'

		];
	  }
	

	  /**
		* share the given key|value through the application
		*
		*/
	  public function share($key, $value){
		  $this->container[$key] = $value;
	  }
	  public function loadHelper(){
		  $this->file->call('Vendor/helpers.php');
	  }

	 
}