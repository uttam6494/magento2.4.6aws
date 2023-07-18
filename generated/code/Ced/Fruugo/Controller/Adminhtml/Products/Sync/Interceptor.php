<?php
namespace Ced\Fruugo\Controller\Adminhtml\Products\Sync;

/**
 * Interceptor class for @see \Ced\Fruugo\Controller\Adminhtml\Products\Sync
 */
class Interceptor extends \Ced\Fruugo\Controller\Adminhtml\Products\Sync implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Psr\Log\LoggerInterface $logger, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Ced\Fruugo\Model\FeedsFactory $feedsFactory, \Ced\Fruugo\Helper\Data $helper, \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory)
    {
        $this->___init();
        parent::__construct($context, $logger, $resultPageFactory, $feedsFactory, $helper, $redirectFactory);
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
