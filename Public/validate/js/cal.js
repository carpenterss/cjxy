function checkdkje() {
    var name = $('#txtMoney').val();
    if (name == null || name == "") {
        alert("请填写贷款金额");
        $('#txtMoney').focus();
        return false;
    } else if (name.match(/^[1-9]\d*\.\d*|0\.\d*[1-9]\d*$/) == null) {
        alert('贷款金额只能填写大于0的正数')
        return false;
    } else {
        return true;
    }
}
function checklv() {
    var name = $('#txtInterest').val();
    if (name == null || name == "") {
        alert("请填写贷款利率");
        $('#txtMoney').focus();
        return false;
    } else if (name.match(/^[1-9]\d*\.\d*|0\.\d*[1-9]\d*$/) == null) {
        alert('贷款利率只能填写大于0的正数')
        return false;
    } else {
        return true;
    }
}
function checkdkqx() {
    var name = $('#loan_period_select').val();
    if (name == null || name == "") {
        alert("贷款期限不能为空!")
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        alert("贷款期限只能填写大于0的正整数")
        return false;
    } else {
        return true;
    }
}

function checkdata(){
    if(checkdkje() == false)
        return false;
    else if(checkdkqx() == false)
        return false;
    else if(checklv() == false)
        return false;
    else
        return true;
}