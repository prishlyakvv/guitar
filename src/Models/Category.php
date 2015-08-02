<?php

namespace src\Models;

use System\Model\MainModel;

class Category extends MainModel {

    protected $_tbl = 'categories';

    public function getAllCategories() {

        $tbl = $this->selectColumns('self.id, self.name, self.file')
            ->where('self.id', array(1, 2))
            ->order('self.id ASC')
            ->execute();

        $categories = $tbl->fetchAll();

        return $categories;

    }


} 