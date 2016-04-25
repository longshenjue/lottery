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