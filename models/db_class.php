<?php

class DB {

    private static $_instance = array();
    private $instanse_name;
    private $selfpath;
    private $db;
    private $magic_quotes_gpc;
    private $result;
    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;
    private $dbencoding;
    private $table;
    private $unique = array();
    private $primary = array();
    private $autoincrement;
    private $fields = array();
    private $reverse_fields = array();
    private $defaults = array();
    private $join = array();
    private $order = array();
    private $group = array();
    private $random = false;
    private $sql_fields = array();
    private $sql_where = array();
    private $sql_fulltext = array();
    private $was_set = false;
    private $autoreset = true;
    private $aliases = array();
    private $distinct = '';
    private $table_alias = array();

    public static function table($table = '', $params = false) {
        include_once (dirname(__file__) . '/db_config.php');
        if (is_array($params)) {
            $dbuser = $params['dbuser'];
            $dbpass = $params['dbpass'];
            $dbname = $params['dbname'];
            $dbhost = isset($params['dbhost']) ? $params['dbhost'] : 'localhost';
            $dbencoding = isset($params['dbencoding']) ? $params['dbencoding'] : 'utf8';
        } else {
            $dbuser = db_config::$dbuser;
            $dbpass = db_config::$dbpass;
            $dbname = db_config::$dbname;
            $dbhost = db_config::$dbhost;
            $dbencoding = db_config::$dbencoding;
        }
        $instance_name = sha1($table . $dbuser . $dbpass . $dbname . $dbhost);

        if (!isset(self::$_instance[$instance_name]) or null === self::$_instance[$instance_name]) {
            self::$_instance[$instance_name] = new self($table, $dbuser, $dbpass, $dbname, $dbhost, $dbencoding);
            self::$_instance[$instance_name]->instanse_name = $instance_name;
        }
        return self::$_instance[$instance_name];
    }

    private function __construct($table, $dbuser, $dbpass, $dbname, $dbhost, $dbencoding) {
        $this->magic_quotes_gpc = get_magic_quotes_gpc();
        $this->selfpath = dirname(__file__);
        if (strpos($dbhost, ':') !== false) {
            list($host, $port) = explode(':', $dbhost, 2);
            $this->db = mysqli_connect($host, $dbuser, $dbpass, $dbname, $port);
        } else
            $this->db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        if (!$this->db)
            $this->error('Connection error. Can not connect to database');
        $this->db->set_charset($dbencoding);
        if ($this->db->error)
            $this->error($this->db->error);
        if ($table)
            $this->table = $table;
        $this->autoreset = db_config::$autoreset;
    }

    private function __clone() {
        
    }

    public static function db($params = false) {
        return self::table(false, $params);
    }

    public function auto_reset($bool = true) {
        $this->autoreset = $bool;
        return $this;
    }

    public function is_error() {
        return $this->db->error ? true : false;
    }

    public function total() {
        $join = $this->_build_join();
        $from = $this->_build_from();
        $where = $this->_build_where();
        $group = $this->_build_group();
        //echo "SELECT COUNT(*) as `count` FROM {$from} {$join} {$where} {$group}";
        $this->was_set = true;
        $q = "SELECT COUNT({$this->distinct}*) as `count` FROM {$from} {$join} {$where} {$group}";
        $result = $this->db->query($q, MYSQLI_USE_RESULT);
        if ($this->db->error)
            $this->error($this->db->error, $q);
        else
            return (int) $result->fetch_object()->count;
    }

    public function get($limit = 0, $start = 0) {
        $this->get_table_info($this->table, $this->table);
        $join = $this->_build_join();
        $select = $this->_build_select();
        $from = $this->_build_from();
        $where = $this->_build_where();
        $group = $this->_build_group();
        $order = $this->_build_order();
        $limit = $this->_build_limit($limit, $start);
        $output = array();
        $this->was_set = true;
        $q = "SELECT {$this->distinct}{$select} \r\n FROM {$from} \r\n {$join} \r\n {$where} \r\n {$group} \r\n {$order} \r\n {$limit}";
        $result = $this->db->query($q, MYSQLI_USE_RESULT);
        if ($this->db->error)
            $this->error($this->db->error, $q);
        while ($row = $result->fetch_assoc()) {
            $output[] = $row;
        }
        $result->free();
        return $output;
    }

