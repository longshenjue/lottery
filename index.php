<?php
/**
 * Created by PhpStorm.
 * User: yuting
 * Date: 2015/8/27
 * Time: 10:47
 */
include("common.php");
header("Content-type:text/html;charset=utf-8");
$_control = isset($_GET["control"]) ? $_GET["control"] : "";

$_action = isset($_GET["action"]) ? $_GET["action"] : "";
if ($_control == "" || in_array($_control, explode(",", FOXPHP_FORBIDDEN_TYPE))) exit('url错误');

//加载全局函数库
include(FOXPHP_PATH . "/common/functions.php");
require(FOXPHP_PATH . "/MVC/Control/_Master.php");

$_control_path = FOXPHP_PATH . "/MVC/Control/" . $_control . ".php";
if (!file_exists($_control_path)) exit('control is not exists');   //转到404
require($_control_path);

if (!class_exists($_control)) exit('class is not exists');

$_init_control = new $_control();

if (method_exists($_init_control, $_action)) {
    $_init_control->$_action();//执行类方法
}

$_init_control->run();
