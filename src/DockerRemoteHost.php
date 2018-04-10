<?php

namespace Foogile\NetBeans\PhpUnit;

class DockerRemoteHost implements RemoteHostInterface
{
    private $dockerContainerID;
    private $dockercontainerName;
    public function __construct($dockerContainerName) 
    { 
		if(empty($dockerContainerName)){
			echo "ERROR: you must provide a valid \$dockerContainerName".
			return;
		}
		
        $cmd = "docker ps -aqf \"name=$dockerContainerName\"";
        $this->dockerContainerID = exec($cmd);
        
        if(empty($this->dockerContainerID)) {
			echo "ERROR: docker container \"$dockerContainerName\" not found ";
			echo "Be sure to correctly set \$dockerName in phpunit-docker.php";
		}
    }
  
    public function put($localPath, $remotePath)
    {
        $cmd="docker cp $localPath $this->dockerContainerID:$remotePath ";
        //echo "Put: " . $cmd . "\n";
        exec($cmd);
    }
    
    public function get($remotePath, $localPath)
    {
        $cmd="docker cp $this->dockerContainerID:$remotePath $localPath ";
        //echo "Get: " . $cmd . "\n";
        exec($cmd);
    }

    public function exec($command)
    {
        $cmd="docker exec $this->dockerContainerID $command";
        //echo "Run: " . $cmd . "\n";
        exec($cmd);
    }

    public function delete($remotePath)
    {
        $cmd="docker exec $this->dockerContainerID rm -rf $remotePath";
        //echo "Run: " . $cmd . "\n";
        exec($cmd);
    }

}
