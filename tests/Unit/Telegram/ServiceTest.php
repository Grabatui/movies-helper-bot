<?php

namespace Tests\Unit\Telegram;

use App\Commands\AbstractCommand;
use App\Commands\Actions\AbstractAction;
use App\Telegram\Exception\UnknownRequestException;
use App\Telegram\Response\UpdateResponse;
use App\Telegram\Service;
use Tests\TestCase;

class TestCommand extends AbstractCommand
{
    public static function getName(): string
    {
        return 'testCommandName';
    }

    public function handle(): void
    {
        global $temporaryCommandResult;

        $temporaryCommandResult = true;
    }
}

class TestAction extends AbstractAction
{
    public static function getName(): string
    {
        return 'testName';
    }

    public function handle(): void
    {
        global $temporaryCommandResult;

        $temporaryCommandResult = true;
    }

    public function isSatisfied(): bool
    {
        global $temporaryActionReturn;

        return ! is_null($temporaryActionReturn) ? $temporaryActionReturn : false;
    }
}

class ServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setPseudoConfig();
    }

    public function test_findAndHandleCommand_throwsException(): void
    {
        $service = $this->getService();

        $this->expectException(UnknownRequestException::class);

        $service->findAndHandleCommand(
            $this->getDummyUpdateResponse()
        );
    }

    public function test_findAndHandleCommand_happyPath_command(): void
    {
        $service = $this->getService();

        $service->findAndHandleCommand(
            $this->getDummyUpdateResponse([
                'message' => [
                    'message_id' => 1,
                    'date' => time(),
                    'chat' => [
                        'id' => 1,
                        'type' => 'private',
                    ],
                    'text' => '/testCommandName',
                ],
            ])
        );

        global $temporaryCommandResult;

        $this->assertTrue($temporaryCommandResult);
    }

    public function test_findAndHandleCommand_happyPath_action(): void
    {
        $service = $this->getService();

        global $temporaryActionReturn;

        $temporaryActionReturn = true;

        $service->findAndHandleCommand(
            $this->getDummyUpdateResponse()
        );

        global $temporaryCommandResult;

        $this->assertTrue($temporaryCommandResult);
    }

    public function test_findAndHandleCommand_action_notSatisfied(): void
    {
        $service = $this->getService();

        global $temporaryActionReturn;

        $temporaryActionReturn = false;

        $this->expectException(UnknownRequestException::class);

        $service->findAndHandleCommand(
            $this->getDummyUpdateResponse()
        );
    }

    private function setPseudoConfig(): void
    {
        config([
            'telegram' => [
                'commands' => [TestCommand::class],
                'actions' => [TestAction::class],
            ],
        ]);
    }

    private function getService(): Service
    {
        return new Service();
    }

    private function getDummyUpdateResponse(array $response = []): UpdateResponse
    {
        return new UpdateResponse(array_merge(
            [
                'update_id' => 1,
            ],
            $response
        ));
    }
}
