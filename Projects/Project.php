<?php

namespace OnlineSupporter\Teamleader\Projects;

use OnlineSupporter\Teamleader\Exception;
use OnlineSupporter\Teamleader\Teamleader;

class Project
{
    /**
     * @var  int
     */
    private $id;

    /**
     * @var  string
     */
    private $title;

    /**
     * @var string
     */
    private $phase;

    /**
     * @var integer
     */
    private $start_date;

    /**
     * @var string
     */
    private $start_date_formatted;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $name
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return float
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @param float $price
     */
    public function setPhase($phase)
    {
        $this->phase = $phase;
    }

    /**
     * @return integer
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param integer $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * @return string
     */
    public function getStartDateFormatted()
    {
        return $this->start_date_formatted;
    }

    /**
     * @param integer $start_date
     */
    public function setStartDateFormatted($start_date_formatted)
    {
        $this->start_date_formatted = $start_date_formatted;
    }

    /**
     * Initialize an Project with raw data we got from the API
     *
     * @return Project
     */
    public static function initializeWithRawData($data)
    {
        $project = new Project();

        foreach ($data as $key => $value) {
            switch ($key) {
                default:
                    // Ignore empty values
                    if ($value == '') {
                        continue;
                    }

                    $methodName = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
                    if (!method_exists(__CLASS__, $methodName)) {
                        if (Teamleader::DEBUG) {
                            var_dump($key, $value);
                            throw new Exception('Unknown method (' . $methodName . ')');
                        }
                    } else {
                        call_user_func(array($project, $methodName), $value);
                    }
            }
        }

        return $project;
    }

    /**
     * This method will convert an invoice to an array that can be used for an
     * API-request
     *
     * @return array
     */
    public function toArrayForApi()
    {
        $return = array(
            'title' => $this->getTitle(),
        );

        if ($this->getPhase()) {
            $return['phase'] = $this->getPhase();
        }
        if ($this->getStartDate()) {
            $return['start_date'] = $this->getStartDate();
        }
        if ($this->getStartDateFormatted()) {
            $return['start_date_formatted'] = $this->getStartDateFormatted();
        }

        return $return;
    }
}
