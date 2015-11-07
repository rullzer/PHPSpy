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
	 * Get a SpyData object that can be used to obtain information about this
     * Spy. The SpyData object has references to this object so updates are live.
	 *
	 * @return SpyData
	 */
	public function __spyData() {
		return new SpyData($this->calls);
	}
}
