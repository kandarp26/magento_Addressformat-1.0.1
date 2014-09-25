<?php

class Ct_Addressformat_Block_Adminhtml_Addressformat_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('addressformatGrid');
      $this->setDefaultSort('addressformat_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  /*
   * 
   * country_format_id  int(10) unsigned  (NULL)           NO      PRI     (NULL)   auto_increment  select,insert,update,references         
country_id         varchar(2)        utf8_general_ci  NO      MUL                              select,insert,update,references         
type               varchar(30)       utf8_general_ci  NO                                       select,insert,update,references         
format 
   * */
  protected function _prepareCollection()
  {
      $collection = Mage::getModel('addressformat/addressformat')->getCollection();

      
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('country_format_id', array(
          'header'    => Mage::helper('addressformat')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'country_format_id',
      ));

      $this->addColumn('country_id', array(
          'header'    => Mage::helper('addressformat')->__('Country'),
          'type' => 'int',
          'align'     => 'left',
          'index'     => 'country_id',
          'renderer'  => 'Ct_Addressformat_Block_Widget_Renderer_Country',
      ));

      $this->addColumn('type', array(
          'header'    => Mage::helper('addressformat')->__('Type'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'type',
          'type'      => 'options',
          'options'   => array(
                'text' => 'Text',
                'html' => 'HTML',
                'oneline' => 'One Line',
                'pdf' => 'PDF',
                'js_template' => 'JavaScript Template',
          ),
      ));
	  
      /*$this->addColumn('format', array(
            'header'    => Mage::helper('addressformat')->__('format'),
            'width'     => '150px',
            'index'     => 'format',
      ));*/
      
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('addressformat')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('addressformat')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('addressformat_id');
        $this->getMassactionBlock()->setFormFieldName('addressformat');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('addressformat')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('addressformat')->__('Are you sure?')
        ));

        /*$statuses = Mage::getSingleton('addressformat/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('addressformat')->__('Change status'),
             'url'  => $this->getUrl('* /* /massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('addressformat')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));*/
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}