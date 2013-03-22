<?php

class PickerFieldAddExistingSearchHandler extends GridFieldAddExistingSearchHandler {
	
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
	
	public function doSearch($data, $form) {
		$list = $this->context->getResults($data);
		$list = $this->applySearchFilters($list);
		$list = $list->subtract($this->grid->getList());
		$list = new PaginatedList($list, $this->request);
	
		$data = $this->customise(array(
				'SearchForm' => $form,
				'Items'      => $list
		));
		return $data->index();
	}
	
	
	public function Items() {
		$list = DataList::create($this->grid->getList()->dataClass());
		$list = $this->applySearchFilters($list);
		$list = $list->subtract($this->grid->getList());
		$list = new PaginatedList($list, $this->request);

		return $list;
	}
	
	public function applySearchFilters($list){
		$component	= $this->grid->getConfig()->getComponentByType('PickerFieldAddExistingSearchButton');
		
		if($filters = $component->getSearchFilters())	{ $list = $list->filter($filters); }
		if($excludes = $component->getSearchExcludes())	{ $list = $list->exclude($excludes); }
		
		return $list;
	}
}
