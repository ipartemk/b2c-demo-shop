<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder;

use ArrayObject;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Generated\Shared\Transfer\RestTaskAttributesTransfer;
use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Glue\TasksRestApi\Processor\Mapper\TaskMapperInterface;
use Pyz\Glue\TasksRestApi\TasksRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class TaskRestResponseBuilder implements TaskRestResponseBuilderInterface
{
    /**
     * @var \Pyz\Glue\TasksRestApi\Processor\Mapper\TaskMapperInterface
     */
    private TaskMapperInterface $taskMapper;

    /**
     * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    private RestResourceBuilderInterface $restResourceBuilder;

    /**
     * @param \Pyz\Glue\TasksRestApi\Processor\Mapper\TaskMapperInterface $taskMapper
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     */
    public function __construct(
        TaskMapperInterface $taskMapper,
        RestResourceBuilderInterface $restResourceBuilder,
    ) {
        $this->taskMapper = $taskMapper;
        $this->restResourceBuilder = $restResourceBuilder;
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createMissingAccessTokenErrorResponse(): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode(TasksRestApiConfig::RESPONSE_CODE_ACCESS_CODE_INVALID)
            ->setStatus(Response::HTTP_FORBIDDEN)
            ->setDetail(TasksRestApiConfig::RESPONSE_DETAIL_INVALID_ACCESS_TOKEN);

        return $this->restResourceBuilder->createRestResponse()->addError($restErrorMessageTransfer);
    }

    /**
     * @param \ArrayObject<int,\Generated\Shared\Transfer\MessageTransfer> $errorMessages
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createRestErrorResponse(ArrayObject $errorMessages): RestResponseInterface
    {
        $restErrorMessageTransfer = (new RestErrorMessageTransfer())
            ->setCode((string)Response::HTTP_BAD_REQUEST)
            ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->setDetail(TasksRestApiConfig::RESPONSE_UNKNOWN_ERROR);

        foreach ($errorMessages as $errorMessage) {
            $restErrorMessageTransfer->setStatus(Response::HTTP_BAD_REQUEST)
                ->setDetail($errorMessage->getMessage());

            return $this->restResourceBuilder->createRestResponse()->addError($restErrorMessageTransfer);
        }

        return $this->restResourceBuilder->createRestResponse()->addError($restErrorMessageTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TaskCollectionTransfer $taskCollectionTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createTaskCollectionRestResponse(
        TaskCollectionTransfer $taskCollectionTransfer,
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        foreach ($taskCollectionTransfer->getTasks() as $taskTransfer) {
            $restResponse->addResource($this->createTasksResource($taskTransfer));
        }

        return $restResponse;
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer|null $taskTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createTaskRestResponse(
        ?TaskTransfer $taskTransfer = null,
    ): RestResponseInterface {
        $restResponse = $this->restResourceBuilder->createRestResponse();
        if (!$taskTransfer) {
            return $restResponse;
        }

        return $restResponse->addResource(
            $this->createTasksResource($taskTransfer),
        );
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createEmptyResponse(): RestResponseInterface
    {
        return $this->restResourceBuilder->createRestResponse();
    }

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    private function createTasksResource(TaskTransfer $taskTransfer): RestResourceInterface
    {
        $restTaskAttributesTransfer = $this->taskMapper
            ->mapTaskTransferToRestTaskAttributesTransfer(
                $taskTransfer,
                new RestTaskAttributesTransfer(),
            );
        /** @var string $idTask */
        $idTask = $taskTransfer->getIdTask();

        return $this->restResourceBuilder->createRestResource(
            TasksRestApiConfig::RESOURCE_CUSTOMER_TASKS,
            $idTask,
            $restTaskAttributesTransfer,
        );
    }
}
