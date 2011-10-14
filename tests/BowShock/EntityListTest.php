<?php

use BowShock\EntityList;

/**
 * @covers \BowShock\EntityList
 */
class BowShock_EntityListTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var EntityList
     */
    private $list;

    /**
     * @see \PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        $this->list = new EntityList();
    }

    public function testGetIterator()
    {
        $iterator = $this->list->getIterator();
        $this->assertInstanceOf('\\BowShock\\EntityList\\Iterator', $iterator);
    }

    public function testInitialCountIsZero()
    {
        $this->assertSame(0, count($this->list));
    }

    /**
     * @depends testInitialCountIsZero
     */
    public function testAddToList()
    {
        $this->list->add('stuff');
        $this->assertSame(1, count($this->list));
    }

    /**
     * @depends testAddToList
     */
    public function testClearList()
    {
        $this->list->add('stuff');
        $this->list->clear();
        $this->assertSame(0, count($this->list));
    }

}