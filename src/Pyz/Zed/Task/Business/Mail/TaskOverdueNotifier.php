<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business\Mail;

use ArrayObject;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MailRecipientTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\TaskConditionsTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Zed\Task\Communication\Plugin\Mail\TaskOverdueMailTypeBuilderPlugin;
use Pyz\Zed\Task\Persistence\TaskRepositoryInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

class TaskOverdueNotifier implements TaskOverdueNotifierInterface
{
    /**
     * @var \Pyz\Zed\Task\Persistence\TaskRepositoryInterface
     */
    private TaskRepositoryInterface $taskRepository;

    /**
     * @var \Spryker\Zed\Mail\Business\MailFacadeInterface
     */
    private MailFacadeInterface $mailFacade;

    /**
     * @var \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    private CustomerFacadeInterface $customerFacade;

    /**
     * @param \Pyz\Zed\Task\Persistence\TaskRepositoryInterface $taskRepository
     * @param \Spryker\Zed\Mail\Business\MailFacadeInterface $mailFacade
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     */
    public function __construct(
        TaskRepositoryInterface $taskRepository,
        MailFacadeInterface $mailFacade,
        CustomerFacadeInterface $customerFacade,
    ) {
        $this->taskRepository = $taskRepository;
        $this->mailFacade = $mailFacade;
        $this->customerFacade = $customerFacade;
    }

    /**
     * @return void
     */
    public function notify(): void
    {
        $taskCollectionTransfer = $this->taskRepository->get($this->prepareCriteriaTransfer());
        foreach ($taskCollectionTransfer->getTasks() as $taskTransfer) {
            $this->sendMail($taskTransfer);
        }
    }

    /**
     * @return \Generated\Shared\Transfer\TaskCriteriaTransfer
     */
    private function prepareCriteriaTransfer(): TaskCriteriaTransfer
    {
        $taskCriteriaTransfer = new TaskCriteriaTransfer();
        $taskCriteriaTransfer->setTaskConditions(
            (new TaskConditionsTransfer())->setIsOverdue(true),
        );

        return $taskCriteriaTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return void
     */
    private function sendMail(TaskTransfer $taskTransfer): void
    {
        $customerTransfer = $this->customerFacade->findCustomerById(
            (new CustomerTransfer())->setIdCustomer($taskTransfer->getFkCreator()),
        );

        if (!$customerTransfer) {
            return;
        }

        $recipientName = sprintf('%s %s', $customerTransfer->getFirstName(), $customerTransfer->getLastName());

        $recipients = new ArrayObject([
            (new MailRecipientTransfer())->setEmail($customerTransfer->getEmail())
                ->setName($recipientName),
        ]);

        $mailTransfer = (new MailTransfer())
            ->setType(TaskOverdueMailTypeBuilderPlugin::MAIL_TYPE)
            ->setRecipients($recipients);

        $mailTransfer->offsetSet('taskTitle', $taskTransfer->getTitle());
        $mailTransfer->offsetSet('taskDueDate', $taskTransfer->getDueDate());
        $mailTransfer->offsetSet('recipientName', $recipientName);

        $this->mailFacade->handleMail($mailTransfer);
    }
}
