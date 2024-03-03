<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business\Model;

use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Zed\Task\Persistence\TaskEntityManagerInterface;
use Pyz\Zed\Task\Persistence\TaskRepositoryInterface;

class TaskManager implements TaskManagerInterface
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
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function create(TaskTransfer $taskTransfer): TaskTransfer
    {
        return $this->taskEntityManager->create($taskTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function update(TaskTransfer $taskTransfer): TaskTransfer
    {
        return $this->taskEntityManager->update($taskTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return bool
     */
    public function delete(TaskTransfer $taskTransfer): bool
    {
        return $this->taskEntityManager->delete($taskTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionTransfer
     */
    public function getTaskCollection(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionTransfer
    {
        return $this->taskRepository->get($taskCriteriaTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer|null
     */
    public function findOne(TaskCriteriaTransfer $taskCriteriaTransfer): ?TaskTransfer
    {
        return $this->taskRepository->findOne($taskCriteriaTransfer);
    }
}
