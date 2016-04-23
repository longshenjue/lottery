<?php

class ctlBase
{
    var $_view = "index";//模版名称
    var $_vars = array();//变量保存器
    function setView($viewName)
    {
        $this->_view = $viewName;
    }

    function getView()
    {
        return FOXPHP_PATH . "/MVC/View/default/" . $this->_view . FOXPHP_VIEWEXT;
    }

    function setVar($varName, $varValue)
    {
        $this->_vars[$varName] = $varValue;
    }
    function run()//执行Control 加载模版和变量解包
    {
        //解包我们的变量
        extract($this->_vars);
        //加载头部模版
        include(FOXPHP_PATH . "/MVC/View/default/" . FOXPHP_VIEWHEADER . FOXPHP_VIEWEXT);

        //记载模版
        include($this->getView());

        //加载尾部模版
        include(FOXPHP_PATH . "/MVC/View/default/" . FOXPHP_VIEWFOOTER . FOXPHP_VIEWEXT);
    }
}