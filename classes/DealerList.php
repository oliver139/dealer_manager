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

class DealerList
{
    public static function addEntry($id_dealer, $brands) {
        $sql = 'INSERT INTO `'. _DB_PREFIX_ . 'dealer_list` (`id_dealer`, `id_dealer_brand`) VALUES ';

        $values = [];
        foreach ($brands as $brand) {
            $values[] = sprintf("('%s', '%s')", $id_dealer, $brand);
        }

        $sql .= implode(", ", $values);
        
        return Db::getInstance()->execute($sql);
    }

    public static function delEntryByDealer($id_dealer) {
        $sql = 'DELETE FROM `' . _DB_PREFIX_ . 'dealer_list` WHERE `id_dealer` = ' . $id_dealer;
        return Db::getInstance()->execute($sql);
    }

    public static function delEntryByBrand($id_dealer_brand) {
        $sql = 'DELETE FROM `' . _DB_PREFIX_ . 'dealer_list` WHERE `id_dealer_brand` = ' . $id_dealer_brand;
        return Db::getInstance()->execute($sql);
    }

    public static function updateEntry($id_dealer, $brands) {
        return self::delEntryByDealer($id_dealer) && self::addEntry($id_dealer, $brands);
    }

    public static function getEntryByDealer($id_dealer) {
        $sql = new DbQuery();
        $sql->select('id_dealer_brand');
        $sql->from('dealer_list', 'dl');
        $sql->where('dl.id_dealer = ' . $id_dealer);

        return Db::getInstance()->executeS($sql);
    }
}
