<?php
/**
 * Created by PhpStorm.
 * User: ting
 * Date: 2016/10/11
 * Time: 12:32
 */
class clsUser extends clsBase
{
    var $username = '';
    function __construct()
    {
        $this->username = '123';
    }

    function show()
    {
        echo $this->username;
    }
}