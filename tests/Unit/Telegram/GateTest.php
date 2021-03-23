<?php

namespace Tests\Unit\Telegram;

use App\Telegram\Exception\WrongResponseException;
use App\Telegram\Gate;
use App\Telegram\Request\GetMeRequest;
use App\Telegram\Request\RequestInterface;
use App\Telegram\Response\GetMeResponse;
use App\Telegram\Response\ResponseInterface;
use GuzzleHttp\Client;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;
use Tests\TestCase;

class GateTest extends TestCase
{
    public function test_call_happyPath(): void
    {
        $request = new GetMeRequest();
        $response = new GetMeResponse([
            'result' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'FirstName',
            ],
        ]);

        $client = $this->getGuzzleClient($request, $response);

        $gate = $this->getGate($client);

        /** @var GetMeResponse $actualResponse */
        $actualResponse = $gate->call($request);

        $this->assertEquals($response->user, $actualResponse->user);
    }

    public function test_call_throwsException(): void
    {
        $request = new GetMeRequest();
        $response = new GetMeResponse([
            'result' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'FirstName',
            ],
        ]);

        $client = $this->getGuzzleClient($request, $response, false);

        $gate = $this->getGate($client);

        $this->expectException(WrongResponseException::class);

        $gate->call($request);
    }

    private function getGuzzleClient(RequestInterface $request, ResponseInterface $response, bool $isSuccess = true)
    {
        $client = $this->prophesize(Client::class);

        $body = $this->prophesize(StreamInterface::class);
        $body->getContents()->willReturn(
            json_encode(
                $isSuccess
                    ? array_merge($response->toArray(), ['ok' => true])
                    : $response->toArray()
            )
        );

        $guzzleResponse = $this->prophesize(\Psr\Http\Message\ResponseInterface::class);
        $guzzleResponse->getBody()->willReturn($body->reveal());

        $client
            ->request(
                $request->getMethod()->getValue(),
                Argument::containing($request->getUri())->getKey(),
                $request->toArray()
            )
            ->willReturn($guzzleResponse->reveal());

        return $client;
    }

    private function getGate($client): Gate
    {
        return new Gate(
            $client->reveal(),
            app('log')
        );
    }
}