    public function get_one() {
        $this->get_table_info($this->table, $this->table);
        $join = $this->_build_join();
        $select = $this->_build_select();
        $from = $this->_build_from();
        $where = $this->_build_where();
        $group = $this->_build_group();
        $order = $this->_build_order();
        $output = array();
        $this->was_set = true;
        $q = "SELECT {$this->distinct}{$select} FROM {$from} {$join} {$where} {$group} {$order} LIMIT 1";
        $result = $this->db->query($q, MYSQLI_USE_RESULT);
        if ($this->db->error)
            $this->error($this->db->error, $q);
        return $result->fetch_assoc();
    }

    public function get_list($name, $limit = 0, $start = 0, $table = false) {
        $table = $table ? $table : $this->table;
        if (is_array($name)) {
            $key = key($name);
            $val = $name[$key];
            $select = "`{$table}`.`{$key}`,`{$table}`.`{$val}`";
        } else
            $select = "`{$table}`.`{$name}`";
        $this->get_table_info($this->table, $this->table);
        $join = $this->_build_join();
        $from = $this->_build_from();
        $where = $this->_build_where();
        $group = $this->_build_group();
        $order = $this->_build_order();
        $limit = $this->_build_limit($limit, $start);
        $output = array();
        $this->was_set = true;
        $q = "SELECT {$this->distinct}{$select} FROM {$from} {$join} {$where} {$group} {$order} {$limit}";
        $result = $this->db->query($q, MYSQLI_USE_RESULT);
        if ($this->db->error)
            $this->error($this->db->error, $q);
        while ($row = $result->fetch_assoc()) {
            if (is_array($name)) {
                $output[$row[$key]] = $row[$val];
            } else
                $output[] = $row[$name];
        }
        $result->free();
        return $output;
    }

    public function get_single($name, $table = false) {
        $table = $table ? $table : $this->table;
        $this->get_table_info($this->table, $this->table);
        $join = $this->_build_join();
        $from = $this->_build_from();
        $where = $this->_build_where();
        $group = $this->_build_group();
        $order = $this->_build_order();
        $this->was_set = true;
        $q = "SELECT `{$table}`.`{$name}` FROM {$from} {$join} {$where} {$group} {$order} LIMIT 1";
        $result = $this->db->query($q, MYSQLI_USE_RESULT);
        if ($this->db->error)
            $this->error($this->db->error, $q);
        $output = $result->fetch_assoc();
        $result->free();
        if ($output && isset($output[$name]))
            return $output[$name];
        else
            return null;
    }

    public function delete($limit = 0, $start = 0, $table = false) {
        $this->get_table_info($this->table, $this->table);
        $join = $this->_build_join();
        $from = $this->_build_from();
        $where = $this->_build_where();
        $order = $this->_build_order();
        $limit = $this->_build_limit($limit, $start);
        $this->was_set = true;
        $q = "DELETE FROM {$from} {$join} {$where} {$order} {$limit}";
        $this->db->query($q);
        if ($this->db->error)
            $this->error($this->db->error, $q);
        return $this->db->affected_rows;
    }

    public function insert($arr = array(), $table = false) {
        if (is_array($arr)) {
            $table = $table ? $table : $this->table;
            $fieldvalues = array();
            $this->was_set = true;
            reset($arr);
            $first = $arr[key($arr)];
            if (is_array($first)) {
                $fieldnames = array_keys($first);
                foreach ($arr as $item) {
                    $fieldvalues[] = array_values($item);
                }
            } else {
                $fieldnames = array_keys($arr);
                $fieldvalues[0] = array_values($arr);
            }
            unset($first, $arr);
            foreach ($fieldvalues as $key => $values) {
                foreach ($values as $fkey => $subitem) {
                    $values[$fkey] = $this->sys_esc($subitem);
                }
                $fieldvalues[$key] = '(\'' . implode('\',\'', $values) . '\')';
            }
            $q = "INSERT INTO `{$table}` (`" . implode('`,`', $fieldnames) . "`) VALUES " . implode(',', $fieldvalues);
            $this->db->query($q);
            if ($this->db->error)
                $this->error($this->db->error, $q);
            unset($fieldvalues);
            return $this->db->affected_rows;
        }
    }

