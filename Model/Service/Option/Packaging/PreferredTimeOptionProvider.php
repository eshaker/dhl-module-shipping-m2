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
 * @package   Dhl\Shipping\Model
 * @author    Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @copyright 2018 Netresearch GmbH & Co. KG
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.netresearch.de/
 */
namespace Dhl\Shipping\Model\Service\Option\Packaging;

use Dhl\Shipping\Api\Data\Service\ServiceSettingsInterface;
use Dhl\Shipping\Api\Data\ServiceSelectionInterface;
use Dhl\Shipping\Model\Service\Option\OptionProviderInterface;
use Dhl\Shipping\Service\Bcs\PreferredTime;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 *
 * @package  Dhl\Shipping\Model
 * @author   Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class PreferredTimeOptionProvider implements OptionProviderInterface
{

    const SERVICE_CODE = PreferredTime::CODE;

    /**
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * PreferredDayOptionProvider constructor.
     * @param TimezoneInterface $timezone
     */
    public function __construct(TimezoneInterface $timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @param array $service
     * @param array $args
     * @return array
     */
    public function enhanceServiceWithOptions($service, $args)
    {
        /** @var ServiceSelectionInterface| bool $selection */
        $selection = isset($args['selection']) ? $args['selection'] : false;
        $options = [];
        if ($selection && $selection->getServiceCode() === $this->getServiceCode()) {
            $selectedValue = current($selection->getServiceValue());
            $options[] = [
                'label' => $this->formatTime($selectedValue),
                'value' => $selectedValue,
                'disable' => false
            ];
            $service[ServiceSettingsInterface::OPTIONS] = $options;
        }

        return $service;
    }

    /**
     * @return string
     */
    public function getServiceCode()
    {
        return self::SERVICE_CODE;
    }

    /**
     * Format selected value to start and end hours eg. 10:00 - 12:00
     *
     * @param string $timeString
     * @return string
     */
    public function formatTime($timeString)
    {
        $start = substr($timeString,0,4);
        $end = substr($timeString,4,4);

        return substr_replace( $start, ':', -2, 0 )
            . ' - ' . substr_replace( $end, ':', -2, 0 );
    }
}