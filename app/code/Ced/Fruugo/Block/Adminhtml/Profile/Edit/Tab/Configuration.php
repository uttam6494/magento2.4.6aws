<?php
/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_CsGroup
 * @author 		CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license      http://cedcommerce.com/license-agreement.txt
 */
namespace Ced\Fruugo\Block\Adminhtml\Profile\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\Form as DataForm;

class Configuration extends \Magento\Config\Block\System\Config\Form
{
	 const SCOPE_DEFAULT = 'default';

    const SCOPE_WEBSITES = 'websites';

    const SCOPE_STORES = 'stores';
     
    const SCOPE_VENDOR = 'vendor';
    /**
     * Config data array
     *
     * @var array
     */
    protected $_configData;

    /**
     * Backend config data instance
     *
     * @var \Magento\Config\Model\Config
     */
    protected $_configDataObject;

    /**
     * Default fieldset rendering block
     *
     * @var \Magento\Config\Block\System\Config\Form\Fieldset
     */
    protected $_fieldsetRenderer;

    /**
     * Default field rendering block
     *
     * @var \Magento\Config\Block\System\Config\Form\Field
     */
    protected $_fieldRenderer;

    /**
     * List of fieldset
     *
     * @var array
     */
    protected $_fieldsets = [];

    /**
     * Translated scope labels
     *
     * @var array
     */
    protected $_scopeLabels = [];

    /**
     * Backend Config model factory
     *
     * @var \Magento\Config\Model\Config\Factory
     */
    protected $_configFactory;

    /**
     * Magento\Framework\Data\FormFactory
     *
     * @var \Magento\Framework\Data\FormFactory
     */
    protected $_formFactory;

    /**
     * System config structure
     *
     * @var \Magento\Config\Model\Config\Structure
     */
    protected $_configStructure;

    /**
     *Form fieldset factory
     *
     * @var \Magento\Config\Block\System\Config\Form\Fieldset\Factory
     */
    protected $_fieldsetFactory;

