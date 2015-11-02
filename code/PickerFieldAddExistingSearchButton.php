<?php

class PickerFieldAddExistingSearchButton extends GridFieldAddExistingSearchButton {
	protected $searchFilters	= null;
	protected $searchExcludes	= null;
	protected $searchList		= null;
	
	public function handleSearch($grid, $request) {
		return new PickerFieldAddExistingSearchHandler($grid, $this);
	}
	
	public function setSearchFilters($filters) {
		$this->searchFilters = $filters;
	}
	
	public function setSearchExcludes($excludes) {
		$this->searchExcludes = $excludes;
	}

	/**
	 * Set a custom list to be searched on
	 * @param SS_List $list
	 */
	public function setSearchList(SS_List $list) {
		$this->searchList = $list;
	}
	
	public function getSearchFilters() {
		return $this->searchFilters;
	}
	
	public function getSearchExcludes() {
		return $this->searchExcludes;
	}

	public function getSearchList() {
		return $this->searchList;
	}
	
}