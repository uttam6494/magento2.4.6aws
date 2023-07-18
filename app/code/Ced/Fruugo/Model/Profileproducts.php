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
 * @author 		CedCommerce Core Team <connect@cedcommerce.com>
 * @copyright   Copyright CedCommerce (http://cedcommerce.com/)
 * @license      http://cedcommerce.com/license-agreement.txt
 */


namespace Ced\Fruugo\Model;

class Profileproducts extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Ced\Fruugo\Model\ResourceModel\Profileproducts');
    }


    /**
     * @return $this
     */

    public function update()
    {
        $this->getResource()->update($this);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProductsCollection()
    {
        return $this->getResource('Ced\Fruugo\Model\ResourceModel\Profileproducts\Collection');
    }


    /**
     * getting group vendors
     */
    public function getProfileProducts($profileId)
    {
        return $this->getResource()->getProfileProducts($profileId);
    }

    public function deleteFromProfile($productId)
    {
        $this->_getResource()->deleteFromProfile($productId);
        return $this;
    }

    public function profileProductExists($productId, $profileId)
    {
        $result = $this->_getResource()->profileProductExists($productId, $profileId);
        return ( is_array($result) && count($result) > 0 ) ? true : false;
    }






    /**
     * Load entity by attribute
     *
     * @param string|array field
     * @param null|string|array $value
     * @param string $additionalAttributes
     * @return bool|Ced_CsMarketplace_Model_Abstract
     */
    public function loadByField($field, $value, $additionalAttributes = '*')
    {
        $collection = $this->getResourceCollection()
            ->addFieldToSelect($additionalAttributes);
        if(is_array($field) && is_array($value)){
            foreach($field as $key=>$f) {
                if(isset($value[$key])) {
                    //$f = $helper->getTableKey($f);
                    $collection->addFieldToFilter($f, $value[$key]);
                }
            }
        } else {
            /* echo "{{".$field.' == '.$value."}}"; */
            //$field = $helper->getTableKey($field);
            $collection->addFieldToFilter($field, $value);
            /* echo $collection->getSelect();die; */
        }

        $collection->setCurPage(1)
            ->setPageSize(1);
        /* echo $collection->getSize();die; */
        foreach ($collection as $object) {
            /* print_r($object->getData());die; */
            $this->load($object->getId());
            return $this;
        }
        return $this;
    }

}