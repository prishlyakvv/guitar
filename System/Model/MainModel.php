<?php

namespace System\Model;

use PDO;

class MainModel {

    protected $_tbl = '';
    protected $_tblAlias = 'self';

    const JOIN_TYPE = 'JOIN';
    const JOIN_TYPE_LEFT = 'LEFT JOIN';

    /**
     * @var \System\App
     */
    private $_app;

    /**
     * @var \PDO
     */
    private $_pdo;


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

        $configDB = $this->_app->getConfigParam('db_parameters');

        $dsn = "mysql:host={$configDB['database_host']};dbname={$configDB['database_name']};charset={$configDB['database_encoding']}";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        $this->_pdo = new PDO($dsn, $configDB['database_user'], $configDB['database_password'], $opt);

    }

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
     * @return $this
     */
    public function where($str, $val = '') {

        $where = (!$this->_srcQueryWhere) ? " " : " AND ";

        $where .= " {$str}";

        if (is_array($val)) {
            $val = join(', ', $val);
            $where .= " IN ({$val})";
        } elseif (!empty($val) || $val === 0) {
            $where .= " = {$val}";
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
            $stmt = $this->_pdo->prepare($this->_srcQuery);
            $stmt->execute();

            $this->_srcQueryObj = $stmt;
        } catch(\Exception $ex) {
            echo 'Ошибка в запросе: <hr> <pre>' . $this->_srcQuery . '</pre><hr>';
            echo 'Трейс: <hr> <pre>' . (string) $ex . '</pre><hr>';
            die;
        }


        return $this;

    }


    /**
     * Получить все записи результата
     *
     * @return mixed
     */
    public function fetchAll() {

        return (array) $this->_srcQueryObj->fetchAll();

    }

    /**
     * Получить одну запись
     *
     * @return mixed
     */
    public function fetchOne() {

        return (array) $this->_srcQueryObj->fetchObject();

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

        $sql = "
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

        return $sql;
    }

} 