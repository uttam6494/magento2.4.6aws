<?php
namespace Ced\Fruugo\Block\Adminhtml\Profile\Edit\Tab\Info;

/**
 * Interceptor class for @see \Ced\Fruugo\Block\Adminhtml\Profile\Edit\Tab\Info
 */
class Interceptor extends \Ced\Fruugo\Block\Adminhtml\Profile\Edit\Tab\Info implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Widget\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Data\FormFactory $formFactory, \Magento\Store\Model\System\Store $store, \Magento\Framework\ObjectManagerInterface $objectInterface, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $registry, $formFactory, $store, $objectInterface, $data);
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
