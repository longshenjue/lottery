<?php
$foreach_id = array();
function foreach_callback($match)
{
    $id = md5(uniqid());
    global $foreach_id;
    $foreach_id[] = $id;
    return "<{" . $match[1] . ":" . $id;
}

function strong($str)
{
    return "<b style='color: red'>$str</b>";
}

function myIf($str)
{
    return eval("return $str;");
}

class ctlBase
{
    public $_view = "index";//模版名称
    public $_vars = array();//变量保存器

    function setView($viewName)
    {
        $this->_view = $viewName;
    }

    function getView()
    {
        return FOXPHP_PATH . "/MVC/View/default/" . $this->_view . FOXPHP_VIEWEXT;
    }

    function setVar($varName, $varValue)
    {
        $this->_vars[$varName] = $varValue;
    }

    function run()//执行Control 加载模版和变量解包
    {
        //解包我们的变量
        extract($this->_vars);

        ob_start();
        //加载头部模版
        include(FOXPHP_PATH . "/MVC/View/default/" . FOXPHP_VIEWHEADER . FOXPHP_VIEWEXT);
        //记载模版
        include($this->getView());
        //加载尾部模版
        include(FOXPHP_PATH . "/MVC/View/default/" . FOXPHP_VIEWFOOTER . FOXPHP_VIEWEXT);

        $tpl = ob_get_contents();
        ob_clean();
        $this->_vars['a'] = 'test A !';
        $this->_vars['usernName'] = 'ting';

        $tpl = $this->getForeachVars($tpl);
        $tpl = $this->getSimpleVars($tpl);

        echo $tpl;
//        $file_name = str_replace('/', '_' , $_SERVER['REQUEST_URI']) . md5($_SERVER['REQUEST_URI']);
//        if (file_exists("foxphp/cache/" . $file_name)) {
//            echo file_get_contents("foxphp/cache/" . $file_name);
//        } else {
//            file_put_contents("foxphp/cache/" . $file_name, $tpl);
//            echo $tpl;
//        }
    }

    function getSimpleVars($tpl)
    {
        $pattern = "/<\{\\$(\w{1,20})\}>/is";
        if (preg_match_all($pattern, $tpl, $result)) {
            $ret = $result[1];
            foreach ($ret as $item) {
                if (array_key_exists($item, $this->_vars)) {
                    $replacePattern = "/<\{\\$" . $item . "\}>/is";
                    $tpl = preg_replace($replacePattern, $this->_vars[$item], $tpl);
                }
            }
        }
        return $tpl;
    }

    function getForeachVars($tpl)
    {
        global $foreach_id;
        //对每一个foreach 加上一个唯一标示符
        $tpl = preg_replace_callback("/<{(foreach)/is", "foreach_callback", $tpl);
//        $foreach_id = array_reverse($foreach_id);
        foreach ($foreach_id as $fid) {
            if (preg_match_all("/<\{foreach:" . $fid . "\s+data=(?<varObject>\w{1,20})\s+item=(?<varItem>\w{1,20})\s+key=(?<varKey>\w{1,20})/is", $tpl, $result)) {
                $finalResult = "";
                $varObject = $result["varObject"][0];
                $varItem = $result["varItem"][0];
                $varKey = $result["varKey"][0];

                if (array_key_exists($varObject, $this->_vars)) {
                    $pattern = "/<{foreach:" . $fid . "\s+data=" . $varObject . ".*?}>(?<replaceCnt>.*?)<{\/foreach}>/is";

                    preg_match($pattern, $tpl, $cntReuslt);
                    $cntReuslt = $cntReuslt["replaceCnt"];//需要被替换的内容

                    foreach ($this->_vars[$varObject] as $key => $row) {
                        $tmp = $this->replaceForeachVar($cntReuslt, $varItem, $key, $row, $fid);
                        $tmp = $this->replaceIf($tmp, $varItem, $row);
                        $finalResult .= $tmp;
                    }
                }
//                echo $finalResult;exit();
                //替换最终的某个 foreach的值
                $tpl = preg_replace("/<{foreach:" . $fid . "\s+data=" . $varObject . ".*?}>.*?<{\/foreach}>/is", $finalResult, $tpl);
            }
        }
        return $tpl;
    }

