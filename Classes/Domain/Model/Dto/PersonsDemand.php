<?php
namespace NN\NnAddress\Domain\Model\Dto;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Gerald Grote <g.grote@neonaut.de>, Neonaut GmbH
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

class PersonsDemand extends AbstractEntity {

	/** @var integer */
	protected $storagePage;

	/**
	 * @var array
	 */
	protected $selectedIds;

	/**
	 * @var array
	 */
	protected $groups;

	/**
	 * @var array
	 */
	protected $categories;

	/**
	 * @var string
	 */
	protected $categoryConjunction;

	/**
	 * @var string
	 */
	protected $searchTerm;

	/**
	 * @var array
	 */
	protected $searchFields;


	/** @var string */
	public $orderDirection;

	/** @var string */
	public $orderBy;


	/**
	 * Set list of storage pages
	 *
	 * @param string $storagePage storage page list
	 * @return void
	 */
	public function setStoragePage($storagePage) {
		$this->storagePage = $storagePage;
	}

	/**
	 * Get list of storage pages
	 *
	 * @return string
	 */
	public function getStoragePage() {
		return $this->storagePage;
	}


	/**
	 * Get selected persons uids
	 *
	 * @return array
	 */
	public function getSelectedIds() {
		return $this->selectedIds;
	}

	/**
	 * Set selected persons ids
	 *
	 * @param array $selectedIds $selectedIds
	 * @return void
	 */
	public function setSelectedIds($selectedIds) {
		$this->selectedIds = $selectedIds;
	}
	


	/**
	 * Set list of allowed groups
	 *
	 * @param array $groups groups
	 *
	 * @return void
	 */
	public function setGroups($groups) {
		$this->groups = $groups;
	}

	/**
	 * Get allowed groups
	 *
	 * @return array
	 */
	public function getGroups() {
		return $this->groups;
	}

	
	

	/**
	 * Set list of categories
	 *
	 * @param array $categories categories
	 *
	 * @return void
	 */
	public function setCategories($categories) {
		$this->categories = $categories;
	}

	/**
	 * Get allowed categories
	 *
	 * @return array
	 */
	public function getCategories() {
		return $this->categories;
	}	
	
	
	/**
	 * Set category conjunction
	 *
	 * @param string $categoryConjunction
	 *
	 * @return void
	 */
	public function setCategoryConjunction($categoryConjunction) {
		$this->categoryConjunction = $categoryConjunction;
	}

	/**
	 * Get category conjunction
	 *
	 * @return string
	 */
	public function getCategoryConjunction() {
		return $this->categoryConjunction;
	}

	
	/**
	 * Set search term
	 *
	 * @param string $searchTerm
	 *
	 * @return void
	 */
	public function setSearchTerm($searchTerm) {
		$this->searchTerm = $searchTerm;
	}

	/**
	 * Get category conjunction
	 *
	 * @return string
	 */
	public function getSearchTerm() {
		return $this->searchTerm;
	}


	/**
	 * Set search term
	 *
	 * @param array $searchFields
	 *
	 * @return void
	 */
	public function setSearchFields($searchFields) {
		$this->searchFields = $searchFields;
	}

	/**
	 * Get category conjunction
	 *
	 * @return array
	 */
	public function getSearchFields() {
		return $this->searchFields;
	}
	
	

	/**
	 * Set orderBy
	 *
	 * @param string $orderBy orderBy
	 * @return void
	 */
	public function setOrderBy($orderBy) {
		$this->orderBy = $orderBy;
	}

	/**
	 * Get orderBy
	 *
	 * @return string
	 */
	public function getOrderBy() {
		return $this->orderBy;
	}

	/**
	 * Set orderDirection
	 *
	 * @param string $orderDirection orderDirection
	 * @return void
	 */
	public function setOrderDirection($orderDirection) {
		$this->orderDirection = $orderDirection;
	}

	/**
	 * Get orderDirection
	 *
	 * @return string
	 */
	public function getOrderDirection() {
		return $this->orderDirection;
	}


}
