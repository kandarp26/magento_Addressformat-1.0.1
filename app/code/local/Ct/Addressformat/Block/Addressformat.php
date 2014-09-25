<?php
class Ct_Addressformat_Block_Addressformat extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getAddressformat()
     { 
        if (!$this->hasData('addressformat')) {
            $this->setData('addressformat', Mage::registry('addressformat'));
        }
        
        return $this->getData('addressformat');
        
    }
}