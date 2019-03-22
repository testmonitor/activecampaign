<?php

namespace Tests;

class ActiveCampaignTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function test_making_basic_requests()
    {
        $testmonitor = new \ByTestGear\TestMonitorAdmin\TestMonitor('', '123', $http = Mockery::mock('GuzzleHttp\Client'));

        $http->shouldReceive('request')->once()->with('GET', 'websites', [])->andReturn(
            $response = Mockery::mock('GuzzleHttp\Psr7\Response')
        );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn('{"data": [{"key": "value"}]}');

        $testmonitor->websites();
    }

    public function test_handling_validation_errors()
    {
        $testmonitor = new \ByTestGear\TestMonitorAdmin\TestMonitor('', '123', $http = Mockery::mock('GuzzleHttp\Client'));

        $http->shouldReceive('request')->once()->with('GET', 'websites', [])->andReturn(
            $response = Mockery::mock('GuzzleHttp\Psr7\Response')
        );

        $response->shouldReceive('getStatusCode')->andReturn(422);
        $response->shouldReceive('getBody')->once()->andReturn('{"errors": {"name": ["The name is required."]}}');

        try {
            $testmonitor->websites();
        } catch (\ByTestGear\TestMonitorAdmin\Exceptions\ValidationException $e) {
        }

        $this->assertEquals(['name' => ['The name is required.']], $e->errors());
    }

    public function test_handling_404_errors()
    {
        $this->expectException(\ByTestGear\TestMonitorAdmin\Exceptions\NotFoundException::class);

        $testmonitor = new \ByTestGear\TestMonitorAdmin\TestMonitor('', '123', $http = Mockery::mock('GuzzleHttp\Client'));

        $http->shouldReceive('request')->once()->with('GET', 'websites', [])->andReturn(
            $response = Mockery::mock('GuzzleHttp\Psr7\Response')
        );

        $response->shouldReceive('getStatusCode')->andReturn(404);

        $testmonitor->websites();
    }

    public function test_handling_failed_action_errors()
    {
        $testmonitor = new \ByTestGear\TestMonitorAdmin\TestMonitor('', '123', $http = Mockery::mock('GuzzleHttp\Client'));

        $http->shouldReceive('request')->once()->with('GET', 'websites', [])->andReturn(
            $response = Mockery::mock('GuzzleHttp\Psr7\Response')
        );

        $response->shouldReceive('getStatusCode')->andReturn(400);
        $response->shouldReceive('getBody')->once()->andReturn('Error!');

        try {
            $testmonitor->websites();
        } catch (\ByTestGear\TestMonitorAdmin\Exceptions\FailedActionException $e) {
        }

        $this->assertEquals('Error!', $e->getMessage());
    }
}