<?php

class Ct_Addressformat_Block_Adminhtml_Addressformat_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'addressformat';
        $this->_controller = 'adminhtml_addressformat';
        
        $this->_updateButton('save', 'label', Mage::helper('addressformat')->__('Save Format'));
        $this->_updateButton('delete', 'label', Mage::helper('addressformat')->__('Delete Format'));
        
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('addressformat_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'addressformat_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'addressformat_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('addressformat_data') && Mage::registry('addressformat_data')->getId() ) {
            return Mage::helper('addressformat')->__("Edit Format '%s'", $this->htmlEscape(
            Mage::app()->getLocale()->getCountryTranslation(Mage::registry('addressformat_data')->getCountryId())));
        } else {
            return Mage::helper('addressformat')->__('Add Format');
        }
    }
}