<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business;

use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\Task\Business\TaskBusinessFactory getFactory()
 * @method \Pyz\Zed\Task\Persistence\TaskRepositoryInterface getRepository()
 * @method \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface getEntityManager()
 */
class TaskFacade extends AbstractFacade implements TaskFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function create(TaskTransfer $taskTransfer): TaskTransfer
    {
        return $this->getFactory()->createTaskManager()->create($taskTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function update(TaskTransfer $taskTransfer): TaskTransfer
    {
        return $this->getFactory()->createTaskManager()->update($taskTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return bool
     */
    public function delete(TaskTransfer $taskTransfer): bool
    {
        return $this->getFactory()->createTaskManager()->delete($taskTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionTransfer
     */
    public function getTaskCollection(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionTransfer
    {
        return $this->getFactory()->createTaskManager()->getTaskCollection($taskCriteriaTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer|null
     */
    public function findTask(TaskCriteriaTransfer $taskCriteriaTransfer): ?TaskTransfer
    {
        return $this->getFactory()->createTaskManager()->findOne($taskCriteriaTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function notifyAboutOverdueTasks(): void
    {
        $this->getFactory()->createTaskOverdueNotifier()->notify();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $customerEmail
     * @param int $idTask
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function assign(string $customerEmail, int $idTask): TaskTransfer
    {
        return $this->getFactory()->createTaskAssigner()->assign($customerEmail, $idTask);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $tag
     * @param int $idTask
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function addTag(string $tag, int $idTask): TaskTransfer
    {
        return $this->getFactory()->createTaskTagManager()->addTag($tag, $idTask);
    }
}
