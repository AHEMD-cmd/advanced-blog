<?php

namespace System;
class File
{

	/**
	 * root path
	 * @var string
	 */
	 private $root;

	 const DS = DIRECTORY_SEPARATOR;

	 /**
	  * constructor
	  * @param string $root
	  */

	  public function __construct($root) {
		$this->root = $root;

	  }

	  public function exists($file) {
		return file_exists($this->to($file));

	  }

	  public function call($file) {
		require $this->to($file);

	  }

	  public function toVendor($path) {
		return $this->to('vendor/'.$path);

	  }

	  public function to($path) {
		return $this->root . static::DS . str_replace(['/', '\\'], static::DS, $path);

	  }
}