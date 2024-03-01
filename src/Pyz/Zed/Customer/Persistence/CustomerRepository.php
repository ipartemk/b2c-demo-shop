<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Customer\Persistence;

use Generated\Shared\Transfer\CustomerCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Persistence\CustomerRepository as SprykerCustomerRepository;

/**
 * @method \Spryker\Zed\Customer\Persistence\CustomerPersistenceFactory getFactory()
 */
class CustomerRepository extends SprykerCustomerRepository
{
    /**
     * @param \Generated\Shared\Transfer\CustomerCriteriaTransfer $customerCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function findCustomerByCriteria(CustomerCriteriaTransfer $customerCriteriaTransfer): ?CustomerTransfer
    {
        $customerQuery = $this->getFactory()->createSpyCustomerQuery();

        if ($customerCriteriaTransfer->getCustomerReference()) {
            $customerQuery->filterByCustomerReference($customerCriteriaTransfer->getCustomerReference());
        }

        if ($customerCriteriaTransfer->getEmail()) {
            $customerQuery->filterByEmail($customerCriteriaTransfer->getEmail());
        }

        $customerEntity = $customerQuery->findOne();

        if ($customerEntity === null) {
            return null;
        }

        return $this->getFactory()
            ->createCustomerMapper()
            ->mapCustomerEntityToCustomer($customerEntity->toArray());
    }
}
