<?php
// For some reason, setting this fixes the 5.2 tests but breaks the 5.3 ones ...
if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    ini_set('memory_limit', '128M');
}

// Errors on full!
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

$autoloader = require dirname(__DIR__) . '/vendor/autoload.php';

