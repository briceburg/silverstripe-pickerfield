<?php

class PickerFieldAddExistingSearchButton extends GridFieldAddExistingSearchButton {
	
	public function handleSearch($grid, $request) {
		return new PickerFieldAddExistingSearchHandler($grid, $this);
	}
	
}