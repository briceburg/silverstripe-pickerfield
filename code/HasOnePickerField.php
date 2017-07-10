<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\ReadonlyField;

class HasOnePickerField extends PickerField
{
    protected $isHaveOne = true;

    protected $childObject;

    protected $currentHasOne;

    /**
     * Usage [e.g. in getCMSFields]
     *    $field = new HasOnePickerField($this, 'DamID', 'Selected Dam', $this->Dam(), 'Select a Dam');
     *
     * @param DataObject $childObject   - The DataObject we are manipulating with this field: typically $this via getCMSFields
     * @param string $name              - Field Name of has_one relationship (e.g. DamID, SireID, etc.): ensure 'ID' suffix
     * @param string $title             - GridField Title
     * @param Object $currentHasOne     - Result of the current has_one relationship method (E.g. $this->HasOneMethod())
     * @param string $linkExistingTitle - AddExisting Button Title
     */

    public function __construct(DataObject $childObject, $name, $title = null, $currentHasOne, $linkExistingTitle = null, $searchContext = null)
    {
        $modelClass = $childObject->getRelationClass(str_replace('ID', '', $name));
        if (!$modelClass) {
            $modelClass = $currentHasOne->className;
        }

        $this->setModelClass($modelClass);
        $this->childObject = $childObject;
        $this->currentHasOne = $currentHasOne;

        // convert the has_one relation getter to a DataList / SS_List
        $dataList = $modelClass::get()->filter(array('ID' => $currentHasOne->ID));

        // construct the PickerField
        parent::__construct($name, $title, $dataList, $linkExistingTitle);

        // remove components non-applicable to has_one relationships
        $this->getConfig()->removeComponentsByType('GridFieldPaginator');
    }


    /**
     * Returns a read-only version of this field.
     *
     * @return FormField
     */
    public function performReadonlyTransformation()
    {
        $clone = $this->castedCopy(HasOnePickerField_Readonly::class);
        $clone->setPicker($this);

        return $clone;
    }

    public function getCurrentHasOne()
    {
        return $this->currentHasOne;
    }
}

class HasOnePickerField_Readonly extends ReadonlyField
{
    protected $picker;

    private static $casting = [
        'Message' => 'Text'
    ];

    public function setPicker($picker)
    {
        $this->picker = $picker;
    }

    public function setValue($value, $data = NULL)
    {
        if ($this->picker) {
            if ($one = $this->picker->getCurrentHasOne()) {
                if ($one->exists()) {
                    $value = ($one = $this->picker->getCurrentHasOne()) ? $one->Title : 'Not-set';

                    parent::setValue($value, $data);
                }
            }
        }

        return $this;
    }
}
