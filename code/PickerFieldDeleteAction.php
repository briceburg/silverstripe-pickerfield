<?php

class PickerFieldDeleteAction extends GridFieldDeleteAction {
	
	public function __construct() {
		parent::__construct(true); // unlink vs. delete selected objects
	}
	
	
	public function handleAction(GridField $gridField, $actionName, $arguments, $data) {
		// use native GridFieldDeleteAction handleAction() method when !has_one
		if(!$gridField->isHaveOne()) { return parent::handleAction($gridField, $actionName, $arguments, $data); }
		
		// appropriate handling of has_one relationships [so as not to delete the object]
		$childProperty = $gridField->getName();
		$gridField->childObject->$childProperty = 0;
		$gridField->childObject->write();
		
		$gridField->setList(ArrayList::create());
	}
	
	
}
