
//function checkfwdx() {
//    var name = $('input[name = d_fwdx]').val();
//    if (name == null || name == "") {
//        fwdx.innerHTML = "房屋大小不能为空!";
//        return false;
//    } else {
//        fwdx.innerHTML = "";
//        return true;
//    }
//}
function checkdkyh() {
    var name = $('input[name = d_hzyh]').val();
    if (name == null || name == "") {
        dkyh.innerHTML = "贷款银行不能为空!";
        return false;
    } else {
        dkyh.innerHTML = "";
        return true;
    }
}
function checkdkje() {
    var name = $('input[name = d_dkje]').val();
    if (name == null || name == "") {
        dkje.innerHTML = "贷款金额不能为空!";
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        dkje.innerHTML = "贷款金额填写不正确，";
        return false;
    } else {
        dkje.innerHTML = "";
        return true;
    }
}
//function checkfl() {
//    var name = $('input[name = d_fl]').val();
//    if (name == null || name == "") {
//        fl.innerHTML = "房龄不能为空!";
//        return false;
//    } else {
//        fl.innerHTML = "";
//        return true;
//    }
//}
//function checkzldd() {
//    var name = $('input[name = d_zldd]').val();
//    if (name == null || name == "") {
//        zldd.innerHTML = "坐落地点不能为空!";
//        return false;
//    } else {
//        zldd.innerHTML = "";
//        return true;
//    }
//}
//function checksqrnl() {
//    var name = $('input[name = d_sqrnl]').val();
//    if (name == null || name == "") {
//        sqrnl.innerHTML = "申请人年龄不能为空!";
//        return false;
//
//    } else {
//        sqrnl.innerHTML = "";
//        return true;
//    }
//}
//function checksqrsr() {
//    var name = $('input[name = d_sqrsr]').val();
//    if (name == null || name == "") {
//        sqrsr.innerHTML = "申请人收入不能为空!";
//        return false;
//    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
//        sqrsr.innerHTML = "申请人收入填写不正确，";
//        return false;
//    } else {
//        sqrsr.innerHTML = "";
//        return true;
//    }
//}
//function checksqrgzdd() {
//    var name = $('input[name = d_sqrgzdd]').val();
//    if (name == null || name == "") {
//        sqrgzdd.innerHTML = "申请人工作地点不能为空!";
//        return false;
//    } else {
//        sqrgzdd.innerHTML = "";
//        return true;
//    }
//}
//function checkdkzsyt() {
//    var name = $('input[name = d_dkzsyt]').val();
//    if (name == null || name == "") {
//        dkzsyt.innerHTML = "贷款真实用途不能为空!";
//        return false;
//    } else {
//        dkzsyt.innerHTML = "";
//        return true;
//    }
//}
//function checkgthkrnl() {
//    var name = $('input[name = d_gthkrnl]').val();
//    if (name == null || name == "") {
//        gthkrnl.innerHTML = "共同还款人年龄不能为空!";
//        return false;
//    } else {
//        gthkrnl.innerHTML = "";
//        return true;
//    }
//}
//function checkgthkrsr() {
//    var name = $('input[name = d_gthkrsr]').val();
//    if (name == null || name == "") {
//        gthkrsr.innerHTML = "共同还款人收入不能为空!";
//        return false;
//    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
//        gthkrsr.innerHTML = "共同还款人收入填写不正确，";
//        return false;
//    } else {
//        gthkrsr.innerHTML = "";
//        return true;
//    }
//}
//function checkgthkrgzdd() {
//    var name = $('input[name = d_gthkrgzdd]').val();
//    if (name == null || name == "") {
//        gthkrgzdd.innerHTML = "共同还款人工作地点不能为空!";
//        return false;
//    } else {
//        gthkrgzdd.innerHTML = "";
//        return true;
//    }
//}
function checkdblv() {
    var name = $('input[name = d_dblv]').val();
    if (name == null || name == "") {
        dblv.innerHTML = "担保利率不能为空!";
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        dblv.innerHTML = "担保利率填写不正确，";
        return false;
    } else {
        dblv.innerHTML = "";
        return true;
    }
}
function checkdbf() {
    var name = $('input[name = d_dbf]').val();
    if (name == null || name == "") {
        dbf.innerHTML = "担保费不能为空!";
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        dbf.innerHTML = "担保费填写不正确，";
        return false;
    } else {
        dbf.innerHTML = "";
        return true;
    }
}
function checkbzj() {
    var name = $('input[name = d_bzj]').val();
    if (name == null || name == "") {
        bzj.innerHTML = "保证金不能为空!";
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        bzj.innerHTML = "保证金填写不正确，";
        return false;
    } else {
        bzj.innerHTML = "";
        return true;
    }
}
function checkdata() {
    //if (checksqzl() == false)
    //    return false;
    if(checkdkje() == false)
        return false;
    if(checkdkyh() == false)
        return false;
    //if (checkfwdx() == false)
    //    return false;
    //if (checkfl() == false)
    //    return false;
    //if (checkzldd() == false)
    //    return false;
    //if (checksqrnl() == false)
    //    return false;
    //if (checksqrsr() == false)
    //    return false;
    //if (checksqrgzdd() == false)
    //    return false;
    //if (checkdkzsyt() == false)
    //    return false;
    //if (checkgthkrnl() == false)
    //    return false;
    //if (checkgthkrsr() == false)
    //    return false;
    //if (checkgthkrgzdd() == false)
    //    return false;
    if (checkdblv() == false)
        return false;
    if (checkdbf() == false)
        return false;
    if (checkbzj() == false)
        return false;
    else
        return true;
}
function disbutton(){
    //var d_sqzl = $('input[name = d_sqzl]').val();
    //var d_fwpgbg = $('input[name = d_fwpgbg]').val();
    //var d_fwdx = $('input[name = d_fwdx]').val();
    //var d_fl = $('input[name= d_fl]').val();
    //var d_zldd = $('input[name = d_zldd]').val();
    //var d_sqrnl = $('input[name = d_sqrnl]').val();
    //var d_sqrsr = $('input[name = d_sqrsr]').val();
    //var d_sqrgzdd = $('input[name = d_sqrgzdd]').val();
    //var d_dkzsyt = $('input[name = d_dkzsyt]').val();
    //var d_gthkrnl = $('input[name = d_gthkrnl]').val();
    //var d_gthkrsr = $('input[name = d_gthkrsr]').val();
    //var d_gthkrgzdd = $('input[name = d_gthkrgzdd]').val();
    //var d_dbf = $('input[name = d_dbf]').val();
    //var d_bzj = $('input[name = d_bzj]').val();
    //var d_dblv = $('input[name = d_dblv]').val();
    //if (d_sqzl == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_fwpgbg == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_fwdx == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_fl == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_zldd == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_sqrnl == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_sqrsr == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_sqrgzdd == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_dkzsyt == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_gthkrnl == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_gthkrsr == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_gthkrgzdd == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_dbf == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_bzj == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else if (d_dblv == "") {
    //    document.getElementById("send-btn").disabled = true;
    //}
    //else {
    //    document.getElementById("send-btn").disabled = false;
    //}
}