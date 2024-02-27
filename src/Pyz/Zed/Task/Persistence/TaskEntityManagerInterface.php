<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence;

use Generated\Shared\Transfer\TaskTagTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TaskEntityManagerInterface
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
     * @param string $tag
     * @param int $idTask
     *
     * @return \Generated\Shared\Transfer\TaskTagTransfer
     */
    public function addTag(string $tag, int $idTask): TaskTagTransfer;
}
