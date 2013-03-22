<?php

class HasOneGridFieldAddExistingSearchHandler extends GridFieldAddExistingSearchHandler {

	public function __construct($grid, $button) {
		parent::__construct($grid, $button);
		
		/*
		var_dump($this->context);
		@todo allow overriding of SearchContext
		*/
		
	}
	

	public function add($request) {
		if(!$id = $request->postVar('id')) {
			$this->httpError(400);
		}
		
		$childProperty = $this->grid->getName();
		$this->grid->childObject->$childProperty = $id;
		$this->grid->childObject->write();
	}


}
