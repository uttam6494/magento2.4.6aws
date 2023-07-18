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

namespace Ced\Fruugo\Model\ResourceModel\FailedFruugoOrders;



class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection

{

    public function _construct()
    {
        $this->_init(
            'Ced\Fruugo\Model\FailedFruugoOrders',
            'Ced\Fruugo\Model\ResourceModel\FailedFruugoOrders'
        );
    }

}