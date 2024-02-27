<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business;

use Pyz\Zed\Task\Business\Mail\TaskOverdueNotifier;
use Pyz\Zed\Task\Business\Mail\TaskOverdueNotifierInterface;
use Pyz\Zed\Task\Business\Model\TaskAssigner;
use Pyz\Zed\Task\Business\Model\TaskAssignerInterface;
use Pyz\Zed\Task\Business\Model\TaskManager;
use Pyz\Zed\Task\Business\Model\TaskManagerInterface;
use Pyz\Zed\Task\Business\Model\TaskTagManager;
use Pyz\Zed\Task\Business\Model\TaskTagManagerInterface;
use Pyz\Zed\Task\TaskDependencyProvider;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

/**
 * @method \Pyz\Zed\Task\TaskConfig getConfig()
 * @method \Pyz\Zed\Task\Persistence\TaskRepositoryInterface getRepository()
 * @method \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface getEntityManager()
 */
class TaskBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\Task\Business\Model\TaskManagerInterface
     */
    public function createTaskManager(): TaskManagerInterface
    {
        return new TaskManager(
            $this->getRepository(),
            $this->getEntityManager(),
        );
    }

    /**
     * @return \Pyz\Zed\Task\Business\Mail\TaskOverdueNotifierInterface
     */
    public function createTaskOverdueNotifier(): TaskOverdueNotifierInterface
    {
        return new TaskOverdueNotifier(
            $this->getRepository(),
            $this->getMailFacade(),
            $this->getCustomerFacade(),
        );
    }

    /**
     * @return \Pyz\Zed\Task\Business\Model\TaskAssignerInterface
     */
    public function createTaskAssigner(): TaskAssignerInterface
    {
        return new TaskAssigner(
            $this->getCustomerFacade(),
            $this->getRepository(),
            $this->getEntityManager(),
        );
    }

    /**
     * @return \Pyz\Zed\Task\Business\Model\TaskTagManagerInterface
     */
    public function createTaskTagManager(): TaskTagManagerInterface
    {
        return new TaskTagManager(
            $this->getRepository(),
            $this->getEntityManager(),
        );
    }

    /**
     * @return \Spryker\Zed\Mail\Business\MailFacadeInterface
     */
    public function getMailFacade(): MailFacadeInterface
    {
        return $this->getProvidedDependency(TaskDependencyProvider::FACADE_MAIL);
    }

    /**
     * @return \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    public function getCustomerFacade(): CustomerFacadeInterface
    {
        return $this->getProvidedDependency(TaskDependencyProvider::FACADE_CUSTOMER);
    }
}
