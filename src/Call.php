<?php
/**
 * Copyright (c) 2015 Roeland Jago Douma <rullzer@owncloud.com>
 * This file is licensed under the Licensed under the MIT license:
 * http://opensource.org/licenses/MIT
 */

 namespace PHPSpy;

 class Call {
	/** @var string */
	private $method;

	/** @var array */
	private $arguments;

	/**
	 * @param string $method
	 * @param array $arguments
	 */
	public function __construct($method,
	                            $arguments) {
		$this->method = $method;
		$this->arguments = $arguments;
	}

	/**
	 * @return string
	 */
	public function getMethod() {
		return $this->method;
	}

	/**
	 * @return array
	 */
	public function getArguments() {
		return $this->arguments;
	}

 }

