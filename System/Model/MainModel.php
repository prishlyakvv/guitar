<?php

namespace System\Model;

use PDO;
use System\Lib\SmallLibs;

abstract class MainModel implements ModelInterface {

    protected $_tbl = '';
    protected $_tblAlias = 'self';
    protected $_pk = 'id';

    const JOIN_TYPE = 'JOIN';
    const JOIN_TYPE_LEFT = 'LEFT JOIN';

    const TYPE_INT = 'int';
    const TYPE_STRING = 'string';

    /**
     * @var \System\App
     */
    private $_app;

    /**
     * @var \PDO
     */
    private $_connection;


    private $_srcQuery = '';

    /**
     * @var \PDOStatement
     */
    private $_srcQueryObj;
    private $_nameMainTable = 'self';
    private $_srcQuerySelectColumns = '*';
    private $_srcQueryJoin = array();
    private $_srcQueryWhere = array();
    private $_srcQueryGroup = '';
    private $_srcQueryOrder = '';
    private $_srcQueryLimit = '';


    public function __construct($app) {

        $this->_app = $app;

        $configDB = $this->getApp()->getConfigParam('db_parameters');

        $dsn = "mysql:host={$configDB['database_host']};dbname={$configDB['database_name']};charset={$configDB['database_encoding']}";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        /**
         * Соединение создается 1 раз и хранится в классе App
         */
        if (!$this->getApp()->getConnectionDB()) {
            $coonection = new PDO($dsn, $configDB['database_user'], $configDB['database_password'], $opt);
            $this->getApp()->setConnectionDB($coonection);
        }

        $this->_connection = $this->getApp()->getConnectionDB();
    }

    protected function clearParamsQuery() {
        $this->_srcQueryObj = null;
        $this->_nameMainTable = 'self';
        $this->_srcQuerySelectColumns = '*';
        $this->_srcQueryJoin = array();
        $this->_srcQueryWhere = array();
        $this->_srcQueryGroup = '';
        $this->_srcQueryOrder = '';
        $this->_srcQueryLimit = '';
    }

    /**
     * @return mixed
     */
    public abstract function getColumns();

    /**
     * @return \System\App
     */
    public function getApp() {
        return $this->_app;
    }


    /**
     * SELECT $columns FROM
     *
     * @param array $columns
     * @throws \Exception
     * @return $this
     */
    public function selectColumns($columns = array()) {

        if (!is_array($columns)) {
            throw new \Exception('Параметр selectColumns.$columns должно быть массивом');
        }

        $num = 0;
        $count = count($columns);
        $this->_srcQuerySelectColumns = '';
        foreach ($columns as $alias => $column) {
            $num++;
            $this->_srcQuerySelectColumns .= ' ' . $column . ' AS "' . $alias . '" ';
            if ($count > $num) {
                $this->_srcQuerySelectColumns .= ", ";
            }
        }

        return $this;
    }

    /**
     * SELECT * FROM product AS $alias
     *
     * @param $alias
     * @return $this
     */
    public function setTblAlias($alias) {

        $this->_tblAlias = $alias;
        return $this;

    }

    /**
     * Join присоединение таблиц
     *
     * @param $tbl = присоединяемая таблица
     * @param $name = алиас присоединеной таблицы
     * @param $columnLeft = название левой колонки
     * @param $columnRight = название правой колонки
     * @param $type = JOIN_TYPE/JOIN_TYPE_LEFT
     * @return $this
     */
    public function info($tbl, $name, $columnLeft, $columnRight, $type = self::JOIN_TYPE) {

        $this->_srcQueryJoin[] = " {$type} {$tbl} AS {$name} ON {$name}.{$columnLeft} = {$this->_nameMainTable}.$columnRight";

        return $this;
    }

