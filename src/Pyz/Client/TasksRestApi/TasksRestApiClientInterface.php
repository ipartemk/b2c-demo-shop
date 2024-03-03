<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\TasksRestApi;

use Generated\Shared\Transfer\RestTaskAssignRequestTransfer;
use Generated\Shared\Transfer\RestTaskTagRequestTransfer;
use Generated\Shared\Transfer\TaskCollectionResponseTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TasksRestApiClientInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionResponseTransfer
     */
    public function get(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionResponseTransfer;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function getOne(TaskCriteriaTransfer $taskCriteriaTransfer): TaskResponseTransfer;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function create(TaskTransfer $taskTransfer): TaskResponseTransfer;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function update(TaskTransfer $taskTransfer): TaskResponseTransfer;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function delete(TaskTransfer $taskTransfer): TaskResponseTransfer;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\RestTaskAssignRequestTransfer $restTaskAssignRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function assign(RestTaskAssignRequestTransfer $restTaskAssignRequestTransfer): TaskResponseTransfer;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\RestTaskTagRequestTransfer $restTaskTagRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function addTag(RestTaskTagRequestTransfer $restTaskTagRequestTransfer): TaskResponseTransfer;
}
