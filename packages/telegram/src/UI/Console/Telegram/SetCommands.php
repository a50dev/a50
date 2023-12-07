<?php

declare(strict_types=1);

namespace A50\Telegram\UI\Console\Telegram;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use A50\Telegram\Application\SetBotCommands\SetBotCommandsCommand;
use A50\Telegram\Application\SetBotCommands\SetBotCommandsHandler;

final class SetCommands extends Command
{
    private array $list;
    private SetBotCommandsHandler $handler;

    public function __construct(array $list, SetBotCommandsHandler $handler)
    {
        parent::__construct();
        $this->list = $list;
        $this->handler = $handler;
    }

    /**
     */
    protected function configure(): void
    {
        $this
            ->setName("telegram:set-commands")
            ->setDescription('Use this method to change the list of the bot\'s commands');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $command = new SetBotCommandsCommand();
            $command->list = $this->list;

            $this->handler->__invoke($command);

            $successMessage = "<info>Commands:</info>\n";

            foreach ($command->list as $name => $description) {
                $successMessage .= \sprintf("<info>– %s: %s.</info>\n", $name, $description);
            }

            $successMessage .= '<info>were successfully set up.</info>';
            $output->writeln($successMessage);

            return 0;
        } catch (Exception $exception) {
            $errorMessage = \sprintf('<error>Something went wrong: %s</error>', $exception->getMessage());
            $output->writeln($errorMessage);

            return 1;
        }
    }
}
