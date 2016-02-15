<?php

return [

    'netglue_ip' => [

        /**
         * If you want the detected 'real ip' of the remote user available in the request
         * server params i.e. $this->getRequest()->getServer('REMOTE_ADDR') instead of
         * the proxy or load balancer address, set this to true and the onBootstrap method
         * of the Module will overwrite it
         */
        'rewrite_remote_addr' => false,
    ],

];
