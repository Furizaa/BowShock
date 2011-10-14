<?php

use BowShock\Model\TestDummy;

/**
 * @covers \BowShock\Model\BaseModel
 */
class BowShock_Model_BaseModelTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \BowShock\Model\TestDummy
     */
    private $base;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->base = new TestDummy();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->base = null;
        parent::tearDown();
    }

    public function testModelRemembersValues()
    {
        $this->base->setOptions(array(
        	'id' => 99,
        	'created_at' => '123',
        	'updated_at' => '456',
            'testValue'  => '789'
        ));
        $this->assertSame(99, $this->base->getId());
        $this->assertSame('123', $this->base->getCreatedAt());
        $this->assertSame('456', $this->base->getUpdatedAt());
        $this->assertSame('789', $this->base->getTestValue());
    }

}

