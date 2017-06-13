<?php
namespace NN\NnAddress\Mvc\Controller;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
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

/**
 * Basic functions used by PersonController
 *
 * @package nn_address
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class BasicController extends \NN\NnAddress\Mvc\Controller\ActionController {
	
	/**
	 * personRepository
	 *
	 * @var \NN\NnAddress\Domain\Repository\PersonRepository
	 * @inject
	 */
	protected $personRepository = NULL;


	/**
	 * Create the demand object which define which records will get shown
	 *
	 * @param array $settings
	 * @param string $class optional class which must be an instance of \NN\NnAddress\Domain\Model\Dto\PersonsDemand
	 * @return \NN\NnAddress\Domain\Model\Dto\PersonsDemand
	 */
	protected function createDemandObject($settings, $class = 'NN\\NnAddress\\Domain\Model\\Dto\\PersonsDemand') {

		/* @var $demand \NN\NnAddress\Domain\Model\Dto\PersonsDemand */
		$demand = $this->objectManager->get($class, $settings);
		if (!$demand instanceof \NN\NnAddress\Domain\Model\Dto\PersonsDemand) {
			throw new \UnexpectedValueException(
				sprintf('The demand object must be an instance of \NN\NnAddress\Domain\Model\Dto\PersonsDemand, but %s given!', $class),
				5976576597);
		}
		$demand->setSelectedIds(GeneralUtility::intExplode(',', $settings['selectedUids'], TRUE));

		$groups = $this->getRequestArgument('group', '/^([0-9]{1,})$/', (($settings['groupSearchTypeAnd'] == 1) ? TRUE : FALSE));
		$groups = ( $groups !== NULL ) ? $groups : $this->settings['groups'];
		if ( is_array($groups) ) {
			$groups = implode(',', $groups);
		} else {
			if ( !empty($this->settings['groups']) || !empty($groups) ) {
				// Append to selected groups the subgroups
				$groupIdList = array($groups);
				foreach ( explode(',', $groups) as $group ) {
					$this->getGroupIdList($group, $groupIdList);
				}

				$groups = implode(',',$groupIdList);
			}
		}
		$demand->setGroups(GeneralUtility::intExplode(',', $groups, TRUE));

		$demand->setCategories(GeneralUtility::intExplode(',', $settings['categories'], TRUE));
		$demand->setCategoryConjunction($settings['categoryConjunction']);



		$demand->setSearchTerm($this->getRequestArgument('sword', $settings['swordValidationExpr']));
		$demand->setSearchFields(\TYPO3\CMS\Extbase\Utility\ArrayUtility::trimExplode(',', $settings['searchInFields'], true));

		$demand->setOrderBy($settings['orderBy']);
		$demand->setOrderDirection($settings['order']);

		return $demand;
	}



	/**
	 * Find all persons according to Demand
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
	 */
	protected function getPersonsByDemand() {
		$demand = $this->createDemandObject($this->settings);
		return $this->personRepository->findDemanded($demand);
	}


	/**
	 * Find all persons, optional by selected groups
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
	 */
	protected function getPersons() {
		$sword  = $this->getRequestArgument('sword', $this->settings['swordValidationExpr']);
		$groups = $this->getRequestArgument('group', '/^([0-9]{1,})$/', (($this->settings['groupSearchTypeAnd'] == 1) ? TRUE : FALSE));
		$groups = ( $groups !== NULL ) ? $groups : $this->settings['groups'];
		
		$categories = $this->settings['categories'];
		$categoryConjunction = $this->settings['categoryConjunction'];


		if ( is_array($groups) ) {
			$groups = implode(',', $groups);
		} else {
			if ( !empty($this->settings['groups']) || !empty($groups) ) {
				// Append to selected groups the subgroups
				$groupIdList = array($groups);
				foreach ( explode(',', $groups) as $group ) {
					$this->getGroupIdList($group, $groupIdList);
				}
				
				$groups = implode(',',$groupIdList);
			}
		}
		
		if ( !empty($categories) ) {
			return $this->personRepository->findByCategories($categories, $categoryConjunction);
		}

		if ( !empty($groups) ) {
			if ( !empty($sword) ) {
				return $this->personRepository->findByGroupsAndSword($groups, $sword, $this->settings['searchInFields'], (($this->settings['groupSearchTypeAnd'] == 1) ? TRUE : FALSE));
			} else return $this->personRepository->findByGroups($groups, (($this->settings['groupSearchTypeAnd'] == 1) ? TRUE : FALSE));
		} else {
			if ( !empty($sword) ) {
				return $this->personRepository->findBySword($sword, $this->settings['searchInFields']);
			} else return $this->personRepository->findAll();
		}
	}
	
	/**
	 * Set's to fluid the input fields if search is enabled
	 *
	 * @return void
	 */
	protected function setSearchPresets() {
		if ( $this->settings['enableSearch'] == 1 ) {
			$groupId = $this->getRequestArgument('group', '/^([0-9]{1,})$/', (($this->settings['groupSearchTypeAnd'] == 1) ? TRUE : FALSE));
			
			$this->view->assign('sword', $this->getRequestArgument('sword', $this->settings['swordValidationExpr']));
			$this->view->assign('groups', $this->groupRepository->findAll());
			
			if ( !is_array($groupId) ) {
				$this->view->assign('selectedGroup', $groupId);
			
				// Build the Hierachy Object for sub selected groups
				$p = $this->groupRepository->findOneByUid(intval($groupId));
				$p = ( is_object($p) ) ? $p->getParentGroups()->current() : NULL;
				$options = ( is_object($p) ) ? $p->getChildGroups() : $this->groupRepository->findAll();
				$idList[]        = array(
					'model'   => $this->groupRepository->findOneByUid(intval($groupId)),
					'options' => $options
				);
				
				$groupHierachy = @array_reverse($this->getGroupIdHierachy($groupId, $idList));
				$this->view->assign('groupHierachy', $groupHierachy);
			} else {
				$this->view->assign('selectedGroups', $groupId);
			}
		}
	}
	/**
	 * Creates an array of each sub level by the latest selected group upwards
	 *
	 * @param int $groupId
	 * @param array $idList
	 * @return array
	 */
	private function getGroupIdHierachy($groupId, &$idList) {
		if ( empty($groupId) ) return NULL;
		$curGroupObj = $this->groupRepository->findOneByUid(intval($groupId));
		$parentGroup = $curGroupObj->getParentGroups()->current();
		
		if ( is_object($parentGroup) ) {
			$p = $parentGroup->getParentGroups()->current();
			$options = ( is_object($p) ) ? $p->getChildGroups() : $this->groupRepository->findAll();
		
			$uid      = $parentGroup->getUid();
			$idList[] = array(
				'model'   => $parentGroup,
				'options' => $options,
			);
			$this->getGroupIdHierachy($uid, $idList);
		}
		
		return $idList;
	}
	
	/**
	 * Creates an array of each available subgroup IDs inside a group
	 *
	 * @param int $groupId
	 * @param array $idList
	 * @return array
	 */
	private function getGroupIdList($groupId, &$idList) {
		if ( $groupId <= 0 ) return NULL;
		$curGroupObj = $this->groupRepository->findOneByUid(intval($groupId));
		$childGroups = $curGroupObj->getChildGroups();
		
		if ( $childGroups->count() > 0 ) {
			$childGroups = $childGroups->toArray();
			foreach ( $childGroups as $childGroup ) {
				$uid      = $childGroup->getUid();
				$idList[] = $uid;
				$this->getGroupIdList($uid, $idList);
			}
		}
		
		return $idList;
	}
	
}
?>