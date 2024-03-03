<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksRestApi\Controller;

use Generated\Shared\Transfer\RestTaskTagAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \Pyz\Glue\TasksRestApi\TasksRestApiFactory getFactory()
 */
class TaskTagsResourceController extends AbstractController
{
    /**
     * @Glue({
     *     "post": {
     *          "summary": [
     *              "Assign task to customer."
     *          ],
     *          "parameters": [{
     *              "ref": "acceptLanguage"
     *          }],
     *          "responses": {
     *              "422": "Unprocessable entity."
     *          }
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestTaskTagAttributesTransfer $restTaskTagAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function patchAction(
        RestRequestInterface $restRequest,
        RestTaskTagAttributesTransfer $restTaskTagAttributesTransfer,
    ): RestResponseInterface {
        return $this->getFactory()
            ->createTaskTagAdder()
            ->addTag($restTaskTagAttributesTransfer, $restRequest);
    }
}
