<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class TaskConfig extends AbstractBundleConfig
{
    /**
     * @var int
     */
    public const DEFAULT_PAGINATION_MAX_PER_PAGE = 4;
}