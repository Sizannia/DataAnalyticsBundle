<?php

namespace Sizannia\DataAnalyticsBundle\Reader\GoogleAnalytics;

use Sizannia\DataAnalyticsBundle\Reader\InterfaceReader;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class TableReader implements InterfaceReader {

    /**
     * @var array
     */
    private $header;

    /**
     * @var array
     */
    private $rows;

    /**
     * @var
     */
    private $totalResults;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    /**
     * @param \Widop\GoogleAnalytics\Response $parameters
     */
    public function parse($parameters) {
        $this->totalResults = $parameters->getTotalsForAllResults();
        $headers = $parameters->getColumnHeaders();
        $this->header = array();
        foreach ($headers as $key => $header) {
            $this->header[] = ucfirst(str_replace('ga:', '', $header['name']));
        }
        $this->rows = $parameters->getRows();
    }


    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return array
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @return mixed
     */
    public function getTotalResults()
    {
        return $this->totalResults;
    }
} 