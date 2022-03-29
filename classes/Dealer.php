<?php
/**
 * 2022 Oliver
 *
 * NOTICE OF LICENSE
 *
 * This file is licenced under the GNU General Public License, version 3 (GPL-3.0).
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement.
 *
 *  @author     Oliver <oliver139.working@gmail.com>
 *  @copyright  2022 Oliver
 *  @license    https://opensource.org/licenses/GPL-3.0 GNU General Public License version 3
 */

class Dealer extends ObjectModel
{
    public $name;
    public $tel;
    public $email;
    public $fax;
    public $facebook;
    public $twitter;
    public $instagram;
    public $web;
    public $map_link;
    public $address;

    /** @var $active Status*/
    public $active;

    /** @var $date_add */
    public $date_add;

    /** @var $date_upd */
    public $date_upd;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = [
        'table' => 'dealer',
        'primary' => 'id_dealer',
        'fields' => [
            'name' => ['type' => self::TYPE_STRING, 'size' => 255],
            'tel' => ['type' => self::TYPE_STRING, 'size' => 255],
            'email' => ['type' => self::TYPE_STRING, 'size' => 255],
            'fax' => ['type' => self::TYPE_STRING, 'size' => 255],
            'facebook' => ['type' => self::TYPE_STRING, 'size' => 255],
            'twitter' => ['type' => self::TYPE_STRING, 'size' => 255],
            'instagram' => ['type' => self::TYPE_STRING, 'size' => 255],
            'web' => ['type' => self::TYPE_STRING, 'size' => 255],
            'map_link' => ['type' => self::TYPE_STRING, 'size' => 255],
            'address' => ['type' => self::TYPE_STRING, 'size' => 255],
            'active'    => ['type' => self::TYPE_BOOL, 'validate' => 'isBool'],
            'date_add'  => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
            'date_upd'  => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
        ],
    ];

    public function delete() {
        return parent::delete() && DealerList::delEntryByDealer($this->id);
    }
}
