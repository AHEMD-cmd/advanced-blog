<?php

namespace System\Http;

class Request
{

	  private $url;

	  private $baseUrl;

	  public function prepareUrl() {

		$requestUri =  $this->server('REQUEST_URI');

		if(strpos($requestUri, '?') !== false){
			list($requestUri, $queryString) = explode('?', $requestUri);
		}
		$this->url = $requestUri; 

		list($protocol) = explode('/', $this->server('SERVER_PROTOCOL'));

		$script = explode('\\', $this->server('DOCUMENT_ROOT')); 
		$script = $script[count($script) -1];

		$this->baseUrl = $protocol. '://' . $this->server('HTTP_HOST').'/'. $script;

		// echo $this->url;
		
	  }

	  public function server($key, $default = null) {

		return array_get($_SERVER, $key, $default);
		
	  }

	  public function get($key, $default = null) {

		return array_get($_GET, $key, $default);
	  }

	  public function post($key, $default = null) {

		return array_get($_POST, $key, $default);
	  }

	  public function method() {

		return  $_SERVER['REQUEST_METHOD'];
	  }

	  public function baseUrl() {

		return  $this->baseUrl;
	  }

	  public function url() {

		return $this->url;
	  }

	  
	 
}