<?php

class PickerGridField extends GridField {
	
	public function __construct($name, $title = null, SS_List $dataList = null, $linkExistingTitle = 'Select Existing', $sortField = null) {
		$config = GridfieldConfig::create()->addComponents(
			new GridFieldButtonRow('before'),
			new GridFieldToolbarHeader(),
			new GridFieldDataColumns(),
			new GridFieldTitleHeader(),
			new GridFieldDeleteAction(true),
			new GridFieldPaginator(),
			new GridFieldAddExistingSearchButton()
		);
		
		if($sortField)
		{
			$config->addComponent(new GridFieldOrderableRows($sortField));
		}
		
		$config->getComponentByType('GridFieldAddExistingSearchButton')->setTitle($linkExistingTitle);

		return parent::__construct($name, $title, $dataList, $config);
	}
	
}