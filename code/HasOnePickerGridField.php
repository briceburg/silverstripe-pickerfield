<?php

class HasOnePickerGridField extends PickerGridField {
	
	protected $childObject;
	
	/**
	 * Usage [e.g. in getCMSFields]
	 *    $field = new HasOnePickerGridField($this, 'DamID', 'Selected Dam', $this->Dam(), 'Select a Dam');
	 *    
	 * @param DataObject $childObject	- The field we are executing on
	 * @param string $name				- Field Name of has_one relationship (e.g. DamID, SireID, etc.)
	 * @param string $title				- GridField Title
	 * @param SS_List $dataList			- Result of the has_one relationship method (E.g. $this->HasOneMethod())
	 * @param string $linkExistingTitle	- GridFieldAddExistingSearchButton Title
	 */
	
	public function __construct(DataObject $childObject, $name, $title = null, SS_List $dataList, $linkExistingTitle = 'Select Existing', $searchContext = null) {
		$modelClass = $dataList->className;
		$this->childObject = $childObject;
		$this->setModelClass($modelClass);
		
		// convert the has_one relation getter to a DataList / SS_List
		// @todo is there a DataObject getter for a has_one relation that returns an appropriate DataList???
		// @todo  ^^ for now, use the $childObject kludge.
		$dataList = $modelClass::get()->filter(array('ID' => $dataList->ID));
		$dataList->setDataModel($childObject);
		
		// construct the PickerField
		parent::__construct($name, $title, $dataList);
		
		// remove components non-applicable to has_one relationships
		$this->getConfig()->removeComponentsByType('GridFieldPaginator');
		$this->getConfig()->removeComponentsByType('GridFieldAddExistingSearchButton');
		
		// add custom has_one handling
		$this->getConfig()->addComponent($component = new HasOneGridFieldAddExistingSearchButton());
		$component->setTitle($linkExistingTitle);
	}
	
}