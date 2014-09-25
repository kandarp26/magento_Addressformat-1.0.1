<?php

class Ct_Addressformat_Adminhtml_AddressformatController extends Mage_Adminhtml_Controller_action
{
    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('addressformat/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')
            ->__('Country Wise Address Format'), Mage::helper('adminhtml')->__('Country Wise Address Format'));
        
        return $this;
    }   
 
    public function indexAction() {
        $this->_initAction()
            ->renderLayout();
    }

    public function editAction() {
        
        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('addressformat/addressformat')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            else
            {
                $addressFormate = Mage::getStoreConfig('customer/address_templates/text');
                $model->setFormat($addressFormate);
            }

            Mage::register('addressformat_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('addressformat/items');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Country Wise Address Format'), Mage::helper('adminhtml')->__('Country Wise Address Format'));
            //$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('addressformat/adminhtml_addressformat_edit'))
                ->_addLeft($this->getLayout()->createBlock('addressformat/adminhtml_addressformat_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('addressformat')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }
 
    public function newAction() {
        $this->_forward('edit');
    }
 
    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {

            $model = Mage::getModel('addressformat/addressformat');
            if ($this->getRequest()->getParam('id')) {
                
                $formatedata = Mage::getModel('addressformat/addressformat')->load($this->getRequest()->getParam('id'));
                
                if($formatedata->getcountryId() !=  $data['country_id'] || $formatedata->getType() != $data['type'])
                {
                    $formate = Mage::getModel('addressformat/addressformat')->getCollection()
                        ->addFieldToFilter('country_id',$data['country_id'])
                        ->addFieldToFilter('type',$data['type']);
                    $formatedata = $formate->getData();
                    if(!empty($formatedata))
                    {
                        Mage::getSingleton('adminhtml/session')->addError("Formate for This country already exist.");
                        $this->_redirect('*/*/');
                        return;
                    }
                    
                }
                $model->setData($data)->setId($this->getRequest()->getParam('id'));
            } else {
                $formate = Mage::getModel('addressformat/addressformat')->getCollection()
                       ->addFieldToFilter('country_id',$data['country_id'])
                       ->addFieldToFilter('type',$data['type']);
                $formatedata = $formate->getData();
                if(!empty($formatedata))
                {
                    Mage::getSingleton('adminhtml/session')->addError("Formate for This country already exist.");
                    $this->_redirect('*/*/');
                    return;
                }else {
                    $model->setData($data);
                }
                
            }
            
            try {
                    
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('addressformat')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('addressformat')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }
 
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('addressformat/addressformat');
                 
                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();
                     
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction() {
        $addressformatIds = $this->getRequest()->getParam('addressformat');
        if(!is_array($addressformatIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($addressformatIds as $addressformatId) {
                    $addressformat = Mage::getModel('addressformat/addressformat')->load($addressformatId);
                    $addressformat->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($addressformatIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    public function massStatusAction()
    {
        $addressformatIds = $this->getRequest()->getParam('addressformat');
        if(!is_array($addressformatIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($addressformatIds as $addressformatId) {
                    $addressformat = Mage::getSingleton('addressformat/addressformat')
                        ->load($addressformatId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($addressformatIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }


}