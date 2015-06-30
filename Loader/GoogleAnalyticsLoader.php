<?php

namespace Sizannia\DataAnalyticsBundle\Loader;

use Widop\GoogleAnalytics\Client;
use Widop\GoogleAnalytics\Service;
use Widop\GoogleAnalytics\Query;

class GoogleAnalyticsLoader {

    /**
     * @var array
     */
    private $dimensions;

    /**
     * @var array
     */
    private $metrics;

    /**
     * @var Service
     */
    private $service;


    /**
     * @var \DateTime
     */
    private $dateBegin;

    /**
     * @var \DateTime
     */
    private $dateEnd;

    /**
     * @var integer
     */
    private $maxResult;

    /**
     * @var Query
     */
    private $query;

    /**
     * @var Query
     */
    private $defaultQuery;

    /**
     * @param Service $googleService
     */
    public function __construct(Service $googleService, Query $query) {
        $this->service = $googleService;
        $this->dateBegin = new \DateTime('-1 month');
        $this->dateEnd = new \DateTime();
        $this->query = $query;
        $this->defaultQuery = $query;
    }

    /**
     * @return \Widop\GoogleAnalytics\Response
     * @throws \Widop\GoogleAnalytics\Exception\GoogleAnalyticsException
     */
    public function execute() {
        $this->query = $this->defaultQuery;
        $this->query->setStartDate($this->dateBegin);
        $this->query->setEndDate($this->dateEnd);
        $this->query->setMetrics($this->metrics);
        $this->query->setDimensions($this->dimensions);
        $this->query->setMaxResults($this->maxResult);
        $result = $this->service->query($this->query);
        return $result;
    }


    /**
     * @param \DateTime $dateBegin
     */
    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;
    }

    /**
     * @param \DateTime $dateEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @param array $dimensions
     */
    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;
    }

    /**
     * @param Service $googleService
     */
    public function setService($googleService)
    {
        $this->service = $googleService;
    }

    /**
     * @param array $metrics
     */
    public function setMetrics($metrics)
    {
        $this->metrics = $metrics;
    }

    /**
     * @param int $maxResult
     */
    public function setMaxResult($maxResult)
    {
        $this->maxResult = $maxResult;
    }
} 