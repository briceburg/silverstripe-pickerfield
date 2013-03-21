<?php

class HasOnePickerGridField extends PickerGridField {
	
	protected $childObject;
	
	public function __construct($childObject, $name, $title = null, $hasOneRelationMethod= null, $linkExistingTitle = 'Select Existing') {
		
		$this->childObject = $childObject;
		
		$modelClass = preg_replace('/ID$/','',$name);
		
		if(!$hasOneRelationMethod)
		{
			$hasOneRelationMethod = $modelClass;
		}
		
		$this->setModelClass($modelClass);
		
		
		$parent = $childObject->$hasOneRelationMethod();
		$dataList = $modelClass::get()->filter(array('ID' => $parent->ID));
		
		
		// construct a PickerGridField
		parent::__construct($name, $title, $dataList);
		
		
		// remove components non-applicable to has_one relationships
		$this->getConfig()->removeComponentsByType('GridFieldPaginator');
		$this->getConfig()->removeComponentsByType('GridFieldAddExistingSearchButton');
		
		// add custom has_one handling
		$component = new HasOneGridFieldAddExistingSearchButton();
		$component->setTitle($linkExistingTitle);
		$this->getConfig()->addComponent($component);
	}
	
}