    public function update($arr = array(), $limit = 0, $start = 0, $table = false) {
        if (is_array($arr)) {
            $table = $table ? $table : $this->table;
            $where = $this->_build_where();
            $order = $this->_build_order();
            $limit = $this->_build_limit($limit, $start);
            $fieldvalues = array();
            $this->was_set = true;
            foreach ($arr as $key => $item) {
                if (is_array($item)) {
                    foreach ($item as $subkey => $subitem) {
                        $subitem = $this->sys_esc($subitem);
                        $fieldvalues[$key] = "`{$table}`.`{$subkey}` = '{$subitem}'";
                    }
                } else {
                    $item = $this->sys_esc($item);
                    $fieldvalues[0][] = "`{$table}`.`{$key}` = '{$item}'";
                }
            }
            foreach ($fieldvalues as $values) {
                $q = "UPDATE `{$table}` SET " . implode(',', $values) . " {$where} {$order} {$limit}";
                $this->db->query($q);
                if ($this->db->error)
                    $this->error($this->db->error, $q);
            }
            return $this->db->affected_rows;
        }
    }

    public function update_fk($left_key_name = '', $left_key = '', $right_key_name = '', $right_key = '', $table = false, $fields = array()) {
        if ($left_key_name && $left_key && $right_key_name && $right_key) {
            $table = $table ? $table : $this->table;
            $new_keys = array();
            if (is_array($right_key))
                $new_keys = array_unique($right_key);
            else
                $new_keys = array_unique(explode(',', str_replace(' ', '', $right_key)));
            $left_key = $this->sys_esc($left_key);
            foreach ($right_key as $key => $right_value) {
                $right_value = $this->sys_esc($right_value);
                $right_key[$key] = "('{$left_key }','{$right_value}')";
            }
            $q = "DELETE FROM `{$table}` WHERE `{$left_key_name}` = '{$left_key}' ";
            $this->db->query($q);
            if ($this->db->error)
                $this->error($this->db->error, $q);
            $q = "INSERT INTO `{$table}` (`{$left_key_name}`,`{$right_key_name}`) VALUES " . implode(',', $right_key);
            $this->db->query($q);
            if ($this->db->error)
                $this->error($this->db->error, $q);
            return $this->db->affected_rows;
        }
    }

    public function set($arr = array(), $table = false) {
        if (is_array($arr)) {
            $table = $table ? $table : $this->table;
            $fieldvalues = array();
            foreach ($arr as $key => $item) {
                if (is_array($item)) {
                    foreach ($item as $subkey => $subitem) {
                        $subitem = $this->sys_esc($subitem);
                        $fieldvalues[$key]['ins_key'][] = "`{$table}`.`{$subkey}`";
                        $fieldvalues[$key]['ins_val'][] = "'{$subitem}'";
                        //if (in_array($subkey, $this->primary))
                        //    continue;
                        $fieldvalues[$key]['update'][] = "`{$table}`.`{$subkey}` = '{$subitem}'";
                    }
                } else {
                    $item = $this->sys_esc($item);

                    $fieldvalues[0]['ins_key'][] = "`{$table}`.`{$key}`";
                    $fieldvalues[0]['ins_val'][] = "'{$item}'";
                    //if (in_array($key, $this->primary))
                    //    continue;
                    $fieldvalues[0]['update'][] = "`{$table}`.`{$key}` = '{$item}'";
                }
            }
            foreach ($fieldvalues as $values) {
                //$this->dprint($values);
                $q = "INSERT INTO `{$table}` (" . implode(',', $values['ins_key']) . ") VALUES (" . implode(',', $values['ins_val']) .
                        ") 
                    ON DUPLICATE KEY UPDATE " . implode(',', $values['update']);
                $this->db->query($q);
                if ($this->db->error)
                    $this->error($this->db->error, $q);
            }
            return $this->db->affected_rows;
        }
    }

