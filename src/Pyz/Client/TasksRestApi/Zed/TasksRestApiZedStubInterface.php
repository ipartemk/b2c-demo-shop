<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\TasksRestApi\Zed;

use Generated\Shared\Transfer\RestTaskAssignRequestTransfer;
use Generated\Shared\Transfer\RestTaskTagRequestTransfer;
use Generated\Shared\Transfer\TaskCollectionResponseTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TasksRestApiZedStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionResponseTransfer
     */
    public function get(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function getOne(TaskCriteriaTransfer $taskCriteriaTransfer): TaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function create(TaskTransfer $taskTransfer): TaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function update(TaskTransfer $taskTransfer): TaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function delete(TaskTransfer $taskTransfer): TaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestTaskAssignRequestTransfer $restTaskAssignRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function assign(RestTaskAssignRequestTransfer $restTaskAssignRequestTransfer): TaskResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestTaskTagRequestTransfer $restTaskTagRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function addTag(RestTaskTagRequestTransfer $restTaskTagRequestTransfer): TaskResponseTransfer;
}
