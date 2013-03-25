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
			new GridFieldDeleteAction(true),
			new GridFieldPaginator(),
			new PickerFieldAddExistingSearchButton()
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
	
	public function getSearchFilters() {
		return $this->config->getComponentByType('PickerFieldAddExistingSearchButton')
			->getSearchFilters();
	}
	
	public function getSearchExcludes() {
		return $this->config->getComponentByType('PickerFieldAddExistingSearchButton')
			->getSearchExcludes();
	}
	
}