<?php
namespace Ced\Fruugo\Controller\Index\Index;

/**
 * Interceptor class for @see \Ced\Fruugo\Controller\Index\Index
 */
class Interceptor extends \Ced\Fruugo\Controller\Index\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Ced\Fruugo\Helper\Data $data, \Ced\Fruugo\Helper\Order $orderHelper, \Magento\Framework\Json\Helper\Data $json)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $data, $orderHelper, $json);
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