    public function fields($fields = '', $reverse = false, $table = false) {
        if ($fields) {
            if ($this->was_set && $this->autoreset)
                $this->reset();
            $table = $table ? $table : $this->table;
            if (!isset($this->fields[$table]))
                $this->fields[$table] = array();
            if (is_array($fields))
                $this->fields[$table] = array_unique(array_merge((array) $this->fields[$table], $fields));
            else
                $this->fields[$table] = array_unique(array_merge((array) $this->fields[$table], explode(',', str_replace(' ', '', $fields))));
            $this->reverse_fields[$table] = $reverse;
        }
        return $this;
    }

    public function where($field = '', $value = '', $table = false, $no_quotes = false, $join_with = 'AND', $operator = false) {
        if ($field) {
            if ($this->was_set && $this->autoreset)
                $this->reset();
            $table = $table ? $table : $this->table;
            if (is_array($field)) {
                foreach ($field as $key => $value) {
                    $this->sql_where[] = array(
                        'table' => $table,
                        'field' => $key,
                        'value' => $value,
                        'join_with' => $join_with,
                        'no_quotes' => $no_quotes,
                        'operator' => $operator);
                }
            } else {
                $this->sql_where[] = array(
                    'table' => $table,
                    'field' => $field,
                    'value' => $value,
                    'join_with' => $join_with,
                    'no_quotes' => $no_quotes,
                    'operator' => $operator);
            }
        }
        return $this;
    }

    public function open_sub($join_with = 'AND') {
        $this->sql_where[] = array(
            'table' => '',
            'field' => '',
            'value' => '',
            'join_with' => '(',
            'no_quotes' => '',
            'operator' => $join_with);
    }

    public function close_sub() {
        $this->sql_where[] = array(
            'table' => '',
            'field' => '',
            'value' => '',
            'join_with' => ')',
            'no_quotes' => '',
            'operator' => '');
    }

    public function or_sub() {
        $this->open_sub('OR');
    }

    public function and_sub() {
        $this->open_sub('AND');
    }

    public function and_where($field = '', $value = '', $table = false, $no_quotes = false) {
        return $this->where($field, $value, $table, $no_quotes, 'AND');
    }

    public function or_where($field = '', $value = '', $table = false, $no_quotes = false) {
        return $this->where($field, $value, $table, $no_quotes, 'OR');
    }

    public function like($field = '', $value = '', $pattern = array('%', '%'), $table = false, $join_with = 'AND') {
        return $this->where($field, $pattern[0] . $value . $pattern[1], $table, false, $join_with, 'LIKE');
    }

    public function and_like($field = '', $value = '', $pattern = array('%', '%'), $table = false) {
        return $this->where($field, $pattern[0] . $value . $pattern[1], $table, false, 'AND', 'LIKE');
    }

    public function or_like($field = '', $value = '', $pattern = array('%', '%'), $table = false) {
        return $this->where($field, $pattern[0] . $value . $pattern[1], $table, false, 'OR', 'LIKE');
    }

    public function not_like($field = '', $value = '', $pattern = array('%', '%'), $table = false, $join_with = 'AND') {
        return $this->where($field, $pattern[0] . $value . $pattern[1], $table, false, $join_with, 'NOT LIKE');
    }

    public function and_not_like($field = '', $value = '', $pattern = array('%', '%'), $table = false) {
        return $this->where($field, $pattern[0] . $value . $pattern[1], $table, false, 'AND', 'NOT LIKE');
    }

    public function or_not_like($field = '', $value = '', $pattern = array('%', '%'), $table = false) {
        return $this->where($field, $pattern[0] . $value . $pattern[1], $table, false, 'OR', 'NOT LIKE');
    }

    public function where_in($field = '', $values = '', $table = false) {
        if (!is_array($values)) {
            $values = explode(',', str_replace(' ', '', $values));
        }
        return $this->where($field, $values, $table, false, 'AND', 'IN');
    }

    public function where_not_in($field = '', $values = '', $table = false) {
        if (!is_array($values)) {
            $values = explode(',', str_replace(' ', '', $values));
        }
        return $this->where($field, $values, $table, false, 'AND', 'NOT IN');
    }

