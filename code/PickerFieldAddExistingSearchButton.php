<?php

class PickerFieldAddExistingSearchButton extends GridFieldAddExistingSearchButton {
	protected $searchFilters	= null;
	protected $searchExcludes	= null;
	
	public function handleSearch($grid, $request) {
		return new PickerFieldAddExistingSearchHandler($grid, $this);
	}
	
	public function setSearchFilters($filters) {
		$this->searchFilters = $filters;
	}
	
	public function setSearchExcludes($excludes) {
		$this->searchExcludes = $excludes;
	}
	
	public function getSearchFilters() {
		return $this->searchFilters;
	}
	
	public function getSearchExcludes() {
		return $this->searchExcludes;
	}
	
}