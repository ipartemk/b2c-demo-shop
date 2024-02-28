<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksRestApi\Processor\Tasks;

use Generated\Shared\Transfer\RestTaskAttributesTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Client\TasksRestApi\TasksRestApiClientInterface;
use Pyz\Glue\TasksRestApi\Processor\Mapper\TaskMapperInterface;
use Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder\TaskRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class TaskCreator implements TaskCreatorInterface
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
     * @var \Pyz\Glue\TasksRestApi\Processor\Mapper\TaskMapperInterface
     */
    private TaskMapperInterface $taskMapper;

    /**
     * @param \Pyz\Client\TasksRestApi\TasksRestApiClientInterface $tasksRestApiClient
     * @param \Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder\TaskRestResponseBuilderInterface $taskRestResponseBuilder
     * @param \Pyz\Glue\TasksRestApi\Processor\Mapper\TaskMapperInterface $taskMapper
     */
    public function __construct(
        TasksRestApiClientInterface $tasksRestApiClient,
        TaskRestResponseBuilderInterface $taskRestResponseBuilder,
        TaskMapperInterface $taskMapper,
    ) {
        $this->tasksRestApiClient = $tasksRestApiClient;
        $this->taskRestResponseBuilder = $taskRestResponseBuilder;
        $this->taskMapper = $taskMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestTaskAttributesTransfer $attributesTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function create(
        RestTaskAttributesTransfer $attributesTransfer,
        RestRequestInterface $restRequest,
    ): RestResponseInterface {
        if (!$restRequest->getRestUser()) {
            return $this->taskRestResponseBuilder
                ->createMissingAccessTokenErrorResponse();
        }

        $taskTransfer = $this->createTaskTransfer($attributesTransfer, $restRequest);
        $taskResponseTransfer = $this->tasksRestApiClient->create($taskTransfer);

        if (!$taskResponseTransfer->getIsSuccessful()) {
            return $this->taskRestResponseBuilder->createRestErrorResponse(
                $taskResponseTransfer->getMessages(),
            );
        }

        return $this->taskRestResponseBuilder->createTaskRestResponse(
            $taskResponseTransfer->getTask(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RestTaskAttributesTransfer $attributesTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    private function createTaskTransfer(
        RestTaskAttributesTransfer $attributesTransfer,
        RestRequestInterface $restRequest,
    ): TaskTransfer {
        /** @var \Generated\Shared\Transfer\RestUserTransfer $restUser */
        $restUser = $restRequest->getRestUser();
        /** @var int $customerId */
        $customerId = $restUser->getSurrogateIdentifier();
        $taskTransfer = $this->taskMapper->mapRestTaskAttributesTransferToTaskTransfer(
            $attributesTransfer,
            new TaskTransfer(),
        );
        $taskTransfer->setFkCreator($customerId);

        return $taskTransfer;
    }
}