    public function and_in($field = '', $values = '', $table = false) {
        if (!is_array($values)) {
            $values = explode(',', str_replace(' ', '', $values));
        }
        return $this->where($field, $values, $table, false, 'AND', 'IN');
    }

    public function and_not_in($field = '', $values = '', $table = false) {
        if (!is_array($values)) {
            $values = explode(',', str_replace(' ', '', $values));
        }
        return $this->where($field, $values, $table, false, 'AND', 'NOT IN');
    }

    public function or_in($field = '', $values = '', $table = false) {
        if (!is_array($values)) {
            $values = explode(',', str_replace(' ', '', $values));
        }
        return $this->where($field, $values, $table, false, 'OR', 'IN');
    }

    public function or_not_in($field = '', $values = '', $table = false) {
        if (!is_array($values)) {
            $values = explode(',', str_replace(' ', '', $values));
        }
        return $this->where($field, $values, $table, false, 'OR', 'NOT IN');
    }

    public function fulltext($fields, $phrase, $mode = 'natural', $table = false) {
        if ($fields && $table) {
            if ($this->was_set && $this->autoreset)
                $this->reset();
            $table = $table ? $table : $this->table;
            if (is_array($fields))
                $fields = array_unique($fields);
            else
                $fields = array_unique(explode(',', str_replace(' ', '', $fields)));
            $this->sql_fulltext = array(
                'fields' => $fields,
                'phrase' => $phrase,
                'table' => $table,
                'mode' => $mode);
        }
        return $this;
    }

    public function sort_by($field = '', $direction = 'asc', $table = false) {
        if ($field) {
            if ($this->was_set && $this->autoreset)
                $this->reset();
            $table = $table ? $table : $this->table;
            $this->order[] = array(
                'table' => $table,
                'field' => $field,
                'direction' => ($direction == 'desc') ? 'desc' : 'asc');
        }
        return $this;
    }

    public function order_by($field = '', $direction = 'asc', $table = false) {
        return $this->sort_by($field, $direction, $table);
    }

    public function random() {
        if ($this->was_set && $this->autoreset)
            $this->reset();
        $this->random = true;
        return $this;
    }

    public function join($type = 'LEFT', $field = '', $table = '', $join_field = '', $left_table = false, $alias = false, $right_fields = false, $reverse_fields = false) {
        if ($type && $field && $join_field && $table) {
            if ($this->was_set && $this->autoreset)
                $this->reset();
            $l_table = $left_table ? $left_table : $this->table;
            $alias = $alias ? $alias : $table;
            $condition = "`{$l_table}`." . $this->_prepare_field($field) . "`{$alias}`.`{$join_field}`";
            $this->join[] = array(
                'left_table' => $l_table,
                'right_table' => $table,
                'condition' => $condition,
                'alias' => $alias,
                'type' => $type);
            if ($right_fields) {
                $this->fields($right_fields, $reverse_fields, $alias);
            }
        }
        return $this;
    }

    public function left_join($field = '', $table = '', $join_field = '', $left_table = false, $alias = false, $right_fields = false, $reverse_fields = false) {
        return $this->join($type = 'LEFT', $field, $table, $join_field, $left_table, $alias = false, $right_fields, $reverse_fields);
    }

    public function right_join($field = '', $table = '', $join_field = '', $left_table = false, $alias = false, $right_fields = false, $reverse_fields = false) {
        return $this->join($type = 'RIGHT', $field, $table, $join_field, $left_table, $alias = false, $right_fields, $reverse_fields);
    }

    public function inner_join($field = '', $table = '', $join_field = '', $left_table = false, $alias = false, $right_fields = false, $reverse_fields = false) {
        return $this->join($type = 'INNER', $field, $table, $join_field, $left_table, $alias = false, $right_fields, $reverse_fields);
    }

    public function group_by($field = '', $table = false) {
        if ($field) {
            if ($this->was_set && $this->autoreset)
                $this->reset();
            $table = $table ? $table : $this->table;
            $this->group[] = array('table' => $table, 'field' => $field);
        }
        return $this;
    }

    public function query($query = '') {
        $this->result = $this->db->query($query, MYSQLI_USE_RESULT); //echo $query;
        if ($this->db->error)
            $this->error($this->db->error);
        return $this;
    }

