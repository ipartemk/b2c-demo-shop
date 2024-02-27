<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence;

use Generated\Shared\Transfer\TaskTagTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Orm\Zed\Task\Persistence\MeuTask;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\Task\Persistence\TaskPersistenceFactory getFactory()
 */
class TaskEntityManager extends AbstractEntityManager implements TaskEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function create(TaskTransfer $taskTransfer): TaskTransfer
    {
        $this->validateRequiredFields($taskTransfer);

        $taskEntity = (new MeuTask())->fromArray($taskTransfer->toArray());
        $taskEntity->save();

        return $this->getFactory()
            ->createTaskMapper()
            ->mapTaskEntityToTaskTransfer(
                $taskEntity,
                $taskTransfer,
            );
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function update(TaskTransfer $taskTransfer): TaskTransfer
    {
        $this->validateRequiredFields($taskTransfer);

        $taskEntity = $this->getFactory()
            ->getTaskPropelQuery()
            ->filterByIdTask($taskTransfer->getIdTaskOrFail())
            ->findOne();

        $taskEntity->fromArray($taskTransfer->toArray());
        $taskEntity->save();

        return $this->getFactory()
            ->createTaskMapper()
            ->mapTaskEntityToTaskTransfer(
                $taskEntity,
                $taskTransfer,
            );
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return bool
     */
    public function delete(TaskTransfer $taskTransfer): bool
    {
        return (bool)$this->getFactory()
            ->getTaskPropelQuery()
            ->filterByIdTask($taskTransfer->getIdTaskOrFail())
            ->delete();
    }

    /**
     * @param string $tag
     * @param int $idTask
     *
     * @return \Generated\Shared\Transfer\TaskTagTransfer
     */
    public function addTag(string $tag, int $idTask): TaskTagTransfer
    {
        $taskTagEntity = $this->getFactory()->getTaskTagPropelQuery()
            ->filterByTag($tag)
            ->findOneOrCreate();

        $taskTagEntity->save();

        $taskTagRelationEntity = $this->getFactory()->getTaskTagRelationPropelQuery()
            ->filterByFkTask($idTask)
            ->filterByFkTaskTag($taskTagEntity->getIdTaskTag())
            ->findOneOrCreate();

        $taskTagRelationEntity->save();

        return $this->getFactory()
            ->createTaskMapper()
            ->mapTaskTagEntityToTaskTagTransfer(
                $taskTagEntity,
                new TaskTagTransfer(),
            );
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return void
     */
    private function validateRequiredFields(TaskTransfer $taskTransfer): void
    {
        $taskTransfer->requireFkCreator()
            ->requireTitle()
            ->requireDescription()
            ->requireDueDate()
            ->requireStatus();
    }
}
