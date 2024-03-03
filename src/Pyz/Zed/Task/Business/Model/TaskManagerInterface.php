<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business\Model;

use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TaskManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function create(TaskTransfer $taskTransfer): TaskTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function update(TaskTransfer $taskTransfer): TaskTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return bool
     */
    public function delete(TaskTransfer $taskTransfer): bool;

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionTransfer
     */
    public function getTaskCollection(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer|null
     */
    public function findOne(TaskCriteriaTransfer $taskCriteriaTransfer): ?TaskTransfer;
}
