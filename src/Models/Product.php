<?php

namespace src\Models;

use System\Model\MainModel;

class Product extends MainModel {

    protected $_tbl = 'product';

    public function getColumns() {

        return array(
            'name' => array(
                'type' => 'varchar',
                'typeLength' => 255,
            ),
            'file' => array(
                'type' => 'varchar',
                'typeLength' => 255,
            ),
        );

    }

    /**
     * @return mixed
     */
    public function getAllProducts() {

        $tbl = $this->selectColumns(array(
                'id' => 'self.id',
                'name' => 'self.name',
                'file' => 'self.file',
            ))
            ->order('self.id ASC')
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
            ))
            ->where('self.id', (int) $id)
            ->execute();

        $product = $tbl->fetchOne();

        return $product;

    }


} 