<?php
namespace Ced\Fruugo\Block\Adminhtml\Profile\Edit\Tab\Configuration;

/**
 * Interceptor class for @see \Ced\Fruugo\Block\Adminhtml\Profile\Edit\Tab\Configuration
 */
class Interceptor extends \Ced\Fruugo\Block\Adminhtml\Profile\Edit\Tab\Configuration implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Data\FormFactory $formFactory, \Magento\Config\Model\Config\Factory $configFactory, \Magento\Config\Model\Config\Structure $configStructure, \Magento\Config\Block\System\Config\Form\Fieldset\Factory $fieldsetFactory, \Magento\Config\Block\System\Config\Form\Field\Factory $fieldFactory, \Magento\Framework\ObjectManagerInterface $objectInterface, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $formFactory, $configFactory, $configStructure, $fieldsetFactory, $fieldFactory, $objectInterface, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getForm');
        return $pluginInfo ? $this->___callPlugins('getForm', func_get_args(), $pluginInfo) : parent::getForm();
    }
}
