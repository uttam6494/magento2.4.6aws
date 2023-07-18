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

namespace Ced\Fruugo\Model\Carrier;
use Magento\Quote\Model\Quote\Address\RateRequest;

class Shipfruugocom extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    const REGISTRY_INDEX_SHIPPING_METHOD = 'fruugo_shipping_method';
    const REGISTRY_INDEX_SHIPPING_TOTAL = 'fruugo_shipping_total';
    public $_code = 'shipfruugocom';
    public $_logger;
    /**
     * @var bool
     */
    public $_isFixed = true;
   
    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    public $_rateResultFactory;
    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    public $_rateMethodFactory;

    public $_state;
    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\State $appState,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Magento\Framework\App\State $state,
        \Magento\Framework\Registry $registry,
        $data = []
    ) {
        $this->appState = $appState;
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_logger = $logger;
        $this->registry = $registry;
        $this->_state = $state;
        parent::__construct($scopeConfig, $rateErrorFactory,$logger, $data);
    }

    /**
     * Collect rates for this shipping method based on information in $request
     * @param \Magento\Shipping\Model\Rate\Result $request
     * @return \Magento\Shipping\Model\Rate\Result
     */
    public function collectRates(RateRequest $request)
    {
       
       if (!$this->getConfigFlag('active')) {
            return false;
        }
        if($this->appState->getAreaCode() == 'webapi_rest')
        {
            return false;
        }
     
        if($this->appState->getAreaCode() =='crontab' || $this->appState->getAreaCode() =='adminhtml'){
            $price = $this->registry->registry(self::REGISTRY_INDEX_SHIPPING_TOTAL);
              //  $price = $this->getConfigData('price');
                // set a default shipping price maybe 0
                if (!$price)
                {
                    $price = 0;
                }

                $handling = $this->getConfigFlag('handling');

                /** @var \Magento\Shipping\Model\Rate\Result $result */
                $result = $this->_rateResultFactory->create();

                /** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
                $method = $this->_rateMethodFactory->create();
                $method->setCarrier($this->_code);
                $method->setMethod($this->_code);

                $method->setCarrierTitle($this->getConfigData('title'));
                $shippingService = $this->registry->registry(self::REGISTRY_INDEX_SHIPPING_METHOD);
               // $method->setMethodTitle($this->getConfigData('name'));
               $method->setMethodTitle(($shippingService) ? $shippingService : $this->getConfigData('name'));
                $method->setPrice($price);
                $method->setCost(0);

                $result->append($method);
                return $result;
           
        }else
        {
            return false;
        }

        //if($this->_state->getAreaCode() == 'frontend') {return false;}

       
    }

    public function getAllowedMethods() {
        return [$this->_code => $this->getConfigData('title')];
    }

    public function getCode(){
        return $this->_code;
    }
}