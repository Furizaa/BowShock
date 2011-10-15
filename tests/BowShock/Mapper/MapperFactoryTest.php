<?php

require_once 'MapperImpl.php';

use BowShock\Mapper\MapperFactory;

/**
 * @covers \BowShock\Mapper\MapperFactory
 */
class BowShock_Mapper_MapperFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \BowShock\Mapper\MapperFactory
     */
    private $factory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->factory = MapperFactory::getInstance();
        $this->factory->setMapperNamespace('');
        $this->mapper  = new MapperImpl();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        MapperFactory::resetInstance();
        parent::tearDown();
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('\\BowShock\\Mapper\\MapperFactory', $this->factory);
    }

    public function testResetInstance()
    {
        $firstInstance = MapperFactory::getInstance();
        MapperFactory::resetInstance();
        $secondInstance = MapperFactory::getInstance();
        $this->assertNotSame($firstInstance, $secondInstance);
    }

    public function testRegisterMapper()
    {
        $this->assertFalse($this->factory->isMapperRegistered($this->mapper));
        $this->factory->registerMapper($this->mapper);
        $this->assertTrue($this->factory->isMapperRegistered($this->mapper));
    }

    public function testGetMapperReturnsRegisteredMapper()
    {
        $this->factory->registerMapper($this->mapper);
        $mapper = $this->factory->getMapper('MapperImpl');
        $this->assertSame($mapper, $this->mapper);
    }

    public function testGetMapperCreatesNewMapper()
    {
        $mapper = $this->factory->getMapper('MapperImpl');
        $this->assertNotSame($mapper, $this->mapper);
    }

    public function testInvokeMagicMethodWithCustomNamespace()
    {
    	$mapper = $this->factory->getMapperImplMapper();
        $this->assertInstanceOf('MapperImpl', $mapper);
    }

    /**
     * @expectedException \BowShock\Mapper\FactoryException
     */
    public function testInvokeInvalidMapperThrowsException()
    {
        $this->factory->getNotExistsMapper();
    }

	/**
     * @expectedException \BowShock\Mapper\FactoryException
     */
    public function testInvokeInvalidMethodThrowsException()
    {
        $this->factory->totalBogus();
    }
}