    function genForeach($tplCnt)//解析循环标签
    {
        global $foreach_id;
        //对每一个foreach 加上一个唯一标示符
        $tplCnt = preg_replace_callback("/{(foreach):(\w{1,30})/is", "foreach_callback", $tplCnt);

        $foreach_id = array_reverse($foreach_id);
        foreach ($foreach_id as $fid) {
            if (preg_match_all("/{foreach:(?<varObject>\w{1,30}?):" . $fid . "\s+name=\"(?<varName>[a-zA-Z]{1,30}?)\"}/is", $tplCnt, $result)) {
                $finalResult = "";
                $varObject = $result["varObject"][0];
                $varName = $result["varName"][0];

                if (array_key_exists($varObject, $this->_vars)) {
                    $pattern = "/{foreach:" . $varObject . ":"
                        . $fid . "\s+.*?}(?<replaceCnt>.*?){\/endforeach}/is";

                    preg_match($pattern, $tplCnt, $cntReuslt);
                    // var_export($cntReuslt);
                    $cntReuslt = $cntReuslt["replaceCnt"];//需要被替换的内容


                    // echo ($cntReuslt);
                    // continue;
                    foreach ($this->_vars[$varObject] as $row) {
                        $tmp = $this->replaceForeachVar($cntReuslt, $varName, $row, $fid);


                        $finalResult .= $tmp;

                    }
                }
                //echo $finalResult;exit();
                //替换最终的某个 foreach的值
                $tplCnt = preg_replace('/{foreach:' . $varObject . ':'
                    . $fid . '\s+.*?}.*?{\/endforeach}/is', $finalResult, $tplCnt);

            }
        }

        //	var_export($foreach_id);
        return $tplCnt;
    }

    function replaceForeachVar($cnt, $varItem, $key, $row, $fid)
    {
        //替换循环 内部内容
        if (preg_match_all("/<{\\$" . $varItem . "\.(?<varValue>\w{1,30})}>/is", $cnt, $result)) {
//            $varValue = $result["varValue"];
            $result = $result[1];
        }
        foreach ($result as $r) {
            if ($row[$r]) {
                $cnt = preg_replace("/<{\\$" . $varItem . "\." . $r . "}>/is",
                    $row[$r], $cnt);

//                if ($varValue == trim($r)) {//代表没有函数
//                    $cnt = preg_replace("/<{\\$" . $varItem . "\." . $varValue . "}>/is",
//                        $row[$varValue], $cnt);
//                } else {//代表有函数
//                    $newr = preg_replace("/<{\\$" . $varItem . "\." . $varValue . "}>/is",
//                        $row[$varValue], $r);
//                    eval('$last=' . $newr . ";");
//                    if ($last) {
//                        $cnt = str_replace("{" . $r . "}",
//                            $last, $cnt);
//                    }
//                }
            }
        }
        if (strstr($cnt, "strong(")) {
            $pattern_strong = "/strong\((?<strong>\w+)\)/is";

            if (preg_match_all($pattern_strong, $cnt, $result)) {
                $replacement = $result['strong'][0];
            }
            eval("\$last=strong(\$replacement);");
            $cnt = preg_replace($pattern_strong, $last, $cnt);
        }
        return $cnt;
    }

    function replaceIf($cnt)
    {
        if (strstr($cnt, "<{if")) {
            $pattern_if = "/<{if\((?<if>.+)\)}>/is";

            if (preg_match_all($pattern_if, $cnt, $result)) {
                $replacement = $result['if'][0];
            }
            eval("\$if=myIf(\$replacement);");
            $pattern = "/<{if.*?}>(.*?)<{\/if}>/is";
            if (isset($if) && $if) {
                $cnt = preg_replace($pattern, '$1', $cnt);
            } else {
                $cnt = preg_replace($pattern, '', $cnt);
            }
        }
        return $cnt;
    }


    function __get($name)
    {
        return load_class($name);
    }
}
