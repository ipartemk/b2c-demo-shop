<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class TasksRestApiConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESOURCE_TASKS = 'tasks';

    /**
     * @var string
     */
    public const RESOURCE_TASK_ASSIGN = 'task-assign';

    /**
     * @var string
     */
    public const RESOURCE_TASK_TAGS = 'task-tags';

    /**
     * @var string
     */
    public const RESPONSE_UNKNOWN_ERROR = 'Unknown error.';

    /**
     * @uses \Spryker\Glue\AuthRestApi\AuthRestApiConfig::RESPONSE_DETAIL_INVALID_ACCESS_TOKEN
     *
     * @var string
     */
    public const RESPONSE_DETAIL_INVALID_ACCESS_TOKEN = 'Invalid access token.';

    /**
     * @uses \Spryker\Glue\AuthRestApi\AuthRestApiConfig::RESPONSE_CODE_ACCESS_CODE_INVALID
     *
     * @var string
     */
    public const RESPONSE_CODE_ACCESS_CODE_INVALID = '001';
}
