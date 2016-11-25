<?php

namespace SumoCoders\Teamleader\Projects;

use SumoCoders\Teamleader\Exception;
use SumoCoders\Teamleader\Teamleader;

class Project
{
    /**
     * @var  int
     */
    private $id;

    /**
     * @var  int
     */
    private $project_nr;

    /**
     * @var  string
     */
    private $title;

    /**
     * @var  string
     */
    private $contact_or_company;

    /**
     * @var  integer
     */
    private $contact_or_company_id;

    /**
     * @var float
     */
    private $budget_indication;

    /**
     * @var string
     */
    private $phase;

    /**
     * @var float
     */
    private $budget_spent_internal;

    /**
     * @var float
     */
    private $budget_spent_external;

    /**
     * @var string
     */
    private $description_html;

    /**
     * @var integer
     */
    private $start_date;

    /**
     * @var string
     */
    private $start_date_formatted;

    /**
     * @var array
     */
    private $custom_fields = array();

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
     * @return int
     */
    public function getProjectNr()
    {
        return $this->project_nr;
    }

    /**
     * @param int $project_nr
     */
    public function setProjectNr($project_nr)
    {
        $this->project_nr = $project_nr;
    }

    /**
     * @return int
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
     * @return string
     */
    public function getContactOrCompany()
    {
        return $this->contact_or_company;
    }

    /**
     * @param string $contact_or_company
     */
    public function setContactOrCompany($contact_or_company)
    {
        $this->contact_or_company = $contact_or_company;
    }

    /**
     * @return int
     */
    public function getContactOrCompanyId()
    {
        return $this->contact_or_company_id;
    }

    /**
     * @param int $contact_or_company
     */
    public function setContactOrCompanyId($contact_or_company_id)
    {
        $this->contact_or_company_id = $contact_or_company_id;
    }

    /**
     * @return float
     */
    public function getBudgetIndication()
    {
        return $this->budget_indication;
    }

    /**
     * @param float $budget_indication
     */
    public function setBudgetIndication($budget_indication)
    {
        $this->budget_indication = $budget_indication;
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
     * @return float
     */
    public function getBudgetSpentInternal()
    {
        return $this->budget_spent_internal;
    }

    /**
     * @param float $budget_spent_internal
     */
    public function setBudgetSpentInternal($budget_spent_internal)
    {
        $this->budget_spent_internal = $budget_spent_internal;
    }

    /**
     * @return float
     */
    public function getBudgetSpentExternal()
    {
        return $this->budget_spent_external;
    }

    /**
     * @param float $budget_spent_external
     */
    public function setBudgetSpentExternal($budget_spent_external)
    {
        $this->budget_spent_external = $budget_spent_external;
    }

    /**
     * @return string
     */
    public function getDescriptionHtml()
    {
        return $this->description_html;
    }

    /**
     * @param string $description_html
     */
    public function setDescriptionHtml($description_html)
    {
        $this->description_html = $description_html;
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
     * @return array
     */
    public function getCustomFields()
    {
        return $this->custom_fields;
    }

    /**
     * @param integer $start_date
     */
    public function setCustomFields($custom_fields)
    {
        $this->custom_fields = $custom_fields;
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
