<?php

namespace ArticleVoting;

require_once 'CheckProxy.php';

class FingerprintChecks
{
    /**
     * Instance of the CheckProxy class for proxy detection.
     *
     * @var CheckProxy
     */
    private $isProxyCheck;
    //private $userAgentCheck

    /**
     * FingerprintChecks constructor.
     */
    public function __construct()
    {
        $this->isProxyCheck = new CheckProxy();
        //other checks for example user agents
    }

    /**
     * Check if the fingerprint is OK based on various checks, such as proxy detection.
     *
     * @return bool True if the fingerprint is OK, false otherwise.
     */
    public function checkFingerprintOK() {

        //check if it is proxy, return false if is a proxy (false = not OK)
        if ($this->isProxyCheck->isProxy()){
            return false;
        }
        //additional checks for user agents or other fingerprints

        return true;
    }

}