<?php
/**
 * BowShock
 *
 * @category   BowShock
 * @package    Mapper
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @since      File available since Release 1.0.0
 */

namespace BowShock\Mapper;

use BowShock\Mapper\Db\BaseMapper,
	BowShock\Mapper\FactoryException;

/**
 * Mapper Factory
 *
 * @package    Mapper
 * @author     Andreas Hoffmann <furizaa@gmail.com>
 * @copyright  2010-2011 Andreas Hoffmann <furizaa@gmail.com>
 * @version    Release: $Id:$
 * @since      Class available since Release 1.0.0
 */
class MapperFactory
{

    /**
     * @var string
     */
    const DEFAULT_MAPPER_NAMESPACE = '\\BowShock\\Mapper\\Db\\';

    /**
     * @var MapperFactory
     */
    private static $instance;

    /**
     * Registered model mapper instances
     *
     * @var BaseMapper[]
     */
    private $registeredMappers = array();

    /**
     * @var string
     */
    private $mapperNamespace = '\\BowShock\\Mapper\\Db\\';

    /**
     * Singelton constructor
     */
    private function __construct()
    {
    }

    /**
     * Get Singleton Instance of Class
     *
     * @return Factory
     */
    public static function getInstance()
    {
        if (NULL === self::$instance) {
            self::$instance = new MapperFactory();
        }
        return self::$instance;
    }

    /**
     * @return the $mapperNamespace
     */
    public function getMapperNamespace()
    {
        return $this->mapperNamespace;
    }

    /**
     * @param string $mapperNamespace
     */
    public function setMapperNamespace($mapperNamespace)
    {
        $this->mapperNamespace = $mapperNamespace;
    }

    /**
     * Reset Singleton Instance
     */
    public static function resetInstance()
    {
        self::$instance = NULL;
    }

    /**
     * Register mapper with factory. Previously registered mappers with
     * the same class will be overwritten.
     *
     * @param BaseMapper $mapper
     * @param String $registeredKey
     */
    public function registerMapper(BaseMapper $mapper, $registeredKey = NULL)
    {
        if (NULL === $registeredKey) {
            $registeredKey = get_class($mapper);
        }
        $this->registeredMappers[$registeredKey] = $mapper;
    }

    /**
     * Checks if mapper is registered
     *
     * @param BaseMapper | String $mapper
     */
    public function isMapperRegistered($mapper)
    {
        if (is_object($mapper) && $mapper instanceof BaseMapper) {
            $mapper = get_class($mapper);
        }
        return array_key_exists($mapper, $this->registeredMappers);
    }

    /**
     * Fetch registered mapper from fully qualified class name.
     * If no mapper of this type has been registered before, a new one
     * will be registered and retrieved.
     *
     * @param String $mapperClassName
     * @return BaseMapper
     * @throws FactoryException
     */
    public function getMapper($mapperClassName)
    {
        if (!array_key_exists($mapperClassName, $this->registeredMappers)) {
            if (!class_exists($mapperClassName, false)) {
                throw new FactoryException(sprintf('Mapper %s not found!', $mapperClassName));
            }
            $mapperToRegister = new $mapperClassName();
            $this->registerMapper($mapperToRegister);
            return $this->getMapper($mapperClassName);
        }
        return $this->registeredMappers[$mapperClassName];
    }

    /**
     * Overload method access
     *
     * Creates the following virtual methods:
     * - getAccountMapper()
     *
     * @param  String $method
     * @param  Array  $args
     * @throws FactoryException
     */
    public function __call($method, $args)
    {
        if (preg_match('/^get(?P<mapper>[a-zA-Z]+)Mapper$/', $method, $matches)) {
            $mapper = $this->getMapperNamespace() . $matches['mapper'];
            return $this->getMapper($mapper);
        } else {
            throw new FactoryException(sprintf('Method %s does not exist!', $method));
        }
    }

}