<?php

namespace Sizannia\DataAnalyticsBundle\Reader\GoogleAnalytics;

use Sizannia\DataAnalyticsBundle\Reader\InterfaceReader;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class MapReader implements InterfaceReader{

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
        $datas = $parameters->getRows();
        foreach ($datas as $data) {
            $this->rows[$data[0]] = $data[1];
        }
        $this->logger->info('--- Map Block Data ---');
        $this->logger->info(json_encode($this->rows, true));
        $this->logger->info('--- End Map Block Data ---');
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