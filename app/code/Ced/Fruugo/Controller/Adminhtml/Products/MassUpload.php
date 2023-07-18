<?php

/**
 * CedCommerce
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the End User License Agreement (EULA)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://cedcommerce.com/license-agreement.txt
 *
 * @category    Ced
 * @package     Ced_Fruugo
 * @author      CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CEDCOMMERCE (http://cedcommerce.com/)
 * @license     http://cedcommerce.com/license-agreement.txt
 */

namespace Ced\Fruugo\Controller\Adminhtml\Products;

class MassUpload extends \Magento\Backend\App\Action
{
    const CHUNK_SIZE = 100;

    /**
     * PageFactory
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public $resultPageFactory;

    /**
     * Filter
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    public $filter;

    /**
     * Session
     * @var \Magento\Backend\Model\Session
     */
    public $session;

    /**
     * Json Factory
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    public $resultJsonFactory;

    public $dataHelper;

    public $registry;

    /**
     * MassUpload constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Ced\Fruugo\Helper\Data $data
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Ced\Fruugo\Helper\Data $data,
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->filter = $filter;
        $this->session =  $context->getSession();
        $this->resultJsonFactory = $resultJsonFactory;
        $this->dataHelper = $data;
        $this->registry = $registry;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * Product sync
     */
    public function execute()
    {

        if(!$this->dataHelper->checkForConfiguration()) {
            $this->messageManager->addErrorMessage(__('Products Upload Failed. Fruugo API not enabled or Invalid. Please check Fruugo Configuration.'));
            $redirect = $this->redirectFactory->create();
            return $redirect->setPath(\Ced\Fruugo\Controller\Adminhtml\Products\Index::REDIRECT_PATH);
        }
        $batchid = $this->getRequest()->getParam('batchid');
        if (isset($batchid) ) {
            /*if($batchid >=5) {*/
                $this->session->setAllBatchCompleted(false);
                if(empty($this->session->getResponseSession()))
                    $this->session->setResponseSession([]);
                $resultJson = $this->resultJsonFactory->create();
                $productids = $this->session->getFruugoProducts();
                if(!isset($productids[$batchid+1]) || count($productids[$batchid+1]) < 1) {
                    $this->session->setAllBatchCompleted(true);
                    //$prod = $this->session->getResponseSession();
                    //echo "<pre>";print_r($prod);die('d');
                }
                if (isset($productids[$batchid]) && $this->dataHelper->createProductOnFruugo($productids[$batchid])) {
                    return $resultJson->setData([
                        'success' => count($productids[$batchid]) . " Product(s) XML Created successfully",
                    ]);
                }
            /*}
            return $resultJson->setData([
                'error' => count($productids[$batchid]) . " Product(s) Upload Failed",
            ]);*/
        }

        $this->dataHelper = $this->_objectManager->get('Ced\Fruugo\Helper\Data');
        $collection = $this->filter->getCollection($this->_objectManager->create('Magento\Catalog\Model\Product')
            ->getCollection());
        $productids = $collection->getAllIds();

        if (count($productids) == 0) {
            $this->messageManager->addErrorMessage('No Product selected to upload.');
            $redirect = $this->redirectFactory->create();
            return $redirect->setPath(\Ced\Fruugo\Controller\Adminhtml\Products\Index::REDIRECT_PATH);
        }

        if (count($productids) < self::CHUNK_SIZE - 1) {
            $this->session->setNoBatches(true);
            if ( $this->dataHelper->createProductOnFruugo($productids)) {
                $this->messageManager->addSuccessMessage(count($productids) . ' Product(s) XML Created Successfully');
            } else {
                $this->messageManager->addErrorMessage('Product(s) Upload Failed.');
            }

            $redirect = $this->redirectFactory->create();
            return $redirect->setPath(\Ced\Fruugo\Controller\Adminhtml\Products\Index::REDIRECT_PATH);
        }

        $productids = array_chunk($productids, self::CHUNK_SIZE);
        $this->registry->register('productids', count($productids));
        $this->session->setFruugoProducts($productids);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Ced_Fruugo::Fruugo');
        $resultPage->getConfig()->getTitle()->prepend(__('Upload Products'));
        return $resultPage;

    }

    /**
     * IsALLowed
     * @return boolean
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ced_Fruugo::Fruugo');
    }

}
