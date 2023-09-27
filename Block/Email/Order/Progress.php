<?php
/**
 * Sales Order Email Status Progress
 */
namespace Ceven\ExtraStepsEOP\Block\Email\Order;

class Progress extends \SummaTheme\Base\Block\Email\Order\Progress
{
    public function isOrderPickedUp()
    {
        $pickupStatusConfig = $this->scopeConfig->getValue('summa_theme/email_order_progress/pickup_status', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $pickupStatuses = $pickupStatusConfig ? explode(',', $pickupStatusConfig) : [];
        return in_array($this->getOrder()->getStatus(), $pickupStatuses);
    }

    public function getPickupTitle()
    {
        return trim($this->getConfig('summa_theme/email_order_progress/pickup_title') ?: '');
    }
}
