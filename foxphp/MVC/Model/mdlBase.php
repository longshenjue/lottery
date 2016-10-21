<?php

/**
 * Created by PhpStorm.
 * User: ting
 * Date: 2016/5/12
 * Time: 21:45
 */
class mdlBase
{
    public $table_name = ""; //
    public $id = 0;
    public $primaryId = 'id'; // 主键字段名

    function load($where = '')
    {
        if ($this->table_name == '' || $this->id == 0)
            return;

        $vars = get_object_vars($this);

        $sql = "";
        foreach ($vars as $key => $value) {
            if (trim($value) == "") {
                if ($sql != "") {
                    $sql .= ",";
                }
                $sql .= $key;
            }
        }
        if ($sql == '') {
            return;
        }
        $sql = "select " . $sql . " from " . $this->table_name . " where ";
        if ($where == "") {
            $sql .= $this->primaryId . "=" . $this->id;
        } else {
            $sql .= $where;
        }
        $db = load_db();
        $ret = $db->execForArray($sql);
        if ($ret && count($ret) == 1) {
            $ret = $ret[0];
            $vars = array_keys($vars);
            foreach ($ret as $k => $v) {
                if (in_array($k, $vars)) {
                    $this->$k = $v;
                }
            }
        }
    }
}