    public function insert_id() {
        return $this->db->insert_id;
    }

    public function result() {
        $out = array();
        if ($this->result) {
            while ($obj = $this->result->fetch_assoc()) {
                $out[] = $obj;
            }
            $this->result->free();
        }
        return $out;
    }

    public function row() {
        $obj = $this->result->fetch_assoc();
        $this->result->free();
        return $obj;
    }

    public function escape($val, $not_qu = false) {
        if (is_int($val))
            return (int) $val;
        if ($not_qu)
            return $this->magic_quotes_gpc ? $val : $this->db->real_escape_string($val);
        return '\'' . ($this->magic_quotes_gpc ? $val : $this->db->real_escape_string($val)) . '\'';
    }

    public function sum($field = '', $alias = false, $table = false) {
        $table = $table ? $table : $this->table;
        if ($alias) {
            if ($this->was_set && $this->autoreset)
                $this->reset();
            $this->sql_fields[] = "SUM(`{$table}`.`{$field}`) AS `{$alias}`";
            return $this;
        } else {
            $join = $this->_build_join();
            $where = $this->_build_where();
            $group = $this->_build_group();
            $this->was_set = true;
            $row = $this->query("SELECT SUM(`{$table}`.`{$field}`) AS `{$field}` FROM `{$table}` {$join} {$where} {$group}")->row();
            return $row[$field];
        }
    }

    public function max($field = '', $alias = false, $table = false) {
        $table = $table ? $table : $this->table;
        if ($alias) {
            if ($this->was_set && $this->autoreset)
                $this->reset();
            $this->sql_fields[] = "MAX(`{$table}`.`{$field}`) AS `{$alias}`";
            return $this;
        } else {
            $join = $this->_build_join();
            $where = $this->_build_where();
            $group = $this->_build_group();
            $this->was_set = true;
            $row = $this->query("SELECT MAX(`{$table}`.`{$field}`) AS `{$field}` FROM `{$table}` {$join} {$where} {$group}")->row();
            return $row[$field];
        }
    }

    public function min($field = '', $alias = false, $table = false) {
        $table = $table ? $table : $this->table;
        if ($alias) {
            if ($this->was_set && $this->autoreset)
                $this->reset();
            $this->sql_fields[] = "MIN(`{$table}`.`{$field}`) AS `{$alias}`";
            return $this;
        } else {
            $join = $this->_build_join();
            $where = $this->_build_where();
            $group = $this->_build_group();
            $this->was_set = true;
            $row = $this->query("SELECT MIN(`{$table}`.`{$field}`) AS `{$field}` FROM `{$table}` {$join} {$where} {$group}")->row();
            return $row[$field];
        }
    }

    public function concat($fields = '', $alias = '', $separator = ',', $table = false) {
        if ($fields && $alias) {
            if ($this->was_set && $this->autoreset)
                $this->reset();
            $table = $table ? $table : $this->table;
            if (!is_array($fields))
                $fields = explode(',', preg_replace('/\s*\,\s*/u', ',', $fields));
            foreach ($fields as $field)
                $concat_str[] = "`{$table}`.`{$field}`";
            $concat_str = implode(',', $concat_str);
            $separator = $this->sys_esc($separator);
            $this->sql_fields[] = "CONCAT_WS('{$separator}',{$concat_str}) AS `{$alias}`";
        }
        return $this;
    }

    public function group_concat($field = '', $alias = '', $separator = ',', $table = false, $distinct = true, $order_by = false, $direct = 'ASC') {
        if ($field) {
            if ($this->was_set && $this->autoreset)
                $this->reset();
            $alias = $alias ? $alias : $field;
            $table = $table ? $table : $this->table;
            $separator = $this->sys_esc($separator);
            $order = $order_by ? "ORDER BY `{$order_by}` {$direct}" : '';
            $this->sql_fields[] = 'GROUP_CONCAT(' . ($distinct ? 'DISTINCT ' : '') . "`{$table}`.`{$field}` {$order} SEPARATOR '{$separator}') AS `{$alias}`";
        }
        return $this;
    }

