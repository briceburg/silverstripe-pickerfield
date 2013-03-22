<?php

class PickerFieldAddExistingSearchHandler extends GridFieldAddExistingSearchHandler {
	
	public function doSearch($data, $form) {
		$list = $this->context->getResults($data);
		$list = $list->subtract($this->grid->getList());
		$list = new PaginatedList($list, $this->request);
	
		$data = $this->customise(array(
				'SearchForm' => $form,
				'Items'      => $list
		));
		return $data->index();
	}
	

	public function add($request) {
		// use native GridFieldAddExistingSearchHandler add() method when not has_one
		if(!$this->grid->isHaveOne()) { return parent::add($request); }
		
		if(!$id = $request->postVar('id')) {
			$this->httpError(400);
		}
		
		// appropriate handling of has_one relationships
		$childProperty = $this->grid->getName();
		$this->grid->childObject->$childProperty = $id;
		$this->grid->childObject->write();
	}


}
