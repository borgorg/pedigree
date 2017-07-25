<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
/**
 * Pedigree module for XOOPS
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GPL 2.0 or later
 * @package         pedigree
 * @since           2.5.x
 * @author          XOOPS Module Dev Team (https://xoops.org)
 */

defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');

/**
 * Class PedigreeTemp
 */
class PedigreeTemp extends XoopsObject
{
    //Constructor
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->initVar('Id', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('NAAM', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('id_owner', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('id_breeder', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('user', XOBJ_DTYPE_TXTBOX, null, false, 25);
        $this->initVar('roft', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('mother', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('father', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('foto', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('coi', XOBJ_DTYPE_TXTBOX, null, false, 10);
    }

    /**
     * @param bool $action
     *
     * @return XoopsThemeForm
     */
    public function getForm($action = false)
    {
        global $xoopsDB, $xoopsModuleConfig;

        if (false === $action) {
            $action = $_SERVER['REQUEST_URI'];
        }

        $title = $this->isNew() ? sprintf(_AM_PEDIGREE_PEDIGREE_TEMP_ADD) : sprintf(_AM_PEDIGREE_PEDIGREE_TEMP_EDIT);

        include_once $GLOBALS['xoops']->path('class/xoopsformloader.php');

        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $form->addElement(new XoopsFormTextArea(_AM_PEDIGREE_PEDIGREE_TEMP_NAAM, 'NAAM', $this->getVar('NAAM'), 4, 47), true);
        $form->addElement(new XoopsFormText(_AM_PEDIGREE_PEDIGREE_TEMP_ID_OWNER, 'id_owner', 50, 255, $this->getVar('id_owner')), false);
        $form->addElement(new XoopsFormText(_AM_PEDIGREE_PEDIGREE_TEMP_ID_BREEDER, 'id_breeder', 50, 255, $this->getVar('id_breeder')), false);
        $form->addElement(new XoopsFormText(_AM_PEDIGREE_PEDIGREE_TEMP_USER, 'user', 50, 255, $this->getVar('user')), false);
        $form->addElement(new XoopsFormText(_AM_PEDIGREE_PEDIGREE_TEMP_ROFT, 'roft', 50, 255, $this->getVar('roft')), false);
        $form->addElement(new XoopsFormText(_AM_PEDIGREE_PEDIGREE_TEMP_MOTHER, 'mother', 50, 255, $this->getVar('mother')), false);
        $form->addElement(new XoopsFormText(_AM_PEDIGREE_PEDIGREE_TEMP_FATHER, 'father', 50, 255, $this->getVar('father')), false);
        $form->addElement(new XoopsFormText(_AM_PEDIGREE_PEDIGREE_TEMP_FOTO, 'foto', 50, 255, $this->getVar('foto')), false);

        include_once $GLOBALS['xoops']->path('class/tree.php');
        //            $Handler = xoops_getModuleHandler("animal_", $xoopsModule->getVar("dirname"));
        $tempHandler = xoops_getModuleHandler('temp', PEDIGREE_DIRNAME);
        $criteria    = new CriteriaCompo();
        $criteria->setSort('Id');
        $criteria->setOrder('ASC');
        $_arr   = $tempHandler->getAll();
        $mytree = new XoopsObjectTree($_arr, '_id', '_pid');
        $form->addElement(new XoopsFormLabel(_AM_PEDIGREE_PEDIGREE_TEMP_COI, $mytree->makeSelBox('_pid', '_title', '--', $this->getVar('_pid'), false)));

        $form->addElement(new XoopsFormHidden('op', 'save_pedigree_temp'));

        //Submit buttons
        $button_tray   = new XoopsFormElementTray('', '');
        $submit_button = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
        $button_tray->addElement($submit_button);

        $cancel_button = new XoopsFormButton('', '', _CANCEL, 'cancel');
        $cancel_button->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($cancel_button);

        $form->addElement($button_tray);

        return $form;
    }
}

/**
 * Class PedigreeTempHandler
 */
class PedigreeTempHandler extends XoopsPersistableObjectHandler
{
    /**
     * @param null|XoopsDatabase $db
     */
    public function __construct(XoopsDatabase $db)
    {
        parent::__construct($db, 'pedigree_temp', 'PedigreeTemp', 'Id', 'NAAM');
    }
}
