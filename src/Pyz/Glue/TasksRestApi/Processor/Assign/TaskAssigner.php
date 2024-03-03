<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksRestApi\Processor\Assign;

use Generated\Shared\Transfer\RestTaskAssignAttributesTransfer;
use Generated\Shared\Transfer\RestTaskAssignRequestTransfer;
use Pyz\Client\TasksRestApi\TasksRestApiClientInterface;
use Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder\TaskRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class TaskAssigner implements TaskAssignerInterface
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
     * @param \Generated\Shared\Transfer\RestTaskAssignAttributesTransfer $attributesTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function assign(
        RestTaskAssignAttributesTransfer $attributesTransfer,
        RestRequestInterface $restRequest,
    ): RestResponseInterface {
        if (!$restRequest->getRestUser()) {
            return $this->taskRestResponseBuilder
                ->createMissingAccessTokenErrorResponse();
        }

        $restTaskAssignRequestTransfer = $this->createRestTaskAssignRequestTransfer(
            $attributesTransfer,
            $restRequest,
        );
        $taskResponseTransfer = $this->tasksRestApiClient->assign($restTaskAssignRequestTransfer);

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
     * @param \Generated\Shared\Transfer\RestTaskAssignAttributesTransfer $attributesTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\RestTaskAssignRequestTransfer
     */
    private function createRestTaskAssignRequestTransfer(
        RestTaskAssignAttributesTransfer $attributesTransfer,
        RestRequestInterface $restRequest,
    ): RestTaskAssignRequestTransfer {
        $idTask = (int)$restRequest->getResource()->getId();

        return (new RestTaskAssignRequestTransfer())
            ->setIdTask($idTask)
            ->setEmail($attributesTransfer->getEmail());
    }
}
