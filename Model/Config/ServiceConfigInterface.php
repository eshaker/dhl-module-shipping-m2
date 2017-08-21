<?php
/**
 * Dhl Shipping
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to
 * newer versions in the future.
 *
 * PHP version 7
 *
 * @category  Dhl
 * @package   Dhl\Shipping
 * @author    Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @copyright 2017 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */

namespace Dhl\Shipping\Model\Config;

use Dhl\Shipping\Service\ServiceCollectionFactory;
use Dhl\Shipping\Service;

/**
 * ServiceConfig
 *
 * @category Dhl
 * @package  Dhl\Shipping
 * @author   Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
interface ServiceConfigInterface
{
    const CONFIG_XML_FIELD_PREFERREDDAY = 'carriers/dhlshipping/service_preferredday_enabled';
    const CONFIG_XML_FIELD_PREFERREDDAY_HANDLING_FEE = 'carriers/dhlshipping/service_preferredday_handling_fee';
    const CONFIG_XML_FIELD_PREFERREDDAY_HANDLING_FEE_TEXT = 'carriers/dhlshipping/service_preferredday_handling_fee_text';
    const CONFIG_XML_FIELD_PREFERREDTIME_HANDLING_FEE = 'carriers/dhlshipping/service_preferredtime_handling_fee';
    const CONFIG_XML_FIELD_PREFERREDTIME_HANDLING_FEE_TEXT = 'carriers/dhlshipping/service_preferredtime_handling_fee_text';
    const CONFIG_XML_FIELD_CUTOFFTIME = 'carriers/dhlshipping/service_cutoff_time';
    const CONFIG_XML_FIELD_PREFERREDLOCATION_PLACEHOLDER = 'carriers/dhlshipping/service_preferredlocation_placeholder';
    const CONFIG_XML_FIELD_PREFERREDNEIGHBOUR_PLACEHOLDER = 'carriers/dhlshipping/service_preferredneighbour_placeholder';

    const CONFIG_XML_PATH_AUTOCREATE_VISUALCHECKOFAGE = 'carriers/dhlshipping/shipment_autocreate_service_visualcheckofage';
    const CONFIG_XML_PATH_AUTOCREATE_RETURNSHIPMENT   = 'carriers/dhlshipping/shipment_autocreate_service_returnshipment';
    const CONFIG_XML_PATH_AUTOCREATE_INSURANCE        = 'carriers/dhlshipping/shipment_autocreate_service_insurance';
    const CONFIG_XML_PATH_AUTOCREATE_BULKYGOODS       = 'carriers/dhlshipping/shipment_autocreate_service_bulkygoods';

    const CONFIG_XML_PATH_AUTOCREATE_ENABLED = 'carriers/dhlshipping/shipment_autocreate_enabled';
    const CONFIG_XML_PATH_CRON_ORDER_STATUS = 'carriers/dhlshipping/shipment_autocreate_order_status';

    /**
     * Load all DHL additional service models.
     *
     * @param mixed $store
     *
     * @return Service\ServiceCollection
     */
    public function getServices($store = null);

    /**
     * Obtain preferred day handling fee from config.
     *
     * @param null $store
     * @return int
     */
    public function getPrefDayFee($store = null);

    /**
     * Obtain prefered time handling fees from config.
     *
     * @param null $store
     * @return int
     */
    public function getPrefTimeFee($store = null);

    /**
     * Obtain pref day handling fee text from config.
     *
     * @param null $store
     * @return string
     */
    public function getPrefDayHandlingFeeText($store = null);

    /**
     * Obtain pref time handling fee text from config.
     *
     * @param null $store
     * @return string
     */
    public function getPrefTimeHandlingFeeText($store = null);

    /**
     * Check if automatic shipment creation is enabled for store
     *
     * @deprecated Not used anywhere
     * @see \Dhl\Shipping\AutoCreate\OrderProvider::load
     * @see \Magento\Store\Model\StoresConfig::getStoresConfigByPath
     *
     * @param null $store
     * @return bool
     */
    public function isAutoCreateEnabled($store = null);

    /**
     * Get allowed order statuses for automatic shipment creation
     *
     * @param null $store
     * @return mixed
     */
    public function getAutoCreateOrderStatus($store = null);

}
