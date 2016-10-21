<?php

class ctlIndex extends ctlBase
{
    function index()
    {
        $this->clsUser->show(); // 使用了魔术方法 __get  来执行 load_class 这个方法来实例化对象，
        //还可以使用__call 方法来执行类中未定义的方法
        exit;
        $newobj = load_class('clsUser');
//        $newobj = new $c();
//        var_dump($newobj);exit;
    }

    function showindex()
    {
        $this->setView("index");
        $user = load_class('clsUser');
        $userList = [[
            'id' => '123',
            'name' => 'ting'
        ], [
            'id' => '456',
            'name' => 'zhang'
        ]];
        $this->setVar("userList", $userList);
        $this->setVar("user", $user);
        $this->setVar("title", "网页标题是？！<br>");
    }

    function showuser()
    {
        /*
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

        $db = load_db();
        $newList = $db->execForArray("select * from t_user");
        $this->setVar("newList", $newList);
        */

        /*
        $user = load_model("mdlUser");
        $user->table_name = 't_user';
        $user->id = "1";
        $user->load();
        $this->setVar("user", $user);



        $db = load_db();
        $sql[] = "insert into t_user(username,userpwd,useremail,sex) values('zhang','123','zhang@qq.com',1)";
        $sql[] = "select LAST_INSERT_ID() into @newuserid";
        $sql[] = "insert into userdetail(userid,user_realname,user_qq) VALUES (@newuserid,'张扬','123123')";
        $sql[] = "select @newuserid";
        $uid = $db->execForTrac($sql, 'int');
        exit($uid);*/

    }
}