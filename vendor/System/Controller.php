<?php

namespace System;

abstract class Controller
{
	  protected $app;
	  
	
	  public function __construct(Application $app) {
		  $this->app = $app;
	  }

	  public function __get($key) {
		
		  $this->app->get($key);
	  }

	
	


	  
	 
}