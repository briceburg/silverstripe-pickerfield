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
	public function __construct($name, $title = null, SS_List $dataList = null, $linkExistingTitle = 'Select Existing', $sortField = null) {
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
		
		$config->getComponentByType('PickerFieldAddExistingSearchButton')->setTitle($linkExistingTitle);

		return parent::__construct($name, $title, $dataList, $config);
	}
	
	public function isHaveOne(){
		return $this->isHaveOne;
	}
	
}