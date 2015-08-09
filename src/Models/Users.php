<?php

namespace src\Models;

use System\Model\MainModel;

class Users extends MainModel {

    protected $_tbl = 'users';

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
            'password' => array(
                'type' => 'varchar',
                'typeLength' => 255,
            ),
        );

    }

    /**
     * @param array $data
     * @return mixed
     */
    public function login($data = array()) {

        $name = $data['name'];
        $pass = md5($data['password']);

        $tbl = $this->selectColumns(array(
            'id' => 'self.id',
            'name' => 'self.name',
        ))
            ->where('self.name',  $name, $this::TYPE_STRING)
            ->where('self.password', $pass, $this::TYPE_STRING)
            ->execute();

        $rez = (array) $tbl->fetchOne();

        return $rez;

    }

} 