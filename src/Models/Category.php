<?php

namespace src\Models;

use System\Model\MainModel;

class Category extends MainModel {

    protected $_tbl = 'category';

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
                'typeLength' => 255,
            ),
            'file' => array(
                'type' => 'varchar',
                'typeLength' => 255,
            ),
            'parent_category' => array(
                'type' => 'int',
            ),
            'number_sort' => array(
                'type' => 'int',
            ),
        );

    }

    /**
     * @return mixed
     */
    public function getAllCategories() {

        $tbl = $this->selectColumns(array(
                'id' => 'self.id',
                'name' => 'self.name',
                'file' => 'self.file',
                'parent_category' => 'self.parent_category',
                'number_sort' => 'self.number_sort',
            ))
            ->order('self.number_sort ASC')
            ->execute();

        $categories = $tbl->fetchAll();

        return (array) $categories;

    }

    /**
     * @param int $id
     * @return array
     */
    public function getAllThisLevelCategories($id = 0) {

        $tbl = $this->selectColumns(array(
            'id' => 'self.id',
            'name' => 'self.name',
            'file' => 'self.file',
            'parent_category' => 'self.parent_category',
            'number_sort' => 'self.number_sort',
        ))
            ->info('product', 'product', 'category_id', 'id', MainModel::JOIN_TYPE_LEFT)
            ->info('category', 'category_children', 'parent_category', 'id', MainModel::JOIN_TYPE_LEFT)
            ->where('(category_children.id IS NOT NULL OR product.id IS NOT NULL)')
            ->group('self.id')
            ->order('self.number_sort ASC');

        if ($id) {
            $tbl->where('self.parent_category', (int) $id);
        } else {
            $tbl->where('self.parent_category', 0);
        }

        $categories = $tbl->execute()->fetchAll();

        return (array) $categories;

    }



    public function getAllCategoriesForFilter() {

        $tbl = $this->selectColumns(array(
            'id' => 'self.id',
            'name' => 'self.name',
        ))
            ->order('self.name ASC')
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
                'cat_parent_category' => 'self.parent_category',
                'cat_number_sort' => 'self.number_sort',
                'id' => 'product.id',
                'name' => 'product.name',
                'file' => 'product.file',
            ))
            ->where('self.id', (int) $catId)
            ->where('product.visible', 1)
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

    /**
     * @param int $id
     * @return mixed
     */
    public function getCategory($id = 0) {

        $tbl = $this->selectColumns(array(
            'id' => 'self.id',
            'name' => 'self.name',
            'file' => 'self.file',
            'parent_category' => 'self.parent_category',
            'number_sort' => 'self.number_sort',

        ))
            ->where('self.id', (int) $id)
            ->execute();

        return $tbl->fetchOne();

    }

} 