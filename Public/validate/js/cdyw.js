function checkcd_clppxh() {
    var name = $('input[name = cd_clppxh]').val();
    if (name == null || name == "") {
        cd_clppxh.innerHTML = "车辆品牌型号不能为空!";
        return false;
    } else {
        cd_clppxh.innerHTML = "";
        return true;
    }
}
function checkcd_cph() {
    var name = $('input[name = cd_cph]').val();
    if (name == null || name == "") {
        cd_cph.innerHTML = "车牌号不能为空!";
        return false;
    } else {
        cd_cph.innerHTML = "";
        return true;
    }
}
function checkcd_djh() {
    var name = $('input[name = cd_djh]').val();
    if (name == null || name == "") {
        cd_djh.innerHTML = "车车架号不能为空!";
        return false;
    } else {
        cd_djh.innerHTML = "";
        return true;
    }
}
function checkcd_clys() {
    var name = $('input[name = cd_clys]').val();
    if (name == null || name == "") {
        cd_clys.innerHTML = "车辆颜色不能为空!";
        return false;
    } else {
        cd_clys.innerHTML = "";
        return true;
    }
}
function checkcd_fjrq() {
    var name = $('input[name = cd_fjrq]').val();
    if (name == null || name == "") {
        cd_fjrq.innerHTML = "封籍日期不能为空!";
        return false;
    } else {
        cd_fjrq.innerHTML = "";
        return true;
    }
}
function checkcd_dkxx() {
    var name = $('input[name = cd_dkxx]').val();
    if (name == null || name == "") {
        cd_dkxx.innerHTML = "垫款信息不能为空!";
        return false;
    } else {
        cd_dkxx.innerHTML = "";
        return true;
    }
}
function checkcd_bxgsmc() {
    var name = $('input[name = cd_bxgsmc]').val();
    if (name == null || name == "") {
        cd_bxgsmc.innerHTML = "保险公司名称不能为空!";
        return false;
    } else {
        cd_bxgsmc.innerHTML = "";
        return true;
    }
}
function checkcd_bxje() {
    var name = $('input[name = cd_bxje]').val();
    if (name == null || name == "") {
        cd_bxje.innerHTML = "保险金额不能为空!";
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        cd_bxje.innerHTML = "保险金额不正确，";
        return false;
    } else {
        cd_bxje.innerHTML = "";
        return true;
    }
}
function checkcd_bdrq() {
    var name = $('input[name = cd_bdrq]').val();
    if (name == null || name == "") {
        cd_bdrq.innerHTML = "保单日期不能为空!";
        return false;
    } else {
        cd_bdrq.innerHTML = "";
        return true;
    }
}
function checkcd_clssx() {
    $("input[name='cd_bxxm']:checkbox:checked").each(function () {
        if ($(this).val() == 1) {
            var name = $('input[name = cd_clssx]').val();
            if (name == null || name == "") {
                cd_clssx.innerHTML = "车辆损失险不能为空!";
                return false;
            } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
                cd_clssx.innerHTML = "车辆损失险不正确，";
                return false;
            } else {
                cd_clssx.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    })
}
function checkcd_qcdqx() {
    $("input[name='cd_bxxm']:checkbox:checked").each(function () {
        if ($(this).val() == 2) {
            var name = $('input[name = cd_qcdqx]').val();
            if (name == null || name == "") {
                cd_qcdqx.innerHTML = "全车盗抢险不能为空!";
                return false;
            } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
                cd_qcdqx.innerHTML = "全车盗抢险不正确，";
                return false;
            } else {
                cd_qcdqx.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    })
}
function checkcd_zrssx() {
    $("input[name='cd_bxxm']:checkbox:checked").each(function () {
        if ($(this).val() == 3) {
            var name = $('input[name = cd_zrssx]').val();
            if (name == null || name == "") {
                cd_zrssx.innerHTML = "自燃损失险不能为空!";
                return false;
            } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
                cd_zrssx.innerHTML = "自燃损失险不正确，";
                return false;
            } else {
                cd_zrssx.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    })
}
function checkcd_bjmptyx() {
    $("input[name='cd_bxxm']:checkbox:checked").each(function () {
        if ($(this).val() == 4) {
            var name = $('input[name = cd_bjmptyx]').val();
            if (name == null || name == "") {
                cd_bjmptyx.innerHTML = "不计免赔特约险不能为空!";
                return false;
            } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
                cd_bjmptyx.innerHTML = "不计免赔特约险不正确，";
                return false;
            } else {
                cd_bjmptyx.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    })
}
function checkcd_qtbxje() {
    $("input[name='cd_bxxm']:checkbox:checked").each(function () {
        if ($(this).val() == 5) {
            var name = $('input[name = cd_qtbxje]').val();
            if (name == null || name == "") {
                cd_qtbxmc.innerHTML = "其他保险金额不能为空!";
                return false;
            } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
                cd_qtbxmc.innerHTML = "其他保险金额不正确";
                return false;
            } else {
                cd_qtbxmc.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    })
}
function checkcd_dkyh() {
    var name = $('input[name = cd_dkyh]').val();
    if (name == null || name == "") {
        cd_dkyh.innerHTML = "贷款银行不能为空!";
        return false;
    } else {
        cd_dkyh.innerHTML = "";
        return true;
    }
}
function checkcd_hkkh() {
    var name = $('input[name = cd_hkkh]').val();
    if (name == null || name == "") {
        cd_hkkh.innerHTML = "还款卡号不能为空!";
        return false;
    } else {
        cd_hkkh.innerHTML = "";
        return true;
    }
}
function checkcd_dkje() {
    var name = $('input[name = cd_dkje]').val();
    if (name == null || name == "") {
        cd_dkje.innerHTML = "贷款金额不能为空!";
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        cd_dkje.innerHTML = "贷款金额不正确，";
        return false;
    } else {
        cd_dkje.innerHTML = "";
        return true;
    }
}
function checkcd_dkdqr() {
    var name = $('input[name = cd_dkdqr]').val();
    if (name == null || name == "") {
        cd_dkdqr.innerHTML = "贷款到期日不能为空!";
        return false;
    } else {
        cd_dkdqr.innerHTML = "";
        return true;
    }
}
function checkcd_dkffr() {
    var name = $('input[name = cd_dkffr]').val();
    if (name == null || name == "") {
        cd_dkffr.innerHTML = "贷款发放日不能为空!";
        return false;
    } else {
        cd_dkffr.innerHTML = "";
        return true;
    }
}
function checkcd_dkbl() {
    var name = $('input[name = cd_dkbl]').val();
    if (name == null || name == "") {
        cd_dkbl.innerHTML = "贷款比例不能为空!";
        return false;
    } else {
        cd_dkbl.innerHTML = "";
        return true;
    }
}

function checkdata() {
    if (checkcd_clppxh() == false)
        return false;
    if (checkcd_cph() == false)
        return false;
    if (checkcd_djh() == false)
        return false;
    if (checkcd_clys() == false)
        return false;
    if (checkcd_fjrq() == false)
        return false;
    if (checkcd_dkxx() == false)
        return false;
    if (checkcd_bxgsmc() == false)
        return false;
    if (checkcd_bxje() == false)
        return false;
    if (checkcd_bdrq() == false)
        return false;
    if (checkcd_clssx() == false)
        return false;
    if (checkcd_qcdqx() == false)
        return false;
    if (checkcd_zrssx() == false)
        return false;
    if (checkcd_bjmptyx() == false)
        return false;
    if (checkcd_qtbxje() == false)
        return false;
    if (checkcd_dkyh() == false)
        return false;
    if (checkcd_hkkh() == false)
        return false;
    if (checkcd_dkje() == false)
        return false;
    if (checkcd_dkdqr() == false)
        return false;
    if (checkcd_dkffr() == false)
        return false;
    if (checkcd_dkbl() == false)
        return false;
    else
        return true;
}
