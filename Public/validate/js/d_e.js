function checkgdxm(gdid) {
    var name = $('#gdxm' + gdid).val();
    if (name == null || name == "") {
        document.getElementById('gdxmnull' + gdid).innerHTML = "股东姓名不能为空"
        return false;
    } else {
        document.getElementById('gdxmnull' + gdid).innerHTML = " ";
        return true;
    }
}
function checkgdsfzh(gdid) {
    var name = $('#gdsfzh' + gdid).val();
    if (name == null || name == "") {
        document.getElementById('gdsfzhnull' + gdid).innerHTML = "股东身份证号不能为空"
        return false;
    } else if (!isIdCardNo(name)) {
        document.getElementById('gdsfzhnull' + gdid).innerHTML = "身份证格式不正确";
        return false;
    } else {
        document.getElementById('gdsfzhnull' + gdid).innerHTML = " ";
        return true;
    }
}


//function checkname() {
//    var name = $('input[name = d_e_name]').val();
//    if (name == null || name == "") {
//        namenull.innerHTML = "企业名称不能为空!";
//        return false;
//    } else if (name.match(/([\u4e00-\u9fa5]{1,100})/) == null) {
//        namenull.innerHTML = "企业名称不正确";
//        return false;
//    } else {
//        namenull.innerHTML = "";
//        return true;
//    }
//}
function checkyyzzh() {
    var name = $('input[name = d_e_yyzzh]').val();
    if (name == null || name == "") {
        yyzzhnull.innerHTML = "营业执照号不能为空!";
        return false;
    } else {
        yyzzhnull.innerHTML = "";
        return true;
    }
}
function checksudjzh() {
    var name = $('input[name = d_e_sudjzh]').val();
    if (name == null || name == "") {
        sudjzhnull.innerHTML = "税务登记证号不能为空!";
        return false;
    } else {
        sudjzhnull.innerHTML = "";
        return true;
    }
}
function checkzzjgdmzh() {
    var name = $('input[name = d_e_zzjgdmzh]').val();
    if (name == null || name == "") {
        zzjgdmzhnull.innerHTML = "组织机构代码证号不能为空!";
        return false;
    } else {
        zzjgdmzhnull.innerHTML = "";
        return true;
    }
}
//function checkgdxm() {
//    var name = $('input[name = d_e_gdxm]').val();
//    if (name == null || name == "") {
//        gdxm.innerHTML = "股东姓名不能为空!";
//        return false;
//    } else if (name.match(/([\u4e00-\u9fa5]{1,4})/) == null) {
//        gdxm.innerHTML = "名称不正确";
//        return false;
//    } else {
//        gdxm.innerHTML = "";
//        return true;
//    }
//}

//function checkgdsfzh() {
//    var name = $('input[name = d_e_gdsfzh]').val();
//    if (name == null || name == "") {
//        gdsfzh.innerHTML = "股东身份证号不能为空!";
//        return false;
//    }else if(!isIdCardNo(name)){
//        gdsfzh.innerHTML = "股东身份证号不正确";
//    } else {
//        gdsfzh.innerHTML = "";
//        return true;
//    }
//}

function checkfrsfzh() {
    var name = $('input[name = d_e_frsfzh]').val();
    if (name == null || name == "") {
        frsfzh.innerHTML = "法人身份证号不能为空!";
        return false;
    } else if (!isIdCardNo(name)) {
        frsfzh.innerHTML = "法人身份证号不正确";
    } else {
        frsfzh.innerHTML = "";
        return true;
    }
}

function checkfrhjzz() {
    var name = $('input[name = d_e_frhjzz]').val();
    if (name == null || name == "") {
        frhjzz.innerHTML = "法人户籍住址不能为空!";
        return false;
    } else {
        frhjzz.innerHTML = "";
        return true;
    }
}

function checkfrlxfs() {
    var name = $('input[name = d_e_frlxfs]').val();
    if (name == null || name == "") {
        frlxfs.innerHTML = "法人联系方式不能为空!";
        return false;
    } else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
        frlxfs.innerHTML = "联系方式格式不正确，座机格式：XXXX-XXXXXXXX，手机格式为XXXXXXXXXXX";
        return false;
    } else {
        frlxfs.innerHTML = "";
        return true;
    }
}
function checkfrxm() {
    var name = $("input[name = d_e_frxm]").val();
    if (name == null || name == "") {
        frxm.innerHTML = "法人姓名不能为空";
        return false;
    } else {
        frxm.innerHTML = "";
        return true;
    }
}

