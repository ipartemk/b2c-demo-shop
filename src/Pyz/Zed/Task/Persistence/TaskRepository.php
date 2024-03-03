<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence;

use DateTime;
use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Orm\Zed\Task\Persistence\MeuTaskQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Pyz\Zed\Task\TaskConfig;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Spryker\Zed\PropelOrm\Business\Runtime\ActiveQuery\Criteria as SprykerCriteria;

/**
 * @method \Pyz\Zed\Task\Persistence\TaskPersistenceFactory getFactory()
 */
class TaskRepository extends AbstractRepository implements TaskRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskCollectionTransfer
     */
    public function get(TaskCriteriaTransfer $taskCriteriaTransfer): TaskCollectionTransfer
    {
        $taskQuery = $this->getFactory()->getTaskPropelQuery();
        $taskQuery = $this->applyCriteria($taskCriteriaTransfer, $taskQuery);
        $taskQuery = $this->applyPagination($taskCriteriaTransfer, $taskQuery);

        $taskCollectionTransfer = (new TaskCollectionTransfer())->setPagination(
            $taskCriteriaTransfer->getPagination(),
        );

        return $this->getFactory()->createTaskMapper()->mapTaskEntitiesToTaskCollectionTransfer(
            $taskQuery->find(),
            $taskCollectionTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer|null
     */
    public function findOne(TaskCriteriaTransfer $taskCriteriaTransfer): ?TaskTransfer
    {
        $taskQuery = $this->getFactory()->getTaskPropelQuery();
        $taskQuery = $this->applyCriteria($taskCriteriaTransfer, $taskQuery);

        $taskEntity = $taskQuery->findOne();

        if (!$taskEntity) {
            return null;
        }

        return $this->getFactory()->createTaskMapper()->mapTaskEntityToTaskTransfer(
            $taskEntity,
            new TaskTransfer(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     * @param \Orm\Zed\Task\Persistence\MeuTaskQuery $taskQuery
     *
     * @return \Orm\Zed\Task\Persistence\MeuTaskQuery
     */
    private function applyCriteria(
        TaskCriteriaTransfer $taskCriteriaTransfer,
        MeuTaskQuery $taskQuery,
    ): MeuTaskQuery {
        if (!$taskCriteriaTransfer->getTaskConditions()) {
            return $taskQuery;
        }

        if ($taskCriteriaTransfer->getTaskConditions()->getIdTask() !== null) {
            $taskQuery->filterByIdTask(
                $taskCriteriaTransfer->getTaskConditions()
                    ->getIdTask(),
            );
        }

        if (count($taskCriteriaTransfer->getTaskConditions()->getTaskIds()) > 0) {
            $taskQuery->filterByIdTask_In(
                $taskCriteriaTransfer->getTaskConditions()
                    ->getTaskIds(),
            );
        }

        if ($taskCriteriaTransfer->getTaskConditions()->getIsOverdue() === true) {
            $taskQuery->filterByDueDate(
                ['max' => new DateTime('-1 day')],
                SprykerCriteria::BETWEEN,
            );
        }

        if ($taskCriteriaTransfer->getTaskConditions()->getTitle()) {
            $taskQuery->filterByTitle(
                '%' . mb_strtolower($taskCriteriaTransfer->getTaskConditions()->getTitle()) . '%',
                Criteria::LIKE,
            );
        }

        if ($taskCriteriaTransfer->getTaskConditions()->getDescription()) {
            $taskQuery->filterByDescription(
                '%' . mb_strtolower($taskCriteriaTransfer->getTaskConditions()->getDescription()) . '%',
                Criteria::LIKE,
            );
        }

        if ($taskCriteriaTransfer->getTaskConditions()->getTag()) {
            $taskQuery->useMeuTaskTagRelationQuery()
                    ->useMeuTaskTagQuery()
                        ->filterByTag($taskCriteriaTransfer->getTaskConditions()->getTag())
                    ->endUse()
                ->endUse();
        }

        return $taskQuery;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskCriteriaTransfer $taskCriteriaTransfer
     * @param \Orm\Zed\Task\Persistence\MeuTaskQuery $taskQuery
     *
     * @return \Orm\Zed\Task\Persistence\MeuTaskQuery
     */
    private function applyPagination(
        TaskCriteriaTransfer $taskCriteriaTransfer,
        MeuTaskQuery $taskQuery,
    ): MeuTaskQuery {
        if (
            !$taskCriteriaTransfer->getPagination()
            || !$taskCriteriaTransfer->getPagination()->getPage()
        ) {
            return $taskQuery;
        }

        $paginationTransfer = $taskCriteriaTransfer->getPagination();
        if (!$paginationTransfer->getMaxPerPage()) {
            $paginationTransfer->setMaxPerPage(TaskConfig::DEFAULT_PAGINATION_MAX_PER_PAGE);
        }

        $paginationModel = $taskQuery->paginate(
            $paginationTransfer->getPage(),
            $paginationTransfer->getMaxPerPage(),
        );

        /** @var \Orm\Zed\Task\Persistence\MeuTaskQuery $paginatedCustomerQuery */
        $paginatedCustomerQuery = $paginationModel->getQuery();

        return $paginatedCustomerQuery;
    }
}
