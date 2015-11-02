<?php

class PickerField extends GridField {
	protected $isHaveOne = false;
	
	/**
	 * Usage [e.g. in getCMSFields]
	 *    $field = new PickerField('Authors', 'Selected Authors', $this->Authors(), 'Select Author(s)');
	 *     
	 * @param string $name              - Name of field (typically the relationship method)
	 * @param string $title             - GridField Title
	 * @param SS_List $dataList         - Result of the relationship component method (E.g. $this->Authors())
	 * @param string $linkExistingTitle - AddExisting Button Title
	 * @param string $sortField         - Field to sort on. Be sure it exists in the $many_many_extraFields static
	 */
	public function __construct($name, $title = null, SS_List $dataList = null, $linkExistingTitle = null, $sortField = null) {
		$config = GridfieldConfig::create()->addComponents(
			new GridFieldButtonRow('before'),
			new GridFieldToolbarHeader(),
			new GridFieldDataColumns(),
			new GridFieldTitleHeader(),
			new GridFieldPaginator(),
			new PickerFieldAddExistingSearchButton(),
			new PickerFieldDeleteAction()
		);
		
		if($sortField)
		{
			$config->addComponent(new GridFieldOrderableRows($sortField));
		}
		
		if(!$linkExistingTitle)
		{
			$linkExistingTitle = ($this->isHaveOne()) ? 
				'Select a ' . $dataList->dataClass() :		// singular [has_one]
				'Select ' . $dataList->dataClass() . '(s)';	// plural [has_many, many_many]
		}
		
		$config->getComponentByType('PickerFieldAddExistingSearchButton')->setTitle($linkExistingTitle);

		return parent::__construct($name, $title, $dataList, $config);
	}
	
	public function isHaveOne(){
		return $this->isHaveOne;
	}
	
	public function setSearchFilters($filters) {
		$this->config->getComponentByType('PickerFieldAddExistingSearchButton')
			->setSearchFilters($filters);
		
		return $this;
	}
	
	public function setSearchExcludes($excludes) {
		$this->config->getComponentByType('PickerFieldAddExistingSearchButton')
			->setSearchExcludes($excludes);
		
		return $this;
	}

	/**
	 * @param SS_List $list List to search on
	 * @return $this
	 */
	public function setSearchList(SS_List $list) {
		$this->config->getComponentByType('PickerFieldAddExistingSearchButton')
			->setSearchList($list);

		return $this;
	}

	public function getSearchFilters() {
		return $this->config->getComponentByType('PickerFieldAddExistingSearchButton')
			->getSearchFilters();
	}
	
	public function getSearchExcludes() {
		return $this->config->getComponentByType('PickerFieldAddExistingSearchButton')
			->getSearchExcludes();
	}

	/**
	 * @return SS_List
	 */
	public function getSearchLIst() {
		return $this->config->getComponentByType('PickerFieldAddExistingSearchButton')
			->getSearchList();
	}
	
	public function enableCreate($button_title = null) {
	    $this->addDetailForm();
	     
	    $button = new GridFieldAddNewButton();
	    if($button_title) $button->setButtonName($button_title);
	     
	    $this->config->addComponent($button);
	    
	    return $this; 
	}
	
	public function enableEdit() {
	    $this->addDetailForm();
	    
	    $this->config->addComponent(new GridFieldEditButton());
	     
	    return $this;
	}
	
	
	public function setSelectTitle($title) {
	    $this->config->getComponentByType('PickerFieldAddExistingSearchButton')->setTitle($title);
	    
	    return $this;
	}
	
	private function addDetailForm(){
	     
	    if($this->config->getComponentByType('GridFieldDetailForm'))
	        return;
	     
	    $form = new GridFieldDetailForm();
	    $form->setItemRequestClass('PickerFieldEditHandler');
	     
	     
	    return $this->config->addComponent($form);
	}
}