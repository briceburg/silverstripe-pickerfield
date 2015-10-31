<?php
/**
 * A custom grid field request handler that allows interacting with form fields when adding records.
 */
class PickerFieldEditHandler extends GridFieldDetailForm_ItemRequest {

	public function doSave($data, $form) {

	    /**
	     * modelled after doSave method on GridFieldDetailForm_ItemRequest
	     */
	    if(!$this->record->canEdit()) {
	        return $controller->httpError(403);
	    }

	    if (isset($data['ClassName']) && $data['ClassName'] != $this->record->ClassName) {
	        $newClassName = $data['ClassName'];
	        // The records originally saved attribute was overwritten by $form->saveInto($record) before.
	        // This is necessary for newClassInstance() to work as expected, and trigger change detection
	        // on the ClassName attribute
	        $this->record->setClassName($this->record->ClassName);
	        // Replace $record with a new instance
	        $this->record = $this->record->newClassInstance($newClassName);
	    }

	    try {
	        $form->saveInto($this->record);
	        $this->record->write();

	    } catch(ValidationException $e) {
	        $form->sessionMessage($e->getResult()->message(), 'bad');
	        $responseNegotiator = new PjaxResponseNegotiator(array(
	            'CurrentForm' => function() use(&$form) {
	                return $form->forTemplate();
	            },
	            'default' => function() use(&$controller) {
	                return $controller->redirectBack();
	            }
	        ));
	        if($controller->getRequest()->isAjax()){
	            $controller->getRequest()->addHeader('X-Pjax', 'CurrentForm');
	        }
	        return $responseNegotiator->respond($controller->getRequest());
	    }


	    // object has been created; assign the relationship

	    if($this->gridField->isHaveOne()) {
    	    $childProperty = $this->gridField->getName();
    	    $this->gridField->childObject->$childProperty = $this->record->ID;
    	    $this->gridField->childObject->write();
	    } else {
	        $list = $this->gridField->getList();
	        //$list->add($this->record, $extraData);

	        $extraData = $this->getExtraSavedData($this->record, $list);
	        $list->add($this->record, $extraData);
	    }


	    return $this->edit(Controller::curr()->getRequest());
	}



	/**
	* Get the list of extra data from the $record as saved into it by
	* {@see Form::saveInto()}
	*
	* Handles detection of falsey values explicitly saved into the
	* DataObject by formfields
	*
	* @param DataObject $record
	* @param SS_List $list
	* @return array List of data to write to the relation
	*/
	protected function getExtraSavedData($record, $list) {
		// Skip extra data if not ManyManyList
		if(!($list instanceof ManyManyList)) {
			return null;
		}

		$data = array();
		foreach($list->getExtraFields() as $field => $dbSpec) {
			$savedField = "ManyMany[{$field}]";
			if($record->hasField($savedField)) {
				$data[$field] = $record->getField($savedField);
			}
		}
		return $data;
	}




}
