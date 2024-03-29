<?php
/**
 * BowShock
 *
 * @category   BowShock
 * @package    Model
 * @subpackage DbTable
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @since      File available since Release 1.0.0
 */

namespace BowShock\Model\DbTable;

use BowShock\Model\DbTable\FactoryException,
	BowShock\Mapper\Db\BaseMapper;

/**
 * Db Table Factory
 *
 * @package    Model
 * @subpackage DbTable
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @version    Release: $Id:$
 * @since      Class available since Release 1.0.0
 */
class TableFactory
{

    /**
     * Holds mapping from mapper to db table
     *
     * @var Array
     */
    private $tableToMapper = array();

    /**
     * Table to use when no one could be mapped
     *
     * @var String
     */
    private $defaultTableClassName;

    /**
     * @var TableFactory
     */
    private static $instance;

    /**
     * Singelton constructor
     */
    private function __construct()
    {
    }

    /**
     * Get Singleton Instance of Class
     *
     * @return TableFactory
     */
    public static function getInstance()
    {
        if (NULL === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Reset Singleton Instance
     */
    public static function resetInstance()
    {
        self::$instance = NULL;
    }

    /**
     * Set default db table instance to use
     *
     * @param String $dbTableClassName
     */
    public function setDefaultTable($dbTableClassName)
    {
        $this->defaultTableClassName = $dbTableClassName;
    }

    /**
     * Get default db table instance
     *
     * @return String
     */
    public function getDefaultTable()
    {
        return $this->defaultTableClassName;
    }

    /**
     * Register db table class name for a mapper class name
     *
     * @param String $tableClassName
     * @param String $mapperClassName
     */
    public function setTableForMapper($tableClassName, $mapperClassName)
    {
        $this->tableToMapper[$mapperClassName] = $tableClassName;
    }

    /**
     * Get registered db table class name for mapper
     *
     * @param String $mapperClassName
     */
    public function getTableForMapper($mapperClassName)
    {
        return $this->tableToMapper[$mapperClassName];
    }

    /**
     * Create the configured table instance for a provided mapper instance
     * or mapper class name.
     *
     * @param BaseMapper | String $modelMapper
     * @throws FactoryException
     * @return \Zend_Db_Table_Abstract
     */
    public function createMappedTable($modelMapper)
    {
        if ($modelMapper instanceof BaseMapper) {
            $modelMapper = get_class($modelMapper);
        }
        if (!array_key_exists($modelMapper, $this->tableToMapper)) {
            if (!class_exists($this->defaultTableClassName)) {
                throw new FactoryException('Default db table class not found!');
            }
            $tableClassName = $this->defaultTableClassName;
        } else {
            $tableClassName = (String) $this->tableToMapper[$modelMapper];
            if (!class_exists($tableClassName)) {
                throw new FactoryException('Mapped db table class not found!');
            }
        }

        return new $tableClassName();
    }

    /**
     * Factory method to initialize mapping from mappers to db table class
     * names.
     *
     * @param Array $options
     */
    public static function factory($options)
    {
        self::getInstance()->setDefaultTable($options['default']);
        foreach ((array) $options['map'] as $mapperClassName => $dbTableClassName) {
            self::getInstance()->setTableForMapper($dbTableClassName, $mapperClassName);
        }
    }

}