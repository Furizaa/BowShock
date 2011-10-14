<?php

require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
require_once 'Zend/Db/Table/Abstract.php';

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
        $this->factory->setDefaultTable('BowShock\\Model\\DbTable\\TestDummy');
        $this->assertInstanceOf('BowShock\\Model\\DbTable\\TestDummy', $this->factory->createMappedTable('...'));
    }

    public function testCreateMappedTable()
    {
        $this->factory->setTableForMapper('BowShock\\Model\\DbTable\\TestDummy', 'BowShock\\Mapper\\Db\\TestDummy');
        $mapper = new TestDummy();
        $this->assertInstanceOf('BowShock\\Model\\DbTable\\TestDummy', $this->factory->createMappedTable($mapper));
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
        $this->factory->setTableForMapper('Boogus', 'BowShock\\Model\\DbTable\\TestDummy');
        $this->factory->createMappedTable('BowShock\\Model\\DbTable\\TestDummy');
    }

}

