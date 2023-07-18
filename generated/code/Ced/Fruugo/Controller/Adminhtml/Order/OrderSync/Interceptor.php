<?php
namespace Ced\Fruugo\Controller\Adminhtml\Order\OrderSync;

/**
 * Interceptor class for @see \Ced\Fruugo\Controller\Adminhtml\Order\OrderSync
 */
class Interceptor extends \Ced\Fruugo\Controller\Adminhtml\Order\OrderSync implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Ced\Fruugo\Helper\Order $helper, \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $helper, $redirectFactory);
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