    /**
     * Добавление условий
     *
     * where('self.id = 5')
     * where('self.id', 5)
     * where('self.id', array(5, 7))
     *
     * @param $str
     * @param string $val
     * @param string $type
     * @return $this
     */
    public function where($str, $val = '', $type = self::TYPE_INT) {

        $where = (!$this->_srcQueryWhere) ? " " : " AND ";

        $where .= " {$str}";

        if (is_array($val)) {
            $val = join(', ', $val);
            $where .= " IN ({$val})";
        } elseif (!empty($val) || $val === 0) {
            if ($type == self::TYPE_INT) {
                $where .= " = {$val}";
            } elseif ($type == self::TYPE_STRING) {
                $where .= " = '{$val}'";
            }

        }

        $this->_srcQueryWhere[] = $where;

        return $this;
    }


    /**
     * Установка лимита при получении записи
     *
     * limit(5)
     * limit(5, 10)
     *
     * @param int $limit
     * @param bool|int $limit2
     * @return $this
     */
    public function limit($limit, $limit2 = false) {
        $limitSql = " LIMIT ";
        if ($limit2) {
            $limitSql .= "{$limit}, {$limit2}";
        } else {
            $limitSql .= "{$limit}";
        }
        $this->_srcQueryLimit = $limitSql;
        return $this;
    }

    /**
     * Установка группировки
     *
     * group('self.id')
     * group('self.id, category.name')
     *
     * @param group
     * @return $this
     */
    public function group($group) {

        $this->_srcQueryGroup = " GROUP BY {$group}";

        return $this;

    }

    /**
     * Установка сортировки
     *
     * order('self.id')
     * order('self.id, category.name')
     *
     * @param order
     * @return $this
     */
    public function order($order) {

        $this->_srcQueryOrder = " ORDER BY {$order}";
        return $this;

    }

    /**
     * Выполнение запроса
     *
     * @return $this
     */
    public function execute() {

        $this->_srcQuery = $this->getSQL();

        try {
            $stmt = $this->getConnection()->prepare($this->_srcQuery);
            $stmt->execute();

            $this->_srcQueryObj = $stmt;
        } catch(\Exception $ex) {
            $this->logExcept($ex);
        }


        return $this;

    }


    /**
     * Получить все записи результата
     *
     * @return mixed
     */
    public function fetchAll() {

        $rez = (array) $this->_srcQueryObj->fetchAll();
        $this->clearParamsQuery();
        return $rez;

    }

    /**
     * Получить одну запись
     *
     * @return mixed
     */
    public function fetchOne() {

        $rez = (array) $this->_srcQueryObj->fetchObject();
        $this->clearParamsQuery();
        return $rez;

    }

    /**
     * Получить все записи результата
     *
     * @return mixed
     */
    public function getCount() {

        $this->selectColumns(array(
            'count' => 'count(*)',
        ))->execute();

        $rez = (int) $this->_srcQueryObj->fetchColumn();
        $this->clearParamsQuery();
        return $rez;

    }


    /**
     * Получение Sql
     *
     * @return string
     */
    public function getSQL() {

        $joins = implode(' ', $this->_srcQueryJoin);
        $wheres = '';
        if ($this->_srcQueryWhere) {
            $wheres = 'WHERE ' . implode(' ', $this->_srcQueryWhere);
        }

        $this->_srcQuery = "
                SELECT
                    {$this->_srcQuerySelectColumns}
                FROM
                    {$this->_tbl} AS {$this->_nameMainTable}
                    {$joins}
                {$wheres}
                {$this->_srcQueryGroup}
                {$this->_srcQueryOrder}
                {$this->_srcQueryLimit}
            ";

        return $this->_srcQuery;
    }

