<?php

namespace Tests\Unit\Telegram;

use App\Telegram\Facade;
use App\Telegram\Gate;
use App\Telegram\Request\GetMeRequest;
use App\Telegram\Response\GetMeResponse;
use BadMethodCallException;
use Prophecy\Argument;
use Tests\TestCase;

class FacadeTest extends TestCase
{
    public function test_existsMethod(): void
    {
        $response = $this->prophesize(GetMeResponse::class)->reveal();

        $facade = $this->getFacade($response);

        $request = $this->prophesize(GetMeRequest::class);

        $result = $facade->getMe($request->reveal());

        $this->assertInstanceOf(GetMeResponse::class, $result);
    }

    public function test_throwsException(): void
    {
        $response = $this->prophesize(GetMeResponse::class)->reveal();

        $facade = $this->getFacade($response);

        $request = $this->prophesize(GetMeRequest::class);

        $this->expectException(BadMethodCallException::class);

        $facade->notExistsMethod($request->reveal());
    }

    private function getFacade($return): Facade
    {
        $gate = $this->prophesize(Gate::class);

        $gate
            ->call(Argument::any())
            ->willReturn($return);

        return new Facade($gate->reveal());
    }
}
