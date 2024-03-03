<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksRestApi\Processor\Assign;

use Generated\Shared\Transfer\RestTaskAssignAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface TaskAssignerInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestTaskAssignAttributesTransfer $attributesTransfer
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function assign(
        RestTaskAssignAttributesTransfer $attributesTransfer,
        RestRequestInterface $restRequest,
    ): RestResponseInterface;
}
