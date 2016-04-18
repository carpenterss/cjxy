<?php
//将时间戳转化为星期数
function week_info($date)
{
    switch ($date) {
        case "1":
            $week_day = "星期一";
            break;
        case "2":
            $week_day = "星期二";
            break;
        case "3":
            $week_day = "星期三";
            break;
        case "4":
            $week_day = "星期四";
            break;
        case "5":
            $week_day = "星期五";
            break;
        case "6":
            $week_day = "星期六";
            break;
        case "7":
            $week_day = "星期日";
            break;
    }
    return $week_day;
}

function p($array)
{
    dump($array, 1, '<pre>', 0);
}

/**
 * TODO 基础分页的相同代码封装，使123前台的代码更少
 * @param $m 模型，引用传递
 * @param $where 查询条件
 * @param int $pagesize 每页查询条数
 * @return \Think\Page
 */
function getpage(&$m, $where, $pagesize = 10)
{
    $m1 = clone $m;//浅复制一个模型
    $count = $m->where($where)->count();//连惯操作后会对join等操作进行重置
    $m = $m1;//为保持在为定的连惯操作，浅复制一个模型
    $p = new Think\Page($count, $pagesize);
    $p->lastSuffix = false;
    $p->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录  每页<b>%LIST_ROW%</b>条  第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</li>');
    $p->setConfig('prev', '上一页');
    $p->setConfig('next', '下一页');
    $p->setConfig('last', '末页');
    $p->setConfig('first', '首页');
    $p->setConfig('theme', '%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');

    $p->parameter = I('get.');

    $m->limit($p->firstRow, $p->listRows);

    return $p;
}


function exportExcel($expTitle, $expCellName, $expTableData)
{
    $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
    $fileName = $_SESSION['account'] . date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
    $cellNum = count($expCellName);
    $dataNum = count($expTableData);
    vendor("PHPExcel.PHPExcel");

    $objPHPExcel = new PHPExcel();
    $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

    $objPHPExcel->getActiveSheet(0)->mergeCells('A1:' . $cellName[$cellNum - 1] . '1');//合并单元格
    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
    for ($i = 0; $i < $cellNum; $i++) {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '2', $expCellName[$i][1]);
    }
    // Miscellaneous glyphs, UTF-8
    for ($i = 0; $i < $dataNum; $i++) {
        for ($j = 0; $j < $cellNum; $j++) {
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 3), $expTableData[$i][$expCellName[$j][0]]);
        }
    }

    header('pragma:public');
    header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
    header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}

function num2rmb($number = 0, $int_unit = '元', $is_round = TRUE, $is_extra_zero = FALSE)
{
    // 将数字切分成两段
    $parts = explode('.', $number, 2);
    $int = isset($parts[0]) ? strval($parts[0]) : '0';
    $dec = isset($parts[1]) ? strval($parts[1]) : '';

    // 如果小数点后多于2位，不四舍五入就直接截，否则就处理
    $dec_len = strlen($dec);
    if (isset($parts[1]) && $dec_len > 2) {
        $dec = $is_round
            ? substr(strrchr(strval(round(floatval("0." . $dec), 2)), '.'), 1)
            : substr($parts[1], 0, 2);
    }

    // 当number为0.001时，小数点后的金额为0元
    if (empty($int) && empty($dec)) {
        return '零';
    }

    // 定义
    $chs = array('0', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
    $uni = array('', '拾', '佰', '仟');
    $dec_uni = array('角', '分');
    $exp = array('', '万');
    $res = '';

    // 整数部分从右向左找
    for ($i = strlen($int) - 1, $k = 0; $i >= 0; $k++) {
        $str = '';
        // 按照中文读写习惯，每4个字为一段进行转化，i一直在减
        for ($j = 0; $j < 4 && $i >= 0; $j++, $i--) {
            $u = $int{$i} > 0 ? $uni[$j] : ''; // 非0的数字后面添加单位
            $str = $chs[$int{$i}] . $u . $str;
        }
        //echo $str."|".($k - 2)."<br>";
        $str = rtrim($str, '0');// 去掉末尾的0
        $str = preg_replace("/0+/", "零", $str); // 替换多个连续的0
        if (!isset($exp[$k])) {
            $exp[$k] = $exp[$k - 2] . '亿'; // 构建单位
        }
        $u2 = $str != '' ? $exp[$k] : '';
        $res = $str . $u2 . $res;
    }

    // 如果小数部分处理完之后是00，需要处理下
    $dec = rtrim($dec, '0');

    // 小数部分从左向右找
    if (!empty($dec)) {
        $res .= $int_unit;

        // 是否要在整数部分以0结尾的数字后附加0，有的系统有这要求
        if ($is_extra_zero) {
            if (substr($int, -1) === '0') {
                $res .= '零';
            }
        }

        for ($i = 0, $cnt = strlen($dec); $i < $cnt; $i++) {
            $u = $dec{$i} > 0 ? $dec_uni[$i] : ''; // 非0的数字后面添加单位
            $res .= $chs[$dec{$i}] . $u;
        }
        $res = rtrim($res, '0');// 去掉末尾的0
        $res = preg_replace("/0+/", "零", $res); // 替换多个连续的0
    } else {
        $res .= $int_unit . '整';
    }
    return $res;
}


function calsyhkts($date, $type, $enddate)
{
    if ($type != 3) {
        $todayd = date('d');
        $todaym = date('m');
        $todayy = date('Y');
        if ($todayd < substr($date, 8, 2)) {
            return substr($date, 8, 2) - $todayd;
        } elseif ($todayd == substr($date, 8, 2)) {
            return 0;
        } else {
            return getChaBetweenTwoDate(date('Y-m-d', mktime(0, 0, 0, $todaym + 1, substr($date, 8, 2), $todayy)), date('Y-m-d'));
        }
    } else {
        return getChaBetweenTwoDate($enddate, date('Y-m-d'));
    }
}

function getChaBetweenTwoDate($date1, $date2)
{
    $Date_List_a1 = explode("-", $date1);
    $Date_List_a2 = explode("-", $date2);
    $d1 = mktime(0, 0, 0, $Date_List_a1[1], $Date_List_a1[2], $Date_List_a1[0]);
    $d2 = mktime(0, 0, 0, $Date_List_a2[1], $Date_List_a2[2], $Date_List_a2[0]);
    $Days = round(($d1 - $d2) / 3600 / 24);
    return $Days;
}

function object_array($array)
{
    if (is_object($array)) {
        $array = (array)$array;
    }
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}

function get_AI_ID()
{
    $sql = "insert into create_id (id) values('')";
    $id = M('create_id')->execute($sql);
    $id = M()->query("select * from create_id order by id desc")[0]['id'];
    return $id;
}

function guid(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = 0;// "-"
        $uuid = 0// "{"
            .substr($charid, 0, 8)
            .substr($charid, 8, 4)
            .substr($charid,12, 4)
            .substr($charid,16, 4)
            .substr($charid,20,12);
        return $uuid;
    }
}

?>