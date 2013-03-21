<?php

class HasOneGridFieldAddExistingSearchHandler extends GridFieldAddExistingSearchHandler {


	public function add($request) {
		if(!$id = $request->postVar('id')) {
			$this->httpError(400);
		}
		
		$childProperty = $this->grid->getModelClass() . 'ID';
		$this->grid->childObject->$childProperty = $id;
		$this->grid->childObject->write();
	}


}
