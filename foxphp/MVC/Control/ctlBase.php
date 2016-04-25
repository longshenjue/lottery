<?php

class ctlBase
{
    public $_view = "";//模版名称
    public $_vars = array();//变量保存器
    function setView($viewName)
    {
        $this->_view = $viewName;
    }

    function getView()
    {
        if ($this->_view != "") {
            return FOXPHP_PATH . "/MVC/View/default/" . $this->_view . FOXPHP_VIEWEXT;
        } else {
            return '';
        }
    }

    function getHeader()
    {
        if ($this->_view != "") {
            return FOXPHP_PATH . "/MVC/View/default/" . FOXPHP_VIEWHEADER . FOXPHP_VIEWEXT;
        } else {
            return '';
        }

    }

    function getFooter()
    {
        if ($this->_view != "") {
            return FOXPHP_PATH . "/MVC/View/default/" . FOXPHP_VIEWFOOTER . FOXPHP_VIEWEXT;
        } else {
            return '';
        }
    }

    function setVar($varName, $varValue)
    {
        $this->_vars[$varName] = $varValue;
    }
    function run()//执行Control 加载模版和变量解包
    {
        //解包变量
        extract($this->_vars);
        //加载头部模版
        $header = $this->getHeader();
        if ($header != '') include($header);

        //记载模版
        $view = $this->getView();
        if ($header != '') include($view);

        //加载尾部模版
        $footer = $this->getFooter();
        if ($footer != '') include($footer);
    }
}