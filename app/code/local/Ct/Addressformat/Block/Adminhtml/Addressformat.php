<?php
class Ct_Addressformat_Block_Adminhtml_Addressformat extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_addressformat';
    $this->_blockGroup = 'addressformat';
    $this->_headerText = Mage::helper('addressformat')->__('Address Manager');
    $this->_addButtonLabel = Mage::helper('addressformat')->__('Add New Country');
    parent::__construct();
  }
}