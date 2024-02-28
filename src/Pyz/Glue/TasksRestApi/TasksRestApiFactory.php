<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\TasksRestApi;

use Pyz\Glue\TasksRestApi\Processor\Assign\TaskAssigner;
use Pyz\Glue\TasksRestApi\Processor\Assign\TaskAssignerInterface;
use Pyz\Glue\TasksRestApi\Processor\Mapper\TaskMapper;
use Pyz\Glue\TasksRestApi\Processor\Mapper\TaskMapperInterface;
use Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder\TaskRestResponseBuilder;
use Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder\TaskRestResponseBuilderInterface;
use Pyz\Glue\TasksRestApi\Processor\Tasks\TaskCreator;
use Pyz\Glue\TasksRestApi\Processor\Tasks\TaskCreatorInterface;
use Pyz\Glue\TasksRestApi\Processor\Tasks\TaskDeleter;
use Pyz\Glue\TasksRestApi\Processor\Tasks\TaskDeleterInterface;
use Pyz\Glue\TasksRestApi\Processor\Tasks\TaskReader;
use Pyz\Glue\TasksRestApi\Processor\Tasks\TaskReaderInterface;
use Pyz\Glue\TasksRestApi\Processor\Tasks\TaskUpdater;
use Pyz\Glue\TasksRestApi\Processor\Tasks\TaskUpdaterInterface;
use Pyz\Glue\TasksRestApi\Processor\TaskTag\TaskTagAdder;
use Pyz\Glue\TasksRestApi\Processor\TaskTag\TaskTagAdderInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \Pyz\Client\TasksRestApi\TasksRestApiClientInterface getClient()
 */
class TasksRestApiFactory extends AbstractFactory
{
    /**
     * @return \Pyz\Glue\TasksRestApi\Processor\Tasks\TaskReaderInterface
     */
    public function createTaskReader(): TaskReaderInterface
    {
        return new TaskReader(
            $this->getClient(),
            $this->createTaskRestResponseBuilder(),
        );
    }

    /**
     * @return \Pyz\Glue\TasksRestApi\Processor\Tasks\TaskCreatorInterface
     */
    public function createTaskCreator(): TaskCreatorInterface
    {
        return new TaskCreator(
            $this->getClient(),
            $this->createTaskRestResponseBuilder(),
            $this->createTaskMapper(),
        );
    }

    /**
     * @return \Pyz\Glue\TasksRestApi\Processor\Tasks\TaskUpdaterInterface
     */
    public function createTaskUpdater(): TaskUpdaterInterface
    {
        return new TaskUpdater(
            $this->getClient(),
            $this->createTaskRestResponseBuilder(),
            $this->createTaskMapper(),
        );
    }

    /**
     * @return \Pyz\Glue\TasksRestApi\Processor\Tasks\TaskDeleterInterface
     */
    public function createTaskDeleter(): TaskDeleterInterface
    {
        return new TaskDeleter(
            $this->getClient(),
            $this->createTaskRestResponseBuilder(),
        );
    }

    /**
     * @return \Pyz\Glue\TasksRestApi\Processor\Mapper\TaskMapperInterface
     */
    public function createTaskMapper(): TaskMapperInterface
    {
        return new TaskMapper();
    }

    /**
     * @return \Pyz\Glue\TasksRestApi\Processor\RestResponseBuilder\TaskRestResponseBuilderInterface
     */
    public function createTaskRestResponseBuilder(): TaskRestResponseBuilderInterface
    {
        return new TaskRestResponseBuilder(
            $this->createTaskMapper(),
            $this->getResourceBuilder(),
        );
    }

    /**
     * @return \Pyz\Glue\TasksRestApi\Processor\Assign\TaskAssignerInterface
     */
    public function createTaskAssigner(): TaskAssignerInterface
    {
        return new TaskAssigner(
            $this->getClient(),
            $this->createTaskRestResponseBuilder(),
        );
    }

    /**
     * @return \Pyz\Glue\TasksRestApi\Processor\TaskTag\TaskTagAdderInterface
     */
    public function createTaskTagAdder(): TaskTagAdderInterface
    {
        return new TaskTagAdder(
            $this->getClient(),
            $this->createTaskRestResponseBuilder(),
        );
    }
}
