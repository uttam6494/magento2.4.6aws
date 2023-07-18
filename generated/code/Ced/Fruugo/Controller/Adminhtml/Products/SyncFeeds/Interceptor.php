<?php
namespace Ced\Fruugo\Controller\Adminhtml\Products\SyncFeeds;

/**
 * Interceptor class for @see \Ced\Fruugo\Controller\Adminhtml\Products\SyncFeeds
 */
class Interceptor extends \Ced\Fruugo\Controller\Adminhtml\Products\SyncFeeds implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Ced\Fruugo\Model\FeedsFactory $feedsFactory, \Psr\Log\LoggerInterface $logger, \Ced\Fruugo\Helper\Data $helper, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->___init();
        parent::__construct($context, $feedsFactory, $logger, $helper, $resultPageFactory);
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
