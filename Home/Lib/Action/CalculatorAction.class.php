<?php

class CalculatorAction extends CommonAction
{
    public function calculator()
    {
        $Uid = $_SESSION['UserId'];
        $x_p_customer = M("x_p_customer");
        $x_e_customer = M("x_e_customer");
        $x_p_sql = "select x_p_name,x_p_idcrad,x_dkje,x_qx,x_lv,x_hkfs  from oa_x_p_customer inner join oa_xdbusiness where oa_x_p_customer.id=x_id and x_hkdj<>5 ";
        $x_e_sql = "select x_e_name,x_e_yyzzh,x_dkje,x_qx,x_lv,x_hkfs  from oa_x_e_customer inner join oa_xdbusiness where oa_x_e_customer.id=x_id and x_hkdj<>5 ";
        $p_info = $x_p_customer->query($x_p_sql);
        $e_info = $x_e_customer->query($x_e_sql);
        $this->assign('p_info', $p_info);
        $this->assign('e_info', $e_info);
        $this->assign('p_all_info', json_encode($e_info));
        $this->assign('e_all_info', json_encode($e_info));
        $this->display();
    }

    public function printcal()
    {
        $html = I('html');
        // 设置名称
        $filename = 'jisuanqi.xls';
        // 文档类型
        header("Content-Type: application/vnd.ms-excel");
        // 附件
        header("Content-Disposition: attachment; filename=".$filename);
        // 缓存控制
        header('Cache-Control: max-age=0');
        exit($html);
    }
}