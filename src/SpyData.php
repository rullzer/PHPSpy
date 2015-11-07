<?php
/**
 * Copyright (c) 2015 Roeland Jago Douma <rullzer@owncloud.com>
 * This file is licensed under the Licensed under the MIT license:
 * http://opensource.org/licenses/MIT
 */

namespace PHPSpy;

class SpyData {
	
	/** @var Call[] */
	private $calls;

	/**
	 * @param object $object The object to spy on
	 */
	public function __construct(&$calls) {
		$this->calls = &$calls;
	}

	/**
	 * Filter the calls by function
	 * 
	 * @param string $function The function name to filter on
	 * @return Call[]
	 */
	private function filterCalls($function) {
		$calls = array_filter($this->calls, function($call) use ($function) {
			return $call->getMethod() === $function;
		});

		return array_values($calls);
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

		return count($this->filterCalls($function));
	}

	/**
	 * Get all the spied calls
	 *
	 * @param string $function Return only calls to this function
	 * @return Call[]
	 */
	public function getCalls($function = null) {
		if ($function === null) {
			return $this->calls;
		}

		return $this->filterCalls($function);
	}
}
