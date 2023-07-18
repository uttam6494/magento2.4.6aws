<?php
namespace Ced\Fruugo\Controller\Adminhtml\Export\Csvexport;

/**
 * Interceptor class for @see \Ced\Fruugo\Controller\Adminhtml\Export\Csvexport
 */
class Interceptor extends \Ced\Fruugo\Controller\Adminhtml\Export\Csvexport implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Magento\Framework\Filesystem $filesystem, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Ced\Fruugo\Model\Profileproducts $locationFactory, \Magento\Framework\Filesystem\Driver\File $fileDriver, \Magento\Framework\File\Csv $csvParser)
    {
        $this->___init();
        parent::__construct($context, $fileFactory, $filesystem, $date, $locationFactory, $fileDriver, $csvParser);
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
