<?php

class Ct_Addressformat_Block_Adminhtml_Addressformat_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('addressformat_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('addressformat')->__('Format Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('addressformat')->__('Format Information'),
          'title'     => Mage::helper('addressformat')->__('Format Information'),
          'content'   => $this->getLayout()->createBlock('addressformat/adminhtml_addressformat_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}