<?php
namespace Ced\Fruugo\Controller\Adminhtml\Products\MassUpload;

/**
 * Interceptor class for @see \Ced\Fruugo\Controller\Adminhtml\Products\MassUpload
 */
class Interceptor extends \Ced\Fruugo\Controller\Adminhtml\Products\MassUpload implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Framework\Registry $registry, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Ced\Fruugo\Helper\Data $data, \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $filter, $registry, $resultJsonFactory, $data, $redirectFactory);
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
