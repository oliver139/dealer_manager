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

    public static function getEntryByBrand($id_dealer_brand) {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('dealer_list', 'dl');
        $sql->where('dl.id_dealer_brand = ' . $id_dealer_brand);

        return Db::getInstance()->executeS($sql);
    }

    public static function getList($id_lang = 1, $active_only = true) {
        $sql = 'SELECT dl.`id_dealer`, GROUP_CONCAT(dl.`id_dealer_brand` ORDER BY dl.id_dealer_brand ASC SEPARATOR ",") AS brand, d.`tel`, `email`, `fax`, `facebook`, `twitter`, `instagram`, `web`, `map_link`, dlang.`name`, `address`
        FROM `' . _DB_PREFIX_ . 'dealer_list` dl
        LEFT JOIN `' . _DB_PREFIX_ . 'dealer_brand` dlb ON dl.`id_dealer_brand` = dlb.`id_dealer_brand`
        LEFT JOIN `' . _DB_PREFIX_ . 'dealer` d ON dl.`id_dealer` = d.`id_dealer`
        LEFT JOIN `' . _DB_PREFIX_ . 'dealer_lang` dlang ON dl.`id_dealer` = dlang.`id_dealer`
        WHERE dlang.id_lang = ' . $id_lang;
        
        if ($active_only) {
            $sql .= ' AND dlb.`active` = 1 AND d.`active` = 1';
        }

        $sql .= ' GROUP BY dl.`id_dealer` ORDER BY dlang.`name`';

        return Db::getInstance()->executeS($sql);
    }

    public static function getListByBrandId($id_dealer_brand, $id_lang = 2, $active_only = true) {
        $sql = 'SELECT dl.`id_dealer`, GROUP_CONCAT(dl.`id_dealer_brand` ORDER BY dl.id_dealer_brand ASC SEPARATOR ",") AS brand, d.`tel`, `email`, `fax`, `facebook`, `twitter`, `instagram`, `web`, `map_link`, dlang.`name`, `address`
        FROM `' . _DB_PREFIX_ . 'dealer_list` dl
        LEFT JOIN `' . _DB_PREFIX_ . 'dealer_brand` dlb ON dl.`id_dealer_brand` = dlb.`id_dealer_brand`
        LEFT JOIN `' . _DB_PREFIX_ . 'dealer` d ON dl.`id_dealer` = d.`id_dealer`
        LEFT JOIN `' . _DB_PREFIX_ . 'dealer_lang` dlang ON dl.`id_dealer` = dlang.`id_dealer`
        WHERE dlang.id_lang = ' . $id_lang . ' AND dl.`id_dealer` IN (SELECT `id_dealer` FROM `' . _DB_PREFIX_ . 'dealer_list` WHERE id_dealer_brand = ' . $id_dealer_brand . ')';
        
        if ($active_only) {
            $sql .= ' AND dlb.`active` = 1 AND d.`active` = 1';
        }

        $sql .= ' GROUP BY dl.`id_dealer` ORDER BY dlang.`name`';

        return Db::getInstance()->executeS($sql);
    }
}