    /**
     * Form field factory
     *
     * @var \Magento\Config\Block\System\Config\Form\Field\Factory
     */
    protected $_fieldFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Config\Model\Config\Factory $configFactory
     * @param \Magento\Config\Model\Config\Structure $configStructure
     * @param \Magento\Config\Block\System\Config\Form\Fieldset\Factory $fieldsetFactory
     * @param \Magento\Config\Block\System\Config\Form\Field\Factory $fieldFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Factory $configFactory,
        \Magento\Config\Model\Config\Structure $configStructure,
        \Magento\Config\Block\System\Config\Form\Fieldset\Factory $fieldsetFactory,
        \Magento\Config\Block\System\Config\Form\Field\Factory $fieldFactory,
        \Magento\Framework\ObjectManagerInterface $objectInterface,
        array $data = []
    ) {
    	
        parent::__construct($context, $registry, $formFactory,$configFactory,$configStructure,$fieldsetFactory,$fieldFactory,$data);
        $this->_configFactory = $configFactory;
        $this->_configStructure = $configStructure;
        $this->_fieldsetFactory = $fieldsetFactory;
        $this->_fieldFactory = $fieldFactory;
        $this->_objectManager = $objectInterface;

        $this->_scopeLabels = [
            self::SCOPE_DEFAULT => __('[GLOBAL]'),
            self::SCOPE_WEBSITES => __('[WEBSITE]'),
            self::SCOPE_STORES => __('[STORE VIEW]'),
        ];
    }

    /**
     * Initialize objects required to render config form
     *
     * @return $this
     */
    protected function _initObjects()
    {
        $this->_configDataObject = $this->_configFactory->create(
            [
                'data' => [
                    'section' => $this->getSectionCode(),
                    'website' => $this->getWebsiteCode(),
                    'store' => $this->getStoreCode(),
                ],
            ]
        );

        $this->_configData = $this->_configDataObject->load();
        $this->_fieldsetRenderer = $this->_fieldsetFactory->create();
        $this->_fieldRenderer = $this->_fieldFactory->create();
        return $this;
    }

    /**
     * Initialize form
     *
     * @return $this
     */
    public function initForm()
    {
        $this->_initObjects();

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        /** @var $section \Magento\Config\Model\Config\Structure\Element\Section */
        $section = $this->_configStructure->getElement($this->getSectionCode());
       
        if ($section && $section->isVisible()) {
            foreach ($section->getChildren() as $group) {
                $this->_initGroup($group, $section, $form);
            }
        }

        $this->setForm($form);
        return $this;
    }

    /**
     * Initialize config field group
     *
     * @param \Magento\Config\Model\Config\Structure\Element\Group $group
     * @param \Magento\Config\Model\Config\Structure\Element\Section $section
     * @param \Magento\Framework\Data\Form\AbstractForm $form
     * @return void
     */
    protected function _initGroup(
        \Magento\Config\Model\Config\Structure\Element\Group $group,
        \Magento\Config\Model\Config\Structure\Element\Section $section,
        \Magento\Framework\Data\Form\AbstractForm $form
    ) {
    	$data = $group->getData();
    	//print_r($data);
    	 if(!isset($data['showInProfile']) || $data['showInProfile']!=1)
    	{
    		return;
    	} 
        $frontendModelClass = $group->getFrontendModel();
        $fieldsetRenderer = $frontendModelClass ? $this->_layout->getBlockSingleton(
            $frontendModelClass
        ) : $this->_fieldsetRenderer;

        $fieldsetRenderer->setForm($this);
        $fieldsetRenderer->setConfigData($this->_configData);
        $fieldsetRenderer->setGroup($group);

        $fieldsetConfig = [
            'legend' => $group->getLabel(),
            'comment' => $group->getComment(),
            'expanded' => $group->isExpanded(),
            'group' => $group->getData(),
        ];
		
        $fieldset = $form->addFieldset($this->_generateElementId($group->getPath()), $fieldsetConfig);
        $fieldset->setRenderer($fieldsetRenderer);
        $group->populateFieldset($fieldset);
        $this->_addElementTypes($fieldset);

        $dependencies = $group->getDependencies($this->getStoreCode());
        $elementName = $this->_generateElementName($group->getPath());
        $elementId = $this->_generateElementId($group->getPath());

        $this->_populateDependenciesBlock($dependencies, $elementId, $elementName);

        if ($group->shouldCloneFields()) {
            $cloneModel = $group->getCloneModel();
            foreach ($cloneModel->getPrefixes() as $prefix) {
                $this->initFields($fieldset, $group, $section, $prefix['field'], $prefix['label']);
            }
        } else {
            $this->initFields($fieldset, $group, $section);
        }

        $this->_fieldsets[$group->getId()] = $fieldset;
    }

    /**
     * Return dependency block object
     *
     * @return \Magento\Backend\Block\Widget\Form\Element\Dependence
     */
    protected function _getDependence()
    {
        if (!$this->getChildBlock('element_dependence')) {
            $this->addChild('element_dependence', 'Magento\Backend\Block\Widget\Form\Element\Dependence');
        }
        return $this->getChildBlock('element_dependence');
    }

    /**
     * Initialize config group fields
     *
     * @param \Magento\Framework\Data\Form\Element\Fieldset $fieldset
     * @param \Magento\Config\Model\Config\Structure\Element\Group $group
     * @param \Magento\Config\Model\Config\Structure\Element\Section $section
     * @param string $fieldPrefix
     * @param string $labelPrefix
     * @return $this
     */
    public function initFields(
        \Magento\Framework\Data\Form\Element\Fieldset $fieldset,
        \Magento\Config\Model\Config\Structure\Element\Group $group,
        \Magento\Config\Model\Config\Structure\Element\Section $section,
        $fieldPrefix = '',
        $labelPrefix = ''
    ) {
    	//print_r($fieldset->getData());die;
        if (!$this->_configDataObject) {
            $this->_initObjects();
        }

        // Extends for config data
        $extraConfigGroups = [];

        /** @var $element \Magento\Config\Model\Config\Structure\Element\Field */
        foreach ($group->getChildren() as $element) {
            if ($element instanceof \Magento\Config\Model\Config\Structure\Element\Group) {
                $this->_initGroup($element, $section, $fieldset);
            } else {
            	
                $path = $element->getConfigPath() ?: $element->getPath($fieldPrefix);
                if ($element->getSectionId() != $section->getId()) {
                    $groupPath = $element->getGroupPath();
                    if (!isset($extraConfigGroups[$groupPath])) {
                        $this->_configData = $this->_configDataObject->extendConfig(
                            $groupPath,
                            false,
                            $this->_configData
                        );
                        $extraConfigGroups[$groupPath] = true;
                    }
                }
                $this->_initElement($element, $fieldset, $path, $fieldPrefix, $labelPrefix);
            }
        }
        return $this;
    }

    /**
     * Initialize form element
     *
     * @param \Magento\Config\Model\Config\Structure\Element\Field $field
     * @param \Magento\Framework\Data\Form\Element\Fieldset $fieldset
     * @param string $path
     * @param string $fieldPrefix
     * @param string $labelPrefix
     * @return void
     */
    protected function _initElement(
        \Magento\Config\Model\Config\Structure\Element\Field $field,
        \Magento\Framework\Data\Form\Element\Fieldset $fieldset,
        $path,
        $fieldPrefix = '',
        $labelPrefix = ''
    ) {
   		 $data = $field->getData();
    	if(!isset($data['showInProfile']) || $data['showInProfile']!=1)
    	{
    		return;
    	}
       // $inherit = true;
    	//$inherit = $this->isInherit($path);
        $data = null;
        if (array_key_exists($path, $this->_configData)) {
            $data = $this->_configData[$path];
            $inherit = false;
        } elseif ($field->getConfigPath() !== null) {
            $data = $this->getConfigValue($field->getConfigPath());
           
        } else {
            $data = $this->getConfigValue($path);
           
        }
        $fieldRendererClass = $field->getFrontendModel();
        if ($fieldRendererClass) {
            $fieldRenderer = $this->_layout->getBlockSingleton($fieldRendererClass);
        } else {
            $fieldRenderer = $this->_fieldRenderer;
        }

        $fieldRenderer->setForm($this);
        $fieldRenderer->setConfigData($this->_configData);

        $elementName = $this->_generateElementName($field->getPath(), $fieldPrefix);
        $elementId = $this->_generateElementId($field->getPath($fieldPrefix));

        if ($field->hasBackendModel()) {
            $backendModel = $field->getBackendModel();
            $backendModel->setPath(
                $path
            )->setValue(
                $data
            )->setWebsite(
                $this->getWebsiteCode()
            )->setStore(
                $this->getStoreCode()
            )->afterLoad();
            $data = $backendModel->getValue();
        }

        $dependencies = $field->getDependencies($fieldPrefix, $this->getStoreCode());
        $this->_populateDependenciesBlock($dependencies, $elementId, $elementName);

        $sharedClass = $this->_getSharedCssClass($field);
        $requiresClass = $this->_getRequiresCssClass($field, $fieldPrefix);

        $formField = $fieldset->addField(
            $elementId,
            $field->getType(),
            [
                'name' => $elementName,
                'label' => $field->getLabel($labelPrefix),
                'comment' => $field->getComment($data),
                'tooltip' => $field->getTooltip(),
                'hint' => $field->getHint(),
                'value' => $data,
                'inherit' => $this->isInherit($path),
                'class' => $field->getFrontendClass() . $sharedClass . $requiresClass,
                'field_config' => $field->getData(),
                'scope' => $this->getScope(),
                'scope_id' => $this->getScopeId(),
                'scope_label' => $this->getScopeLabel($field),
                'can_use_default_value' =>true,//$this->canUseDefaultValues($field->showInDefault(),$path), //$this->canUseDefaultValue($field->showInDefault()),//true,//$this->canUseDefaultValues($field->showInDefault(),$path),
                'can_use_website_value' => false//$this->canUseWebsiteValue($field->showInWebsite())
            ]
        );
        $field->populateInput($formField);

        if ($field->hasValidation()) {
            $formField->addClass($field->getValidation());
        }
        if ($field->getType() == 'multiselect') {
            $formField->setCanBeEmpty($field->canBeEmpty());
        }
        if ($field->hasOptions()) {
            $formField->setValues($field->getOptions());
        }
        $formField->setRenderer($fieldRenderer);
    }

    /**
     * Populate dependencies block
     *
     * @param array $dependencies
     * @param string $elementId
     * @param string $elementName
     * @return void
     */
    protected function _populateDependenciesBlock(array $dependencies, $elementId, $elementName)
    {
        foreach ($dependencies as $dependentField) {
            /** @var $dependentField \Magento\Config\Model\Config\Structure\Element\Dependency\Field */
            $fieldNameFrom = $this->_generateElementName($dependentField->getId(), null, '_');
            $this->_getDependence()->addFieldMap(
                $elementId,
                $elementName
            )->addFieldMap(
                $this->_generateElementId($dependentField->getId()),
                $fieldNameFrom
            )->addFieldDependence(
                $elementName,
                $fieldNameFrom,
                $dependentField
            );
        }
    }

    /**
     * Generate element name
     *
     * @param string $elementPath
     * @param string $fieldPrefix
     * @param string $separator
     * @return string
     */
    protected function _generateElementName($elementPath, $fieldPrefix = '', $separator = '/')
    {
        $part = explode($separator, $elementPath);
        array_shift($part);
        //shift section name
        $fieldId = array_pop($part);
        //shift filed id
        $groupName = implode('][groups][', $part);
        $name = 'groups[' . $groupName . '][fields][' . $fieldPrefix . $fieldId . '][value]';
        return $name;
    }

    /**
     * Generate element id
     *
     * @param string $path
     * @return string
     */
    protected function _generateElementId($path)
    {
        return str_replace('/', '_', $path);
    }

    /**
     * Get config value
     *
     * @param string $path
     * @return mixed
     */
    public function getConfigValue($path)
    {
    	$pcode =$this->getRequest()->getParam('pcode');
    	
    	if($pcode) {
            if(strlen($pcode)>0)
            {
                /* print_r($this->_scopeConfig->getValue($gcode.'/'.$path, $this->getScope(), $this->getScopeCode()));
                die; */
                return $this->_scopeConfig->getValue($pcode.'/'.$path, $this->getScope(), $this->getScopeCode());
            }
            else 
            {
                /* print_r($this->_scopeConfig->getValue($path, $this->getScope(), $this->getScopeCode()));
                die('zzzz'); */
                return $this->_scopeConfig->getValue($path, $this->getScope(), $this->getScopeCode());
                //die;
            }
        }
    	//die;
    }

    /**
     * @return \Magento\Backend\Block\Widget\Form|\Magento\Framework\View\Element\AbstractBlock
     */
    protected function _beforeToHtml()
    {
        $this->initForm();
        return parent::_beforeToHtml();
    }

    /**
     * Append dependence block at then end of form block
     *
     * @param string $html
     * @return string
     */
    protected function _afterToHtml($html)
    {
        if ($this->_getDependence()) {
            $html .= $this->_getDependence()->toHtml();
        }
        $html = parent::_afterToHtml($html);
        return $html;
    }

    /**
     * Check if can use default value
     *
     * @param int $fieldValue
     * @return boolean
     */
    
    public function canUseDefaultValues($fieldValue,$path)
    {
        $pcode =$this->getRequest()->getParam('pcode');
    	
    	if(strlen($pcode)>0)
    	{
    		
    	//print_r($path);
    	$data= $this->_scopeConfig->getValue($pcode.'/'.$path, $this->getScope(), $this->getScopeCode());
       /*  if ($this->getScope() == self::SCOPE_STORES && $fieldValue) {
            return true;
        }
        if ($this->getScope() == self::SCOPE_WEBSITES && $fieldValue) {
            return true;
        } */
    	
    	if($data!='')
    	{
    		return false;
    	}
    	else 
    	{
    		return true; 
    	}
    }
   else {
   	       
           return true;
    }
        
    }
    
    public function isInherit($path)
    {
        $pcode =$this->getRequest()->getParam('pcode');
    	 
    	if($pcode) { 
            if(strlen($pcode)>0)
            {
                $data= $this->_scopeConfig->getValue($pcode.'/'.$path, $this->getScope(), $this->getScopeCode());
                if($data!='')
                {
                    return false;
                }
                else
                {
                    return true;
                }
            }
        }
    	return true;
    
    }
    

    /**
     * Check if can use website value
     *
     * @param int $fieldValue
     * @return boolean
     */
    public function canUseWebsiteValue($fieldValue)
    {
        if ($this->getScope() == self::SCOPE_STORES && $fieldValue) {
            return true;
        }
        return false;
    }

    /**
     * Retrieve current scope
     *
     * @return string
     */
    public function getScope()
    {
        $scope = $this->getData('scope');
        if ($scope === null) {
            if ($this->getStoreCode()) {
                $scope = self::SCOPE_STORES;
            } elseif ($this->getWebsiteCode()) {
                $scope = self::SCOPE_WEBSITES;
            } else {
                $scope = self::SCOPE_DEFAULT;
            }
            $this->setScope($scope);
        }

        return $scope;
    }

    /**
     * Retrieve label for scope
     *
     * @param \Magento\Config\Model\Config\Structure\Element\Field $field
     * @return string
     */
    public function getScopeLabel(\Magento\Config\Model\Config\Structure\Element\Field $field)
    {
        $showInStore = $field->showInStore();
        $showInWebsite = $field->showInWebsite();

        if ($showInStore == 1) {
            return $this->_scopeLabels[self::SCOPE_STORES];
        } elseif ($showInWebsite == 1) {
            return $this->_scopeLabels[self::SCOPE_WEBSITES];
        }
        return $this->_scopeLabels[self::SCOPE_DEFAULT];
    }

    /**
     * Get current scope code
     *
     * @return string
     */
    public function getScopeCode()
    {
        $scopeCode = $this->getData('scope_code');
        if ($scopeCode === null) {
            if ($this->getStoreCode()) {
                $scopeCode = $this->getStoreCode();
            } elseif ($this->getWebsiteCode()) {
                $scopeCode = $this->getWebsiteCode();
            } else {
                $scopeCode = '';
            }
            $this->setScopeCode($scopeCode);
        }

        return $scopeCode;
    }

    /**
     * Get current scope code
     *
     * @return int|string
     */
    public function getScopeId()
    {
        $scopeId = $this->getData('scope_id');
        if ($scopeId === null) {
            if ($this->getStoreCode()) {
                $scopeId = $this->_storeManager->getStore($this->getStoreCode())->getId();
            } elseif ($this->getWebsiteCode()) {
                $scopeId = $this->_storeManager->getWebsite($this->getWebsiteCode())->getId();
            } else {
                $scopeId = '';
            }
            $this->setScopeId($scopeId);
        }
        return $scopeId;
    }

    /**
     * Get additional element types
     *
     * @return array
     */
    protected function _getAdditionalElementTypes()
    {
        return [
            'allowspecific' => 'Magento\Config\Block\System\Config\Form\Field\Select\Allowspecific',
            'image' => 'Magento\Config\Block\System\Config\Form\Field\Image',
            'file' => 'Magento\Config\Block\System\Config\Form\Field\File'
        ];
    }

    /**
     * Temporary moved those $this->getRequest()->getParam('blabla') from the code accross this block
     * to getBlala() methods to be later set from controller with setters
     */
    /**
     * Enter description here...
     *
     * @TODO delete this methods when {^see above^} is done
     * @return string
     */
    public function getSectionCode()
    {
        return 'fruugoconfiguration';
    }

    /**
     * Enter description here...
     *
     * @TODO delete this methods when {^see above^} is done
     * @return string
     */
    public function getWebsiteCode()
    {
        return $this->getRequest()->getParam('website', '');
    }

    /**
     * Enter description here...
     *
     * @TODO delete this methods when {^see above^} is done
     * @return string
     */
    public function getStoreCode()
    {
        return $this->getRequest()->getParam('store', '');
    }
    
    
    /**
     * Get css class for "shared" functionality
     *
     * @param \Magento\Config\Model\Config\Structure\Element\Field $field
     * @return string
     */
    protected function _getSharedCssClass(\Magento\Config\Model\Config\Structure\Element\Field $field)
    {
        $sharedClass = '';
        if ($field->getAttribute('shared') && $field->getConfigPath()) {
            $sharedClass = ' shared shared-' . str_replace('/', '-', $field->getConfigPath());
            return $sharedClass;
        }
        return $sharedClass;
    }

    /**
     * Get css class for "requires" functionality
     *
     * @param \Magento\Config\Model\Config\Structure\Element\Field $field
     * @param string $fieldPrefix
     * @return string
     */
    protected function _getRequiresCssClass(\Magento\Config\Model\Config\Structure\Element\Field $field, $fieldPrefix)
    {
        $requiresClass = '';
        $requiredPaths = array_merge($field->getRequiredFields($fieldPrefix), $field->getRequiredGroups($fieldPrefix));
        if (!empty($requiredPaths)) {
            $requiresClass = ' requires';
            foreach ($requiredPaths as $requiredPath) {
                $requiresClass .= ' requires-' . $this->_generateElementId($requiredPath);
            }
            return $requiresClass;
        }
        return $requiresClass;
    }
    public function isVisible()
    {
    	if (isset($this->_data['if_module_enabled']) &&
    			!$this->moduleManager->isOutputEnabled($this->_data['if_module_enabled'])) {
    				return false;
    			}
    			$showInScope = [
    			\Magento\Store\Model\ScopeInterface::SCOPE_STORE => $this->_hasVisibilityValue('showInStore'),
    			\Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE => $this->_hasVisibilityValue('showInWebsite'),
    			\Magento\Store\Model\ScopeInterface::SCOPE_VENDOR => $this->_hasVisibilityValue('showInVendor'),
    			
    			];
    
    			if ($this->_storeManager->isSingleStoreMode()) {
    				$result = !$this->_hasVisibilityValue('hide_in_single_store_mode') && array_sum($showInScope);
    				return $result;
    			}
    
    			return !empty($showInScope[$this->_scope]);
    }

    public function canUseDefaultValue($fieldValue)
    {
    	if ($this->getScope() == self::SCOPE_STORES && $fieldValue) {
    		return true;
    	}
    	if ($this->getScope() == self::SCOPE_WEBSITES && $fieldValue) {
    		return true;
    	}
    	if ($this->getScope() == self::SCOPE_DEFAULT && $fieldValue) {
    		return true;
    	}
    	return false;
    }
	
    /* protected function _toHtml() {
    	if($this->getRequest()->isAjax()) {
    		return parent::_toHtml();
    	}
    	$switcher = $this->getLayout()->createBlock('Magento\Backend\Block\Template')->setStoreSelectOptions($this->getStoreSelectOptions())->setTemplate('csgroup/system/config/switcher.phtml')->toHtml();
    	$switcher .= '<style>.switcher p{ display: none; }</style>';
    	$parent = '<div id="vendor_group_configurations_section">'.parent::_toHtml().'</div>';
    	if(strlen($parent) <= 50) {
    		$parent .= '<div id="messages"><ul class="messages"><li class="error-msg"><ul><li><span>'.__('No Configurations are Available for Current Configuration Scope. Please Up the Configuration Scope by One Level.').'</span></li></ul></li></ul></div>';
    		return $parent;
    	}
    	return $parent;
    } */
    protected function _prepareForm(){

        $form = $this->_formFactory->create();
        //$form = $this->getForm();

        //print_r($form);die;
        //$form = new Varien_Data_Form();
        //die;

        $profile = $this->_coreRegistry->registry('current_profile');
        $pCode = $profile['profile_code'];
        $use_price = (int) $this->_scopeConfig->getValue("fruugoconfiguration/$pCode/use_vat_price");
        
        $fieldset = $form->addFieldset('profile_import_setting', array('legend'=>__('Product Import Setting')));

        $fieldset->addField('profile_use_price', 'select',
            array(
                'name'      => "profile_use_price",
                'label'     => __('Send Price With Vat'),
                'note'  	=> __('If Yes, then NormalPriceWithVat & DiscountPriceWithVat goes with product otherwise NormalPriceWithourVat & DiscountPRiceWithoutVat use.'),
                'required'  => true,
                'value'     => $use_price,
                'values'    => $this->_objectManager->get('Magento\Config\Model\Config\Source\Yesno')->toOptionArray(),
            )
        );
        $fieldset = $form->addFieldset('profile_inventory_setting', array('legend'=>__('Inventory Setting')));
        $selectField= $fieldset->addField('inventory_setting', 'select',
            array(
                'name'      => "inventory_setting",
                'label'     => __('Set Inventory on Base Of Threshold'),
                'note'  	=> __('Select yes if You want to controle your inventory on fruugo'),
                'required'  => true,
                'values'    => $this->_objectManager->get('Magento\Config\Model\Config\Source\Yesno')->toOptionArray(),
                'value'     => $profile->getData('inventory_setting'),
                'onchange' => 'depandent()'
            )
        );
     /*   $selectField->setAfterElementHtml('<div id="val" >');*/


        $fieldset->addField('inventory_threshold_value', 'text',
            array(
                'name'      => "inventory_threshold_value",
                'label'     => __('Inventory Threshold Value'),
                'note'  	=> __('Set Inventory quantity on which Threshold are dependent '),
                'value'     => $profile->getData('inventory_threshold_value'),
               // 'values'    => $this->_objectManager->get('Magento\Config\Model\Config\Source\Yesno')->toOptionArray(),
            )
        );
        $thr=$fieldset->addField('fixed_threshold_value', 'text',
            array(
                'name'      => "fixed_threshold_value",
                'label'     => __('Send  Inventory When Inventory Is Less Then Threshold Value'),
                'note'  	=> __('Send the inventory value when inventory is less then threshold value'),
                'value'     => $profile->getData('fixed_threshold_value'),
                //'values'    => $this->_objectManager->get('Magento\Config\Model\Config\Source\Yesno')->toOptionArray(),
            )
        );
        $selectField->setAfterElementHtml('

            <script>
            function depandent() {                                              
               var e = document.getElementById("inventory_setting");
                var strUser = e.options[e.selectedIndex].value;
             if(strUser==0){
               document.getElementsByClassName("admin__field field field-inventory_threshold_value")[0].style.display = "none";

                document.getElementsByClassName("admin__field field field-fixed_threshold_value")[0].style.display = "none";
                }else{
                document.getElementsByClassName("admin__field field field-inventory_threshold_value")[0].style.display = "block";

                document.getElementsByClassName("admin__field field field-fixed_threshold_value")[0].style.display = "block";
                }
            }
            </script>
        ');
        $thr->setAfterElementHtml('
            <script>
            
          document.getElementsByClassName("admin__field field field-inventory_threshold_value")[0].style.display = "none";
;
         document.getElementsByClassName("admin__field field field-fixed_threshold_value")[0].style.display = "none";
          

            var e = document.getElementById("inventory_setting");
             var strUser = e.options[e.selectedIndex].value;
            if(strUser==0){
               document.getElementsByClassName("admin__field field field-inventory_threshold_value")[0].style.display = "none";

                document.getElementsByClassName("admin__field field field-fixed_threshold_value")[0].style.display = "none";
                }else{
                document.getElementsByClassName("admin__field field field-inventory_threshold_value")[0].style.display = "block";

                document.getElementsByClassName("admin__field field field-fixed_threshold_value")[0].style.display = "block";
                }
            </script>
        ');
        /*$fieldset->addField('profile_name', 'text',
            array(
                'name'      => "profile_name",
                'label'     => __('Profile Name'),
                'class'     => '',
                'required'  => true,
                'value'    =>$profile->getData('profile_name'),
            )
        );*/

        /*$fieldset->addField('store_id', 'select',
            array(
                'name'      => "store_id",
                'label'     => __('Store View'),
                'class'     => '',
                'required'  => true,
                'value' => $profile->getData('store_id'),
                'values' => $this->_store->getStoreValuesForForm(false, true),
                'note'  	=> __('Specific store view information of products will send to fruugo'),
            )
        );*/

        /*$fieldset->addField('profile_status', 'select',
            array(
                'name'      => "profile_status",
                'label'     => __('Profile Status'),
                'class'     => '',
                'required'  => true,
                'value' => $profile->getData('profile_status'),
                'values' => $this->_objectManager->get('Ced\Fruugo\Model\Source\Profile\Status')->getOptionArray(),
                'note'  	=> __('Specific store view information of products will send to fruugo'),
            )
        );


        $fieldset->addField('in_profile_product', 'hidden',
            array(
                'name'  => 'in_profile_product',
                'id'    => 'in_profile_product',
            )
        );


        $fieldset->addField('in_profile_product_old', 'hidden', array('name' => 'in_profile_product_old','id'=>"in_profile_product_old"));

        if ($profile->getId()) {
            $form->getElement('profile_code')->setDisabled(1);
        }*/
        //print_r($data->getData('in_group_vendor_old'));die;
        //$form->setValues($data->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
