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


function checkcd_name() {
    var name = $('input[name = cd_name]').val();
    if (name == null || name == "") {
        cd_name.innerHTML = "客户姓名不能为空!";
        return false;

    } else {
        cd_name.innerHTML = "";
        return true;
    }
}

function checkcd_idcard() {
    var name = $('input[name = cd_idcard]').val();
    if (name == null || name == "") {
        cd_idcard.innerHTML = "身份证不能为空!";
        return false;
    } else if (!isIdCardNo(name)) {
        cd_idcard.innerHTML = "身份证格式不正确";
        return false;
    } else {
        cd_idcard.innerHTML = "";
        return true;
    }
}

function checkcd_mz() {
    var name = $('input[name = cd_mz]').val();
    if (name == null || name == "") {
        cd_mz.innerHTML = "民族不能为空!";
        return false;
    } else if (name.match(/([\u4e00-\u9fa5]{1,10})/) == null) {
        cd_mz.innerHTML = "民族不正确";
        return false;
    } else {
        cd_mz.innerHTML = "";
        return true;
    }
}

function checkcd_gzdw() {
    var name = $('input[name = cd_gzdw]').val();
    if (name == null || name == "") {
        cd_gzdw.innerHTML = "工作单位不能为空!";
        return false;
    } else {
        cd_gzdw.innerHTML = "";
        return true;
    }
}

function checkcd_zw() {
    var name = $('input[name = cd_zw]').val();
    if (name == null || name == "") {
        cd_zw.innerHTML = "职务不能为空!";
        return false;
    } else {
        cd_zw.innerHTML = "";
        return true;
    }
}

function checkcd_hkszd() {
    var name = $('input[name = cd_hkszd]').val();
    if (name == null || name == "") {
        cd_hkszd.innerHTML = "户口所在地不能为空!";
        return false;
    } else {
        cd_hkszd.innerHTML = "";
        return true;
    }
}

function checkcd_sfzszd() {
    var name = $('input[name = cd_sfzszd]').val();
    if (name == null || name == "") {
        cd_sfzszd.innerHTML = "身份证所在地不能为空!";
        return false;
    } else {
        cd_sfzszd.innerHTML = "";
        return true;
    }
}

function checkcd_sjzz() {
    var name = $('input[name = cd_sjzz]').val();
    if (name == null || name == "") {
        cd_sjzz.innerHTML = "实际住址不能为空!";
        return false;
    } else {
        cd_sjzz.innerHTML = "";
        return true;
    }
}

function checkcd_lxfs() {
    var name = $('input[name = cd_lxfs]').val();
    if (name == null || name == "") {
        cd_lxfs.innerHTML = "联系方式不能为空!";
        return false;
    } else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
        cd_lxfs.innerHTML = "联系方式格式不正确，座机格式：XXXX-XXXXXXXX，手机格式为XXXXXXXXXXX";
        return false;
    } else {
        cd_lxfs.innerHTML = "";
        return true;
    }
}

function checkcd_poxm() {
    if($('input[name = cd_hyzk]:checked').val() == 0) {
        var name = $('input[name = cd_poxm]').val();
        if (name == null || name == "") {
            cd_poxm.innerHTML = "配偶姓名不能为空!";
            return false;
        } else {
            cd_poxm.innerHTML = "";
            return true;
        }
    }else{

    return true
}
}

function checkcd_posfzh() {
    if($('input[name = cd_hyzk]:checked').val() == 0){
    var name = $('input[name = cd_posfzh]').val();
    if (name == null || name == "") {
        cd_posfzh.innerHTML = "配偶身份证不能为空!";
        return false;
    }
    else if (!isIdCardNo(name)) {
        cd_posfzh.innerHTML = "身份证不正确";
        return false;
    } else {
        cd_posfzh.innerHTML = "";
        return true;
    }    }else{

        return true
    }
}

function checkcd_polxfs() {
    if($('input[name = cd_hyzk]:checked').val() == 0){
    var name = $('input[name = cd_polxfs]').val();
    if (name == null || name == "") {
        cd_polxfs.innerHTML = "配偶联系方式不能为空!";
        return false;
    }
    else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
        cd_polxfs.innerHTML = "联系方式不正确";
        return false;
    } else {
        cd_polxfs.innerHTML = "";
        return true;
    }    }else{

        return true
    }
}

function checkcd_ponsr() {
    if($('input[name = cd_hyzk]:checked').val() == 0){
    var name = $('input[name = cd_ponsr]').val();
    if (name == null || name == "") {
        cd_ponsr.innerHTML = "配偶年收入不能为空!";
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        cd_ponsr.innerHTML = "收入填写不正确，";
        return false;
    } else {
        cd_ponsr.innerHTML = "";
        return true;
    }    }else{

        return true
    }
}

function checkcd_pogzdw() {
    if($('input[name = cd_hyzk]:checked').val() == 0){
    var name = $('input[name = cd_pogzdw]').val();
    if (name == null || name == "") {
        cd_pogzdw.innerHTML = "配偶工作情况不能为空!";
        return false;
    } else {
        cd_pogzdw.innerHTML = "";
        return true;
    }    }else{

        return true
    }
}

function checkcd_pozw() {
    if($('input[name = cd_hyzk]:checked').val() == 0){
    var name = $('input[name = cd_pozw]').val();
    if (name == null || name == "") {
        cd_pozw.innerHTML = "配偶职务不能为空!";
        return false;
    } else {
        cd_pozw.innerHTML = "";
        return true;
    }    }else{

        return true
    }
}
function checkdata() {
    if (checkcd_name() == false)
        return false;
    if (checkcd_idcard() == false)
        return false;
    if (checkcd_mz() == false)
        return false;
    if (checkcd_gzdw() == false)
        return false;
    if (checkcd_zw() == false)
        return false;
    if (checkcd_hkszd() == false)
        return false;
    if (checkcd_sfzszd() == false)
        return false;
    if (checkcd_sjzz() == false)
        return false;
    if (checkcd_lxfs() == false)
        return false;
    if (checkcd_poxm() == false)
        return false;
    if (checkcd_posfzh() == false)
        return false;
    if (checkcd_polxfs() == false)
        return false;
    if (checkcd_ponsr() == false)
        return false;
    if (checkcd_pogzdw() == false)
        return false;
    if (checkcd_pozw() == false)
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
