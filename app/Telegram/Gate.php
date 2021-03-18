<?php

namespace App\Telegram;

use App\Telegram\Exception\WrongResponseException;
use App\Telegram\Request\AbstractGetRequest;
use App\Telegram\Request\AbstractPostRequest;
use App\Telegram\Request\RequestInterface;
use App\Telegram\Response\ResponseInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Log\LogManager;
use JsonException;

class Gate
{
    private Client $client;

    private LogManager $logger;

    public function __construct(
        Client $client,
        LogManager $logger
    )
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function call(RequestInterface $request): ResponseInterface
    {
        [$uri, $parameters] = $this->processRequest($request);

        try {
            $rawResponse = $this->client->request(
                $request->getMethod()->getValue(),
                $uri,
                $parameters
            );

            $rawResponse = $rawResponse->getBody()->getContents();

            $response = $this->parseRawResponse($rawResponse);

            $this->debugResponse($request, $response);

            if ( ! isset($response['ok']) || ! $response['ok']) {
                throw new WrongResponseException($rawResponse);
            }

            return $request->makeResponse($response);
        } catch (GuzzleException | JsonException | WrongResponseException $exception) {
            $this->logger->critical('Telegram: Response EXCEPTION: ' . $exception->getMessage());

            throw $exception;
        }
    }

    private function processRequest(RequestInterface $request): array
    {
        $token = config('telegram.token', '') ?? '';

        $uri = sprintf('/bot%s%s', $token, $request->getUri());

        $parameters = [];
        if ($request instanceof AbstractGetRequest) {
            $uri .= '?' . http_build_query($request->toArray());
        } elseif ($request instanceof AbstractPostRequest) {
            $parameters['json'] = $request->toArray();
        }

        $this->debugRequest($request, $request->toArray());

        return [$uri, $parameters];
    }

    /**
     * @param string $rawResponse
     * @return array
     * @throws JsonException
     */
    private function parseRawResponse(string $rawResponse): array
    {
        return json_decode($rawResponse, true, 512, JSON_THROW_ON_ERROR);
    }

    private function debugRequest(RequestInterface $request, array $data = []): void
    {
        $logMessage = sprintf(
            'Telegram: Request [%s]: %s',
            $request->getMethod()->getValue(),
            $request->getUri()
        );

        $this->logger->debug($logMessage, $data);
    }

    private function debugResponse(RequestInterface $request, array $response): void
    {
        $logMessage = sprintf(
            'Telegram: Response [%s]: %s',
            $request->getMethod()->getValue(),
            $request->getUri()
        );

        $this->logger->debug($logMessage, $response);
    }
}
