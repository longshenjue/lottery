<?php
class index extends ctlBase
{
    function index()
    {

    }
    function showindex()
    {
        //include(FOXPHP_PATH . "/MVC/View/default/index.php");
        //var_dump($_GET);
        $this->setView("index");
        $this->setVar("title", "网页标题是？！<br>");
    }

    function showuser()
    {
        $md = load_model("UserModel");
        $md->user_id = "001";
        $md->user_name = "ting";
        $md->user_email = "111";
        $md->user_pwd = "";
        set_user($md,3600);
        $this->setView("index");
        if (is_login()){
            $this->setVar("UserStatus","当前用户是：". the_user()->user_name);
        } else{
            $this->setVar("UserStatus","未登录！");
        }
    }
}