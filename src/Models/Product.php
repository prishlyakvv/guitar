<?php

namespace src\Models;

use System\Model\MainModel;

class Product extends MainModel {

    protected $_tbl = 'product';

    public function getColumns() {

        return array(
            'id' => array(
                'type' => 'int',
                'notNull' => true,
                'ai' => true,
                'pk' => true,
            ),
            'name' => array(
                'type' => 'varchar',
            ),
            'price' => array(
                'type' => 'int',
            ),
            'category_id' => array(
                'type' => 'int',
            ),
            'date_create' => array(
                'type' => 'datetime',
            ),
            'date_modifed' => array(
                'type' => 'datetime',
            ),
            'file' => array(
                'type' => 'varchar',
                'typeLength' => 255,
            ),
            'visible' => array(
                'type' => 'tinyint',
            ),
            'isset' => array(
                'type' => 'tinyint',
            ),
            'description' => array(
                'type' => 'text',
            ),
        );

    }

    /**
     * @param array $where
     * @return mixed
     */
    public function getAllProducts($where = array()) {

        $tbl = $this->selectColumns(array(
                'id' => 'self.id',
                'name' => 'self.name',
                'file' => 'self.file',
                'price' => 'self.price',
                'category_id' => 'self.category_id',
                'date_create' => 'self.date_create',
                'date_modifed' => 'self.date_modifed',
                'visible' => 'self.visible',
                'isset' => 'self.isset',
                'description' => 'self.description',
            ));

        if ($where) {
            if (isset($where['visible'])  && in_array($where['visible'], array('visible', 'hidden'))) {
                if ($where['visible'] == 'visible') {
                    $tbl->where('self.visible', 1);
                } elseif ($where['visible'] == 'hidden') {
                    $tbl->where('self.visible', 0);
                }
            }
        }

        $tbl->order('self.id ASC')
            ->execute();

        $products = $tbl->fetchAll();

        return (array) $products;

    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getProduct($id) {

        $tbl = $this->selectColumns(array(
                'id' => 'self.id',
                'name' => 'self.name',
                'file' => 'self.file',
                'price' => 'self.price',
                'category_id' => 'self.category_id',
                'date_create' => 'self.date_create',
                'date_modifed' => 'self.date_modifed',
                'visible' => 'self.visible',
                'isset' => 'self.isset',
                'description' => 'self.description',
            ))
            ->where('self.id', (int) $id)
            ->execute();

        $product = $tbl->fetchOne();

        return $product;

    }

    /**
     * @param array $ids
     * @return bool
     */
    public function removeProducts($ids = array()) {

        return $this->delete($ids);

    }


} 