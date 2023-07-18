<?php
namespace Ced\Fruugo\Block\Adminhtml\Attributes\Map\Mapattribute\Form;

/**
 * Interceptor class for @see \Ced\Fruugo\Block\Adminhtml\Attributes\Map\Mapattribute\Form
 */
class Interceptor extends \Ced\Fruugo\Block\Adminhtml\Attributes\Map\Mapattribute\Form implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Data\FormFactory $formFactory, \Magento\Framework\ObjectManagerInterface $objetManager, $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $formFactory, $objetManager, $data);
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
