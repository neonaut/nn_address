<?php

namespace NN\NnAddress\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Hendrik Reimers <h.reimers@neonaut.de>, Neonaut GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use \TYPO3\CMS\Extbase\Persistence\Repository;
use \NN\NnAddress\Domain\Model\Dto\PersonsDemand;
use \TYPO3\CMS\Extbase\Utility\ArrayUtility;

/**
 *
 *
 * @package nn_address
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PersonRepository extends Repository
{
    protected $defaultOrderings = array(
        'lastName' => QueryInterface::ORDER_ASCENDING,
    );

    /**
     * Find all Persons by Demand
     *
     * @param \NN\NnAddress\Domain\Model\Dto\PersonsDemand $demand
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findDemanded(PersonsDemand $demand)
    {
        $query = $this->createQuery();

        $constraints = array();

        // Categories
        if (!empty($demand->getCategoryConjunction()) && count($demand->getCategories()) > 0) {
            $categoryConstraints = array();

            foreach ($demand->getCategories() as $category) {
                $categoryConstraints[] = $query->contains('categories', $category);
            }

            if ($categoryConstraints) {
                switch (strtolower($demand->getCategoryConjunction())) {
                    case 'or':
                        $constraints[] = $query->logicalOr($categoryConstraints);
                        break;
                    case 'notor':
                        $constraints[] = $query->logicalNot($query->logicalOr($categoryConstraints));
                        break;
                    case 'notand':
                        $constraints[] = $query->logicalNot($query->logicalAnd($categoryConstraints));
                        break;
                    case 'and':
                    default:
                        $constraints[] = $query->logicalAnd($categoryConstraints);
                }
            }
        }

        // Groups
        if (count($demand->getGroups()) > 0) {
            foreach ($demand->getGroups() as $group) {
                if ($group > 0) {
                    $constraints[] = $query->logicalAnd([
                            $query->contains('groups', $group),
                            $query->equals('groups.hidden', 0),
                            $query->equals('groups.deleted', 0)
                        ]
                    );
                }
            }
        }
        // Search
        if (!empty($demand->getSearchTerm())) {
            foreach ($demand->getSearchFields() as $field) {
                $constraints[] = $query->like($field, '%' . $demand->getSearchTerm() . '%');
            }
        }

        // Put together constraints
        if (count($constraints) > 0) {
            $query->matching(
                $query->logicalOr($constraints)
            );
        }

        // Ordering
        $orderings = array('lastName' => QueryInterface::ORDER_ASCENDING);
        if ($demand->getOrderBy()) {
            $orderings = array($demand->getOrderBy() => QueryInterface::ORDER_ASCENDING);
        }

        if ($demand->getOrderDirection()) {
            $orderings = array(array_keys($orderings)[0] => (strtolower($demand->getOrderDirection()) === 'desc') ? QueryInterface::ORDER_DESCENDING : QueryInterface::ORDER_ASCENDING);
        }

        $query->setOrderings($orderings);

        return $query->execute();
    }

    /**
     * Find all Persons by a Group
     *
     * @param \string  $groupList Comma seperated list of Group IDs
     * @param \boolean $andSearch
     *
     * @return \array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findByGroups($groupList, $andSearch = false)
    {
        $query = $this->createQuery();

        /** @var array $groupList */
        $groupList = GeneralUtility::intExplode(",", $groupList);

        $constraints = [];

        foreach ($groupList as $group) {
            if ($group > 0) {
                $constraints[] = $query->logicalAnd([
                        $query->contains('groups', $group),
                        $query->equals('groups.hidden', 0),
                        $query->equals('groups.deleted', 0)
                    ]
                );
            }
        }

        if (count($constraints) > 0) {
            $query->matching(
                ($andSearch ? $query->logicalAnd($constraints) : $query->logicalOr($constraints))
            );
        }

        return $query->execute();
    }

    /**
     * Find all Persons by search string
     *
     * @param \string       $sterm
     * @param \string|array $fieldList
     *
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface|boolean
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findBySword($sterm, $fieldList)
    {
        $query = $this->createQuery();

        if (!is_array($fieldList)) {
            $fieldList = ArrayUtility::trimExplode(',', $fieldList, true);
        }

        if (count($fieldList) <= 0) {
            return false;
        }

        $constraints = [];
        foreach ($fieldList as $field) {
            $constraints[] = $query->like($field, '%' . $sterm . '%');
        }

        $query->matching(
            $query->logicalOr($constraints)
        );

        return $query->execute();
    }

    /**
     * Find all Persons by search string
     *
     * @param \array        $groupList
     * @param \string       $sterm
     * @param \string|array $fieldList
     * @param \boolean      $andSearch
     *
     * @return bool|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findByGroupsAndSword($groupList, $sterm, $fieldList, $andSearch = false)
    {
        $query = $this->createQuery();
        $fieldList = ArrayUtility::trimExplode(',', $fieldList, true);
        $groupList = GeneralUtility::intExplode(',', $groupList);

        if (count($fieldList) <= 0) {
            return false;
        }
        $groupConstraints = [];
        foreach ($groupList as $group) {
            if ($group > 0) {
                $groupConstraints[] = $query->logicalAnd([
                        $query->contains('groups', $group),
                        $query->equals('groups.hidden', 0),
                        $query->equals('groups.deleted', 0)
                    ]
                );
            }
        }

        $constraints = [];
        foreach ($fieldList as $field) {
            $constraints[] = $query->like($field, '%' . $sterm . '%');
        }

        if (count($groupConstraints) > 0) {
            $query->matching(
                $query->logicalAnd(
                    [
                        $query->logicalOr($constraints),
                        $andSearch ? $query->logicalAnd($groupConstraints) : $query->logicalOr($groupConstraints)
                    ]
                )
            );
        } else {
            $query->matching(
                $query->logicalOr($constraints)
            );
        }

        return $query->execute();
    }

    /**
     * Find Person by UID
     *
     * @param \int $personUid
     *
     * @return \object|Person
     */
    public function findByUid($personUid)
    {

        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->getQuerySettings()->setRespectSysLanguage(false);

        return $query->matching(
            $query->logicalAnd([
                    $query->equals('uid', $personUid),
                    $query->equals('deleted', 0)
                ]
            ))->execute()->getFirst();

    }
}
