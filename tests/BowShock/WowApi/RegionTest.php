<?php

use BowShock\WowApi\Region;

class BowShock_WowApi_RegionTest extends \PHPUnit_Framework_TestCase
{
	
	public function testGetRegionApiUrl()
	{
		$url = Region::getRegionApiUri(Region::REGION_EUROPE);
		$this->assertNotNull($url);	
	}
	
}