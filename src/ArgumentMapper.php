<?php

namespace Foogile\NetBeans\PhpUnit;

class ArgumentMapper
{
    const LOG_NAME = 'nb-phpunit-log.xml';
    const LOG_NAME_JSON = 'nb-phpunit-log.json';
    const SUITE_NAME = 'NetBeansSuite.php';
    
    private $pathMappings;
    private $temporaryPath;
    
    /**
     * @param string $temporaryPath Temporary path on remote host
     * @param array $pathMappings Associative array of path mappings. Example: [ "/local/path" => "/remote/path" ]
     */
    public function __construct($temporaryPath, $pathMappings = array())
    {
        $this->pathMappings = $pathMappings;
        $this->temporaryPath = $temporaryPath;
    }
    
    /**
     * @param Arguments $arguments Original arguments
     * @return Arguments
     */
    public function toRemote(Arguments $arguments)
    {
        $out = new Arguments;
        $out->colors = $arguments->colors;
        $out->configuration = $this->getRemotePath($arguments->configuration);
        if($arguments->logJunit) {
            $out->logJunit = $this->getRemoteTemporaryPath(self::LOG_NAME);
        } 
        if($arguments->logJson) {
            $out->logJson = $this->getRemoteTemporaryPath(self::LOG_NAME_JSON);
        }
        $out->suitePath = $this->getRemoteTemporaryPath(self::SUITE_NAME);
        $out->filter = $arguments->filter;
        $out->suiteArguments = array_map(array($this, 'getRemotePath'), $arguments->suiteArguments);
        return $out;
    }
    
    private function getRemotePath($localPath)
    {	
        $res = str_replace(
            array_keys($this->pathMappings),
            array_values($this->pathMappings),
            $localPath
        );
			
		if(DIRECTORY_SEPARATOR != '/') {
			$res = str_replace(DIRECTORY_SEPARATOR, '/', $res);
		}
		
		return $res;
    }
    
    private function getRemoteTemporaryPath($filename)
    {
        return "$this->temporaryPath/$filename";
    }
    
}
