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
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\TasksRestApi\TasksRestApiFactory getFactory()
 */
class TasksRestApiClient extends AbstractClient implements TasksRestApiClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionResponseTransfer
     */
    public function get(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionResponseTransfer
    {
        return $this->getFactory()->createTasksRestApiZedStub()->get($taskCriteriaTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function getOne(TaskCriteriaTransfer $taskCriteriaTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createTasksRestApiZedStub()->getOne($taskCriteriaTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function create(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createTasksRestApiZedStub()->create($taskTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function update(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createTasksRestApiZedStub()->update($taskTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function delete(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createTasksRestApiZedStub()->delete($taskTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestTaskAssignRequestTransfer $restTaskAssignRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function assign(RestTaskAssignRequestTransfer $restTaskAssignRequestTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createTasksRestApiZedStub()->assign($restTaskAssignRequestTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestTaskTagRequestTransfer $restTaskTagRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function addTag(RestTaskTagRequestTransfer $restTaskTagRequestTransfer): TaskResponseTransfer
    {
        return $this->getFactory()->createTasksRestApiZedStub()->addTag($restTaskTagRequestTransfer);
    }
}
