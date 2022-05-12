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

function upgrade_module_1_1($module) {
    $result = true;
    $db = Db::getInstance();
    $langs = Language::getIDs();

    // Create dealer_lang table
    $sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'dealer_lang` (
        `id_dealer` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
        `id_lang` INT(10) UNSIGNED NOT NULL,
        `name` VARCHAR(255) NOT NULL,
        `address` VARCHAR(255),
        PRIMARY KEY (`id_dealer`, `id_lang`)
    ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';
    $result &= $db->execute($sql);

    // Retrieve existing data
    $sql = new DbQuery();
    $sql->select('id_dealer, name, address');
    $sql->from('dealer', 'd');
    $sql->orderBy('id_dealer');
    $data = $db->executeS($sql);

    // Copy to lang table for each lang
    foreach ($data as $value) {
        foreach ($langs as $id_lang) {
            $result &= $db->insert('dealer_lang',[
                'id_dealer' => $value['id_dealer'],
                'id_lang' => $id_lang,
                'name' => $db->escape($value['name']),
                'address' => $db->escape($value['address']),
            ], true, true, Db::REPLACE);
        }
    }

    // Drop old columns
    $sql = 'ALTER TABLE `ps_dealer` DROP `name`, DROP `address`;';
    $result &= $db->execute($sql);

    return $result;
}