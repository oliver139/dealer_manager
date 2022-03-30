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

if (!defined('_PS_VERSION_')) exit;

require_once(dirname(__FILE__) . '/vendor/autoload.php');

class Dealer_Manager extends Module
{
    private $_html = '';
    private $_postErrors = array();
 
    public function __construct() {
        $this->name                   = 'dealer_manager';
        $this->tab                    = 'front_office_features';
        $this->version                = '1.0';
        $this->author                 = 'Oliver';
        $this->bootstrap              = true;
        $this->need_instance          = 0;
        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];

        parent::__construct();

        $this->displayName            = $this->l('Dealer Manager');
        $this->description            = $this->l('This module allows you to manage dealers');
        $this->confirmUninstall       = $this->l('Are you sure to uninstall this module?');
    }

    public function install(){
        // Configuration::updateValue('GENKI_FPS_ACCOUNT_TYPE', '1');
        
        return parent::install() &&
            $this->createImageDir() &&
            $this->installDB() &&
            $this->addTab();
    }

    public function uninstall() {
        return parent::uninstall() && 
            $this->uninstallDB() &&
            $this->removeTab();
    }

    /**
     * Create custom table for saving all the FPS records
     * 
     * @return bool
     */
    private function installDB() {
        $brand_table = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'dealer_brand` (
            `id_dealer_brand` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `active` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'1\',
            `date_add` DATETIME NOT NULL,
            `date_upd` DATETIME NOT NULL,
            PRIMARY KEY (`id_dealer_brand`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

        $dealer_table = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'dealer` (
            `id_dealer` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `tel` VARCHAR(255),
            `email` VARCHAR(255),
            `fax` VARCHAR(255),
            `facebook` VARCHAR(255),
            `twitter` VARCHAR(255),
            `instagram` VARCHAR(255),
            `web` VARCHAR(255),
            `map_link` VARCHAR(511),
            `address` VARCHAR(255),
            `active` TINYINT(1) UNSIGNED NOT NULL DEFAULT \'1\',
            `date_add` DATETIME NOT NULL,
            `date_upd` DATETIME NOT NULL,
            PRIMARY KEY (`id_dealer`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';

        $list_table = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'dealer_list` (
            `id_dealer` INT(10) UNSIGNED NOT NULL,
            `id_dealer_brand` INT(10) UNSIGNED NOT NULL,
            PRIMARY KEY (`id_dealer`, `id_dealer_brand`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;';
        
        return Db::getInstance()->execute($brand_table) && Db::getInstance()->execute($dealer_table) && Db::getInstance()->execute($list_table);
    }

    /**
     * Drop the custom table, not in use currently
     * 
     * @return bool
     */
    private function uninstallDB() {
        $brand_table = 'DROP TABLE `'._DB_PREFIX_.'dealer_brand`';
        $dealer_table = 'DROP TABLE `'._DB_PREFIX_.'dealer`';
        $list_table = 'DROP TABLE `'._DB_PREFIX_.'dealer_list`';
        
        return Db::getInstance()->execute($brand_table) && Db::getInstance()->execute($dealer_table) && Db::getInstance()->execute($list_table);
    }

    private function createImageDir() {
        $res = true;

        if (!file_exists(_PS_IMG_DIR_ . 'dealers/')) {
            $res &= mkdir(_PS_IMG_DIR_ . 'dealers/', 0770);
        }
        if (!file_exists(_PS_IMG_DIR_ . 'dealers/brands/')) {
            $res &= mkdir(_PS_IMG_DIR_ . 'dealers/brands/', 0770);
        }

        return $res;
    }

    private function addTab() {
        $res = true;
        $tabparent = "AdminDealerManager";
        $id_parent = Tab::getIdFromClassName($tabparent);
        if(!$id_parent){
            $tab = new Tab();
            $tab->active = 1;
            $tab->class_name = "AdminDealerManager";
            $tab->name = [];
            foreach (Language::getLanguages() as $lang){
                $tab->name[$lang["id_lang"]] = $this->l('Dealer Manager');
            }
            $tab->id_parent = 0;
            $tab->module = $this->name;
            $res &= $tab->add();
            $id_parent = $tab->id;
        }
        $subtabs = [
            [
                'class'=>'AdminDealerBrand',
                'name'=>'Brands'
            ],
            [
                'class'=>'AdminDealer',
                'name'=>'Dealers'
            ],
        ];
        foreach($subtabs as $subtab){
            $idtab = Tab::getIdFromClassName($subtab['class']);
            if(!$idtab){
                $tab = new Tab();
                $tab->active = 1;
                $tab->class_name = $subtab['class'];
                $tab->name = array();
                foreach (Language::getLanguages() as $lang){
                    $tab->name[$lang["id_lang"]] = $subtab['name'];
                }
                $tab->id_parent = $id_parent;
                $tab->module = $this->name;
                $res &= $tab->add();
            }
        }
        return $res;
    }

    private function removeTab()
    {
        $id_tabs = ["AdminDealerBrand","AdminDealer","AdminDealerManager"];
        foreach($id_tabs as $id_tab){
            $idtab = Tab::getIdFromClassName($id_tab);
            $tab = new Tab((int)$idtab);
            $parentTabID = $tab->id_parent;
            $tab->delete();
            $tabCount = Tab::getNbTabs((int)$parentTabID);
            if ($tabCount == 0){
                $parentTab = new Tab((int)$parentTabID);
                $parentTab->delete();
            }
        }
        return true;
    }
}
