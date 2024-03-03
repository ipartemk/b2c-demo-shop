<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestTaskAttributesTransfer;
use Generated\Shared\Transfer\TaskTransfer;

interface TaskMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     * @param \Generated\Shared\Transfer\RestTaskAttributesTransfer $taskAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestTaskAttributesTransfer
     */
    public function mapTaskTransferToRestTaskAttributesTransfer(
        TaskTransfer $taskTransfer,
        RestTaskAttributesTransfer $taskAttributesTransfer,
    ): RestTaskAttributesTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestTaskAttributesTransfer $taskAttributesTransfer
     * @param \Generated\Shared\Transfer\TaskTransfer $taskTransfer
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function mapRestTaskAttributesTransferToTaskTransfer(
        RestTaskAttributesTransfer $taskAttributesTransfer,
        TaskTransfer $taskTransfer,
    ): TaskTransfer;
}