    /**
     * @param $id
     * @param string $removeByColum
     * @return bool
     */
    public function delete($id, $removeByColum = 'id') {

        $this->preRemove($id, $removeByColum);

        try {

            if (is_array($id)) {

                $ids = implode(',', SmallLibs::int_array($id));

                $this->_srcQuery = "DELETE FROM {$this->_tbl} WHERE FIND_IN_SET ({$removeByColum}, :id)";
                $stmt = $this->getConnection()->prepare($this->_srcQuery);
                $stmt->bindParam(':id', $ids, PDO::PARAM_STR);
            } else {
                $this->_srcQuery = "DELETE FROM {$this->_tbl} WHERE {$removeByColum} = :id";
                $stmt = $this->getConnection()->prepare($this->_srcQuery);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            }

            $res = $stmt->execute();
            $this->postRemove($res);

            $this->clearParamsQuery();

            return $res;

        } catch(\Exception $ex) {
            $this->logExcept($ex);
            return false;
        }

    }

    /**
     * Выполняется перед удалением.
     * Содержит параметры иницатора
     *
     * @param $id
     * @param $removeByColum
     */
    protected function preRemove($id, $removeByColum) {}

    /**
     * Выполняется после удаления
     * Содержит результат
     *
     * @param $res
     */
    protected function postRemove($res) {}

    /**
     * @param $ex
     */
    protected function logExcept($ex) {
        echo 'Ошибка в запросе: <hr> <pre>' . $this->_srcQuery . '</pre><hr>';
        echo 'Трейс: <hr> <pre>' . (string) $ex . '</pre><hr>';
    }

    /**
     * @return string
     */
    public function getPk()
    {
        return $this->_pk;
    }

    /**
     * @param string $pk
     */
    public function setPk($pk)
    {
        $this->_pk = $pk;
    }


    /**
     * Выполняется перед вставкой.
     * Содержит параметры иницатора
     *
     * @param $data
     * @param $pk
     */
    protected function preInsert(&$data, $pk) {}

    public function insert($data = array(), $pk = 'id') {

        $this->preInsert($data, $pk);

        try {

            $params = array();
            foreach($data as $key => $val) {

                if (empty($data[$key])) {
                    unset($data[$key]);
                    continue;
                }

                $params[':' . $key] = $val;
            }

            $keys = array_keys($data);
            $colsStr = implode(', ', $keys);
            $valStr = ':' . implode(', :', $keys);

            $this->_srcQuery = "INSERT INTO {$this->_tbl} ({$colsStr}) VALUES ({$valStr})";

            $stmt = $this->getConnection()->prepare($this->_srcQuery);

            $res = $stmt->execute($params);
            if ($res) {
                $res = $this->getConnection()->lastInsertId($pk);
            }

            $this->clearParamsQuery();

            $this->postInsert($res);
            return $res;

        } catch(\Exception $ex) {
            $this->logExcept($ex);
            return false;
        }

    }


    /**
     * Выполняется после вставки
     * Содержит результат
     *
     * @param $res
     */
    protected function postInsert($res) {}

    /**
     * @param $data
     * @param $where
     */
    protected function preUpdate(&$data, &$where) {}

    public function update($data = array(), $where = array()) {

        $this->preUpdate($data, $where);

        try {

            if (isset($data[$this->getPk()])) {
                unset($data[$this->getPk()]);
            }
            $keys = array_keys($data);
            $colsSet = implode('=?, ', $keys) . '=? ';
            $colsWhere = implode('=?, ', array_keys($where)) . '=? ';

            $this->_srcQuery = "UPDATE {$this->_tbl} SET {$colsSet} WHERE {$colsWhere}";
            $stmt = $this->getConnection()->prepare($this->_srcQuery);

            $params = array_values(array_merge($data, $where));
            $res = $stmt->execute($params);

            if ($res) {
                $res = $data;
            }

            $this->clearParamsQuery();

            $this->postUpdate($res);
            return $res;

        } catch(\Exception $ex) {
            $this->logExcept($ex);
            return false;
        }

    }



    /**
     * Выполняется после вставки
     * Содержит результат
     *
     * @param $res
     */
    protected function postUpdate($res) {}

    /**
     * @return \PDO
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * @param \PDO $connection
     */
    public function setConnection($connection)
    {
        $this->_connection = $connection;
    }

} 