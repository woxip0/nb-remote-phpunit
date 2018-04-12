<?php

namespace Foogile\NetBeans\PhpUnit;
use phpseclib\Net\SCP;
use phpseclib\Net\SSH2;

class DockerSSHRemoteHost implements RemoteHostInterface
{
    private $dockerHost='';
    private $dockerUser='';
    private $dockerPass='';
    private $ssh = null;

    public function __construct($dockerHost, $dockerUser, $dockerPass) 
    { 
        $this->dockerHost = $dockerHost;
        $this->dockerUser = $dockerUser;
        $this->dockerPass = $dockerPass;
        $this->ssh = new SSH2("$this->dockerHost");
        if (!$this->ssh->login($this->dockerUser, $this->dockerPass)) {
            $this->ssh = null;
            echo "Verify your ssh-credentials netbeans/phpunit-docker-ssh.php\n";
            exit("Can\'t logging to $this->dockerUser @ $this->dockerHost");
        }
    }
  
    public function put($localPath, $remotePath)
    {
        $scp = new SCP($this->ssh);
		if (!$scp->put($remotePath,
					   $localPath,
					   SCP::SOURCE_LOCAL_FILE))
		{
			exit("Failed to send file");
		}
    }
    
    public function get($remotePath, $localPath)
    {
        $scp = new SCP($this->ssh);
		if (!$scp->get($remotePath,
					   $localPath,
					   true))
		{
			exit("Failed to receive file");
		}
    }

    public function exec($command)
    {
		echo $this->ssh->exec($command);
    }

    public function delete($remotePath)
    {
		echo $this->ssh->exec("rm -rf $remotePath");
    }

}
