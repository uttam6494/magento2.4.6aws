<?php
namespace Ced\Fruugo\Controller\Adminhtml\Order\MassDelete;

/**
 * Interceptor class for @see \Ced\Fruugo\Controller\Adminhtml\Order\MassDelete
 */
class Interceptor extends \Ced\Fruugo\Controller\Adminhtml\Order\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Sales\Api\OrderManagementInterface $orderManagement, \Magento\Sales\Api\Data\OrderInterface $order)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $filter, $orderManagement, $order);
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
