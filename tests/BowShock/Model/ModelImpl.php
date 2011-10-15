<?php

use BowShock\Model\BaseModel;

class ModelImpl extends BaseModel
{

    /**
     * @var Integer
     */
    private $testValue;
    
    /**
     * @return the $testValue
     */
    public function getTestValue()
    {
        return $this->testValue;
    }

    /**
     * @param Integer $testValue
     */
    public function setTestValue($testValue)
    {
        $this->testValue = $testValue;
    }
    
}