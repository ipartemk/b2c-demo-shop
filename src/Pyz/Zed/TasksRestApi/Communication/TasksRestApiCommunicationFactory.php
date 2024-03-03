<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\TasksRestApi\Communication;

use Pyz\Zed\Task\Business\TaskFacadeInterface;
use Pyz\Zed\TasksRestApi\TasksRestApiDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class TasksRestApiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Pyz\Zed\Task\Business\TaskFacadeInterface
     */
    public function getTaskFacade(): TaskFacadeInterface
    {
        return $this->getProvidedDependency(TasksRestApiDependencyProvider::FACADE_TASK);
    }
}
