<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder;

use ArrayObject;
use Generated\Shared\Transfer\TaskCollectionTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface TaskRestResponseBuilderInterface
{
    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createMissingAccessTokenErrorResponse(): RestResponseInterface;

    /**
     * @param \ArrayObject<int,\Generated\Shared\Transfer\MessageTransfer> $errorMessages
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createRestErrorResponse(ArrayObject $errorMessages): RestResponseInterface;

    /**
     * @param \Generated\Shared\Transfer\TaskCollectionTransfer $taskCollectionTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createTaskCollectionRestResponse(TaskCollectionTransfer $taskCollectionTransfer): RestResponseInterface;

    /**
     * @param \Generated\Shared\Transfer\TaskTransfer|null $taskTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createTaskRestResponse(?TaskTransfer $taskTransfer = null): RestResponseInterface;

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createEmptyResponse(): RestResponseInterface;
}