    public function is_unique($field = '', $value = '', $table = false) {
        if ($field) {
            $table = $table ? $table : $this->table;
            $value = $this->sys_esc($value);
            $result = $this->db->query("SELECT COUNT({$this->distinct}`{$table}`.`{$field}`) AS `count` FROM `{$table}` WHERE `{$table}`.`{$field}` = '{$value}' LIMIT 1");
            if ($this->db->error)
                $this->error($this->db->error);
            else
                return !(bool) $result->fetch_object()->count;
        }
    }

    public function reset() {
        $this->sql_fields = array();
        $this->sql_fulltext = array();
        $this->sql_where = array();
        $this->fields = array();
        $this->reverse_fields = array();
        $this->random = false;
        $this->group = array();
        $this->order = array();
        $this->join = array();
        $this->was_set = false;
        return $this;
    }

    public function alias($field = '', $alias = '', $table = false) {
        if (($field && $alias) or ( is_array($field))) {
            $table = $table ? $table : $this->table;
            if (!isset($this->aliases[$table]))
                $this->aliases[$table] = array();
            if (is_array($field)) {
                $this->aliases[$table] = array_merge((array) $this->aliases[$table], $field);
            } else {
                $this->aliases[$table] = array_merge((array) $this->aliases[$table], array($field => $alias));
            }
        }
        return $this;
    }

    public function increment($field = '', $num = 1, $table = false) {
        if ($field) {
            $num = (int) $num;
            $table = $table ? $table : $this->table;
            $join = $this->_build_join();
            $where = $this->_build_where();
            $this->was_set = true;
            $this->db->query("UPDATE `$table` SET `{$field}` = `{$field}` + {$num} {$join} ");
        }
    }

    public function decrement($field = '', $num = 1, $table = false) {
        if ($field) {
            $num = (int) $num;
            $table = $table ? $table : $this->table;
            $join = $this->_build_join();
            $where = $this->_build_where();
            $this->was_set = true;
            $this->db->query("UPDATE `$table` SET `{$field}` = `{$field}` - {$num} {$where} ");
        }
    }

    public function distinct() {
        if ($this->was_set && $this->autoreset)
            $this->reset();
        $this->distinct = 'DISTINCT ';
    }

    ###

    private function get_table_info($table, $alias) {
        $result = $this->db->query("SHOW COLUMNS FROM `{$table}`", MYSQLI_USE_RESULT);
        if ($this->db->error)
            $this->error($this->db->error);
        //$this->dprint($this->fields);
        while ($row = $result->fetch_object()) {
            //$this->dprint($row);
            if ($row->Key == 'UNI')
                $this->unique[$row->Field] = true;
            if ($row->Key == 'PRI')
                $this->primary[$row->Field] = true;
            if ($row->Key == 'PRI' && $row->Extra == 'auto_increment') {
                $this->autoincrement[$row->Field] = true;
            }
            //$this->fields["{$table}.{$row->Field}"] = $row->Field;
            if (!isset($this->fields[$table]) or ( isset($this->fields[$table]) && in_array($row->Field, $this->fields[$table])) or ( isset
                            ($this->reverse_fields[$table]) && $this->reverse_fields[$table] && !in_array($row->Field, $this->fields[$table])))
                $this->sql_fields["{$alias}.{$row->Field}"] = "`{$alias}`.`{$row->Field}`" . (isset($this->aliases[$table][$row->Field]) ?
                                " AS `{$this->aliases[$table][$row->Field]}`" : '');
        }
    }

    public function sys_esc($val) {
        if (is_int($val))
            return (int) $val;
        if (!$this->magic_quotes_gpc)
            return $this->db->real_escape_string($val);
        return $val;
    }

    private function _build_select() {
        return implode(', ', $this->sql_fields);
    }

    private function _build_from() {
        return "`{$this->table}`";
    }

    private function _build_join() {
        $join = array();
        if ($this->join) {
            foreach ($this->join as $join_tbl) {
                $this->table_alias[$join_tbl['right_table']] = $join_tbl['alias'];
                $this->get_table_info($join_tbl['right_table'], $join_tbl['alias']);
                $join[] = "{$join_tbl['type']} JOIN `{$join_tbl['right_table']}` AS `{$join_tbl['alias']}` ON {$join_tbl['condition']}";
            }
            return implode(' ', $join);
        }
        return '';
    }

