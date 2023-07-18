<?php
namespace Ced\Fruugo\Controller\Adminhtml\Profile\Save;

/**
 * Interceptor class for @see \Ced\Fruugo\Controller\Adminhtml\Profile\Save
 */
class Interceptor extends \Ced\Fruugo\Controller\Adminhtml\Profile\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Config\Model\Config\Structure\Element\Group $group, \Magento\Config\Model\Config\Structure $configStructure, \Magento\Config\Model\Config\Factory $configFactory, \Ced\Fruugo\Helper\Cache $cache, \Magento\Config\Model\ResourceModel\Config $configResource, \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList, \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $group, $configStructure, $configFactory, $cache, $configResource, $cacheTypeList, $cacheFrontendPool, $resultPageFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        return $pluginInfo ? $this->___callPlugins('execute', func_get_args(), $pluginInfo) : parent::execute();
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        return $pluginInfo ? $this->___callPlugins('dispatch', func_get_args(), $pluginInfo) : parent::dispatch($request);
    }
}
