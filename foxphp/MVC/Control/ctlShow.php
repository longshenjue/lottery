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
        $this->setVar("gameInfo", "game start!");
    }
}