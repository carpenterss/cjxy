function checkqpxm(qpid) {
    var name = $('#qpxm' + qpid).val();
    if (name == null || name == "") {
        document.getElementById('qpxmnull' + qpid).innerHTML = "关系人姓名不能为空"
        return false;
    } else {
        document.getElementById('qpxmnull' + qpid).innerHTML = " ";
        return true;
    }
}
function checkqpgx(qpid) {
    var name = $('#qpgx' + qpid).val();
    if (name == null || name == "") {
        document.getElementById('qpgxnull' + qpid).innerHTML = "关系人关系不能为空"
        return false;
    } else {
        document.getElementById('qpgxnull' + qpid).innerHTML = " ";
        return true;
    }
}
function checkqplxfs(qpid) {
    var name = $('#qplxfs' + qpid).val();
    if (name == null || name == "") {
        document.getElementById('qplxfsnull' + qpid).innerHTML = "关系人联系方式不能为空"
        return false;
    } else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
        document.getElementById('qplxfsnull' + qpid).innerHTML = "联系方式格式不正确，座机格式：XXXX-XXXXXXXX，手机格式为XXXXXXXXXXX";
        return false;
    } else {
        document.getElementById('qplxfsnull' + qpid).innerHTML = " ";
        return true;
    }
}

function checkfwxm(fwid) {
    var name = $('#fwxm' + fwid).val();
    if (name == null || name == "") {
        document.getElementById('fwxmnull' + fwid).innerHTML = "房屋性质不能为空"
        return false;
    } else {
        document.getElementById('fwxmnull' + fwid).innerHTML = "";
        return true;
    }
}
function checkfwgx(fwid) {
    var name = $('#fwgx' + fwid).val();
    if (name == null || name == "") {
        document.getElementById('fwgxnull' + fwid).innerHTML = "房屋位置不能为空"
        return false;
    } else {
        document.getElementById('fwgxnull' + fwid).innerHTML = "";
        return true;
    }
}
function checkfwlxfs(fwid) {
    var name = $('#fwlxfs' + fwid).val();
    if (name == null || name == "") {
        document.getElementById('fwlxfsnull' + fwid).innerHTML = "房屋价值不能为空"
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        document.getElementById('fwlxfsnull' + fwid).innerHTML = "房屋价值不正确";
        return false;
    } else {
        document.getElementById('fwlxfsnull' + fwid).innerHTML = "";
        return true;
    }
}

function checkclxh(clid) {
    var name = $('#clxh' + clid).val();
    if (name == null || name == "") {
        document.getElementById('clxhnull' + clid).innerHTML = "车辆型号不能为空"
        return false;
    } else {
        document.getElementById('clxhnull' + clid).innerHTML = "";
        return true;
    }
}
function checkclnx(clid) {
    var name = $('#clnx' + clid).val();
    if (name == null || name == "") {
        document.getElementById('clnxnull' + clid).innerHTML = "车辆年限不能为空"
        return false;
    } else {
        document.getElementById('clnxnull' + clid).innerHTML = "";
        return true;
    }
}
function checkcljz(clid) {
    var name = $('#cljz' + clid).val();
    if (name == null || name == "") {
        document.getElementById('cljznull' + clid).innerHTML = "车辆价值不能为空"
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        document.getElementById('cljznull' + clid).innerHTML = "房屋价值不正确";
        return false;
    } else {
        document.getElementById('cljznull' + clid).innerHTML = "";
        return true;
    }
}


function checkname() {
    var name = $('input[name = d_p_name]').val();
    if (name == null || name == "") {
        namenull.innerHTML = "姓名不能为空!";
        return false;
    } else {
        namenull.innerHTML = "";
        return true;
    }
}

function checkidcard() {
    var name = $('input[name = d_p_idcard]').val();
    if (name == null || name == "") {
        idcard.innerHTML = "身份证不能为空!";
        return false;
    } else if (!isIdCardNo(name)) {
        idcard.innerHTML = "身份证格式不正确";
        return false;
    } else {
        idcard.innerHTML = "";
        return true;
    }
}

function checkmz() {
    var name = $('input[name = d_p_mz]').val();
    if (name == null || name == "") {
        mz.innerHTML = "民族不能为空!";
        return false;
    } else if (name.match(/([\u4e00-\u9fa5]{1,10})/) == null) {
        mz.innerHTML = "民族不正确";
        return false;
    } else {
        mz.innerHTML = "";
        return true;
    }
}

