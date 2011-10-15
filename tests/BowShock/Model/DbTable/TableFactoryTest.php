<?php

require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
require_once 'Zend/Db/Table/Abstract.php';

require_once 'tests/BowShock/Mapper/MapperImpl.php';
require_once 'DbTableImpl.php';

use BowShock\Model\DbTable\TableFactory,
	BowShock\Mapper\Db\TestDummy;

/**
 * @covers \BowShock\Model\DbTable\TableFactory
 */
class BowShock_Model_DbTable_TableFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \BowShock\Model\DbTable\TableFactory
     */
    private $factory;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->factory = TableFactory::getInstance();
        $this->adapter = $this->getMock('Zend_Db_Adapter_Pdo_MySql', array(), array(), '', false);
        Zend_Db_Table_Abstract::setDefaultAdapter($this->adapter);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->factory->resetInstance();
        parent::tearDown();
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('\\BowShock\\Model\\DbTable\\TableFactory', $this->factory);
    }

    public function testResetInstance()
    {
        $firstInstance = TableFactory::getInstance();
        TableFactory::resetInstance();
        $secondInstance = TableFactory::getInstance();
        $this->assertNotSame($firstInstance, $secondInstance);
    }

    public function testSetDefaultTable()
    {
        $this->factory->setDefaultTable('Boogus');
        $this->assertSame('Boogus', $this->factory->getDefaultTable());
    }

    public function testSetTableForMapper()
    {
        $this->factory->setTableForMapper('TestTable', 'TestMapper');
        $this->assertSame('TestTable', $this->factory->getTableForMapper('TestMapper'));
    }

    public function testFactoryMethod()
    {
        $params = array(
            'default' => 'DefaultTable',
            'map' => array(
                'TestMapper' => 'TestTable'
            )
        );

        TableFactory::factory($params);
        $this->assertSame('DefaultTable', $this->factory->getDefaultTable());
        $this->assertSame('TestTable', $this->factory->getTableForMapper('TestMapper'));
    }

    public function testCreateDefaultTable()
    {
        $this->factory->setDefaultTable('DbTableImpl');
        $this->assertInstanceOf('DbTableImpl', $this->factory->createMappedTable('...'));
    }

    public function testCreateMappedTable()
    {
        $this->factory->setTableForMapper('DbTableImpl', 'MapperImpl');
        $mapper = new MapperImpl();
        $this->assertInstanceOf('DbTableImpl', $this->factory->createMappedTable($mapper));
    }

    /**
     * @expectedException BowShock\Model\DbTable\FactoryException
     */
    public function testNoDefaultTableThrowsException()
    {
        $this->factory->createMappedTable('...');
    }

	/**
     * @expectedException BowShock\Model\DbTable\FactoryException
     */
    public function testRegisteredBogusTableThrowsException()
    {
        $this->factory->setTableForMapper('Boogus', 'DbTableImpl');
        $this->factory->createMappedTable('DbTableImpl');
    }

}

