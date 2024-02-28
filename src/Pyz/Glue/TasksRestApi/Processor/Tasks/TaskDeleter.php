<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksRestApi\Processor\Tasks;

use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Client\TasksRestApi\TasksRestApiClientInterface;
use Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder\TaskRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class TaskDeleter implements TaskDeleterInterface
{
    /**
     * @var \Pyz\Client\TasksRestApi\TasksRestApiClientInterface
     */
    private TasksRestApiClientInterface $tasksRestApiClient;

    /**
     * @var \Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder\TaskRestResponseBuilderInterface
     */
    private TaskRestResponseBuilderInterface $taskRestResponseBuilder;

    /**
     * @param \Pyz\Client\TasksRestApi\TasksRestApiClientInterface $tasksRestApiClient
     * @param \Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder\TaskRestResponseBuilderInterface $taskRestResponseBuilder
     */
    public function __construct(
        TasksRestApiClientInterface $tasksRestApiClient,
        TaskRestResponseBuilderInterface $taskRestResponseBuilder,
    ) {
        $this->tasksRestApiClient = $tasksRestApiClient;
        $this->taskRestResponseBuilder = $taskRestResponseBuilder;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function delete(RestRequestInterface $restRequest): RestResponseInterface
    {
        if (!$restRequest->getRestUser()) {
            return $this->taskRestResponseBuilder
                ->createMissingAccessTokenErrorResponse();
        }

        $idTask = (int)$restRequest->getResource()->getId();
        $taskTransfer = (new TaskTransfer())->setIdTask($idTask);
        $taskResponseTransfer = $this->tasksRestApiClient->delete($taskTransfer);

        if (!$taskResponseTransfer->getIsSuccessful()) {
            return $this->taskRestResponseBuilder->createRestErrorResponse(
                $taskResponseTransfer->getMessages(),
            );
        }

        return $this->taskRestResponseBuilder->createEmptyResponse();
    }
}
