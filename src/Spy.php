<?php
/**
 * Copyright (c) 2015 Roeland Jago Douma <rullzer@owncloud.com>
 * This file is licensed under the Licensed under the MIT license:
 * http://opensource.org/licenses/MIT
 */

namespace PHPSpy;

class Spy {
	
	/** @var object */
	private $object;

	/** @var Call[] */
	private $calls = [];

	/**
	 * @param object $object The object to spy on
	 */
	public function __construct($object) {
		if (!is_object($object)) {
			throw new \InvalidArgumentException('Not called with an object');
		}

		$this->object = $object;
	}

	/**
	 * @param string $name The name of the method to call
	 * @param array $arguments The arguments for the method
	 * @return mixed
	 */
	public function __call($name, $arguments) {
		$this->calls[] = new Call($name, $arguments);
		return call_user_func_array([$this->object, $name], $arguments);
	}

	/**
	 * Number of times the spy has been called
	 *
	 * @param string $function Count only calls to this function
	 * @return int
	 */
	public function getCallCount($function = null) {
		if ($function === null) {
			return count($this->calls);
		}

		$calls = array_filter($this->calls, function($call) use ($function) {
			return $call->getMethod() === $function;
		});

		return count($calls);
	}

	/**
	 * Get all the spied calls
	 *
	 * @param string $function Return only calls to this function
	 * @return Calls[]
	 */
	public function getCalls($function = null) {
		if ($function === null) {
			return $this->calls;
		}

		$calls = array_filter($this->calls, function($call) use ($function) {
			return $call->getMethod() === $function;
		});

		return array_values($calls);
	}
}
