<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business\Model;

use Generated\Shared\Transfer\CustomerCriteriaTransfer;
use Generated\Shared\Transfer\TaskConditionsTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Zed\Task\Business\Exception\CustomerNotFoundException;
use Pyz\Zed\Task\Business\Exception\TaskNotFoundException;
use Pyz\Zed\Task\Persistence\TaskEntityManagerInterface;
use Pyz\Zed\Task\Persistence\TaskRepositoryInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;

class TaskAssigner implements TaskAssignerInterface
{
    private CustomerFacadeInterface $customerFacade;

    private TaskRepositoryInterface $taskRepository;

    private TaskEntityManagerInterface $taskEntityManager;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     * @param \Pyz\Zed\Task\Persistence\TaskRepositoryInterface $taskRepository
     * @param \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface $taskEntityManager
     */
    public function __construct(
        CustomerFacadeInterface $customerFacade,
        TaskRepositoryInterface $taskRepository,
        TaskEntityManagerInterface $taskEntityManager,
    ) {
        $this->customerFacade = $customerFacade;
        $this->taskRepository = $taskRepository;
        $this->taskEntityManager = $taskEntityManager;
    }

    /**
     * @param string $customerEmail
     * @param int $idTask
     *
     * @throws \Pyz\Zed\Task\Business\Exception\TaskNotFoundException
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function assign(string $customerEmail, int $idTask): TaskTransfer
    {
        $taskCriteriaTransfer = (new TaskCriteriaTransfer())->setTaskConditions(
            (new TaskConditionsTransfer())->setIdTask($idTask),
        );

        $taskTransfer = $this->taskRepository->findOne($taskCriteriaTransfer);

        if (!$taskTransfer) {
            throw new TaskNotFoundException();
        }

        $taskTransfer->setFkAssignee(
            $this->getCustomerIdByEmail($customerEmail),
        );

        return $this->taskEntityManager->update($taskTransfer);
    }

    /**
     * @param string $customerEmail
     *
     * @throws \Pyz\Zed\Task\Business\Exception\CustomerNotFoundException
     *
     * @return int
     */
    private function getCustomerIdByEmail(string $customerEmail): int
    {
        $customerResponseTransfer = $this->customerFacade->getCustomerByCriteria(
            (new CustomerCriteriaTransfer())->setEmail($customerEmail),
        );

        if (!$customerResponseTransfer->getIsSuccess()) {
            throw new CustomerNotFoundException();
        }

        return $customerResponseTransfer->getCustomerTransfer()->getIdCustomer();
    }
}
