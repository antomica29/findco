<?php

namespace ArticleVoting;

class CheckProxy
{
    /**
     * Check if the request is coming through a proxy server based on various HTTP headers.
     *
     * @return bool True if a proxy is detected, false otherwise.
     */
    public function isProxy()
    {
        //headers list
        $test_HTTP_proxy_headers = [
            'HTTP_VIA',
            'VIA',
            'Proxy-Connection',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED',
            'HTTP_CLIENT_IP',
            'HTTP_FORWARDED_FOR_IP',
            'X-PROXY-ID',
            'MT-PROXY-ID',
            'X-TINYPROXY',
            'X_FORWARDED_FOR',
            'FORWARDED_FOR',
            'X_FORWARDED',
            'FORWARDED',
            'CLIENT-IP',
            'CLIENT_IP',
            'PROXY-AGENT',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'FORWARDED_FOR_IP',
            'HTTP_PROXY_CONNECTION'
        ];

        //check each header individually
        foreach ($test_HTTP_proxy_headers as $header) {
            //if the header is set and not empty, consider it as a proxy
            if (isset($_SERVER[$header]) && !empty($_SERVER[$header])) {
                return true;
            }
        }
        return false;
    }

}