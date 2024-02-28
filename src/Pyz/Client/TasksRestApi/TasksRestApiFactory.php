<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\TasksRestApi;

use Pyz\Client\TasksRestApi\Zed\TasksRestApiZedStub;
use Pyz\Client\TasksRestApi\Zed\TasksRestApiZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class TasksRestApiFactory extends AbstractFactory
{
    /**
     * @return \Pyz\Client\TasksRestApi\Zed\TasksRestApiZedStubInterface
     */
    public function createTasksRestApiZedStub(): TasksRestApiZedStubInterface
    {
        return new TasksRestApiZedStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    public function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(TasksRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
