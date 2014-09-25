<?php

class Ct_Addressformat_Block_Default extends Mage_Customer_Block_Address_Renderer_Default
{
    public function getFormat(Mage_Customer_Model_Address_Abstract $address=null)
    {
        $countryFormat = is_null($address) ? parent::getFormat($address) : $address->getCountryModel()->getFormat($this->getType()->getCode());
        if (is_object($countryFormat)) {
            $cFormat = $countryFormat->getFormat();
        }
        
        $format = $countryFormat ? (!empty($cFormat)?$cFormat:$this->getType()->getDefaultFormat()) : $this->getType()->getDefaultFormat();
        return $format;
    }
}