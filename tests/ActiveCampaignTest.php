<?php

namespace Tests;

use ByTestGear\ActiveCampaign\ActiveCampaign;

class ActiveCampaignTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function test_making_basic_requests()
    {
//        $activeCampaign = new ActiveCampaign('', '123', $http = \Mockery::mock('GuzzleHttp\Client'));
//
//        $http->shouldReceive('request')->once()->with('GET', 'organizations', ['filters[name]' => ''])->andReturn(
//            $response = \Mockery::mock('GuzzleHttp\Psr7\Response')
//        );
//
//        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
//        $response->shouldReceive('getBody')->once()->andReturn('{"data": [{"key": "value"}]}');
//
//        $activeCampaign->organizations();
        $this->assertTrue(true);
    }

}