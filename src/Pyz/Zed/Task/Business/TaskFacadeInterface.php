<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business;

use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TaskFacadeInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function create(TaskTransfer $taskTransfer): TaskTransfer;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function update(TaskTransfer $taskTransfer): TaskTransfer;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return bool
     */
    public function delete(TaskTransfer $taskTransfer): bool;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionTransfer
     */
    public function getTaskCollection(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionTransfer;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer|null
     */
    public function findTask(TaskCriteriaTransfer $taskCriteriaTransfer): ?TaskTransfer;

    /**
     * @api
     *
     * @return void
     */
    public function notifyAboutOverdueTasks(): void;

    /**
     * @api
     *
     * @param string $customerEmail
     * @param int $idTask
     *
     * @throws \Pyz\Zed\Task\Business\Exception\TaskNotFoundException
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function assign(string $customerEmail, int $idTask): TaskTransfer;

    /**
     * @api
     *
     * @param string $tag
     * @param int $idTask
     *
     * @throws \Pyz\Zed\Task\Business\Exception\TaskNotFoundException
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function addTag(string $tag, int $idTask): TaskTransfer;
}
