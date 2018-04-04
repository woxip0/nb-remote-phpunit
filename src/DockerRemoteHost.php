<?php

namespace Foogile\NetBeans\PhpUnit;

class DockerRemoteHost implements RemoteHostInterface
{
    private $dockerContainerID;
    
    public function __construct($dockerContainerName) 
    { 
        $cmd = "docker ps -aqf \"name=$dockerContainerName\"";
        $this->dockerContainerID = exec($cmd);
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
