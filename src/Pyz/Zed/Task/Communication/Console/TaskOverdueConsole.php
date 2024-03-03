<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \Pyz\Zed\Task\Business\TaskFacadeInterface getFacade()
 * @method \Pyz\Zed\Task\Persistence\TaskRepositoryInterface getRepository()
 */
class TaskOverdueConsole extends Console
{
    /**
     * @var string
     */
    public const COMMAND_NAME = 'task:overdue-notification';

    /**
     * @var string
     */
    public const COMMAND_DESCRIPTION = 'Sends notifications for customers about overdue tasks.';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(static::COMMAND_NAME);
        $this->setDescription(static::COMMAND_DESCRIPTION);

        parent::configure();
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->getFacade()->notifyAboutOverdueTasks();

        return static::CODE_SUCCESS;
    }
}
