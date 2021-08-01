<?php
namespace XoopsModules\Pedigree;

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @package         XoopsModules\Pedigree
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         {@link http://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @author          XOOPS Module Dev Team
 */
use XoopsModules\Pedigree\{
    Animal,
    Field
};

/**
 * Class Pedigree\DateSelectBox
 */
class DateSelect extends Pedigree\HtmlInputAbstract
{
    // Define class variables
    private $fieldnumber;
    private $fieldname;
    private $value;
    private $defaultvalue;
    private $lookuptable;
    private $errs;
    private $size = 15;

    /**
     * Constructor
     *
     * @param Field $parentObject
     * @param Animal $animalObject
     *
     */
    public function __construct(Field $parentObject, Animal $animalObject)
    {
        //@todo move language strings to language file
        $this->fieldnumber = $parentObject->getId();
        $this->fieldname = $parentObject->getSetting('fieldname');
        $this->value = $animalObject->{'user' . $this->fieldnumber};
        $this->defaultvalue = $parentObject->getSetting('defaultvalue');
        if ($parentObject->hasLookup()) {
            xoops_error('No lookuptable may be specified for userfield ' . $this->fieldnumber, get_class($this));
        }
        if ($parentObject->inAdvanced()) {
            xoops_error('userfield ' . $this->fieldnumber . ' cannot be shown in advanced info', get_class($this));
        }
        if ($parentObject->inPie()) {
            xoops_error('A Pie-chart cannot be specified for userfield ' . $this->fieldnumber, get_class($this));
        }
    }

    /**
     * @return \XoopsFormTextDateSelect
     */
    public function editField(): \XoopsFormTextDateSelect
    {
        return new \XoopsFormTextDateSelect('<b>' . $this->fieldname . '</b>', 'user' . $this->fieldnumber, $this->size, $this->value);
    }

    /**
     * @param string $name
     *
     * @return \XoopsFormTextDateSelect
     */
    public function newField(?string $name = ''): \XoopsFormTextDateSelect
    {
        return new \XoopsFormTextDateSelect('<b>' . $this->fieldname . '</b>', $name . 'user' . $this->fieldnumber, $this->size, $this->defaultvalue);
    }

    /**
     * @return string
     */
    public function getSearchString()
    {
        return '&amp;o=naam&amp;l=1';
    }

    /**
     * Show the value - which is nothing for this data type
     */
    public function showValue()
    {

    }
}
