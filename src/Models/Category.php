<?php

namespace src\Models;

use System\Model\MainModel;

class Category extends MainModel {

    protected $_tbl = 'category';

    /**
     * @return mixed
     */
    public function getAllCategories() {

        $tbl = $this->selectColumns(array(
                'id' => 'self.id',
                'name' => 'self.name',
                'file' => 'self.file',
            ))
            ->order('self.id ASC')
            ->execute();

        $categories = $tbl->fetchAll();

        return (array) $categories;

    }

    /**
     * @param int $catId
     * @return mixed
     */
    public function getProductsFromCategory($catId = 0) {

        $tbl = $this
            ->info('product', 'product', 'category_id', 'id')
            ->selectColumns(array(
                'cat_id' => 'self.id',
                'cat_name' => 'self.name',
                'cat_file' => 'self.file',
                'id' => 'product.id',
                'name' => 'product.name',
                'file' => 'product.file',
            ))
            ->where('self.id', (int) $catId)
            ->execute();

        $products = $tbl->fetchAll();

        return (array) $products;

    }

    /**
     * @param array $ids
     * @return bool
     */
    public function removeCategories($ids = array()) {

        return $this->delete($ids);

    }

} 