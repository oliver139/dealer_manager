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
                'filter_key' => 'a!name'
            ],
            'image' => array(
                'title' => $this->trans('Image', array(), 'Admin.Global'),
                'align' => 'center',
                'image' => 'dealers/brands',
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
            'name' => 'brand_image',
            'dir' => 'dealers/brands',
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

    public function initPageHeaderToolbar()
    {
        if (empty($this->display)) {
            $this->page_header_toolbar_btn['new_brand'] = array(
                'href' => self::$currentIndex . '&adddealer_brand&token=' . $this->token,
                'desc' => $this->l('Add new brand'),
                'icon' => 'process-icon-new',
            );
        }

        parent::initPageHeaderToolbar();
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
                    'name' => 'name',
                    'id' => 'name',
                    'col' => 5,
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

        // Default values
        if ($this->display == 'add') {
            $this->fields_value['active'] = 1;
        }

        return parent::renderForm();
    }

    protected function uploadImage($id, $name, $dir, $ext = false, $width = 80, $height = 80) {
        return parent::uploadImage($id, $name, $dir, $ext, $width, $height);
    }

    protected function afterImageUpload()
    {
        if (file_exists(_PS_TMP_IMG_DIR_ . $this->table . '_mini_' . $this->object->id . '_' . $this->context->shop->id . '.jpg')) {
            unlink(_PS_TMP_IMG_DIR_ . $this->table . '_mini_' . $this->object->id . '_' . $this->context->shop->id . '.jpg');
        }

        return true;
    }
}
