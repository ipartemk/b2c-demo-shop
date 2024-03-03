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
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class TasksRestApiZedStub implements TasksRestApiZedStubInterface
{
    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    private ZedRequestClientInterface $zedRequestClient;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @uses \Pyz\Zed\TasksRestApi\Communication\Controller\GatewayController::getAction()
     *
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionResponseTransfer
     */
    public function get(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\TaskCollectionResponseTransfer $taskCollectionResponseTransfer */
        $taskCollectionResponseTransfer = $this->zedRequestClient->call('/tasks-rest-api/gateway/get', $taskCriteriaTransfer);

        return $taskCollectionResponseTransfer;
    }

    /**
     * @uses \Pyz\Zed\TasksRestApi\Communication\Controller\GatewayController::getOneAction()
     *
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function getOne(TaskCriteriaTransfer $taskCriteriaTransfer): TaskResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\TaskResponseTransfer $taskResponseTransfer */
        $taskResponseTransfer = $this->zedRequestClient->call('/tasks-rest-api/gateway/get-one', $taskCriteriaTransfer);

        return $taskResponseTransfer;
    }

    /**
     * @uses \Pyz\Zed\TasksRestApi\Communication\Controller\GatewayController::createAction()
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function create(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\TaskResponseTransfer $taskResponseTransfer */
        $taskResponseTransfer = $this->zedRequestClient->call('/tasks-rest-api/gateway/create', $taskTransfer);

        return $taskResponseTransfer;
    }

    /**
     * @uses \Pyz\Zed\TasksRestApi\Communication\Controller\GatewayController::updateAction()
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function update(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\TaskResponseTransfer $taskResponseTransfer */
        $taskResponseTransfer = $this->zedRequestClient->call('/tasks-rest-api/gateway/update', $taskTransfer);

        return $taskResponseTransfer;
    }

    /**
     * @uses \Pyz\Zed\TasksRestApi\Communication\Controller\GatewayController::deleteAction()
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function delete(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\TaskResponseTransfer $taskResponseTransfer */
        $taskResponseTransfer = $this->zedRequestClient->call('/tasks-rest-api/gateway/delete', $taskTransfer);

        return $taskResponseTransfer;
    }

    /**
     * @uses \Pyz\Zed\TasksRestApi\Communication\Controller\GatewayController::assignAction()
     *
     * @param \Generated\Shared\Transfer\RestTaskAssignRequestTransfer $restTaskAssignRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function assign(RestTaskAssignRequestTransfer $restTaskAssignRequestTransfer): TaskResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\TaskResponseTransfer $taskResponseTransfer */
        $taskResponseTransfer = $this->zedRequestClient->call('/tasks-rest-api/gateway/assign', $restTaskAssignRequestTransfer);

        return $taskResponseTransfer;
    }

    /**
     * @uses \Pyz\Zed\TasksRestApi\Communication\Controller\GatewayController::addTagAction()
     *
     * @param \Generated\Shared\Transfer\RestTaskTagRequestTransfer $restTaskTagRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function addTag(RestTaskTagRequestTransfer $restTaskTagRequestTransfer): TaskResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\TaskResponseTransfer $taskResponseTransfer */
        $taskResponseTransfer = $this->zedRequestClient->call('/tasks-rest-api/gateway/add-tag', $restTaskTagRequestTransfer);

        return $taskResponseTransfer;
    }
}
