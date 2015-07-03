<?php

namespace Sizannia\DataAnalyticsBundle\Loader;


interface InterfaceLoader
{
    public function execute();

    /**
     * @param \DateTime $dateBegin
     */
    public function setDateBegin($dateBegin);

    /**
     * @param \DateTime $dateEnd
     */
    public function setDateEnd($dateEnd);

    /**
     * @param array $dimensions
     */
    public function setDimensions($dimensions);

    /**
     * @param Service $googleService
     */
    public function setService($googleService);

    /**
     * @param array $metrics
     */
    public function setMetrics($metrics);

    /**
     * @param int $maxResult
     */
    public function setMaxResult($maxResult);
}