function checkjkzk() {
    var name = $('input[name = d_p_jkzk]').val();
    if (name == null || name == "") {
        jkzk.innerHTML = "健康状况不能为空!";
        return false;
    } else {
        jkzk.innerHTML = "";
        return true;
    }
}

function checkgzdw() {
    var name = $('input[name = d_p_gzdw]').val();
    if (name == null || name == "") {
        gzdw.innerHTML = "工作单位不能为空!";
        return false;
    } else {
        gzdw.innerHTML = "";
        return true;
    }
}

function checkzw() {
    var name = $('input[name = d_p_zw]').val();
    if (name == null || name == "") {
        zw.innerHTML = "职务不能为空!";
        return false;
    } else {
        zw.innerHTML = "";
        return true;
    }
}

function checkhkzz() {
    var name = $('input[name = d_p_hkzz]').val();
    if (name == null || name == "") {
        hkzz.innerHTML = "户口所在地不能为空!";
        return false;
    } else {
        hkzz.innerHTML = "";
        return true;
    }
}

function checksfzzz() {
    var name = $('input[name = d_p_sfzzz]').val();
    if (name == null || name == "") {
        sfzzz.innerHTML = "身份证所在地不能为空!";
        return false;
    } else {
        sfzzz.innerHTML = "";
        return true;
    }
}

function checksjzz() {
    var name = $('input[name = d_p_sjzz]').val();
    if (name == null || name == "") {
        sjzz.innerHTML = "实际住址不能为空!";
        return false;
    } else {
        sjzz.innerHTML = "";
        return true;
    }
}

function checklxfs() {
    var name = $('input[name = d_p_lxfs]').val();
    if (name == null || name == "") {
        lxfs.innerHTML = "联系方式不能为空!";
        return false;
    } else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
        lxfs.innerHTML = "联系方式格式不正确，座机格式：XXXX-XXXXXXXX，手机格式为XXXXXXXXXXX";
        return false;
    } else {
        lxfs.innerHTML = "";
        return true;
    }
}

