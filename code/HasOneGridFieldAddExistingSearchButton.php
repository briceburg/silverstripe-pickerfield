<?php
class HasOneGridFieldAddExistingSearchButton extends GridFieldAddExistingSearchButton {

	public function handleSearch($grid, $request) {
		return new HasOneGridFieldAddExistingSearchHandler($grid, $this);
	}

}
