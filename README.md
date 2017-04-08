# pixiv-api-php

[![Build Status](https://api.travis-ci.org/kokororin/pixiv-api-php.svg)](https://travis-ci.org/kokororin/pixiv-api-php) 
[![Packagist](https://img.shields.io/packagist/dt/kokororin/pixiv-api-php.svg?maxAge=2592000)](https://packagist.org/packages/kokororin/pixiv-api-php)

_Pixiv API for PHP (with Auth supported)_

### Installation

~~~bash
composer require kokororin/pixiv-api-php
~~~

### Example:
~~~php
require './vendor/autoload.php';

$api = new PixivAppAPI;
# running some methods
$api->method();
~~~

## Tests

To execute the test suite, you'll need phpunit.

```bash
$ composer test
```

## API

### PixivAppAPI
**Needn't authentication.**  
See [PixivAppAPI.php](https://github.com/kokororin/pixiv-api-php/blob/master/PixivAppAPI.php) or [PixivAppAPITest.php](https://github.com/kokororin/pixiv-api-php/blob/master/tests/PixivAppAPITest.php) for detail usage.

### PixivAPI (**deprecated**)
**Some method need authentication.**  
See [PixivAPI.php](https://github.com/kokororin/pixiv-api-php/blob/master/PixivAPI.php) or [PixivAPITest.php](https://github.com/kokororin/pixiv-api-php/blob/master/tests/PixivAPITest.php) for detail usage.