function checkpoxm() {
    if ($('input[name = d_p_hyzk]:checked').val() == 0) {
        var name = $('input[name = d_p_poxm]').val();
        if (name == null || name == "") {
            poxm.innerHTML = "配偶姓名不能为空!";
            return false;
        

        } else {
            poxm.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkposfzh() {
    if ($('input[name = d_p_hyzk]:checked').val() == 0) {
        var name = $('input[name = d_p_posfzh]').val();
        if (name == null || name == "") {
            posfzh.innerHTML = "配偶身份证不能为空!";
            return false;
        }
        else if (!isIdCardNo(name)) {
            posfzh.innerHTML = "身份证不正确";
            return false;
        } else {
            posfzh.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkpolxfs() {
    if ($('input[name = d_p_hyzk]:checked').val() == 0) {
        var name = $('input[name = d_p_polxfs]').val();
        if (name == null || name == "") {
            polxfs.innerHTML = "配偶联系方式不能为空!";
            return false;
        }
        else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
            polxfs.innerHTML = "联系方式不正确";
            return false;
        } else {
            polxfs.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkposr() {
    if ($('input[name = d_p_hyzk]:checked').val() == 0) {
        var name = $('input[name = d_p_posr]').val();
        if (name == null || name == "") {
            posr.innerHTML = "配偶年收入不能为空!";
            return false;
        } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
            posr.innerHTML = "收入填写不正确，";
            return false;
        } else {
            posr.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkpogzqk() {
    if ($('input[name = d_p_hyzk]:checked').val() == 0) {
        var name = $('input[name = d_p_pogzqk]').val();
        if (name == null || name == "") {
            pogzqk.innerHTML = "配偶工作情况不能为空!";
            return false;
        } else {
            pogzqk.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkpozw() {
    if ($('input[name = d_p_hyzk]:checked').val() == 0) {
        var name = $('input[name = d_p_pozw]').val();
        if (name == null || name == "") {
            pozw.innerHTML = "配偶职务不能为空!";
            return false;
        } else {
            pozw.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}
//
//function checkmxzc() {
//    var name = $('input[name = d_p_mxzc]').val();
//    if (name == null || name == "") {
//        mxzc.innerHTML = "名下资产不能为空!";
//        return false;
//    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
//        mxzc.innerHTML = "资产填写不正确，";
//        return false;
//    } else {
//        mxzc.innerHTML = "";
//        return true;
//    }
//}

function checkyhck() {
    var name = $('input[name = d_p_yhck]').val();
    if (name == null || name == "") {
        yhck.innerHTML = "银行存款不能为空!";
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        yhck.innerHTML = "银行存款填写不正确，";
        return false;
    } else {
        yhck.innerHTML = "";
        return true;
    }
}

//function checkfwxz() {
//    var name = $('input[name = d_p_fwxz]').val();
//    if (name == null || name == "") {
//        fwxz.innerHTML = "房屋性质不能为空!";
//        return false;
//    } else {
//        fwxz.innerHTML = "";
//        return true;
//    }
//}

//function checkfwxqjz() {
//    var name = $('input[name = d_p_fwxqjz]').val();
//    if (name == null || name == "") {
//        fwxqjz.innerHTML = "房屋小区价值不能为空!";
//        return false;
//    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
//        fwxqjz.innerHTML = "房屋小区价值填写不正确，";
//        return false;
//    } else {
//        fwxqjz.innerHTML = "";
//        return true;
//    }
//}
//
//function checkclxhjz() {
//    var name = $('input[name = d_p_clxhjz]').val();
//    if (name == null || name == "") {
//        clxhjz.innerHTML = "车辆型号及价值不能为空!";
//        return false;
//    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
//        clxhjz.innerHTML = "车辆型号及价值填写不正确，";
//        return false;
//    } else {
//        clxhjz.innerHTML = "";
//        return true;
//    }
//}

function checkjtqtsr() {
    var name = $('input[name = d_p_jtqtsr]').val();
    if (name == null || name == "") {
        jtqtsr.innerHTML = "家庭其他收入不能为空!";
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        jtqtsr.innerHTML = "家庭其他收入填写不正确，";
        return false;
    } else {
        jtqtsr.innerHTML = "";
        return true;
    }
}

//function checkjtqtsrbz() {
//    var name = $('input[name = d_p_jtqtsrbz]').val();
//    if (name == null || name == "") {
//        jtqtsrbz.innerHTML = "家庭其他收入备注不能为空!";
//        return false;
//    } else {
//        jtqtsrbz.innerHTML = "";
//        return true;
//    }
//}

//function checkxyked() {
//    var name = $('input[name = d_p_xyked]').val();
//    if (name == null || name == "") {
//        xyked.innerHTML = "信用卡额度收入不能为空!";
//        return false;
//    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
//        xyked.innerHTML = "信用卡额度填写不正确，";
//        return false;
//    } else {
//        xyked.innerHTML = "";
//        return true;
//    }
//}

//function checkxykfz() {
//    var name = $('input[name = d_p_xykfz]').val();
//    if (name == null || name == "") {
//        xykfz.innerHTML = "信用卡负债收入不能为空!";
//        return false;
//    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
//        xykfz.innerHTML = "信用卡负债填写不正确，";
//        return false;
//    } else {
//        xykfz.innerHTML = "";
//        return true;
//    }
//}

//function checkyhajdk() {
//    var name = $('input[name = d_p_yhajdk]').val();
//    if (name == null || name == "") {
//        yhajdk.innerHTML = "银行按揭余额收入不能为空!";
//        return false;
//    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
//        yhajdk.innerHTML = "银行按揭余额填写不正确，";
//        return false;
//    } else {
//        yhajdk.innerHTML = "";
//        return true;
//    }
//}

//function checkmjjd() {
//    var name = $('input[name = d_p_mjjd]').val();
//    if (name == null || name == "") {
//        mjjd.innerHTML = "民间借贷余额收入不能为空!";
//        return false;
//    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
//        mjjd.innerHTML = "民间借贷余额款填写不正确，";
//        return false;
//    } else {
//        mjjd.innerHTML = "";
//        return true;
//    }
//}

//function checkdwdbqk() {
//    var name = $('input[name = d_p_dwdbqk]').val();
//    if (name == null || name == "") {
//        dwdbqk.innerHTML = "对外担保额度不能为空!";
//        document.getElementById('send-btn').disabled = true;
//        return false;
//    } else {
//        dwdbqk.innerHTML = "";
//        return true;
//    }
//}

//function checkfwsl() {
//    var name = $('input[name = x_p_fwsl]').val();
//    if (name == null || name == "") {
//        fwsl.innerHTML = "房屋数量不能为空!";
//        return false;
//    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
//        fwsl.innerHTML = "房屋数量填写不正确，";
//        return false;
//    } else {
//        fwsl.innerHTML = "";
//        return true;
//    }
//}

function checkjtzhnsr() {
    var name = $('input[name = d_p_jtzhnsr]').val();
    if (name == null || name == "") {
        jtzhnsr.innerHTML = "家庭综合收入不能为空!";
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        jtzhnsr.innerHTML = "家庭综合收入填写不正确，";
        return false;
    } else {
        jtzhnsr.innerHTML = "";
        return true;
    }
}

function checkdata() {
    if (checkjtqtsr() == false)
        return false;
    if (checkname() == false)
        return false;
    if (checkidcard() == false)
        return false;
    if (checkmz() == false)
        return false;
    if (checkjkzk() == false)
        return false;
    if (checkgzdw() == false)
        return false;
    if (checkzw() == false)
        return false;
    if (checkhkzz() == false)
        return false;
    if (checksfzzz() == false)
        return false;
    if (checksjzz() == false)
        return false;
    if (checklxfs() == false)
        return false;

    if (checkyhck() == false)
        return false;
    //if (checkfwxz() == false)
    //    return false;
    //if (checkfwxqjz() == false)
    //    return false;
    //if (checkclxhjz() == false)
    //    return false;
    if (checkjtqtsr() == false)
        return false;
    //if (checkjtqtsrbz() == false)
    //    return false;
    //if (checkxyked() == false)
    //    return false;
    //if (checkxykfz() == false)
    //    return false;
    //if (checkyhajdk() == false)
    //    return false;
    //if (checkmjjd() == false)
    //    return false;
    //if (checkdwdbqk() == false)
    //    return false;
    if (checkpoxm() == false)
        return false;
    if (checkposfzh() == false)
        return false;
    if (checkpolxfs() == false)
        return false;
    if (checkposr() == false)
        return false;
    if (checkpogzqk() == false)
        return false;
    if (checkpozw() == false)
        return false;
    else
        return true;
}


function isIdCardNo(num) {
    num = num.toUpperCase();
    if (!(/(^\d{15}$)|(^\d{17}([0-9]|X)$)/.test(num))) {
        return false;
    }
    var len, re;
    len = num.length;
    if (len == 15) {
        re = new RegExp(/^(\d{6})(\d{2})(\d{2})(\d{2})(\d{3})$/);
        var arrSplit = num.match(re);
        var dtmBirth = new Date('19' + arrSplit[2] + '/' + arrSplit[3] + '/' + arrSplit[4]);
        var bGoodDay;
        bGoodDay = (dtmBirth.getYear() == Number(arrSplit[2])) && ((dtmBirth.getMonth() + 1) == Number(arrSplit[3])) && (dtmBirth.getDate() == Number(arrSplit[4]));
        if (!bGoodDay) {
            return false;
        }
        else {
            var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
            var nTemp = 0, i;
            num = num.substr(0, 6) + '19' + num.substr(6, num.length - 6);
            for (i = 0; i < 17; i++) {
                nTemp += num.substr(i, 1) * arrInt[i];
            }
            num += arrCh[nTemp % 11];
            return num;
        }
    }
    if (len == 18) {
        re = new RegExp(/^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/);
        var arrSplit = num.match(re);
        var dtmBirth = new Date(arrSplit[2] + "/" + arrSplit[3] + "/" + arrSplit[4]);
        var bGoodDay;
        bGoodDay = (dtmBirth.getFullYear() == Number(arrSplit[2])) && ((dtmBirth.getMonth() + 1) == Number(arrSplit[3])) && (dtmBirth.getDate() == Number(arrSplit[4]));
        if (!bGoodDay) {
            alert(dtmBirth.getYear());
            alert(arrSplit[2]);
            return false;
        }
        else {
            var valnum;
            var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
            var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
            var nTemp = 0, i;
            for (i = 0; i < 17; i++) {
                nTemp += num.substr(i, 1) * arrInt[i];
            }
            valnum = arrCh[nTemp % 11];
            if (valnum != num.substr(17, 1)) {
                return false
            }
            return num;
        }
    }
    return false;
}

