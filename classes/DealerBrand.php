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

class DealerBrand extends ObjectModel
{
    /** @var $name The display name of the brand */
    public $name;

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
        'table' => 'dealer_brand',
        'primary' => 'id_dealer_brand',
        'fields' => [
            'name' => ['type' => self::TYPE_STRING, 'size' => 255],
            'active'    => ['type' => self::TYPE_BOOL, 'validate' => 'isBool'],
            'date_add'  => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
            'date_upd'  => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
        ],
    ];


    public function __construct($id = null, $idLang = null, $idShop = null)
    {
        parent::__construct($id, $idLang, $idShop);

        $this->image_dir = _PS_IMG_DIR_ . 'dealers/brands/';
    }

    public function delete() {
        return parent::delete() && $this->deleteImage() && DealerList::delEntryByBrand($this->id);
    }

    public static function getAllBrands($activeOnly = false) {
        $sql = new DbQuery();
        $sql->select('id_dealer_brand, name');
        $sql->from('dealer_brand', 'dlb');
        $sql->orderBy('name');

        if ($activeOnly) {
            $sql->where('dlb.active = 1');
        }

        return Db::getInstance()->executeS($sql);
    }
}
