<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business\Model;

use Generated\Shared\Transfer\TaskConditionsTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Zed\Task\Business\Exception\TaskNotFoundException;
use Pyz\Zed\Task\Persistence\TaskEntityManagerInterface;
use Pyz\Zed\Task\Persistence\TaskRepositoryInterface;

class TaskTagManager implements TaskTagManagerInterface
{
    private TaskRepositoryInterface $taskRepository;

    private TaskEntityManagerInterface $taskEntityManager;

    /**
     * @param \Pyz\Zed\Task\Persistence\TaskRepositoryInterface $taskRepository
     * @param \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface $taskEntityManager
     */
    public function __construct(
        TaskRepositoryInterface $taskRepository,
        TaskEntityManagerInterface $taskEntityManager,
    ) {
        $this->taskRepository = $taskRepository;
        $this->taskEntityManager = $taskEntityManager;
    }

    /**
     * @param string $tag
     * @param int $idTask
     *
     * @throws \Pyz\Zed\Task\Business\Exception\TaskNotFoundException
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function addTag(string $tag, int $idTask): TaskTransfer
    {
        $taskCriteriaTransfer = (new TaskCriteriaTransfer())->setTaskConditions(
            (new TaskConditionsTransfer())->setIdTask($idTask),
        );

        $taskTransfer = $this->taskRepository->findOne($taskCriteriaTransfer);

        if (!$taskTransfer) {
            throw new TaskNotFoundException();
        }

        $taskTagTransfer = $this->taskEntityManager->addTag($tag, $idTask);
        $taskTransfer->addTag($taskTagTransfer);

        return $taskTransfer;
    }
}
