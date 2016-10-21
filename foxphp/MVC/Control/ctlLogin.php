<?php
/**
 * Created by PhpStorm
 * User: zyt
 * Date: 2016/4/25
 * Time: 10:55
 */
class ctlLogin extends ctlBase
{
    function index()
    {
        $visitor = $_POST['visitor'];
        if ($visitor == 1) {
            header("Refresh:2;url=/lottery/show");
        } else {
            $user = $_POST['user'];
            $pwd = $_POST['pwd'];
            header("Refresh:2;url=/lottery/show");
        }
    }
}