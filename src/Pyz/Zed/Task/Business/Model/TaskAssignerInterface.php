<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Business\Model;

use Generated\Shared\Transfer\TaskTransfer;

interface TaskAssignerInterface
{
    /**
     * @param string $customerEmail
     * @param int $idTask
     *
     * @return \Generated\Shared\Transfer\TaskTransfer
     */
    public function assign(string $customerEmail, int $idTask): TaskTransfer;
}
