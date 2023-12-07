<?php

declare(strict_types=1);

namespace A50\Telegram\UI\Console\Telegram;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use A50\Telegram\Application\SetBotWebhook\SetBotWebhookCommand;
use A50\Telegram\Application\SetBotWebhook\SetBotWebhookHandler;

final class SetWebhookCommand extends Command
{
    private SetBotWebhookHandler $handler;

    public function __construct(SetBotWebhookHandler $handler)
    {
        $this->handler = $handler;
        parent::__construct();
    }

    /**
     */
    protected function configure(): void
    {
        $this
            ->setName("telegram:set-webhook '<url>'")
            ->setDescription('Specify a url and receive incoming updates via an outgoing webhook')
            ->addArgument('url', InputArgument::REQUIRED, 'Webhook url');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            /** @var string $url */
            $url = $input->getArgument('url');

            $command = new SetBotWebhookCommand();
            $command->url = $url;

            $this->handler->__invoke($command);

            $output->writeln(\sprintf('<info>Webhook "%s" was successfully set up.</info>', $url));

            return 0;
        } catch (Exception $exception) {
            $output->writeln(\sprintf('<error>Something went wrong: %s</error>', $exception->getMessage()));

            return 1;
        }
    }
}
