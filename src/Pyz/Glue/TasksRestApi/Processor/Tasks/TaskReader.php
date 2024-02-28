<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksRestApi\Processor\Tasks;

use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\TaskConditionsTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Pyz\Client\TasksRestApi\TasksRestApiClientInterface;
use Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder\TaskRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class TaskReader implements TaskReaderInterface
{
    /**
     * @var string
     */
    private const REQUEST_PARAMETER_PAGE = 'page';

    /**
     * @var string
     */
    private const REQUEST_PARAMETER_TITLE = 'title';

    /**
     * @var string
     */
    private const REQUEST_PARAMETER_DESCRIPTION = 'description';

    /**
     * @var string
     */
    private const REQUEST_PARAMETER_TAG = 'tag';

    /**
     * @var int
     */
    private const DEFAULT_PAGINATION_PAGE = 1;

    /**
     * @uses \Pyz\Zed\Task\Persistence\TaskRepository::DEFAULT_PAGINATION_MAX_PER_PAGE
     *
     * @var int
     */
    private const DEFAULT_PAGINATION_MAX_PER_PAGE = 10;

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
    public function get(RestRequestInterface $restRequest): RestResponseInterface
    {
        if (!$restRequest->getRestUser()) {
            return $this->taskRestResponseBuilder
                ->createMissingAccessTokenErrorResponse();
        }

        $idTask = $restRequest->getResource()->getId();

        if ($idTask === null) {
            return $this->getTaskCollection($restRequest);
        }

        return $this->getTask((int)$idTask);
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    private function getTaskCollection(RestRequestInterface $restRequest): RestResponseInterface
    {
        $taskCriteriaTransfer = $this->createTaskCriteriaTransfer($restRequest);
        $taskCollectionResponseTransfer = $this->tasksRestApiClient->get($taskCriteriaTransfer);

        if (!$taskCollectionResponseTransfer->getIsSuccessful()) {
            return $this->taskRestResponseBuilder->createRestErrorResponse(
                $taskCollectionResponseTransfer->getMessages(),
            );
        }

        return $this->taskRestResponseBuilder->createTaskCollectionRestResponse(
            $taskCollectionResponseTransfer->getTasks(),
        );
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Generated\Shared\Transfer\TaskCriteriaTransfer
     */
    private function createTaskCriteriaTransfer(RestRequestInterface $restRequest): TaskCriteriaTransfer
    {
        $taskCriteriaTransfer = new TaskCriteriaTransfer();
        $page = (int)$restRequest->getHttpRequest()->get(
            self::REQUEST_PARAMETER_PAGE,
            self::DEFAULT_PAGINATION_PAGE,
        );

        $taskCriteriaTransfer->setPagination(
            (new PaginationTransfer())->setPage($page)
                ->setMaxPerPage(self::DEFAULT_PAGINATION_MAX_PER_PAGE),
        );

        $title = $restRequest->getHttpRequest()->get(self::REQUEST_PARAMETER_TITLE);
        $description = $restRequest->getHttpRequest()->get(self::REQUEST_PARAMETER_DESCRIPTION);
        $tag = $restRequest->getHttpRequest()->get(self::REQUEST_PARAMETER_TAG);

        if (!$title && !$description && !$tag) {
            return $taskCriteriaTransfer;
        }

        $taskConditionsTransfer = new TaskConditionsTransfer();
        if ($title) {
            $taskConditionsTransfer->setTitle($title);
        }
        if ($description) {
            $taskConditionsTransfer->setDescription($description);
        }
        if ($tag) {
            $taskConditionsTransfer->setTag($tag);
        }

        $taskCriteriaTransfer->setTaskConditions($taskConditionsTransfer);

        return $taskCriteriaTransfer;
    }

    /**
     * @param int $idTask
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    private function getTask(int $idTask): RestResponseInterface
    {
        $taskCriteriaTransfer = (new TaskCriteriaTransfer())
            ->setTaskConditions(
                (new TaskConditionsTransfer())->setIdTask($idTask),
            );
        $taskResponseTransfer = $this->tasksRestApiClient->getOne($taskCriteriaTransfer);

        if (!$taskResponseTransfer->getIsSuccessful()) {
            return $this->taskRestResponseBuilder->createRestErrorResponse(
                $taskResponseTransfer->getMessages(),
            );
        }

        return $this->taskRestResponseBuilder->createTaskRestResponse(
            $taskResponseTransfer->getTask(),
        );
    }
}
