<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskTagTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Orm\Zed\Task\Persistence\MeuTask;
use Orm\Zed\Task\Persistence\MeuTaskTag;
use Propel\Runtime\Collection\ObjectCollection;

class TaskMapper
{
    /**
     * @param \Propel\Runtime\Collection\ObjectCollection $taskEntities
     * @param \Generated\Shared\Transfer\TaskCollectionTransfer $taskCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionTransfer
     */
    public function mapTaskEntitiesToTaskCollectionTransfer(
        ObjectCollection $taskEntities,
        TaskCollectionTransfer $taskCollectionTransfer,
    ): TaskCollectionTransfer {
        foreach ($taskEntities as $taskEntity) {
            $taskCollectionTransfer->addTask(
                $this->mapTaskEntityToTaskTransfer(
                    $taskEntity,
                    new TaskTransfer(),
                ),
            );
        }

        return $taskCollectionTransfer;
    }

    /**
     * @param \Orm\Zed\Task\Persistence\MeuTask $taskEntity
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function mapTaskEntityToTaskTransfer(
        MeuTask $taskEntity,
        TaskTransfer $taskTransfer,
    ): TaskTransfer {
        $taskTransfer->fromArray($taskEntity->toArray(), true);
        foreach ($taskEntity->getMeuTaskTagRelationsJoinMeuTaskTag() as $entity) {
            $taskTagTransfer = $this->mapTaskTagEntityToTaskTagTransfer(
                $entity->getMeuTaskTag(),
                new TaskTagTransfer(),
            );

            $taskTransfer->addTag($taskTagTransfer);
        }

        return $taskTransfer;
    }

    /**
     * @param \Orm\Zed\Task\Persistence\MeuTaskTag $taskTagEntity
     * @param \Generated\Shared\Transfer\TaskTagTransfer $taskTagTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTagTransfer
     */
    public function mapTaskTagEntityToTaskTagTransfer(
        MeuTaskTag $taskTagEntity,
        TaskTagTransfer $taskTagTransfer,
    ): TaskTagTransfer {
        return $taskTagTransfer->fromArray($taskTagEntity->toArray(), true);
    }
}
