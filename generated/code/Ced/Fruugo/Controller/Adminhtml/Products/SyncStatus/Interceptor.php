<?php
namespace Ced\Fruugo\Controller\Adminhtml\Products\SyncStatus;

/**
 * Interceptor class for @see \Ced\Fruugo\Controller\Adminhtml\Products\SyncStatus
 */
class Interceptor extends \Ced\Fruugo\Controller\Adminhtml\Products\SyncStatus implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Psr\Log\LoggerInterface $logger, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Catalog\Model\ProductFactory $productFactory, \Ced\Fruugo\Helper\Data $helper, \Magento\Framework\Filesystem\DirectoryList $directoryList, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Framework\Registry $registry, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory)
    {
        $this->___init();
        parent::__construct($context, $logger, $resultPageFactory, $productFactory, $helper, $directoryList, $filter, $registry, $resultJsonFactory);
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
