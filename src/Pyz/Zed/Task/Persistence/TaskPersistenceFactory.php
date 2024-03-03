<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Persistence;

use Orm\Zed\Task\Persistence\MeuTaskQuery;
use Orm\Zed\Task\Persistence\MeuTaskTagQuery;
use Orm\Zed\Task\Persistence\MeuTaskTagRelationQuery;
use Pyz\Zed\Task\Persistence\Propel\Mapper\TaskMapper;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\Task\TaskConfig getConfig()
 * @method \Pyz\Zed\Task\Persistence\TaskRepositoryInterface getRepository()
 * @method \Pyz\Zed\Task\Persistence\TaskEntityManagerInterface getEntityManager()
 */
class TaskPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Task\Persistence\MeuTaskQuery
     */
    public function getTaskPropelQuery(): MeuTaskQuery
    {
        return MeuTaskQuery::create();
    }

    /**
     * @return \Pyz\Zed\Task\Persistence\Propel\Mapper\TaskMapper
     */
    public function createTaskMapper(): TaskMapper
    {
        return new TaskMapper();
    }

    /**
     * @return \Orm\Zed\Task\Persistence\MeuTaskTagQuery
     */
    public function getTaskTagPropelQuery(): MeuTaskTagQuery
    {
        return MeuTaskTagQuery::create();
    }

    /**
     * @return \Orm\Zed\Task\Persistence\MeuTaskTagRelationQuery
     */
    public function getTaskTagRelationPropelQuery(): MeuTaskTagRelationQuery
    {
        return MeuTaskTagRelationQuery::create();
    }
}
