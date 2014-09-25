<?php 
class Ct_Addressformat_Block_Widget_Renderer_Country extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
        $country_code = $row->getData($this->getColumn()->getIndex());
        return Mage::app()->getLocale()->getCountryTranslation($country_code);
    }
}