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

class AdminDealerController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->table = 'dealer';
        $this->className = 'Dealer';
        parent::__construct();

        $this->fields_list = [
            'id_dealer' => [
                'title' => $this->l('ID'),
                'align' => 'left',
                'class' => 'fixed-width-xs',
            ],
            'name' => [
                'title' => $this->l('Name'),
                'type' => 'text',
                'filter_key' => 'a!name',
                'orderby' => true,
            ],
            'tel' => [
                'title' => $this->l('Telephone'),
                'type' => 'text',
                'filter_key' => 'a!tel',
            ],
            'email' => [
                'title' => $this->l('Email'),
                'type' => 'text',
                'filter_key' => 'a!email',
            ],
            'address' => [
                'title' => $this->l('Address'),
                'type' => 'text',
                'filter_key' => 'a!address',
            ],
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

    public function initPageHeaderToolbar() {
        if (empty($this->display)) {
            $this->page_header_toolbar_btn['new_dealer'] = array(
                'href' => self::$currentIndex . '&adddealer&token=' . $this->token,
                'desc' => $this->l('Add new dealer'),
                'icon' => 'process-icon-new',
            );
        }

        parent::initPageHeaderToolbar();
    }

    public function renderList() {
        return parent::renderList();
    }

    public function renderForm() {
        $b_choice = [];
        $brands = DealerBrand::getAllBrands();
        foreach ($brands as $id => $name) {
            $b_choice[] = [
                'id' => $id,
                'name' => $name,
                'val' => $id,
            ];
        }
        
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
                    'col' => 3,
                    'required' => true,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Telephone'),
                    'name' => 'tel',
                    'id' => 'tel',
                    'col' => 3,
                    'required' => true,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Email'),
                    'name' => 'email',
                    'id' => 'email',
                    'col' => 3,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Fax'),
                    'name' => 'fax',
                    'id' => 'fax',
                    'col' => 3,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Address'),
                    'name' => 'address',
                    'id' => 'address',
                    'col' => 3,
                    'required' => true,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Google Map Link'),
                    'name' => 'map_link',
                    'id' => 'map_link',
                    'col' => 6,
                    'required' => true,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Facebook Link'),
                    'name' => 'facebook',
                    'id' => 'facebook',
                    'col' => 6,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Twitter Link'),
                    'name' => 'twitter',
                    'id' => 'twitter',
                    'col' => 6,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Instagram Link'),
                    'name' => 'instagram',
                    'id' => 'instagram',
                    'col' => 6,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Website'),
                    'name' => 'web',
                    'id' => 'web',
                    'col' => 6,
                ],
                [
                    'type' => 'checkbox',
                    'label' => $this->l('Associated Brands'),
                    'name' => 'brands',
                    'required' => true,
                    'values' => array(
                        'query' => $b_choice,
                        'id' => 'id',
                        'name' => 'name'
                    )
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

        if ($this->display == 'add') {
            $this->fields_value['active'] = 1;
        } elseif ($this->display == 'edit') {
            $brands = DealerList::getEntryByDealer($this->object->id);
            
            foreach ($brands as $brand) {
                $this->fields_value['brands_' . $brand['id_dealer_brand']] = 1;
            }
        }

        return parent::renderForm();
    }

    private function getBrandList() {
        $brands = [];
        $formData = Tools::getAllValues();
        foreach ($formData as $key => $value) {
            if(substr($key, 0, 7) == 'brands_') {
                $brands[] = $value;
            }
        }
        return $brands;
    }

    protected function afterAdd($object) {
        $brands = $this->getBrandList();
        return DealerList::addEntry($object->id, $brands);
    }

    protected function afterUpdate($object) {
        $brands = $this->getBrandList();
        return DealerList::updateEntry($object->id, $brands);
    }
}
