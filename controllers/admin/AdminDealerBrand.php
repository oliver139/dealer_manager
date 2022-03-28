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

class AdminDealerBrandController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'dealer_brand';
        $this->className = 'DealerBrand';
        parent::__construct();
        $this->fields_list = [
            'id_dealer_brand' => [
                'title' => $this->l('ID'),
                'align' => 'left',
                'class' => 'fixed-width-xs',
            ],
            'name' => [
                'title' => $this->l('Name'),
                'type' => 'text',
                'filter_key' => 'a!flag_name'
            ],
            'image' => array(
                'title' => $this->trans('Image', array(), 'Admin.Global'),
                'align' => 'center',
                'image' => 'dbrand',
                'orderby' => false,
                'search' => false,
            ),
            'active' => [
                'title' => $this->l('Active'),
                'type' => 'bool',
                'class' => 'fixed-width-sm',
                'active' => 'status',
                'align' => 'text-center',
                'filter_key' => 'a!active',
                'orderby' => false,
            ],
        ];
        $this->fieldImageSettings = [
            'name' => 'dealer_brand',
            'dir' => 'dbrand',
        ];
        $this->addRowAction('edit');
        $this->addRowAction('duplicate');
        $this->addRowAction('');
        $this->addRowAction('delete');
        $this->bulk_actions = [
            'delete' => [
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?'),
                'icon' => 'icon-trash'
            ],
        ];
    }

    public function renderList() {
        return parent::renderList();
    }

    public function renderForm() {
        if (!($obj = $this->loadObject(true))) return;
        $module_path = __PS_BASE_URI__ . 'modules/' . $this->module->name . '/';
        
        $this->fields_form = [
            'legend' => [
                'icon' => 'icon-pencil',
                'title' => $this->l('Dealer Brand Detail'),
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Name'),
                    'name' => 'brand_name',
                    'id' => 'brand_name',
                    'required' => true,
                ],
                [
                    'type' => 'file',
                    'label' => $this->l('Image'),
                    'name' => 'brand_image',
                    'id' => 'brand_image',
                    'required' => true,
                ],
                [
                    'type' => 'switch',
                    'label' => $this->l('Active'),
                    'name' => 'active',
                    'id' => 'active',
                    'values' => [
                        ['value' => 1],
                        ['value' => 0],
                    ],
                ],
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            ],
        ];
        
        return parent::renderForm();
    }

    public function processSave() {
        // $type = strtolower(Tools::getValue('type'));
        
        // $file = new GenkiFileProcess($_FILES['flag_file'], ['image/jpeg', 'image/png']);
        // $module_root = _PS_MODULE_DIR_ . $this->module->name . '/';

        // if ($file->uploadFiles($module_root . 'views/img/' . $type)) {
        //     return parent::processSave();
        // }
        return parent::processSave();
    }
}
