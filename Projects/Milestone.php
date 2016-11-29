<?php

namespace SumoCoders\Teamleader\Projects;

use SumoCoders\Teamleader\Exception;
use SumoCoders\Teamleader\Teamleader;

class Milestone
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
     * @var  integer
     */
    private $due_date;

    /**
     * @var  float
     */
    private $budget;

    /**
     * @var  integer
     */
    private $closed;

    /**
     * @var  integer
     */
    private $responsible_user_id;

    /**
     * @var  string
     */
    private $billing_type;

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
     * @return integer
     */
    public function getDueDate()
    {
        return $this->due_date;
    }

    /**
     * @param integer $due_date
     */
    public function setDueDate($due_date)
    {
        $this->due_date = $due_date;
    }

    /**
     * @return float
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @param float $budget
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }

    /**
     * @return integer
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * @param integer $closed
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    }

    /**
     * @return integer
     */
    public function getResponsibleUserId()
    {
        return $this->responsible_user_id;
    }

    /**
     * @param integer $responsible_user_id
     */
    public function setResponsibleUserId($responsible_user_id)
    {
        $this->responsible_user_id = $responsible_user_id;
    }

    /**
     * @return string
     */
    public function getBillingType()
    {
        return $this->billing_type;
    }

    /**
     * @param string $billing_type
     */
    public function setBillingType($billing_type)
    {
        $this->billing_type = $billing_type;
    }

    /**
     * Initialize an Milestone with raw data we got from the API
     *
     * @return Milestone
     */
    public static function initializeWithRawData($data)
    {
        $milestone = new Milestone();

        if( is_array($data)) {
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
                            call_user_func(array($milestone, $methodName), $value);
                        }
                }
            }
        }

        return $milestone;
    }

    /**
     * This method will convert a milestone to an array that can be used for an
     * API-request
     *
     * @return array
     */
    public function toArrayForApi()
    {
        $return = array(
            'title' => $this->getTitle(),
        );

        if ($this->getDueDate()) {
            $return['due_date'] = $this->getDueDate();
        }

        if ($this->getBudget()) {
            $return['budget'] = $this->getBudget();
        }

        if ($this->getClosed()) {
            $return['closed'] = $this->getClosed();
        }

        if ($this->getResponsibleUserId()) {
            $return['responsible_user_id'] = $this->getResponsibleUserId();
        }

        if ($this->getBillingType()) {
            $return['billing_type'] = $this->getBillingType();
        }

        return $return;
    }
}
