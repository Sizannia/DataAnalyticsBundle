<?php

namespace Sizannia\DataAnalyticsBundle\Reader\GoogleAnalytics;

use Sizannia\DataAnalyticsBundle\Reader\InterfaceReader;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class PieReader implements InterfaceReader {

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
        $this->header = array();
        $rows = array();
        foreach ($parameters->getRows() as $data) {
            $tmp = $this->parseur(array_reverse($data));
            $rows = array_merge_recursive($rows, $tmp);
        }
        $this->pushData($rows);
        $this->rows = $this->buildTree($rows);
        $this->header = $this->extractCategorie($parameters->getRows());
    }

    private function buildTree($rows) {
        $tmps = array();
        $i = 0;
        foreach ($rows as $key => $row) {
            $tmps[$i]['name'] = $key;
            $tmps[$i]['y'] = $row['y'];
            $tmp[$i]['color'] = '';
            $tmps[$i]['drilldown']['name'] = sprintf("%s Version", $key);
            $tmps[$i]['drilldown']['categories'] = array();
            foreach ($row as $k => $value) {
                if ($k != "y") {
                    $tmps[$i]['drilldown']['categories'][] = sprintf('%s %s' , $key, $k);
                    $tmps[$i]['drilldown']['data'][] = $value['y'];
                    $tmps[$i]['drilldown']['color'] = '';
                }
            }
            $i++;
        }
        return $tmps;
    }


    private  function extractCategorie($tmps) {
        return array_unique(array_column($tmps, 0));
    }

    private function pushData(&$datas) {
        $res = 0;
        foreach ($datas as &$data) {
            if (is_array($data)) {
                $data['y'] = $this->pushData($data);
                $res += $data['y'];
            } else {
                $res += $data;
            }
        }
        return $res;
    }

    private function parseur($datas) {
        $t = $datas[0];
        $rows = array();
        foreach ($datas as $key => $data) {
            if ($key == 0) {
                $rows['y'] = $t / $this->totalResults['ga:sessions'] * 100;
            } else {
                $tmp = $rows;
                unset($rows);
                $rows[$data] = $tmp;
            }
        }
        return $rows;
    }

    /**
     * @return mixed
     */
    public function getTotalResults()
    {
        return $this->totalResults;
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
} 