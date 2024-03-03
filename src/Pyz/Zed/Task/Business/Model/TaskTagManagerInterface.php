<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business\Model;

use Generated\Shared\Transfer\TaskTransfer;

interface TaskTagManagerInterface
{
    /**
     * @param string $tag
     * @param int $idTask
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function addTag(string $tag, int $idTask): TaskTransfer;
}
