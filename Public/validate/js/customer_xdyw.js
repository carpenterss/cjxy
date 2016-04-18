function checkdkje() {
    var name = $('input[name = x_dkje]').val();
    if (name == null || name == "") {
        dkjenull.innerHTML = "贷款金额不能为空!";
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        dkjenull.innerHTML = "贷款金额填写不正确，";
        return false;
    } else {
        dkjenull.innerHTML = "";
        return true;
    }
}
function checklv() {
    var name = $('input[name = x_lv]').val();
    if (name == null || name == "") {
        lvnull.innerHTML = "月利率不能为空!";
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        lvnull.innerHTML = "月利率填写不正确，";
        return false;
    } else {
        lvnull.innerHTML = "";
        return true;
    }
}
//function checkqx() {
//    var name = $('input[name = x_qx]').val();
//    if (name == null || name == "") {
//        qxnull.innerHTML = "贷款期限不能为空!";
//        return false;
//    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
//        qxnull.innerHTML = "贷款期限不正确";
//        return false;
//    } else {
//        qxnull.innerHTML = "";
//        return true;
//    }
//}
function checkyt() {
    var name = $('input[name = x_yt]').val();
    if (name == null || name == "") {
        ytnull.innerHTML = "贷款用途不能为空!";
        return false;
    } else if (name.match(/([\u4e00-\u9fa5]{1,100})/) == null) {
        ytnull.innerHTML = "贷款用途不正确";
        return false;
    } else {
        ytnull.innerHTML = "";
        return true;
    }
}
//function checkfkje() {
//    var name = $('input[name = x_fkje]').val();
//    if (name == null || name == "") {
//        fkjenull.innerHTML = "放款金额不能为空!";
//        return false;
//    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
//        fkjenull.innerHTML = "放款金额填写不正确，";
//        return false;
//    } else {
//        fkjenull.innerHTML = "";
//        return true;
//    }
//}

function checkhkzh() {
    if($('input[name = x_fkfs]:checked').val() == 2) {
        var name = $('input[name = x_hkzh]').val();
        if (name == null || name == "") {
            hkzh.innerHTML = "汇款账号不能为空!";
            return false;
        } else {
            hkzh.innerHTML = "";
            return true;
        }
    }else{
        hkzh.innerHTML = "";
        return true;
    }
}
function checkdata() {
    if (checkdkje() == false)
        return false;
    if (checklv() == false)
        return false;
    if (checkyt() == false)
        return false;
    //if (checkfkje() == false)
    //    return false;
    //if (checkfkfs() == false)
    //    return false;
    //if (checksfck() == false)
    //    return false;
    //if (checkkc() == false)
    //    return false;
    else
        return true;
}
function disbutton(){
    //var x_dkje = $('input[name = x_dkje]').val();
    //var x_lv = $('input[name = x_lv]').val();
    //var x_qx = $('input[name = x_qx]').val();
    //var x_yt = $('input[name = x_yt]').val();
    //var x_fkje = $('input[name = x_fkje]').val();
    //var x_fkfs = $('input[name = x_fkfs]').val();
    //var x_sfck = $('input[name = x_sfck]').val();
    //var x_kc = $('input[name = x_kc]').val();
    //if (x_dkje == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (x_lv == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (x_qx == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (x_yt == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (x_fkje == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (x_fkfs == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (x_sfck == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (x_kc == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else {
    //    document.getElementById("send-btn").disabled = false;
    //}
}