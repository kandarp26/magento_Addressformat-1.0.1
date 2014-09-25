<?php

class Ct_Addressformat_Block_Adminhtml_Addressformat_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
      
        $fieldset = $form->addFieldset('addressformat_form', array('legend'=>Mage::helper('addressformat')->__('Item information')));
     
        $fieldset->addField('country_id', 'select', array(
            'name'  => 'country_id',
            'label'     => 'Country',
            'required'  => true,
            'values'    => Mage::getModel('adminhtml/system_config_source_country')->toOptionArray(),
        ));
    
        $fieldset->addField('type', 'select', array(
            'name'  => 'type',
            'label'     => 'Type',
            'required'  => true,
            'values'    => array('text'=>'Text','oneline'=>'One Line','html'=>'HTML','pdf'=>'PDF','js_template'=>'JavaScript Template',),
        ));

        $fieldset->addField('format', 'editor', array(
            'name'      => 'format',
            'label'     => Mage::helper('addressformat')->__('Format'),
            'title'     => Mage::helper('addressformat')->__('Format'),
            'required'  => true,
            
        ));
     
        if (Mage::getSingleton('adminhtml/session')->getAddressformatData())
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getAddressformatData());
            Mage::getSingleton('adminhtml/session')->setAddressformatData(null);
        } elseif ( Mage::registry('addressformat_data') ) {
        
            $form->setValues(Mage::registry('addressformat_data')->getData());
        }
        
        return parent::_prepareForm();
  }
}