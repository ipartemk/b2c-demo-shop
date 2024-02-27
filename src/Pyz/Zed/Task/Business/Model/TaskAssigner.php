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

    private TaskRepositoryInterface $customerTaskRepository;

    private TaskEntityManagerInterface $customerTaskEntityManager;

    /**
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     * @param \Pyz\Zed\Task\Persistence\TaskRepositoryInterface $customerTaskRepository
     * @param \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface $customerTaskEntityManager
     */
    public function __construct(
        CustomerFacadeInterface $customerFacade,
        TaskRepositoryInterface $customerTaskRepository,
        TaskEntityManagerInterface $customerTaskEntityManager,
    ) {
        $this->customerFacade = $customerFacade;
        $this->customerTaskRepository = $customerTaskRepository;
        $this->customerTaskEntityManager = $customerTaskEntityManager;
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
        $customerTaskCriteriaTransfer = (new TaskCriteriaTransfer())->setTaskConditions(
            (new TaskConditionsTransfer())->setIdTask($idTask),
        );

        $customerTaskTransfer = $this->customerTaskRepository->findOne($customerTaskCriteriaTransfer);

        if (!$customerTaskTransfer) {
            throw new TaskNotFoundException();
        }

        $customerTaskTransfer->setFkAssignee(
            $this->getCustomerIdByEmail($customerEmail),
        );

        return $this->customerTaskEntityManager->update($customerTaskTransfer);
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
