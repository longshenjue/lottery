<?php
function test()
{
    echo 'test1';
}

function the_user()
{
    return isset($_COOKIE[FOXPHP_USERCOOKIE]) ? json_decode($_COOKIE[FOXPHP_USERCOOKIE]) : false;
}

function set_user($md, $time)
{
    if ($time <= 0) {
        //注销
        setcookie(FOXPHP_USERCOOKIE, json_encode($md), time() - 100, "/");
    } else {
        setcookie(FOXPHP_USERCOOKIE, json_encode($md), time() + $time, "/");
    }
}

function is_login()
{
    if (the_user()) return true;
    return false;
}

function load_model($modelName)
{
//    $modelName = ucfirst($modelName);
    $_modelPath = FOXPHP_PATH . "/MVC/Model/mdlBase.php";
    if (!class_exists("mdlBase")) {
        require($_modelPath);
    }

    $mdlPath = FOXPHP_PATH . "/MVC/Model/" . $modelName . ".php";
    if (file_exists($mdlPath)) {
        require($mdlPath);
    }
    return new $modelName();
}

function load_db()
{
    $dbPath = FOXPHP_PATH . "/Lib/dataBase/myDataBase.php";
    if (!class_exists($dbPath)) {
        require($dbPath);
    }
    return new myDataBase();
}

function load_class($className='clsBase')
{
    $basePath = FOXPHP_PATH . "/Lib/class/clsBase.php";
    $classPath = FOXPHP_PATH . "/Lib/class/" . $className . ".php";
    require $basePath;
    require $classPath;
    return new $className();
}

function pkcs5_pad ($text, $blocksize) {  //加密时的字节填充，保持和java 一致
    $pad = $blocksize - (strlen($text) % $blocksize);
    return $text . str_repeat(chr($pad), $pad);
}
function myCrypt($input,$key) //加密 这个加解密的方法暂时不使用，可对cookie进行加解密
{
    $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
    $input =pkcs5_pad($input, $size);
    $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
    $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $data = mcrypt_generic($td, $input);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $data = base64_encode($data);
    return $data;
}
function myDecrypt($str,$key) //解密
{
    $decrypted= mcrypt_decrypt(
        MCRYPT_RIJNDAEL_128,
        $key,
        base64_decode($str),
        MCRYPT_MODE_ECB
    );

    $dec_s = strlen($decrypted);
    $padding = ord($decrypted[$dec_s-1]);
    $decrypted = substr($decrypted, 0, -$padding);
    return $decrypted;
}



 

