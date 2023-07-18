<?php
namespace Ced\Fruugo\Controller\Adminhtml\Order\FailedOrders;

/**
 * Interceptor class for @see \Ced\Fruugo\Controller\Adminhtml\Order\FailedOrders
 */
class Interceptor extends \Ced\Fruugo\Controller\Adminhtml\Order\FailedOrders implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Ced\Fruugo\Helper\Order $helper)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $helper);
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
