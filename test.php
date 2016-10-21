<?php
/**
 * Created by PhpStorm.
 * User: ting
 * Date: 2016/10/12
 * Time: 14:30
 */
    include_once "common.php";
    include "foxphp/common/functions.php";
phpinfo();
    $md = load_model("mdlUser");
    $md->user_id = "001";
    $md->user_name = "ting";
    $md->user_email = "111";
    $md->user_pwd = "";

echo json_encode($md);
