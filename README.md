#PHPSpy#

[![Build Status](https://travis-ci.org/rullzer/PHPSpy.svg?branch=master)](https://travis-ci.org/rullzer/PHPSpy)
[![Coverage Status](https://coveralls.io/repos/rullzer/PHPSpy/badge.svg?branch=master&service=github)](https://coveralls.io/github/rullzer/PHPSpy?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rullzer/PHPSpy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rullzer/PHPSpy/?branch=master)

Easy to use spies for php testing

###Example###
```php
<?php

require('vendor/autoload.php');

use \PHPSpy\Spy;

class Foo {
    public function bar($baz) {
        return $baz === 'x';
    }  
}

$spy = new Spy(new Foo());

// Output: true
var_dump($spy->bar('x'));

// Output: false
var_dump($spy->bar(['x', 'y']));

// Output: 2
var_dump($spy->getCallCount());

$calls = $spy->getCalls();

// Output: 'bar'
var_dump($calls[0]->getMethod());

// Output: ['x']
var_dump($calls[0]->getArguments());

// Output: 'bar'
var_dump($calls[1]->getMethod());

// Output: [['x', 'y']]
var_dump($calls[1]->getArguments());
```
