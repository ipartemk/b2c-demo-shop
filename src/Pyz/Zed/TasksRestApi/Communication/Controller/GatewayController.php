<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\TasksRestApi\Communication\Controller;

use Exception;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\RestTaskAssignRequestTransfer;
use Generated\Shared\Transfer\RestTaskTagRequestTransfer;
use Generated\Shared\Transfer\TaskCollectionResponseTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskResponseTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Pyz\Zed\TasksRestApi\Communication\TasksRestApiCommunicationFactory getFactory()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE_TASK_NOT_FOUND = 'Task not found.';

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionResponseTransfer
     */
    public function getAction(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionResponseTransfer
    {
        $taskCollectionResponseTransfer = (new TaskCollectionResponseTransfer())->setIsSuccessful(false);

        try {
            $taskCollectionTransfer = $this->getFactory()
                ->getTaskFacade()
                ->getTaskCollection($taskCriteriaTransfer);
            $taskCollectionResponseTransfer->setTasks($taskCollectionTransfer)
                ->setIsSuccessful(true);
        } catch (Exception $exception) {
            return $this->handleErrorMessageForCollection($taskCollectionResponseTransfer, $exception);
        }

        return $taskCollectionResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function getOneAction(TaskCriteriaTransfer $taskCriteriaTransfer): TaskResponseTransfer
    {
        $taskResponseTransfer = (new TaskResponseTransfer())->setIsSuccessful(false);

        try {
            $taskTransfer = $this->getFactory()
                ->getTaskFacade()
                ->findTask($taskCriteriaTransfer);

            if (!$taskTransfer) {
                return $taskResponseTransfer->addMessage(
                    (new MessageTransfer())->setMessage(self::ERROR_MESSAGE_TASK_NOT_FOUND),
                );
            }

            $taskResponseTransfer->setTask($taskTransfer)
                ->setIsSuccessful(true);
        } catch (Exception $exception) {
            return $this->handleErrorMessage($taskResponseTransfer, $exception);
        }

        return $taskResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function createAction(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        $taskResponseTransfer = (new TaskResponseTransfer())->setIsSuccessful(false);

        try {
            $taskTransfer = $this->getFactory()
                ->getTaskFacade()
                ->create($taskTransfer);

            $taskResponseTransfer->setTask($taskTransfer)
                ->setIsSuccessful(true);
        } catch (Exception $exception) {
            return $this->handleErrorMessage($taskResponseTransfer, $exception);
        }

        return $taskResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function updateAction(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        $taskResponseTransfer = (new TaskResponseTransfer())->setIsSuccessful(false);

        try {
            $taskTransfer = $this->getFactory()
                ->getTaskFacade()
                ->update($taskTransfer);

            $taskResponseTransfer->setTask($taskTransfer)
                ->setIsSuccessful(true);
        } catch (Exception $exception) {
            return $this->handleErrorMessage($taskResponseTransfer, $exception);
        }

        return $taskResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function deleteAction(TaskTransfer $taskTransfer): TaskResponseTransfer
    {
        $taskResponseTransfer = (new TaskResponseTransfer())->setIsSuccessful(false);

        try {
            $result = $this->getFactory()
                ->getTaskFacade()
                ->delete($taskTransfer);

            $taskResponseTransfer->setIsSuccessful($result);
        } catch (Exception $exception) {
            return $this->handleErrorMessage($taskResponseTransfer, $exception);
        }

        return $taskResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestTaskAssignRequestTransfer $restTaskAssignRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function assignAction(RestTaskAssignRequestTransfer $restTaskAssignRequestTransfer): TaskResponseTransfer
    {
        $taskResponseTransfer = (new TaskResponseTransfer())->setIsSuccessful(false);

        try {
            $taskTransfer = $this->getFactory()
                ->getTaskFacade()
                ->assign(
                    $restTaskAssignRequestTransfer->getEmail(),
                    $restTaskAssignRequestTransfer->getIdTask(),
                );

            $taskResponseTransfer->setTask($taskTransfer)
                ->setIsSuccessful(true);
        } catch (Exception $exception) {
            return $this->handleErrorMessage($taskResponseTransfer, $exception);
        }

        return $taskResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestTaskTagRequestTransfer $restTaskTagRequestTransfer
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    public function addTagAction(RestTaskTagRequestTransfer $restTaskTagRequestTransfer): TaskResponseTransfer
    {
        $taskResponseTransfer = (new TaskResponseTransfer())->setIsSuccessful(false);

        try {
            $taskTransfer = $this->getFactory()
                ->getTaskFacade()
                ->addTag(
                    $restTaskTagRequestTransfer->getTag(),
                    $restTaskTagRequestTransfer->getIdTask(),
                );

            $taskResponseTransfer->setTask($taskTransfer)
                ->setIsSuccessful(true);
        } catch (Exception $exception) {
            return $this->handleErrorMessage($taskResponseTransfer, $exception);
        }

        return $taskResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskCollectionResponseTransfer $responseTransfer
     * @param \Exception $exception
     *
     * @return \Generated\Shared\Transfer\TaskCollectionResponseTransfer
     */
    private function handleErrorMessageForCollection(
        TaskCollectionResponseTransfer $responseTransfer,
        Exception $exception,
    ): TaskCollectionResponseTransfer {
        $messageTransfer = (new MessageTransfer())->setMessage($exception->getMessage());
        $responseTransfer->addMessage($messageTransfer);

        return $responseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskResponseTransfer $responseTransfer
     * @param \Exception $exception
     *
     * @return \Generated\Shared\Transfer\TaskResponseTransfer
     */
    private function handleErrorMessage(
        TaskResponseTransfer $responseTransfer,
        Exception $exception,
    ): TaskResponseTransfer {
        $messageTransfer = (new MessageTransfer())->setMessage($exception->getMessage());
        $responseTransfer->addMessage($messageTransfer);

        return $responseTransfer;
    }
}
