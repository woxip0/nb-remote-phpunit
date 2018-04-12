<?php
namespace Foogile\NetBeans\PhpUnit;

define('DS', DIRECTORY_SEPARATOR);
set_include_path(get_include_path() . (DS == '/' ? ':' : ';') . dirname(__DIR__));
require 'vendor/autoload.php';

// EDITME:
$localWorkingDirectory = dirname(dirname(dirname(__FILE__))) . DS . 'html';
$dockerName = 'my-container';


$pathMappings = array ($localWorkingDirectory => '/var/www/html');
$tmpPath = '/tmp';
$remotePhpUnitPath = '/usr/bin/phpunit';


$testRunner = new TestRunner(
    new ArgumentParser(),
    new ArgumentMapper($tmpPath, $pathMappings),
    new LogMapper(array_flip($pathMappings)),
    new DockerRemoteHost($dockerName),
    $remotePhpUnitPath
);

$testRunner->run($argv);
