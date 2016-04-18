function checkgjs_mc() {
    if ($('input[name = db_type]:checked').val() == 3) {
        var name = $('input[name = gjs_mc]').val();
        if (name == null || name == "") {
            gjs_mc.innerHTML = "贵金属名称不能为空!";
            return false;
        } else {
            gjs_mc.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}
function checkgjs_name() {
    if ($('input[name = db_type]:checked').val() == 3) {
        var name = $('input[name = gjs_name]').val();
        if (name == null || name == "") {
            gjs_name.innerHTML = "贵金属所有人姓名不能为空!";
            return false;
        } else {
            gjs_name.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}
function checkgjs_idcard() {
    if ($('input[name = db_type]:checked').val() == 3) {
        var name = $('input[name = gjs_idcard]').val();
        if (name == null || name == "") {
            gjs_idcard.innerHTML = "贵金属所有人身份证号不能为空!";
            return false;
        }
        else if (!isIdCardNo(name)) {
            gjs_idcard.innerHTML = "贵金属所有人身份证号不正确";
            return false;
        } else {
            gjs_idcard.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}
function checkgjs_lxdh() {
    if ($('input[name = db_type]:checked').val() == 3) {
        var name = $('input[name = gjs_lxdh]').val();
        if (name == null || name == "") {
            gjs_lxdh.innerHTML = "贵金属所有人联系电话不能为空!";
            return false;
        }
        else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
            gjs_lxdh.innerHTML = "贵金属所有人联系电话不正确";
            return false;
        } else {
            gjs_lxdh.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}
function checkgjs_pgjg() {
    if ($('input[name = db_type]:checked').val() == 3) {
        var name = $('input[name = gjs_pgjg]').val();
        if (name == null || name == "") {
            gjs_pgjg.innerHTML = "贵金属评估价格不能为空!";
            return false;
        } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
            gjs_pgjg.innerHTML = "贵金属评估价格不正确，";
            return false;
        } else {
            gjs_pgjg.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}
function checkc_syqr() {
    if ($('input[name = db_type]:checked').val() == 2) {
        var name = $('input[name = c_syqr]').val();
        if (name == null || name == "") {
            c_syqr.innerHTML = "车辆所有权人不能为空!";
            return false;
        } else {
            c_syqr.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}
function checkc_syqrsfzh() {
    if ($('input[name = db_type]:checked').val() == 2) {
        var name = $('input[name = c_syqrsfzh]').val();
        if (name == null || name == "") {
            c_syqrsfzh.innerHTML = "车辆所有权人身份证号不能为空!";
            return false;
        }
        else if (!isIdCardNo(name)) {
            c_syqrsfzh.innerHTML = "车辆所有权人身份证号不正确";
            return false;
        } else {
            c_syqrsfzh.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}
function checkc_syqrlxdh() {
    if ($('input[name = db_type]:checked').val() == 2) {
        var name = $('input[name = c_syqrlxdh]').val();
        if (name == null || name == "") {
            c_syqrlxdh.innerHTML = "车辆所有权人联系电话不能为空!";
            return false;
        }
        else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
            c_syqrlxdh.innerHTML = "车辆所有权人联系电话不正确";
            return false;
        } else {
            c_syqrlxdh.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}
function checkc_ph() {
    if ($('input[name = db_type]:checked').val() == 2) {
        var name = $('input[name = c_ph]').val();
        if (name == null || name == "") {
            c_ph.innerHTML = "车牌号不能为空!";
            return false;
        } else {
            c_ph.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}
function checkc_pp() {
    if ($('input[name = db_type]:checked').val() == 2) {
        var name = $('input[name = c_pp]').val();
        if (name == null || name == "") {
            c_pp.innerHTML = "车辆品牌不能为空!";
            return false;
        } else {
            c_pp.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkc_xh() {
    if ($('input[name = db_type]:checked').val() == 2) {
        var name = $('input[name = c_xh]').val();
        if (name == null || name == "") {
            c_xh.innerHTML = "车辆型号不能为空!";
            return false;
        } else {
            c_xh.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkc_nx() {
    if ($('input[name = db_type]:checked').val() == 2) {
        var name = $('input[name = c_nx]').val();
        if (name == null || name == "") {
            c_nx.innerHTML = "车辆购置日期不能为空!";
            return false;
        } else {
            c_nx.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkc_jz() {
    if ($('input[name = db_type]:checked').val() == 2) {
        var name = $('input[name = c_jz]').val();
        if (name == null || name == "") {
            c_jz.innerHTML = "车辆评估价格不能为空!";
            return false;
        } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
            c_jz.innerHTML = "车辆评估价格不正确，";
            return false;
        } else {
            c_jz.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkc_djh() {
    if ($('input[name = db_type]:checked').val() == 2) {
        var name = $('input[name = c_djh]').val();
        if (name == null || name == "") {
            c_djh.innerHTML = "车辆车架号不能为空!";
            return false;
        } else {
            c_djh.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkc_yhajje() {
    if ($('input[name = db_type]:checked').val() == 2) {
        if ($('input[name = c_ywaj]:checked').val() == 1) {
            var name = $('input[name = c_yhajje]').val();
            if (name == null || name == "") {
                c_yhajje.innerHTML = "车辆已还按揭金额不能为空!";
                return false;
            } else {
                c_yhajje.innerHTML = "";
                return true;
            }

        } else {
            return true;
        }
    }else{
        return true;
    }

}

function checkfw_syqr() {
    if ($('input[name = db_type]:checked').val() == 1) {
        var name = $('input[name = fw_syqr]').val();
        if (name == null || name == "") {
            fw_syqr.innerHTML = "房屋所有权人不能为空!";
            return false;
        } else {
            fw_syqr.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_syqrsfzh() {
    if ($('input[name = db_type]:checked').val() == 1) {
        var name = $('input[name = fw_syqrsfzh]').val();
        if (name == null || name == "") {
            fw_syqrsfzh.innerHTML = "房屋所有权人身份证号不能为空!";
            return false;
        }
        else if (!isIdCardNo(name)) {
            fw_syqrsfzh.innerHTML = "房屋所有权人身份证号不正确";
            return false;
        } else {
            fw_syqrsfzh.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_syqrlxdh() {
    if ($('input[name = db_type]:checked').val() == 1) {
        var name = $('input[name = fw_syqrlxdh]').val();
        if (name == null || name == "") {
            fw_syqrlxdh.innerHTML = "房屋所有权人联系电话不能为空!";
            return false;
        }
        else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
            fw_syqrlxdh.innerHTML = "房屋所有权人联系电话不正确";
            return false;
        } else {
            fw_syqrlxdh.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_fczh() {
    if ($('input[name = db_type]:checked').val() == 1) {
        var name = $('input[name = fw_fczh]').val();
        if (name == null || name == "") {
            fw_fczh.innerHTML = "房屋产权证号不能为空!";
            return false;
        } else {
            fw_fczh.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_tdzh() {
    if ($('input[name = db_type]:checked').val() == 1) {
        var name = $('input[name = fw_tdzh]').val();
        if (name == null || name == "") {
            fw_tdzh.innerHTML = "房屋土地证号不能为空!";
            return false;
        } else {
            fw_tdzh.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_mj() {
    if ($('input[name = db_type]:checked').val() == 1) {
        var name = $('input[name = fw_mj]').val();
        if (name == null || name == "") {
            fw_mj.innerHTML = "房屋面积不能为空!";
            return false;
        } else {
            fw_mj.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_dd() {
    if ($('input[name = db_type]:checked').val() == 1) {
        var name = $('input[name = fw_dd]').val();
        if (name == null || name == "") {
            fw_dd.innerHTML = "房屋地址不能为空!";
            return false;
        } else {
            fw_dd.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_pgjz() {
    if ($('input[name = db_type]:checked').val() == 1) {
        var name = $('input[name = fw_pgjz]').val();
        if (name == null || name == "") {
            fw_pgjz.innerHTML = "房屋评估价值不能为空!";
            return false;
        } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
            fw_pgjz.innerHTML = "房屋评估价值不正确，";
            return false;
        } else {
            fw_pgjz.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

//function checkfw_ywaj() {
//    if ($('input[name = db_type]:checked').val() == 1) {
//        var name = $('input[name = fw_ywaj]').val();
//        if (name == null || name == "") {
//            fw_ywaj.innerHTML = "房屋有无按揭不能为空!";
//            return false;
//        } else {
//            fw_ywaj.innerHTML = "";
//            return true;
//        }
//    } else {
//        return true;
//    }
//}

function checkfw_yhajje() {
    if ($('input[name = db_type]:checked').val() == 1) {
        if($('input[name = fw_ywaj]:checked').val() == 1) {
            var name = $('input[name = fw_yhajje]').val();
            if (name == null || name == "") {
                fw_yhajje.innerHTML = "已还按揭金额不能为空!";
                return false;
            } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
                fw_yhajje.innerHTML = "已还按揭金额不正确，";
                return false;
            } else {
                fw_yhajje.innerHTML = "";
                return true;
            }
        }else{
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_gyrxm() {
    if ($('input[name = db_type]:checked').val() == 1) {
        if ($('input[name = fw_ywgyr]:checked').val() == 1) {
            var name = $('input[name = fw_gyrxm]').val();
            if (name == null || name == "") {
                fw_gyrxm.innerHTML = "房屋共有人姓名不能为空!";
                return false;
            } else {
                fw_gyrxm.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_gyrsfzh() {
    if ($('input[name = db_type]:checked').val() == 1) {
        if ($('input[name = fw_ywgyr]:checked').val() == 1) {
            var name = $('input[name = fw_gyrsfzh]').val();
            if (name == null || name == "") {
                fw_gyrsfzh.innerHTML = "房屋共有人身份证号不能为空!";
                return false;
            }
            else if (!isIdCardNo(name)) {
                fw_gyrsfzh.innerHTML = "房屋共有人身份证号不正确";
                return false;
            } else {
                fw_gyrsfzh.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_gyrlxfs() {
    if ($('input[name = db_type]:checked').val() == 1) {
        if ($('input[name = fw_ywgyr]:checked').val() == 1) {
            var name = $('input[name = fw_gyrlxfs]').val();
            if (name == null || name == "") {
                fw_gyrlxfs.innerHTML = "房屋共有人联系方式不能为空!";
                return false;
            }
            else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
                fw_gyrlxfs.innerHTML = "房屋共有人联系方式不正确";
                return false;
            } else {
                fw_gyrlxfs.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_zlqsrq() {
    if ($('input[name = db_type]:checked').val() == 1) {
        if ($('input[name = fw_fwsfcgdsr]:checked').val() == 1) {
            var name = $('input[name = fw_zlqsrq]').val();
            if (name == null || name == "") {
                fw_zlqsrq.innerHTML = "租赁起始日期不能为空!";
                return false;
            } else {
                fw_zlqsrq.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_zljsrq() {
    if ($('input[name = db_type]:checked').val() == 1) {
        if ($('input[name = fw_fwsfcgdsr]:checked').val() == 1) {
            var name = $('input[name = fw_zljsrq]').val();
            if (name == null || name == "") {
                fw_zljsrq.innerHTML = "租赁结束日期不能为空!";
                return false;
            } else {
                fw_zljsrq.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_zlrxm() {
    if ($('input[name = db_type]:checked').val() == 1) {
        if ($('input[name = fw_fwsfcgdsr]:checked').val() == 1) {
            var name = $('input[name = fw_zlrxm]').val();
            if (name == null || name == "") {
                fw_zlrxm.innerHTML = "房屋承租人姓名不能为空!";
                return false;
            } else {
                fw_zlrxm.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_zlrsfzh() {
    if ($('input[name = db_type]:checked').val() == 1) {
        if ($('input[name = fw_fwsfcgdsr]:checked').val() == 1) {
            var name = $('input[name = fw_zlrsfzh]').val();
            if (name == null || name == "") {
                fw_zlrsfzh.innerHTML = "房屋租赁人身份证号不能为空!";
                return false;
            }
            else if (!isIdCardNo(name)) {
                fw_zlrsfzh.innerHTML = "房屋租赁人身份证号不正确";
                return false;
            } else {
                fw_zlrsfzh.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function checkfw_zlrlxfs() {
    if ($('input[name = db_type]:checked').val() == 1) {
        if ($('input[name = fw_fwsfcgdsr]:checked').val() == 1) {
            var name = $('input[name = fw_zlrlxfs]').val();
            if (name == null || name == "") {
                fw_zlrlxfs.innerHTML = "房屋租赁人联系方式不能为空!";
                return false;
            }
            else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
                fw_zlrlxfs.innerHTML = "房屋租赁人联系方式不正确";
                return false;
            } else {
                fw_zlrlxfs.innerHTML = "";
                return true;
            }
        } else {
            return true;
        }
    } else {
        return true;
    }
}

//function checkxy_name() {
//    if ($('input[name = db_type]:checked').val() == 4) {
//        var name = $('input[name = xy_name]').val();
//        if (name == null || name == "") {
//            xy_name.innerHTML = "借款人姓名不能为空!";
//            return false;
//        } else {
//            xy_name.innerHTML = "";
//            return true;
//        }
//    } else {
//        return true;
//    }
//}
//
//function checkxy_idcard() {
//    if ($('input[name = db_type]:checked').val() == 4) {
//        var name = $('input[name = xy_idcard]').val();
//        if (name == null || name == "") {
//            xy_idcard.innerHTML = "借款人身份证号不能为空!";
//            return false;
//        }
//        else if (!isIdCardNo(name)) {
//            xy_idcard.innerHTML = "借款人身份证号不正确";
//            return false;
//        } else {
//            xy_idcard.innerHTML = "";
//            return true;
//        }
//    } else {
//        return true;
//    }
//}
//
//function checkxy_lxdh() {
//    if ($('input[name = db_type]:checked').val() == 4) {
//        var name = $('input[name = xy_lxdh]').val();
//        if (name == null || name == "") {
//            xy_lxdh.innerHTML = "借款人联系电话不能为空!";
//            return false;
//        }
//        else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
//            xy_lxdh.innerHTML = "借款人联系电话不正确";
//            return false;
//        } else {
//            xy_lxdh.innerHTML = "";
//            return true;
//        }
//    } else {
//        return true;
//    }
//}
//
//function checkxy_sfzdz() {
//    if ($('input[name = db_type]:checked').val() == 4) {
//        var name = $('input[name = xy_sfzdz]').val();
//        if (name == null || name == "") {
//            xy_sfzdz.innerHTML = "借款人身份证所在地址不能为空!";
//            return false;
//        } else {
//            xy_sfzdz.innerHTML = "";
//            return true;
//        }
//    } else {
//        return true;
//    }
//}
//
//function checkxy_sjzz() {
//    if ($('input[name = db_type]:checked').val() == 4) {
//        var name = $('input[name = xy_sjzz]').val();
//        if (name == null || name == "") {
//            xy_sjzz.innerHTML = "借款人实际住址不能为空!";
//            return false;
//        } else {
//            xy_sjzz.innerHTML = "";
//            return true;
//        }
//    } else {
//        return true;
//    }
//}


function checkdata() {
    if (checkgjs_mc() == false)
        return false;
    if (checkgjs_name() == false)
        return false;
    if (checkgjs_idcard() == false)
        return false;
    if (checkgjs_lxdh() == false)
        return false;
    if (checkgjs_pgjg() == false)
        return false;
    if (checkc_syqr() == false)
        return false;
    if (checkc_syqrsfzh() == false)
        return false;
    if (checkc_syqrlxdh() == false)
        return false;
    if (checkc_ph() == false)
        return false;
    if (checkc_pp() == false)
        return false;
    if (checkc_xh() == false)
        return false;
    if (checkc_nx() == false)
        return false;
    if (checkc_jz() == false)
        return false;
    if (checkc_yhajje() == false)
        return false;
    if (checkc_djh() == false)
        return false;
    if (checkfw_syqr() == false)
        return false;
    if (checkfw_syqrsfzh() == false)
        return false;
    if (checkfw_syqrlxdh() == false)
        return false;
    if (checkfw_fczh() == false)
        return false;
    if (checkfw_tdzh() == false)
        return false;
    if (checkfw_mj() == false)
        return false;
    if (checkfw_dd() == false)
        return false;
    if (checkfw_pgjz() == false)
        return false;
    //if (checkfw_ywaj() == false)
    //    return false;
    if (checkfw_yhajje() == false)
        return false;
    if (checkfw_gyrxm() == false)
        return false;
    if (checkfw_gyrsfzh() == false)
        return false;
    if (checkfw_gyrlxfs() == false)
        return false;
    if (checkfw_zlqsrq() == false)
        return false;
    if (checkfw_zljsrq() == false)
        return false;
    if (checkfw_zlrxm() == false)
        return false;
    if (checkfw_zlrsfzh() == false)
        return false;
    if (checkfw_zlrlxfs() == false)
        return false;
    //if (checkxy_name() == false)
    //    return false;
    //if (checkxy_idcard() == false)
    //    return false;
    //if (checkxy_lxdh() == false)
    //    return false;
    //if (checkxy_sfzdz() == false)
    //    return false;
    if (checkqtwpname() == false)
        return false;
    if (checkqtidcard() == false)
        return false;
    if (checkqtlxdh() == false)
        return false;
    if (checkqtpgjg() == false)
        return false;
    if (checkpzname() == false)
        return false;
    if (checkpzidcard() == false)
        return false;
    if (checkpzlxfs() == false)
        return false;
    if (checkpzhm() == false)
        return false;
    if (checkmzje() == false)
        return false;
    if (checkpgjg() == false)
        return false;

    else
        return true;
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

function checkqtwpname() {
    if ($('input[name = db_type]:checked').val() == 6) {
        var name = $('input[name = qt_name]').val();
        if (name == null || name == "") {
            qitawupin.innerHTML = "姓名不能为空!";
            return false;
        } else {
            qitawupin.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkqtidcard() {
    if ($('input[name = db_type]:checked').val() == 6) {
        var name = $('input[name = qt_idcard]').val();
        if (name == null || name == "") {
            qt_idc.innerHTML = "身份证不能为空!";
            return false;
        } else if (!isIdCardNo(name)) {
            qt_idc.innerHTML = "身份证格式不正确";
            return false;
        } else {
            qt_idc.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkqtlxdh() {
    if ($('input[name = db_type]:checked').val() == 6) {
        var name = $('input[name = qt_lxdh]').val();
        if (name == null || name == "") {
            lxdh.innerHTML = "联系方式不能为空!";
            return false;
        } else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
            lxdh.innerHTML = "联系方式格式不正确，座机格式：XXXX-XXXXXXXX，手机格式为XXXXXXXXXXX";
            return false;
        } else {
            lxdh.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkqtpgjg() {
    if ($('input[name = db_type]:checked').val() == 6) {
        var name = $('input[name = qt_pgjg]').val();
        if (name == null || name == "") {
            qt_jiage.innerHTML = "评估价格不能为空!";
            return false;
        } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
            qt_jiage.innerHTML = "评估价格格式填写不正确，";
            return false;
        } else {
            qt_jiage.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkpzname() {
    if ($('input[name = db_type]:checked').val() == 5) {
        var name = $('input[name = pz_name]').val();
        if (name == null || name == "") {
            pz_mz.innerHTML = "姓名不能为空!";
            return false;
        } else {
            pz_mz.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkpzidcard() {
    if ($('input[name = db_type]:checked').val() == 5) {
        var name = $('input[name = pz_idcard]').val();
        if (name == null || name == "") {
            pz_sfz.innerHTML = "身份证不能为空!";
            return false;
        } else if (!isIdCardNo(name)) {
            pz_sfz.innerHTML = "身份证格式不正确";
            return false;
        } else {
            pz_sfz.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkpzlxfs() {
    if ($('input[name = db_type]:checked').val() == 5) {
        var name = $('input[name = pz_lxdh]').val();
        if (name == null || name == "") {
            pz_lxfs.innerHTML = "联系方式不能为空!";
            return false;
        } else if (name.match(/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/) == null) {
            pz_lxfs.innerHTML = "联系方式格式不正确，座机格式：XXXX-XXXXXXXX，手机格式为XXXXXXXXXXX";
            return false;
        } else {
            pz_lxfs.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkpzhm() {
    if ($('input[name = db_type]:checked').val() == 5) {
        var name = $('input[name = pz_hm]').val();
        if (name == null || name == "") {
            pz_number.innerHTML = "凭证号码不能为空!";
            return false;
        } else {
            pz_number.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkmzje() {
    if ($('input[name = db_type]:checked').val() == 5) {
        var name = $('input[name = pz_mzje]').val();
        if (name == null || name == "") {
            pz_je.innerHTML = "面值金额不能为空!";
            return false;
        } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
            pz_je.innerHTML = "面值金额填写不正确，";
            return false;
        } else {
            pz_je.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }
}

function checkpgjg() {
    if ($('input[name = db_type]:checked').val() == 5) {
        var name = $('input[name = pz_pgjg]').val();
        if (name == null || name == "") {
            pz_pzpgjg.innerHTML = "面值金额不能为空!";
            return false;
        } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
            pz_pzpgjg.innerHTML = "面值金额填写不正确，";
            return false;
        } else {
            pz_pzpgjg.innerHTML = "";
            return true;
        }
    } else {
        return true;
    }

}