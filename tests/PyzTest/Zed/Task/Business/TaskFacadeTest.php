<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Task\Business;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\TaskBuilder;
use Generated\Shared\Transfer\TaskConditionsTransfer;
use Generated\Shared\Transfer\TaskCriteriaTransfer;
use Generated\Shared\Transfer\TaskTransfer;
use Pyz\Zed\Task\Business\Exception\CustomerNotFoundException;
use Pyz\Zed\Task\Business\Exception\TaskNotFoundException;
use PyzTest\Zed\Task\TaskBusinessTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group Task
 * @group Business
 * @group Facade
 * @group TaskFacadeTest
 * Add your own group annotations below this line
 */
class TaskFacadeTest extends Unit
{
    protected TaskBusinessTester $tester;

    /**
     * @var int
     */
    private const NOT_EXISTENT_CUSTOMER_TASK_ID = 0;

    /**
     * @var string
     */
    private const NEW_TITLE = 'New title for test';

    /**
     * @var string
     */
    private const TAG = 'Test tag';

    /**
     * @var string
     */
    private const NOT_EXISTENT_CUSTOMER_EMAIL = 'email-not-exist';

    /**
     * @return void
     */
    public function testGetTaskCollectionReturnsTaskCollection(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $taskOneTransfer = $this->tester->haveTask([
            TaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        $taskTwoTransfer = $this->tester->haveTask([
            TaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        $taskIds = [
            $taskOneTransfer->getIdTask(),
            $taskTwoTransfer->getIdTask(),
        ];

        $taskCriteriaTransfer = (new TaskCriteriaTransfer())->setTaskConditions(
            (new TaskConditionsTransfer())->setTaskIds($taskIds),
        );

        // Act
        $taskCollectionTransfer = $this->tester->getTaskFacade()->getTaskCollection($taskCriteriaTransfer);

        // Assert
        $this->assertCount(2, $taskCollectionTransfer->getTasks());
        $ids = [];
        foreach ($taskCollectionTransfer->getTasks() as $taskTransfer) {
            $ids[] = $taskTransfer->getIdTask();
        }

        $this->assertTrue(in_array($taskOneTransfer->getIdTask(), $ids));
        $this->assertTrue(in_array($taskTwoTransfer->getIdTask(), $ids));
    }

    /**
     * @return void
     */
    public function testGetTaskCollectionReturnsEmptyCollectionForNotExistentTasks(): void
    {
        // Arrange
        $taskCriteriaTransfer = (new TaskCriteriaTransfer())->setTaskConditions(
            (new TaskConditionsTransfer())->setIdTask(self::NOT_EXISTENT_CUSTOMER_TASK_ID),
        );

        // Act
        $taskCollectionTransfer = $this->tester->getTaskFacade()->getTaskCollection($taskCriteriaTransfer);

        // Assert
        $this->assertCount(0, $taskCollectionTransfer->getTasks());
    }

    /**
     * @return void
     */
    public function testFindOneReturnsTask(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $expectedTaskTransfer = $this->tester->haveTask([
            TaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        $taskCriteriaTransfer = (new TaskCriteriaTransfer())->setTaskConditions(
            (new TaskConditionsTransfer())->setIdTask($expectedTaskTransfer->getIdTask()),
        );

        // Act
        $taskTransfer = $this->tester->getTaskFacade()->findTask($taskCriteriaTransfer);

        // Assert
        $this->assertNotNull($taskTransfer);
        $this->assertSame($expectedTaskTransfer->getIdTask(), $taskTransfer->getIdTask());
    }

    /**
     * @return void
     */
    public function testFindOneReturnsNullForNotExistentTask(): void
    {
        // Arrange
        $taskCriteriaTransfer = (new TaskCriteriaTransfer())->setTaskConditions(
            (new TaskConditionsTransfer())->setIdTask(self::NOT_EXISTENT_CUSTOMER_TASK_ID),
        );

        // Act
        $taskTransfer = $this->tester->getTaskFacade()->findTask($taskCriteriaTransfer);

        // Assert
        $this->assertNull($taskTransfer);
    }

    /**
     * @return void
     */
    public function testCreateCreatesAndReturnsTask(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();

        $expectedTaskTransfer = (new TaskBuilder([
            TaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]))->build();

        // Act
        $taskTransfer = $this->tester->getTaskFacade()->create($expectedTaskTransfer);

        // Assert
        $this->assertNotNull($taskTransfer->getIdTask());
        $this->assertSame($expectedTaskTransfer->getTitle(), $taskTransfer->getTitle());
        $this->assertSame($expectedTaskTransfer->getDescription(), $taskTransfer->getDescription());
        $this->assertSame($expectedTaskTransfer->getFkCreator(), $taskTransfer->getFkCreator());
        $this->assertSame($expectedTaskTransfer->getDueDate(), $taskTransfer->getDueDate());
        $this->assertSame($expectedTaskTransfer->getStatus(), $taskTransfer->getStatus());
    }

    /**
     * @return void
     */
    public function testUpdateUpdatesandReturnesTask(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $expectedTaskTransfer = $this->tester->haveTask([
            TaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        $oldTitle = $expectedTaskTransfer->getTitle();
        $expectedTaskTransfer->setTitle(self::NEW_TITLE);

        // Act
        $customerTasTransfer = $this->tester->getTaskFacade()->update($expectedTaskTransfer);

        // Assert
        $this->assertSame($expectedTaskTransfer->getTitle(), $customerTasTransfer->getTitle());
        $this->assertNotSame($oldTitle, $customerTasTransfer->getTitle());
    }

    /**
     * @return void
     */
    public function testDeleteDeletesTask(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $expectedTaskTransfer = $this->tester->haveTask([
            TaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        $taskTwoTransfer = $this->tester->haveTask([
            TaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        $taskCriteriaTransfer = (new TaskCriteriaTransfer())->setTaskConditions(
            (new TaskConditionsTransfer())->setIdTask($expectedTaskTransfer->getIdTask()),
        );

        // Act
        $result = $this->tester->getTaskFacade()->delete($expectedTaskTransfer);
        $taskTransfer = $this->tester->getTaskFacade()->findTask($taskCriteriaTransfer);

        // Assert
        $this->assertTrue($result);
        $this->assertNull($taskTransfer);
    }

    /**
     * @return void
     */
    public function testAssignAssignsCustomerToTask(): void
    {
        // Arrange
        $customerCreatorTransfer = $this->tester->haveCustomer();
        $customerAssigneeTransfer = $this->tester->haveCustomer();

        $expectedTaskOneTransfer = $this->tester->haveTask([
            TaskTransfer::FK_CREATOR => $customerCreatorTransfer->getIdCustomer(),
        ]);

        // Act
        $taskTransfer = $this->tester->getTaskFacade()->assign(
            $customerAssigneeTransfer->getEmail(),
            $expectedTaskOneTransfer->getIdTask(),
        );

        // Assert
        $this->assertSame($customerAssigneeTransfer->getIdCustomer(), $taskTransfer->getFkAssignee());
    }

    /**
     * @return void
     */
    public function testAddTagAddsTagToTask(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $expectedTaskOneTransfer = $this->tester->haveTask([
            TaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        // Act
        $taskTransfer = $this->tester->getTaskFacade()->addTag(
            self::TAG,
            $expectedTaskOneTransfer->getIdTask(),
        );

        // Assert
        $this->assertCount(1, $taskTransfer->getTags());
        /** @var \Generated\Shared\Transfer\TaskTagTransfer $taskTagTransfer */
        $taskTagTransfer = $taskTransfer->getTags()->offsetGet(0);

        $this->assertSame(self::TAG, $taskTagTransfer->getTag());
    }

    /**
     * @return void
     */
    public function testAssignToNotExistentCustomerThrowsException(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $expectedTaskOneTransfer = $this->tester->haveTask([
            TaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        // Assert
        $this->expectException(CustomerNotFoundException::class);

        // Act
        $this->tester->getTaskFacade()->assign(
            self::NOT_EXISTENT_CUSTOMER_EMAIL,
            $expectedTaskOneTransfer->getIdTask(),
        );
    }

    /**
     * @return void
     */
    public function testAssignToNotExistentCustomerNoteThrowsException(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $this->tester->haveTask([
            TaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        // Assert
        $this->expectException(TaskNotFoundException::class);

        // Act
        $this->tester->getTaskFacade()->assign(
            $customerTransfer->getEmail(),
            self::NOT_EXISTENT_CUSTOMER_TASK_ID,
        );
    }

    /**
     * @return void
     */
    public function testAddTagToNotExistentCustomerNoteThrowsException(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $this->tester->haveTask([
            TaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        // Assert
        $this->expectException(TaskNotFoundException::class);

        // Act
        $this->tester->getTaskFacade()->addTag(
            self::TAG,
            self::NOT_EXISTENT_CUSTOMER_TASK_ID,
        );
    }
}
