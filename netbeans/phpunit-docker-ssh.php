<?php

namespace Foogile\NetBeans\PhpUnit;

set_include_path(get_include_path() . ':' . __DIR__ . '/../');
require 'vendor/autoload.php';

// EDITME:
$dockerHost = '';
$dockerUser = '';
$dockerPass = '';
$localWorkingDirectory = realpath(dirname(__FILE__) . '/../../html');

$pathMappings = array ($localWorkingDirectory => '/var/www/html');
$tmpPath = '/tmp';
$remotePhpUnitPath = '/usr/bin/phpunit';


$testRunner = new TestRunner(
    new ArgumentParser(),
    new ArgumentMapper($tmpPath, $pathMappings),
    new LogMapper(array_flip($pathMappings)),
    new DockerSSHRemoteHost($dockerHost, $dockerUser, $dockerPass),
    $remotePhpUnitPath
);

$testRunner->run($argv);
