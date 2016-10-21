<div>卡片收集</div>
<?php
if (isset($gameInfo)) {
    echo $gameInfo;
}
echo '<br/>';
if (isset($userInfo)) {
    foreach ($userInfo as $key => $data) {
        $info = $data?"已获得":"未获得";
        echo '卡片'.$key.':'. $info . '<br/>';
    }
}
?>
<script type="text/javascript" src="/lottery/plugins/kiana/kiana.js"></script>
