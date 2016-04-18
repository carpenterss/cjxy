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
    if(checkdkje() == false)
    return false;
    if(checkdkyh() == false)
    return false;
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
    //var d_dbf = $('input[name = d_dbf]').val();
    //var d_bzj = $('input[name = d_bzj]').val();
    //var d_dblv = $('input[name = d_dblv]').val();
    //if (d_dbf == "") {
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
