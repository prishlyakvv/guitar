<?php

namespace System\Model;


interface ModelInterface {

    public function getColumns();
    public function selectColumns($columns = array());
    public function setTblAlias($alias);
    public function info($tbl, $name, $columnLeft, $columnRight, $type);
    public function where($str, $val);
    public function limit($limit, $limit2 = false);
    public function group($group);
    public function order($order);
    public function execute();
    public function fetchAll();
    public function fetchOne();
    public function getSQL();
    public function delete($id, $removeByColum = 'id');
    public function getPk();
    public function setPk($pk);
    public function insert($data = array(), $pk = 'id');
    public function update($data = array(), $where = array());

}