function checkfrpoxm() {
    if ($('input[name = d_e_frhyzk]:checked').val() == 1) {
        var name = $('input[name = d_e_frpoxm]').val();
        if (name == null || name == "") {
            frpoxm.innerHTML = "法人配偶姓名不能为空!";
            return false;
        } else {
            frpoxm.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}


function checkfrposfzh() {
    if ($('input[name = d_e_frhyzk]:checked').val() == 1) {
        var name = $('input[name = d_e_frposfzh]').val();
        if (name == null || name == "") {
            frposfzh.innerHTML = "法人配偶身份证号不能为空!";
            return false;
        } else if (!isIdCardNo(name)) {
            frposfzh.innerHTML = "法人配偶身份证号不正确"
        } else {
            frposfzh.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkfrpohjzz() {
    if ($('input[name = d_e_frhyzk]:checked').val() == 1) {
        var name = $('input[name = d_e_frpohjzz]').val();
        if (name == null || name == "") {
            frpohjzz.innerHTML = "法人配偶户籍住址不能为空!";
            return false;
        } else {
            frpohjzz.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkfrpolxfs() {
    if ($('input[name = d_e_frhyzk]:checked').val() == 1) {
        var name = $('input[name = d_e_frpolxfs]').val();
        if (name == null || name == "") {
            frpolxfs.innerHTML = "法人配偶联系方式不能为空!";
            return false;
        } else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
            frpolxfs.innerHTML = "联系方式格式不正确，座机格式：XXXX-XXXXXXXX，手机格式为XXXXXXXXXXX";
            return false;
        } else {
            frpolxfs.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}
function checkdkkh() {
    var name = $('input[name = d_e_dkkh]').val();
    if (name == null || name == "") {
        dkkh.innerHTML = "贷款卡号不能为空!";
        return false;
    } else {
        dkkh.innerHTML = "";
        return true;
    }
}

function checkkhxkzh() {
    var name = $('input[name = d_e_khxkzh]').val();
    if (name == null || name == "") {
        khxkzh.innerHTML = "银行开户许可证号不能为空!";
        return false;
    } else {
        khxkzh.innerHTML = "";
        return true;
    }
}

function checkjgxydmzh() {
    var name = $('input[name = d_e_jgxydmzh]').val();
    if (name == null || name == "") {
        jgxydmzh.innerHTML = "机构信用代码证号不能为空!";
        return false;
    } else {
        jgxydmzh.innerHTML = "";
        return true;
    }
}

function checkaqxkzhm() {
    var name = $('input[name = d_e_aqscxkzhm]').val();
    if (name == null || name == "") {
        aqxkzhm.innerHTML = "安全生产许可证号码不能为空!";
        return false;
    } else {
        aqxkzhm.innerHTML = "";
        return true;
    }
}

function checkaqscxkzmc() {
    var name = $('input[name = d_e_aqscxkzmc]').val();
    if (name == null || name == "") {
        aqscxkzmc.innerHTML = "安全生产许可证名称不能为空!";
        return false;
    } else {
        aqscxkzmc.innerHTML = "";
        return true;
    }
}

function checkpwxkzmc() {
    var name = $('input[name = d_e_pwxkzmc]').val();
    if (name == null || name == "") {
        pwxkzmc.innerHTML = "排污许可证名称不能为空!";
        return false;
    } else {
        pwxkzmc.innerHTML = "";
        return true;
    }
}

function checkpwxkzhm() {
    var name = $('input[name = d_e_pwxkzhm]').val();
    if (name == null || name == "") {
        pwxkzhm.innerHTML = "排污许可证号码不能为空!";
        return false;
    } else {
        pwxkzhm.innerHTML = "";
        return true;
    }
}

function checkfczhm() {
    var name = $('input[name = d_e_fczhm]').val();
    if (name == null || name == "") {
        fczhm.innerHTML = "房产证号码不能为空!";
        return false;
    } else {
        fczhm.innerHTML = "";
        return true;
    }
}

function checktdsyzhm() {
    var name = $('input[name = d_e_tdsyzhm]').val();
    if (name == null || name == "") {
        tdsyzhm.innerHTML = "土地使用证号码不能为空!";
        return false;
    } else {
        tdsyzhm.innerHTML = "";
        return true;
    }
}
function checkdata() {
    //if (checkname() == false)
    //    return false;
    if (checkyyzzh() == false)
        return false;
    if (checksudjzh() == false)
        return false;
    if (checkzzjgdmzh() == false)
        return false;
    if (checkfrsfzh() == false)
        return false;
    if (checkfrhjzz() == false)
        return false;
    if (checkfrlxfs() == false)
        return false;
    if (checkfrposfzh() == false)
        return false;
    if (checkfrpohjzz() == false)
        return false;
    if (checkfrpolxfs() == false)
        return false;
    //if (checkgdxm() == false)
    //    return false;
    //if (checkgdsfzh() == false)
    //    return false;
    if (checkdkkh() == false)
        return false;
  //  if (checkkhxkzh() == false)
   //     return false;
   // if (checkjgxydmzh() == false)
   //     return false;
   // if (checkaqscxkzmc() == false)
  //      return false;
  //  if (checkaqxkzhm() == false)
   //     return false;
   // if (checkpwxkzmc() == false)
  //     return false;
  //  if (checkpwxkzhm() == false)
  //      return false;
  //  if (checkfczhm() == false)
  //      return false;
  //  if (checktdsyzhm() == false)
   //     return false;
    else
        return true;
}
function disbutton() {
    //var d_e_name = $('input[name = d_e_name]').val();
    //var d_e_yyzzh = $('input[name = d_e_yyzzh]').val();
    //var d_e_sudjzh = $('input[name = d_e_sudjzh]').val();
    //var d_e_zzjgdmzh = $('input[name = d_e_zzjgdmzh]').val();
    //var d_e_frsfzh = $('input[name = d_e_frsfzh]').val();
    //var d_e_frhjzz = $('input[name = d_e_frhjzz]').val();
    //var d_e_frlxfs = $('input[name = d_e_frlxfs]').val();
    //var d_e_frposfzh = $('input[name = d_e_frposfzh]').val();
    //var d_e_frpohjzz = $('input[name = d_e_frpohjzz]').val();
    //var d_e_frpolxfs = $('input[name = d_e_frpolxfs]').val();
    //var d_e_gdxm = $('input[name = d_e_gdxm]').val();
    //var d_e_gdsfzh = $('input[name = d_e_gdsfzh]').val();
    //var d_e_dkkh = $('input[name = d_e_dkkh]').val();
    //var d_e_khxkzh = $('input[name = d_e_khxkzh]').val();
    //var d_e_jgxydmzh = $('input[name = d_e_jgxydmzh]').val();
    //var d_e_aqscxkzmc = $('input[name = d_e_aqscxkzmc]').val();
    //var d_e_aqscxkzhm = $('input[name = d_e_aqscxkzhm]').val();
    //var d_e_pwxkzmc = $('input[name = d_e_pwxkzmc]').val();
    //var d_e_pwxkzhm = $('input[name = d_e_pwxkzhm]').val();
    //var d_e_fczhm = $('input[name = d_e_fczhm]').val();
    //var d_e_tdsyzhm = $('input[name = d_e_tdsyzhm]').val();
    //if (d_e_name == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_yyzzh == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_sudjzh == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_zzjgdmzh == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_frsfzh == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_frhjzz == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_frlxfs == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_frposfzh == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_frpohjzz == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_frpolxfs == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_gdxm == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_gdsfzh == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_dkkh == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_khxkzh == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_jgxydmzh == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_aqscxkzmc == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_aqscxkzhm == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_pwxkzmc == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_pwxkzhm == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_fczhm == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_tdsyzhm == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_e_frposfzh == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else {
    //    document.getElementById("send-btn").disabled = false;
    //}
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
