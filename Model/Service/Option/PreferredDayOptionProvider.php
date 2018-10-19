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
namespace Dhl\Shipping\Model\Service\Option;

use Dhl\Shipping\Api\Data\Service\ServiceSettingsInterface;
use Dhl\Shipping\Model\Service\StartDate;
use Dhl\Shipping\Service\Bcs\PreferredDay;
use Dhl\Shipping\Webservice\ParcelManagement;

/**
 *
 * @package  Dhl\Shipping\Model
 * @author   Sebastian Ertner <sebastian.ertner@netresearch.de>
 * @license  http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link     http://www.netresearch.de/
 */
class PreferredDayOptionProvider implements OptionProviderInterface
{

    const POSTAL_CODE = 'postalCode';

    const SERVICE_CODE = PreferredDay::CODE;

    /**
     * @var ParcelManagement
     */
    private $parcelManagement;

    /**
     * @var StartDate
     */
    private $startDateModel;

    /**
     * PreferredDayOptionProvider constructor.
     * @param ParcelManagement $parcelManagement
     * @param StartDate $startDateModel
     */
    public function __construct(
        ParcelManagement $parcelManagement,
        StartDate $startDateModel
    ) {
        $this->parcelManagement = $parcelManagement;
        $this->startDateModel = $startDateModel;
    }


    /**
     * @param array $service
     * @param array $args
     * @return array
     */
    public function enhanceServiceWithOptions($service, $args)
    {
        try {
            $storeId = isset($args['storeId']) ? $args['storeId'] : null;
            $startDate = $this->startDateModel->getStartDate($storeId);
            // options from the api
            $validDays = $this->parcelManagement->getPreferredDayOptions($startDate, $args[self::POSTAL_CODE]);
        } catch (\Exception $e) {
            $validDays = [];
        }

        $options = [];
        foreach ($validDays as $validDay) {
            $options[] = [
                'label' => $validDay->getStart()->format('D,d.'),
                'value' => $validDay->getStart()->format('Y-m-d'),
                'disable' => false
            ];
        }
        $service[ServiceSettingsInterface::OPTIONS] = $options;

        return $service;
    }

    /**
     * @return string
     */
    public function getServiceCode()
    {
        return self::SERVICE_CODE;
    }
}