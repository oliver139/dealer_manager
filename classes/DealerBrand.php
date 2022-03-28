<?php

/**
 * 2020-2022 Genkiware
 *
 * NOTICE OF LICENSE
 *
 * This file is licenced under the GNU General Public License, version 3 (GPL-3.0).
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement.
 *
 *  @author     Genkiware <info@genkiware.com>
 *  @copyright  2020-2022 Genkiware
 *  @license    https://opensource.org/licenses/GPL-3.0 GNU General Public License version 3
 */

class DealerBrand extends ObjectModel
{
    /** @var $name The display name of the flag */
    public $name;

    /** @var $active Status of the flag */
    public $active;

    /** @var $date_add */
    public $date_add;

    /** @var $date_upd */
    public $date_upd;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'dealer_brand',
        'primary' => 'id_dealer_brand',
        'fields' => [
            'name' => ['type' => self::TYPE_STRING, 'size' => 255],
            'active'    => ['type' => self::TYPE_BOOL, 'validate' => 'isBool'],
            'date_add'  => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
            'date_upd'  => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
        ],
    ];
}
