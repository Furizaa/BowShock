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

namespace BowShock\Resouce;

require_once 'Zend/Application/Resource/ResourceAbstract.php';

/**
 * Mapper resource config loader
 *
 * @package    Resource
 * @subpackage 
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @version    Release: $Id:$
 * @since      Class available since Release 1.0.0
 */
class MapperFactory extends \Zend_Application_Resource_ResourceAbstract
{

    /**
     * (non-PHPdoc)
     * @see Zend_Application_Resource_Resource::init()
     */
    public function init()
    {
        $options = $this->getOptions();

        if (!array_key_exists('namespace', $options)) {
            BowShock\Mapper\MapperFactory::getInstance()->setMapperNamespace($options['namespace']);
        }
    }

}