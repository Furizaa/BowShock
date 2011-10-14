<?php

use BowShock\EntityList\Iterator;

/**
 * @covers BowShock\EntityList\Iterator
 */
class BowShock_EntityList_IteratorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * SUT
     * @var Iterator
     */
    private $iterator;

    /**
     * @see \PHPUnit_Framework_TestCase::setUp()	
     */
    public function setUp()
    {
        $testData = array('one', 'two', 'three');
        $this->iterator = new Iterator($testData);
    }

    public function testCurrentIsFirst()
    {
        $this->assertSame('one', $this->iterator->current());
    }

    /**
     * @depends testCurrentIsFirst
     */
    public function testIterate()
    {
        $this->iterator->next();
        $this->assertSame('two', $this->iterator->current());
    }

    /**
     * @depends testIterate
     */
    public function testRewind()
    {
        $this->iterator->next();
        $this->iterator->rewind();
        $this->assertSame('one', $this->iterator->current());
    }

    /**
     * @depends testRewind
     */
    public function testValid()
    {
        $counter = 0;
        while ($this->iterator->valid()) {
            $counter++;
            $this->iterator->next();
        }
        $this->assertSame(3, $counter);
    }

    /**
     * @depends testValid
     */
    public function testKey()
    {
        $this->assertSame(0, $this->iterator->key());
        $this->iterator->next();
        $this->assertSame(1, $this->iterator->key());
    }

}