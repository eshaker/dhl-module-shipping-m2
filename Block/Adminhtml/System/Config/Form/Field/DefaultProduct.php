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
 * @author    Max Melzer <max.melzer@netresearch.de>
 * @copyright 2017 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\Shipping\Block\Adminhtml\System\Config\Form\Field;

use Dhl\Shipping\Util\ShippingProductsInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Shipping\Model\Config as ShippingConfig;
use Magento\Store\Model\ScopeInterface;

/**
 * Config field block for the Default Product select field.
 * Filters options based on the configured shipping origin.
 *
 * @category Dhl
 * @package  Dhl\Shipping
 * @author   Max Melzer <max.melzer@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class DefaultProduct extends Field
{
    /**
     * @var ShippingProductsInterface
     */
    private $shippingProducts;

    /**
     * DefaultProduct constructor.
     *
     * @param ShippingProductsInterface $shippingProducts
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        ShippingProductsInterface $shippingProducts,
        Context $context,
        array $data = []
    ) {
        $this->shippingProducts = $shippingProducts;

        parent::__construct($context, $data);
    }


    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $items = $element->getValues();
        $items = $this->filterAvailable($items);
        $element->setValues($items);

        return parent::_getElementHtml($element);
    }

    /**
     * @param string[] $items
     * @return string[]
     */
    private function filterAvailable($items)
    {
        $scopeId = $this->_request->getParam('website', 0);
        $shippingOrigin = $this->_scopeConfig->getValue(
            ShippingConfig::XML_PATH_ORIGIN_COUNTRY_ID,
            ScopeInterface::SCOPE_WEBSITE,
            $scopeId
        );
        $applicableCodes = $this->shippingProducts->getApplicableCodes($shippingOrigin);
        $items = array_filter($items, function ($item) use ($applicableCodes) {
            return in_array($item['value'], $applicableCodes);
        });

        return $items;
    }
}
