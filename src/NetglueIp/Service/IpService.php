<?php

namespace NetglueIp\Service;

use Zend\Stdlib\Message as AbstractRequest;
use Zend\Console\Request as ConsoleRequest;
use Zend\Http\PhpEnvironment\Request as PhpRequest;

class IpService
{

    private $message;

    public function __construct(AbstractRequest $message)
    {
        $this->message = $message;
    }

    /**
     * Whether the request is a console request or not
     * @return bool
     */
    public function isConsole()
    {
        return ($this->message instanceof ConsoleRequest);
    }

    public function isPhpRequest()
    {
        return ($this->message instanceof PhpRequest);
    }

    public function getIp()
    {
        $ip = $this->getRemoteAddress();
        if($fwd = $this->getForwardFor()) {
            $ip = $fwd;
        }
        if($cf = $this->getCloudflareConnectingIp()) {
            $ip = $cf;
        }
        return $ip;
    }

    /**
     * Return the IP of the connecting host to cloudflare if set
     * @return string|null
     */
    public function getCloudflareConnectingIp()
    {
        if($this->isPhpRequest()) {
            $data = $this->message->getServer('HTTP_CF_CONNECTING_IP');
            if(!empty($data)) {
                return $data;
            }
        }
    }

    public function getRemoteAddress()
    {
        if($this->isPhpRequest()) {
            $data = $this->message->getServer('REMOTE_ADDR');
            if(!empty($data)) {
                return $data;
            }
        }
    }

    public function getForwardFor()
    {
        if($this->isPhpRequest()) {
            $data = $this->message->getServer('HTTP_X_FORWARDED_FOR');
            if(empty($data)) {
                return null;
            }
            /**
             * Subsequent forward fors are likely appended, so return the first/oldest in the list
             */
            if(strpos($data, ',') !== false) {
                $data = explode(',', $data);
                array_walk($data, 'trim');
                reset($data);
                $data = current($data);
            }
            return $data;
        }
    }

}
