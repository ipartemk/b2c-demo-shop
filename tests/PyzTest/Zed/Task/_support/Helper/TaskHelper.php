<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Task\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\TaskBuilder;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Zed\Task\Business\TaskFacadeInterface;
use SprykerTest\Shared\Testify\Helper\DataCleanupHelperTrait;
use SprykerTest\Shared\Testify\Helper\DependencyHelperTrait;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;

class TaskHelper extends Module
{
    use DependencyHelperTrait;
    use LocatorHelperTrait;
    use DataCleanupHelperTrait;

    /**
     * @param array<string, mixed> $override
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function haveTask(array $override = []): TaskTransfer
    {
        $taskTransfer = (new TaskBuilder($override))
            ->build();

        $taskTransfer = $this->getTaskFacade()->create($taskTransfer);

        $this->getDataCleanupHelper()->_addCleanup(function () use ($taskTransfer): void {
            $this->debug(sprintf('Deleting Customer Task with id: %d', $taskTransfer->getIdTask()));
            $this->getTaskFacade()->delete($taskTransfer);
        });

        return $taskTransfer;
    }

    /**
     * @return \Pyz\Zed\Task\Business\TaskFacadeInterface
     */
    public function getTaskFacade(): TaskFacadeInterface
    {
        return $this->getLocatorHelper()->getLocator()->task()->facade();
    }
}
