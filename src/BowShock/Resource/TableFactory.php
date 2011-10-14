<?php
/**
 * BowShock
 *
 * @category   BowShock
 * @package    Resource
 * @subpackage 
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @since      File available since Release 1.0.0
 */

namespace BowShock\Resource;

require_once 'Zend/Application/Resource/ResourceAbstract.php';

/**
 * Resource loader for the db table dependency injection
 *
 * @package    Resource
 * @subpackage 
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @version    Release: $Id:$
 * @since      Class available since Release 1.0.0
 */
class TableFactory extends \Zend_Application_Resource_ResourceAbstract
{

    /**
     * @see Zend_Application_Resource_Resource::init()
     */
    public function init()
    {
        require_once 'BowShock/Model/DbTable/Factory.php';
        BowShock\Model\DbTable\TableFactory::factory($this->getOptions());
    }

}