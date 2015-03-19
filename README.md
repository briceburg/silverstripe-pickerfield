silverstripe-pickerfield
========================

SilverStripe 3 GridField based management of has_one , has_many , and many_many relationship selection


## Requirements
* SilverStripe >= 3.1
* Andrew Short's GridFieldExtensions [ https://github.com/ajshort/silverstripe-gridfieldextensions ]

## Why?

1. An efficient* GridField based interface to manage relationship selections. 
1. GridField doesn't appear to natively support has_one relationships.
1. The ability to edit and create selected items.

Thanks to the great work of the SilverStripe team and Andrew Short's GridFieldExtensions, the 
development of this module was a bit easier. Be kind to them. 

\* by efficient we needed ajax + pagination, as we couldn't load all records into a dropdown list for instance.

## Usage Overview

Screenshots;
###overview
![overview](https://github.com/briceburg/silverstripe-pickerfield/blob/master/docs/screenshots/pickerfield.png?raw=true)
###link button search [via GridFieldExtensions]
![link button search [via GridFieldExtensions]](http://github.com/briceburg/silverstripe-pickerfield/blob/master/docs/screenshots/add-existing-search.png?raw=true)


```php

/***********************
	Mock DataObject
************************/

class Dog extends DataObject {
	static $db = array(
		'Title'				=> 'Varchar',
		// ....
	);
	
	static $has_one = array(
		'Breeder'			=> 'Breeder'
		'Dam'				=> 'Dog',
		'Sire'				=> 'Dog',
		// ....
	);
	
	static $has_many = array(
		'Owners'	=> 'Member',
		// ....
	);
	
// ....

}


/***********************
	Field Usage
************************/

// sortable field appropriate for selection of has_many and many_many objects
$field = new PickerField('Owners', 'Owners', $this->Owners(), 'Select Owner(s)', 'SortOrder');

// non-sortable version of the above
$field = new PickerField('Owners', 'Owners', $this->Owners());

// sortable field appropriate for the parent selection of a has_one relationship
$field = new HasOnePickerField($this, 'DamID', 'Selected Dam', $this->Dam(), 'Select a Dam');


// we also allow the ability to create and edit associated records via enableCreate, enableEdit methods.
$fields->addFieldsToTab('Root.Main', array(
  new HeaderField('Info','Info Blocks'),
  $field = new HasOnePickerField($this, 'AboutInfoBlockID', 'About Block', $this->AboutInfoBlock())
));
        
$field->enableCreate('Add Block')->enableEdit();
 

```


## Bugs

For support or questions, please use the GitHub provided issue tracker;
* https://github.com/briceburg/silverstripe-pickerfield/issues

