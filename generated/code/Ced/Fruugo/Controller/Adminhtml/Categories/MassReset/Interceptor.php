<?php
namespace Ced\Fruugo\Controller\Adminhtml\Categories\MassReset;

/**
 * Interceptor class for @see \Ced\Fruugo\Controller\Adminhtml\Categories\MassReset
 */
class Interceptor extends \Ced\Fruugo\Controller\Adminhtml\Categories\MassReset implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Ced\Fruugo\Model\ResourceModel\Categories\CollectionFactory $collectionFactory, \Ced\Fruugo\Controller\Adminhtml\Categories\FilterCustom $filter)
    {
        $this->___init();
        parent::__construct($context, $collectionFactory, $filter);
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
