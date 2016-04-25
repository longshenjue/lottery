<?php
function test()
{
    echo 'test1';
}

function the_user()
{
    return isset($_COOKIE[FOXPHP_USERCOOKIE])?json_decode($_COOKIE[FOXPHP_USERCOOKIE]):false;
}

function set_user($md, $time)
{
    if ($time <= 0) {
        //注销
        setcookie(FOXPHP_USERCOOKIE, json_encode($md), time() - 100, "/");
    } else {
        setcookie(FOXPHP_USERCOOKIE, json_encode($md), time() + $time, "/");
    }
}

function is_login()
{
    if(the_user()) return true;
    return false;
}

function load_model($modelName)
{
    require_once(FOXPHP_PATH."/MVC/Model/".$modelName.".php");
    return new $modelName();
}

function response($code, $result = null)
{
    $o = new \stdClass();
    $o->code = $code;
    $o->result = $result;
    if ($code == 100) {
        $o->success = true;
    } else {
        $o->success = false;
    }
    $s = json_encode($o,JSON_UNESCAPED_UNICODE);
    if (isset($_GET['callback'])) {
        echo trim($_GET['callback']) . "($s)";
    } else {
        echo $s;
    }
    return $o->success;
}

