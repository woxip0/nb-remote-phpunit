<?php

namespace Foogile\NetBeans\PhpUnit;

set_include_path(get_include_path() . ':' . __DIR__ . '/../');
require 'vendor/autoload.php';

$pathMappings = array ('/home/dixon/NetBeansProjects/PhpProject1/' => '/var/www/html/');
$tmpPath = '/tmp';
$remotePhpUnitPath = '/usr/bin/phpunit';
$dockerName = "devtest";

$testRunner = new TestRunner(
    new ArgumentParser(),
    new ArgumentMapper($tmpPath, $pathMappings),
    new LogMapper(array_flip($pathMappings)),
    new DockerRemoteHost($dockerName),
    $remotePhpUnitPath
);

$testRunner->run($argv);
