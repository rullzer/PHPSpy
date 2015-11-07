<?php
/**
 * Copyright (c) 2014 Roeland Jago Douma <rullzer@owncloud.com>
 * This file is licensed under the Licensed under the MIT license:
 * http://opensource.org/licenses/MIT
 */

namespace PHPSpy\Tests;

class dummyClass {
	function foo() {

	}

	function bar($a) {

	}

	function foobar($a, $b=null) {

	}
}

class SpyTest extends \PHPUnit_Framework_TestCase {

	public function dataCreateSpyFail() {
		return [
			[null],
			[[]],
			['foo'],
			[42],
		];
	}

	/**
	 * @dataProvider dataCreateSpyFail
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage Not called with an object
	 */
	public function testCreateSpyFail($obj) {
		$spy = new \PHPSpy\Spy($obj);
	}

	public function testGetCallCount() {
		$class = new DummyClass();

		$spy = new \PHPSpy\Spy($class);
		$spyData = $spy->__spyData();

		$this->assertEquals(0, $spyData->getCallCount());

		$spy->foo();
		$this->assertEquals(1, $spyData->getCallCount());

		$spy->bar(1);
		$this->assertEquals(2, $spyData->getCallCount());

		$spy->foobar('a', 'b');
		$this->assertEquals(3, $spyData->getCallCount());

		$spy->foobar('c');
		$this->assertEquals(4, $spyData->getCallCount());
	}

	public function testGetCalls() {
		$class = new DummyClass();

		$spy = new \PHPSpy\Spy($class);
		$spyData = $spy->__spyData();

		$spy->foo();
		$spy->bar(1);
		$spy->foobar('a', 'b');
		$spy->foobar('c');

		$calls = $spyData->getCalls();

		$this->assertEquals('foo', $calls[0]->getMethod());
		$this->assertEquals([], $calls[0]->getArguments());
		$this->assertEquals('bar', $calls[1]->getMethod());
		$this->assertEquals([1], $calls[1]->getArguments());
		$this->assertEquals('foobar', $calls[2]->getMethod());
		$this->assertEquals(['a', 'b'], $calls[2]->getArguments());
		$this->assertEquals('foobar', $calls[3]->getMethod());
		$this->assertEquals(['c'], $calls[3]->getArguments());
	}

	public function testGetCallCountFor1Function() {
		$class = new DummyClass();

		$spy = new \PHPSpy\Spy($class);
		$spyData = $spy->__spyData();

		$spy->foo();
		$spy->bar(1);
		$spy->foobar('a', 'b');
		$spy->foobar('c');

		$this->assertEquals(1, $spyData->getCallCount('foo'));
		$this->assertEquals(1, $spyData->getCallCount('bar'));
		$this->assertEquals(2, $spyData->getCallCount('foobar'));
	}

	public function testGetCallsFor1Function() {
		$class = new DummyClass();

		$spy = new \PHPSpy\Spy($class);
		$spyData = $spy->__spyData();

		$spy->foo();
		$spy->bar(1);
		$spy->foobar('a', 'b');
		$spy->foobar('c');

		$calls = $spyData->getCalls('foo');
		$this->assertCount(1, $calls);
		$this->assertEquals('foo', $calls[0]->getMethod());
		$this->assertEquals([], $calls[0]->getArguments());

		$calls = $spyData->getCalls('bar');
		$this->assertCount(1, $calls);
		$this->assertEquals('bar', $calls[0]->getMethod());
		$this->assertEquals([1], $calls[0]->getArguments());

		$calls = $spyData->getCalls('foobar');
		$this->assertCount(2, $calls);
		$this->assertEquals('foobar', $calls[0]->getMethod());
		$this->assertEquals(['a', 'b'], $calls[0]->getArguments());
		$this->assertEquals('foobar', $calls[1]->getMethod());
		$this->assertEquals(['c'], $calls[1]->getArguments());
	}
}