    private function _build_where() {
        $where = '';
        if ($this->sql_fulltext) {
            foreach ($this->sql_fulltext['fields'] as $key => $val) {
                $this->sql_fulltext['fields'][$key] = "`{$this->sql_fulltext['table']}`.`{$val}`";
            }
            $where .= 'WHERE MATCH (' . implode(',', $this->sql_fulltext['fields']) . ') AGAINST (\'' . $this->sys_esc($this->
                            sql_fulltext['phrase']) . '\'';
            switch ($this->sql_fulltext['mode']) {
                case 'boolean':
                    $where .= ' IN BOOLEAN MODE';
                    break;
                case 'expansion':
                    $where .= ' WITH QUERY EXPANSION';
                    break;
            }
            $where .= ')';
        }
        if ($this->sql_where) {
            $i = 1;
            foreach ($this->sql_where as $k => $w) {
                if (isset($this->table_alias[$w['table']]))
                    $w['table'] = $this->table_alias[$w['table']];
                if (($k > 0 or $where != '') && $w['field'] && $i > 0)
                    $where .= $w['join_with'];
                elseif ($w['field'] && $i > 0)
                    $where .= 'WHERE';

                if ($w['join_with'] && $w['operator'] && !$w['field']) {
                    $where .= $w['operator'] . ' ' . $w['join_with'];
                    $i = 0;
                    continue;
                } elseif ($w['join_with'] && !$w['operator'] && !$w['field']) {
                    $where .= $w['join_with'];
                    continue;
                }

                if (mb_stripos($w['operator'], 'IN') !== false) {
                    foreach ($w['value'] as $wkey => $wval) {
                        $w['value'][$wkey] = '\'' . $this->sys_esc($wval) . '\'';
                    }
                    $where .= " `{$w['table']}`.`{$w['field']}` {$w['operator']} (" . implode(',', $w['value']) . ') ';
                } else {
                    $w['value'] = $w['no_quotes'] ? $w['value'] : '\'' . $w['value'] . '\'';
                    if ($w['operator'])
                        $where .= " `{$w['table']}`.`{$w['field']}` {$w['operator']} {$w['value']} ";
                    else
                        $where .= " `{$w['table']}`." . $this->_prepare_field($w['field']) . " {$w['value']} ";
                }
                ++$i;
            }
        }

        return $where;
    }

    private function _build_order() {
        $order = array();
        if ($this->random) {
            $order[] = 'RAND()';
        }
        if ($this->order) {
            foreach ($this->order as $param) {
                if (isset($this->table_alias[$param['table']]))
                    $param['table'] = $this->table_alias[$param['table']];
                $order[] = "`{$param['table']}`.`{$param['field']}` {$param['direction']}";
            }
        }
        if ($order)
            return 'ORDER BY ' . implode(', ', $order);
        return '';
    }

    private function _build_group() {
        if ($this->group) {
            $group = array();
            foreach ($this->group as $param) {
                $group[] = "`{$param['table']}`.`{$param['field']}`";
            }
            return 'GROUP BY ' . implode(', ', $group);
        }
        return '';
    }

    private function _build_limit($limit, $start) {
        if ($limit != 0) {
            return "LIMIT {$start}, {$limit}";
        }
    }

    private function _prepare_field($field) {
        preg_match_all('/([^<>!=]+)/', $field, $matches);
        preg_match_all('/([<>!=]+)/', $field, $matches2);
        return '`' . trim($matches[0][0]) . '`' . ($matches2[0] ? implode('', $matches2[0]) : '=');
    }

    private function error($text = 'Error!', $query = '') {
        if ($query)
            $query = '<small><pre>' . $query . '</pre></small>';
        echo ('<div class="sdba-error" style="padding:15px;color:red;margin:10px;border:1px solid red;border-radius:2px;">' . $text .
        $query . '</div>');
    }

    public function dprint($var) {
        echo '<pre>' . print_r($var, 1) . '</pre>';
    }

}
