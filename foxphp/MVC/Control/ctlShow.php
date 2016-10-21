<?php
/**
 * Created by PhpStorm.
 * User: ting
 * Date: 2016/4/24
 * Time: 18:40
 */
class ctlShow extends ctlBase
{
    function index()
    {
        $this->setView('show');
        $gameInfo = array();
        $gameInfo['gameName'] = 'lottery';
        $userInfo = [
            '1' => 1,
            '2' => 0,
            '3' => 0,
            '4' => 0,
            '5' => 0,
        ];
        $this->setVar("gameInfo", "game start!");
        $this->setVar("userInfo", $userInfo);
    }

    function getcard()
    {
        $suc = $_GET['suc'];

        return response(100, $suc);
    }
}