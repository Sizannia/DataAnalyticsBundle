<?php

namespace Sizannia\DataAnalyticsBundle\Reader;

interface InterfaceReader {

    /**
     * @param \Widop\GoogleAnalytics\Response $parameters
     */
    public function parse($parameters);
}