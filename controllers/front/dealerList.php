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

class Dealer_ManagerDealerListModuleFrontController extends ModuleFrontController
{
    public $id_dealer_brand;
    public $brand_name;

    public function init()
    {
        parent::init();
        
        $this->id_dealer_brand = Tools::getValue('id_dealer_brand');
        if ($this->id_dealer_brand) {
            $dealers_count = DealerList::getEntryByBrand($this->id_dealer_brand);
            if (empty($dealers_count)) {
                $this->id_dealer_brand = false;
            }

            $dealer_brand = new DealerBrand($this->id_dealer_brand);
            if (!$dealer_brand->active) {
                $this->id_dealer_brand = false;
            }
        }

        $dealers_count = null;
        $this->brand_name = (!$this->id_dealer_brand) ? '' : DealerBrand::getBrandNameById($this->id_dealer_brand);
    }
    
    public function initContent()
    {
        $this->php_self = 'dealerList';
        parent::initContent();

        $brands = DealerBrand::getAllBrands();
        $dealers = (!$this->id_dealer_brand) ? DealerList::getList($this->context->language->id) : DealerList::getListByBrandId($this->id_dealer_brand, $this->context->language->id);
        foreach ($dealers as &$dealer) {
            $dealer['brand'] = explode(',', $dealer['brand']);
        }
        
        $this->context->smarty->assign([
            'brand_name' => $this->brand_name,
            'pagetitle' => (!$this->id_dealer_brand) ? $this->module->l('Dealers') : sprintf($this->module->l('Dealers of %s'), $this->brand_name),
            'brands' => $brands,
            'dealers' => $dealers,
        ]);

        if (!$this->id_dealer_brand) {
            $this->setTemplate('module:dealer_manager/views/templates/front/dealer_grid.tpl');
        } else {
            $this->setTemplate('module:dealer_manager/views/templates/front/dealer_listing.tpl');
        }
    }

    protected function getBreadcrumbLinks()
    {
        $breadcrumb = parent::getBreadcrumbLinks();

        $breadcrumb['links'][] = [
            'title' => $this->module->l('Dealers'),
            'url' => $this->context->link->getModuleLink($this->module->name, 'dealerList'),
        ];
        
        if ($this->id_dealer_brand) {
            $breadcrumb['links'][] = [
                'title' => $this->brand_name,
                'url' => $this->context->link->getModuleLink($this->module->name, 'dealerList', ['id_dealer_brand' => $this->id_dealer_brand]),
            ];
        }

        return $breadcrumb;
    }

    public function setMedia() {
        $this->registerStylesheet('dealer-list', 'modules/' . $this->module->name . '/views/css/front/dealer_list.min.css', ['media' => 'all', 'priority' => 80]);

        return parent::setMedia();
    }
}