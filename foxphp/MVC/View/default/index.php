<?php
/**
 * Created by PhpStorm.
 * User: yuting
 * Date: 2015/8/27
 * Time: 10:51
 */
if (isset($UserStatus)) {
    echo $UserStatus;
}
if (isset($title)) {
    echo $title.'<br/>';
}
?>
<div class="row clearfix">
    <div class="col-md-12 column">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#">首页</a>
            </li>
            <li>
                <a href="#">资料</a>
            </li>
            <li class="disabled">
                <a href="#">消息</a>
            </li>
            <li class="dropdown pull-right">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">下拉菜单<strong class="caret"></strong></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#">列表一</a>
                    </li>
                    <li>
                        <a href="#">列表二</a>
                    </li>
                    <li>
                        <a href="#">列表三</a>
                    </li>
                    <li class="divider">
                    </li>
                    <li>
                        <a href="#">更多列表</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
用户名：<?=$user->username;?><br/>
<{$usernName}> <{$a}> <!-- 简单的变量替换 -->
<br/>
<div>
<{foreach data=userList item=item key=key}>
    <{if(<{$item.id}>=='123')}>
        ID: strong(<{$item.id}>)<hr/>
        NAME: <{$item.name}><hr/>
    <{/if}>
<{/foreach}>
</div>
<br/>


这是一个首页
<form action="/lottery/login" method="post">
    user:<input type="text" value="" name="user"/>
    pwd:<input type="text" value="" name="pwd"/>
    <input type="submit" value="登录"/>
    <input type="hidden" class="j-visitor" name="visitor" value="0"/>
    <input type="submit" class="j-visitorLogin" value="游客登录"/>
</form>

<script>
    $('.j-visitorLogin').click(function(){
        $('.j-visitor').val(1);
    });
</script>