<?php
/**
 * BowShock
 * 
 * @category   BowShock
 * @package    Model
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @since      File available since Release 1.0.0
 */

namespace BowShock\Model;

use BowShock\Model\BaseModel;

/**
 * Model Test Dummy 
 *
 * @package    Model
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @version    Release: $Id:$
 * @since      Class available since Release 1.0.0
 */
class TestDummy extends BaseModel
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