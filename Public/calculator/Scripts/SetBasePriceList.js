var sjs = surea.framework.js;
var AjaxSrv = new surea.framework.js.ajax();
var divList = new surea.framework.js.tablelist();
var divMarketDataList = new surea.framework.js.tablelist();
var divEdsDataList = new surea.framework.js.tablelist();
var divMisDataList = new surea.framework.js.tablelist();
var obj = new Object();
var condition = "";
var conditionList = new surea.framework.js.objects.Dictionary();
var tab0 = false;
var tab1 = false;
var tab2 = false;
var tab3 = false;
var tab4 = false;
var tab5 = false;
var tab6 = false;
var dataType = '';
$(document).ready(function () {
    sjs.initial();
    $('#divTab').css('width', $(window).width() - 20);
    $('#divTab').tabs({
        border: true,
        width: $(window).width() - 20,
        //height: 1500,
        onSelect: function (title) {

        }, onClose: function (title) {
            var projectId = title.split(':')[0];
            setPriceList = setPriceList.replace(projectId + ',', '');
            divList.loadData();
        }
    });
    AjaxSrv.initial("jquery", '/Handlers/Admin/BasePrice/SetBasePriceHandler.ashx', "html");
    divList.initial("divBasePriceSetList", "divBasePricePage", "/Handlers/Admin/BasePrice/SetBasePriceHandler.ashx", '/images/ajax-loader.gif');
    //divMarketDataList.initial("divMarketDataList", "divMarketDataPage", "/Handlers/DataHandler.ashx", '/images/ajax-loader.gif');
    //divEdsDataList.initial("divEdsDataList", "divEdsDataPage", "/Handlers/DataHandler.ashx", '/images/ajax-loader.gif');
    //divMisDataList.initial("divMisDataList", "divMisDataPage", "/Handlers/DataHandler.ashx", '/images/ajax-loader.gif');
    divList.PageInfoType = 1;
    divList.setOrderBy('id', 'desc');
    divList.setPageSize(30);
    //Search();
    $("#searchTable :input").bind("keydown", function () {
        switch (event.keyCode) {
            case 13:
                {
                    Search();
                    return false;
                }
                break;
        }
    });
})
function CloseTab() {
    var tabTitle = $('#divTab').tabs('getSelected').panel('options').title;
    $('#divTab').tabs('close', tabTitle);
    divList.loadData();
}

var addressAscOrDesc = 'asc'
function sortAddress() {

    var fieldName = 'address';
    divList.OrderBy.removeAll();
    divList.setOrderBy(fieldName, curSort ? false : true);
    curSort = !curSort;
    divList.loadData();

}
var curSort = true;
function basePriceOrderBy(obj) {
    var fieldName = $(obj).find(':input').val();
    divList.OrderBy.removeAll();
    divList.setOrderBy(fieldName, curSort ? false : true);
    curSort = !curSort;
    divList.loadData();
}
function clickOrderBy(obj) {
    var fieldName = $(obj).find(':input').val();
    if (dataType == 'market') {
//        divMarketDataList.OrderBy.removeAll();
//        divMarketDataList.setOrderBy(fieldName, curSort ? false : true);
//        curSort = !curSort;
//        divMarketDataList.loadData();
    } else if (dataType == 'eds') {
//        divEdsDataList.OrderBy.removeAll();
//        divEdsDataList.setOrderBy(fieldName, curSort ? false : true);
//        curSort = !curSort;
//        divEdsDataList.loadData();
    } else if (dataType == 'mis') {
//        divMisDataList.OrderBy.removeAll();
//        divMisDataList.setOrderBy(fieldName, curSort ? false : true);
//        curSort = !curSort;
//        divMisDataList.loadData();
    }
}
function MaxAndMin(obj) {
    if ($(obj).text() == '收缩') {
        $('#divSearchContent #searchTable tbody').hide();
        $(obj).text('展开');
    } else {
        $('#divSearchContent #searchTable tbody').show();
        $(obj).text('收缩');
    }
}
function Search() {

    
    GetCondition();
    divList.Condition = condition;
    divList.Conditions = conditionList;
    
    divList.loadData(true);
}
function UpdateGisPrice() {

    sjs.showLoading(null, "请稍等...", false, '/images/ajax-loader.gif', true);

    AjaxSrv.post({ type: 'UpdateGisPrice', data: '' }, function (callBackData) {
        if (callBackData == 0) {
            alert('更新成功');
        } else {
            alert('更新失败，请联系管理员');
        }

        sjs.hideLoading();
    });

}

function projectDetail(id) {
    Divwin.show($(window).width() * 2 / 3, $(window).height() * 2 / 3, true, "../project/ProjectForm.aspx?id=" + id + "&type=search", true);
}
function GenerateGisData() {
    sjs.showLoading(null, "正在执行...", null, "/images/ajax-loader.gif", true, true);
    AjaxSrv.post({ type: 'GenerateGisData', data: '' }, function (callBackData) {
        alert('操作成功');
        sjs.hideLoading();
    });
}
function GetCondition() {

    var conditionObject = new Object();
    condition = "";
    conditionList = new surea.framework.js.objects.Dictionary();
    var index = 0;
    if ($("#txtProjectId").val().trim() != '') {
        //conditionList.setValue("projectid", new surea.framework.js.objects.tablelist.Condition("and", "projectid", "=", $("#txtProjectId").val()));
        var projectid = $("#txtProjectId").val().trim();
        for (i = 0; i < projectid.split(',').length; i++) {
            condition += " or projectid = " + projectid.split(',')[i];
        }
        condition = ' and (' + condition.substring(3, condition.length) + ')';
    }
    if ($("#ctl00_content_selDistrict").val() != -1)
        conditionList.setValue("district", new surea.framework.js.objects.tablelist.Condition("and", "district", "=", $("#ctl00_content_selDistrict").val()));

    if ($("#selMemo").val() != -1) {
        if ($("#selMemo").val() == 0) {
            condition += " and (memo is null or memo = '') ";
        } else {
            condition += " and (memo is not null and memo <> '') ";
        }
    }
    if ($("#selSetPriceIdea").val() != -1) {
        if ($("#selSetPriceIdea").val() == 0) {
            condition += " and (setPriceIdea is null or setPriceIdea = '') ";
        } else {
            condition += " and (setPriceIdea is not null and setPriceIdea <> '') ";
        }
    }
    if ($("#selVerifyIdea").val() != -1) {
        if ($("#selVerifyIdea").val() == 0) {
            condition += " and (VerifyIdea is null or VerifyIdea = '') ";
        } else {
            condition += " and (VerifyIdea is not null and VerifyIdea <> '') ";
        }
    }

    if ($("#ctl00_content_selCirclePosition").val() != -1)
        conditionList.setValue("circlePosition", new surea.framework.js.objects.tablelist.Condition("and", "circlePosition", "=", $("#ctl00_content_selCirclePosition").val()));
    if ($("#ctl00_content_selPlate").val() != -1)
        conditionList.setValue("plate", new surea.framework.js.objects.tablelist.Condition("and", "plate", "=", $("#ctl00_content_selPlate").val()));
    if ($("#ctl00_content_selProjectType").val() != -1)
        conditionList.setValue("projectType", new surea.framework.js.objects.tablelist.Condition("and", "projectType", "=", $("#ctl00_content_selProjectType").val()));
    if ($("#ctl00_content_selProjectLevel").val() != -1)
        conditionList.setValue("projectLevel", new surea.framework.js.objects.tablelist.Condition("and", "projectLevel", "=", $("#ctl00_content_selProjectLevel").val()));
    if ($("#txtProjectName").val().trim() != '')
        conditionList.setValue("projectName", new surea.framework.js.objects.tablelist.Condition("and", "projectName", "like", ("%" + $("#txtProjectName").val() + "%")));
    if ($("#txtAddress").val().trim() != '')
        conditionList.setValue("address", new surea.framework.js.objects.tablelist.Condition("and", "address", "like", ("%" + $("#txtAddress").val() + "%")));
    if ($("#txtDateFrom").val().trim() != '')
        conditionList.setValue("publishDate", new surea.framework.js.objects.tablelist.Condition("and", "publishDate", ">=", $("#txtDateFrom").val(), 1, 'a1'));
    if ($("#txtDateTo").val().trim() != '')
        conditionList.setValue("publishDate1", new surea.framework.js.objects.tablelist.Condition("and", "publishDate", "<=", $("#txtDateTo").val(), 1, "a2"));
    if ($("#txtPriceStart").val().trim() != '')
        conditionList.setValue("unitprice", new surea.framework.js.objects.tablelist.Condition("and", "unitprice", ">=", $("#txtPriceStart").val(), 2, 'b1'));
    if ($("#txtPriceEnd").val().trim() != '')
        conditionList.setValue("unitprice1", new surea.framework.js.objects.tablelist.Condition("and", "unitprice", "<=", $("#txtPriceEnd").val(), 2, "b2"));
    if ($("#selSchool").val() != -1)
        conditionList.setValue("schoolId", new surea.framework.js.objects.tablelist.Condition("and", "schoolId", "=", $("#selSchool").val()));
    if ($("#txtCompletionYearBegin").val().trim() != '')
        conditionList.setValue("completionYear", new surea.framework.js.objects.tablelist.Condition("and", "completionYear", ">=", $("#txtCompletionYearBegin").val().trim(), 6, 'f1'));
    if ($("#txtCompletionYearEnd").val().trim() != '')
        conditionList.setValue("completionYear1", new surea.framework.js.objects.tablelist.Condition("and", "completionYear", "<=", $("#txtCompletionYearEnd").val().trim(), 6, "f2"));

    if ($("#txtCaseCountStart").val().trim() != '')
        conditionList.setValue("caseCount", new surea.framework.js.objects.tablelist.Condition("and", "caseCount", ">=", $("#txtCaseCountStart").val(), 7, 'g1'));
    if ($("#txtCaseCountEnd").val().trim() != '')
        conditionList.setValue("caseCount1", new surea.framework.js.objects.tablelist.Condition("and", "caseCount", "<=", $("#txtCaseCountEnd").val(), 7, "g2"));


    if ($("#selBasePriceStatus").val() != -1)
        conditionList.setValue("status", new surea.framework.js.objects.tablelist.Condition("and", "status", "=", $("#selBasePriceStatus").val()));
    if ($("#ctl00_content_selSettingsType").val() != -1)
        conditionList.setValue("settingsType", new surea.framework.js.objects.tablelist.Condition("and", "settingsType", "=", $("#ctl00_content_selSettingsType").val()));

    if ($("#ctl00_content_selVillaPriceType").val() != -1)
        conditionList.setValue("VillaPriceType", new surea.framework.js.objects.tablelist.Condition("and", "VillaPriceType", "=", $("#ctl00_content_selVillaPriceType").val()));
    if ($("#ctl00_content_selVillaPriceMemo").val() != -1)
        conditionList.setValue("VillaPriceMemo", new surea.framework.js.objects.tablelist.Condition("and", "VillaPriceMemo", "=", $("#ctl00_content_selVillaPriceMemo").val()));

    if ($("#selIsJoinOrder").val() != -1) {
        if ($("#selIsJoinOrder").val() == 0) {
            conditionList.setValue("isjoinorder", new surea.framework.js.objects.tablelist.Condition("and", "isjoinorder", "=", 0));
        } else {
            condition += ' and (isjoinorder is null or isjoinorder = 1) ';
        }
    }
    if ($("#ctl00_content_selProjectTab").val().trim() != '-1') {
        conditionList.setValue("projectTab", new surea.framework.js.objects.tablelist.Condition("and", "projectTab", "like", ("%" + $("#ctl00_content_selProjectTab").val() + "%")));
    }
    if ($("#txtAreaStart").val().trim() != '')
        conditionList.setValue("areastart", new surea.framework.js.objects.tablelist.Condition("and", "areastart", ">=", $("#txtAreaStart").val()));
    if ($("#txtAreaEnd").val().trim() != '')
        conditionList.setValue("areaend", new surea.framework.js.objects.tablelist.Condition("and", "areaend", "<=", $("#txtAreaEnd").val()));

    if ($("#selIsSample").val() != -1) {
        conditionList.setValue("isSample", new surea.framework.js.objects.tablelist.Condition("and", "isSample", "=", $("#selIsSample").val()));
    }

    if ($("#selectUnitPrice").val() != -1) {
        if ($("#selectUnitPrice").val() == '1') {
            condition += ' and (unitprice is not null)';
        } else if ($("#selectUnitPrice").val() == '2') {
            condition += ' and (unitprice is null)';
        }
    }

    if ($('#selField1').val() != '-1' && $('#selField2').val() != '-1') {
        var field1 = $('#selField1').val();
        var field2 = $('#selField2').val();
        if ($("#txtRateStart").val().trim() != '') {
            condition += ' and case when ' + field2 + ' is not null and ' + field2 + ' <> 0 then ((' + field1 + ' / ' + field2 + ') - 1) * 100 else null end >=' + $("#txtRateStart").val().trim();
        }
        if ($("#txtRateEnd").val().trim() != '') {
            condition += ' and case when ' + field2 + ' is not null and ' + field2 + ' <> 0 then ((' + field1 + ' / ' + field2 + ') - 1) * 100 else null end <=' + $("#txtRateEnd").val().trim();
        }
    }

    if ($("#selModifyUnitDifferenceMemo").val() != -1) {
        if ($("#selModifyUnitDifferenceMemo").val() == 1) {
            condition += " and (previousUnitDifferenceMemo <> UnitDifferenceMemo or (previousUnitDifferenceMemo is null and UnitDifferenceMemo <> '') or (previousUnitDifferenceMemo <> '' and UnitDifferenceMemo is null)) ";
        } else {
            condition += " and (previousUnitDifferenceMemo = UnitDifferenceMemo or (previousUnitDifferenceMemo = '' and UnitDifferenceMemo is null) or (previousUnitDifferenceMemo is null and UnitDifferenceMemo = '') or (previousUnitDifferenceMemo is null and UnitDifferenceMemo is null)) ";
        }
    }

    if ($("#selModifyMemo").val() != -1) {
        if ($("#selModifyMemo").val() == 1) {
            condition += " and (previousMemo <> memo or (previousMemo is null and memo <> '') or (previousMemo <> '' and memo is null)) ";
        } else {
            condition += " and (previousMemo = memo or (previousMemo = '' and memo is null) or (previousMemo is null and memo = '') or (previousMemo is null and memo is null) ) ";
        }
    }
    if ($("#ctl00_content_selLine").val().trim() != '-1') {
        if ($("#selLineStop").val() != '-1') {
            if (condition != '') {
                condition += ' and ' + " projectid in (select ProjectId from gis.dbo.GIS_Proj_UndAround where GisUndId in (select id from gis.dbo.GIS_Underground where status = 1 and name like '%" + $("#selLineStop").val() + "%') )";
            } else {
                condition = " and projectid in (select ProjectId from gis.dbo.GIS_Proj_UndAround where GisUndId in (select id from gis.dbo.GIS_Underground where status = 1 and name like '%" + $("#selLineStop").val() + "%') )";
            }
        } else {
            if (condition != '') {
                condition += ' and ' + " projectid in (select ProjectId from gis.dbo.GIS_Proj_UndAround where GisUndId in (select id from gis.dbo.GIS_Underground where status = 1 and ','+line +',' like '%," + $("#ctl00_content_selLine").val() + ",%') )";
            } else {
                condition = " and projectid in (select ProjectId from gis.dbo.GIS_Proj_UndAround where GisUndId in (select id from gis.dbo.GIS_Underground where status = 1 and ','+line +',' like '%," + $("#ctl00_content_selLine").val() + ",%') )";
            }
        }
    }

    conditionObject.condition = condition;
    conditionObject.conditionList = conditionList.getArrayValues();
    return conditionObject;
}
function ChangeLine(obj) {
    var lineId = $(obj).val();
    JSCallBackHandler.newCallBack("GetLineStopList", lineId, function (pCallBackData) {
        pCallBackData = "<option value='-1'>请选择</option>" + pCallBackData;
        $("#selLineStop").empty();
        $("#selLineStop").append(pCallBackData);
    });
}
var setPriceList = '';
function ModifyUnitPrice(id, projectId, projectName) {
    AjaxSrv.post({ type: 'GetSetPriceDataRight', data: projectId }, function (callBackData) {
        if (callBackData == '1') {
            if ((',' + setPriceList).indexOf((',' + projectId + ',')) >= 0) {
                //alert('您已经打开该小区的定价界面');
                $('#divTab').tabs('select', projectId + ':' + projectName);
            } else {
                setPriceList += projectId + ',';
                $('#divTab').tabs('add', {
                    title: projectId + ':' + projectName, //height: 1000,
                    content: '<iframe id=' + id + ' scrolling="yes" frameborder="0"  src="/admin/BasePrice/Popup/SetBasePriceForm.aspx?id=' + encodeURIComponent(id) + '&projectId=' + encodeURIComponent(projectId) + '" style="width:100%;height:1100px;"></iframe>',


                    //href: '/admin/BasePrice/Popup/SetBasePriceForm.aspx',
                    closable: true
                });
            }
            if (setPriceList.split(',').length > 8) {
                $('#divTab').tabs('close', 1);
            }
        } else {
            alert('您没有权限编辑该小区的价格');
        }
    });

}
function ChangePlate(obj) {
    var districtId = $(obj).val();
    JSCallBackHandler.newCallBack("GetPlateList", districtId, function (pCallBackData) {
        pCallBackData = "<option value='-1'>选择板块</option>" + pCallBackData;
        $("#ctl00_content_selPlate").empty();
        $("#ctl00_content_selPlate").append(pCallBackData);
    });
    JSCallBackHandler.newCallBack("GetSchoolListByDistrict", districtId, function (pCallBackData) {
        pCallBackData = "<option value='-1'>请选择</option>" + pCallBackData;
        $("#selSchool").empty();
        $("#selSchool").append(pCallBackData);
    });
}
function setModifyReason(obj) {
    if ($(obj).attr('id') == 'rbModifyReason3' || $(obj).attr('id') == 'rbModifyReason4') {
        $('#txtModifyReason').show();
    } else {
        $('#txtModifyReason').hide();
    }
}
function CancelIsJoinOrder() {
    $('#divPriceChart').empty();
    $('#divTotalFloorChart').empty();
    $('#divPriceFactor').empty();
    $('#divConstructionAreaChart').empty();
    var obj = $('#basePriceList tbody :checkbox[checked=true]');

    var selected = new Array;
    for (i = 0; i < obj.length; i++) {
        selected.push($(obj[i]).attr('id'));
    }
    if (selected.length == 0) {
        alert("请选择需要取消纠错的记录！");
    }
    else {
        if (!confirm("确定要取消纠错" + selected.length + "条记录吗？"))
            return false;
        else {
            AjaxSrv.post({ type: 'SaveCancelJoinOrder', data: selected }, function (callBackData) {
                alert('操作成功');
                CloseBlockUI();
                divList.loadData();
            });
        }
    }
}
function PlateRateSettingsForm() {
    $.blockUI({ message: $('#divPlateRateSettingsForm'), css: {
        top: ($(window).height() - 700) / 2 + 'px',
        left: ($(window).width() - 750) / 2 + 'px',
        width: '750px',
        height: '700px',
        cursor: 'default'
    }, overlayCSS: {
        cursor: 'default'
    }
    });
    //$('#fForm').css('height', (($(window).height() * 2 / 3) - 30));
    $('#fForm').attr('src', 'Popup/PlateRateSettings.aspx');
}
function AppointPlateToUnitPrice() {
    var rtn = prompt("★注意：请谨慎操作！\n请输入\"OK\"确认是否按照查询条件引用板块推导值？", "Cancel")
    if (rtn != "ok" && rtn != "OK") {
        return;
    }

    AjaxSrv.post({ type: 'AppointPlateToUnitPrice', data: JSON.stringify(GetCondition()) }, function (callBackData) {
        alert('操作成功');
        divList.loadData();
    });
}
function AppointBindUnitPrice() {
    var rtn = prompt("★注意：请谨慎操作！\n请输入\"OK\"确认是否按照查询条件引用板块推导值？", "Cancel")
    if (rtn != "ok" && rtn != "OK") {
        return;
    }

    AjaxSrv.post({ type: 'AppointBindUnitPrice', data: JSON.stringify(GetCondition()) }, function (callBackData) {
        alert('操作成功');
        divList.loadData();
    });
}
function AppointFittingValue() {
    var rtn = prompt("★注意：请谨慎操作！\n请输入\"OK\"确认是否按照查询条件引用板块推导值？", "Cancel")
    if (rtn != "ok" && rtn != "OK") {
        return;
    }

    AjaxSrv.post({ type: 'AppointFittingValue', data: JSON.stringify(GetCondition()) }, function (callBackData) {
        alert('操作成功');
        divList.loadData();
    });
}
function GeneratePrice1(btn) {
    if ($('#txtGenerateMonth').val() == '') {
        alert('请选择月份');
        return false;
    }
    $('#trLoading').show();
    var date = $('#txtGenerateMonth').val() + '-01';
    $(btn).attr('disabled', true);
    AjaxSrv.post({ type: 'GeneratePrice1', data: date }, function (callBackData) {
        if (callBackData == 1) {
            alert('操作成功');
        } else {
            alert('操作失败，请联系管理员');
        }
        $('#trLoading').hide();
        $(btn).attr('disabled', false);
    });
}
function GeneratePrice2(btn) {
    if ($('#txtGenerateMonth').val() == '') {
        alert('请选择月份');
        return false;
    }
    $('#trLoading').show();
    var date = $('#txtGenerateMonth').val() + '-01';
    $(btn).attr('disabled', true);
    AjaxSrv.post({ type: 'GeneratePrice2', data: date }, function (callBackData) {
        if (callBackData == 1) {
            alert('操作成功');
        } else {
            alert('操作失败，请联系管理员');
        }
        $('#trLoading').hide();
        $(btn).attr('disabled', false);
    });
}
function GeneratePrice3(btn) {
    if ($('#txtGenerateMonth').val() == '') {
        alert('请选择月份');
        return false;
    }
    $('#trLoading').show();
    var date = $('#txtGenerateMonth').val() + '-01';
    $(btn).attr('disabled', true);
    AjaxSrv.post({ type: 'GeneratePrice3', data: date }, function (callBackData) {
        if (callBackData == 1) {
            alert('操作成功');
        } else {
            alert('操作失败，请联系管理员');
        }
        $('#trLoading').hide();
        $(btn).attr('disabled', false);
    });
}
function GeneratePrice4(btn) {
    if ($('#txtGenerateMonth').val() == '') {
        alert('请选择月份');
        return false;
    }
    $('#trLoading').show();
    var date = $('#txtGenerateMonth').val() + '-01';
    $(btn).attr('disabled', true);
    AjaxSrv.post({ type: 'GeneratePrice4', data: date }, function (callBackData) {
        if (callBackData == 1) {
            alert('操作成功');
        } else {
            alert('操作失败，请联系管理员');
        }
        $('#trLoading').hide();
        $(btn).attr('disabled', false);
    });
}
function GeneratePrice5(btn) {
    if ($('#txtGenerateMonth').val() == '') {
        alert('请选择月份');
        return false;
    }
    $('#trLoading').show();
    var date = $('#txtGenerateMonth').val() + '-01';
    $(btn).attr('disabled', true);
    AjaxSrv.post({ type: 'GeneratePrice5', data: date }, function (callBackData) {
        if (callBackData == 1) {
            alert('操作成功');
        } else {
            alert('操作失败，请联系管理员');
        }
        $('#trLoading').hide();
        $(btn).attr('disabled', false);
    });
}
function GeneratePrice6(btn) {
    if ($('#txtGenerateMonth').val() == '') {
        alert('请选择月份');
        return false;
    }
    $('#trLoading').show();
    var date = $('#txtGenerateMonth').val() + '-01';
    $(btn).attr('disabled', true);
    AjaxSrv.post({ type: 'GeneratePrice6', data: date }, function (callBackData) {
        if (callBackData == 1) {
            alert('操作成功');
        } else {
            alert('操作失败，请联系管理员');
        }
        $('#trLoading').hide();
        $(btn).attr('disabled', false);
    });
}
function SaveIsJoinOrder() {
    $('#divPriceChart').empty();
    $('#divTotalFloorChart').empty();
    $('#divPriceFactor').empty();
    $('#divConstructionAreaChart').empty();
    var obj = $('#basePriceList tbody :checkbox[checked=true]');

    var selected = new Array;
    for (i = 0; i < obj.length; i++) {
        selected.push($(obj[i]).attr('id'));
    }
    if (selected.length == 0) {
        alert("请选择需要纠错的记录！");
    }
    else {
        if (!confirm("确定要纠错" + selected.length + "条记录吗？"))
            return false;
        else {
            AjaxSrv.post({ type: 'SaveIsJoinOrder', data: selected }, function (callBackData) {
                alert('操作成功');
                CloseBlockUI();
                divList.loadData();
            });
        }
    }
}
function PriceView() {
    ShowSetPrice(1);
}
function ShowPlateToUnitPriceForm() {

    $.blockUI({ message: $('#divCalcPlateToUnitPriceForm'), css: {
        top: ($(window).height() - 150) / 2 + 'px',
        left: ($(window).width() - 300) / 2 + 'px',
        width: '300px',
        height: '150px',
        cursor: 'default'
    }, overlayCSS: {
        cursor: 'default'
    }
    });
}
function ShowGenerateNewPrice() {
    $.blockUI({ message: $('#divGenerateNewPrice'), css: {
        top: ($(window).height() - 290) / 2 + 'px',
        left: ($(window).width() - 400) / 2 + 'px',
        width: '400px',
        height: '290px',
        cursor: 'default'
    }, overlayCSS: {
        cursor: 'default'
    }
    });
}
function CalcPlateRateByMonth(btn) {
    if ($('#txtDate').val() == '') {
        alert('请输入日期');
        return false;
    }
    AjaxSrv.post({ type: 'GeneratePlateToUnitPrice', data: $('#txtDate').val() }, function (callBackData) {
        alert('操作成功');
        CloseBlockUI();
        divList.loadData();
    });
}
function ChangeFeedbackType(sel) {
    if ($(sel).val() == '-1') {
        $('#txtSetIdea').attr('disabled', true);
    } else {
        $('#txtSetIdea').attr('disabled', false);
    }
}
function ShowSetPrice(i) {
    var f = false;
    tab0 = false;
    tab1 = false;
    tab2 = false;
    tab3 = false;
    tab4 = false;
    tab5 = false;
    tab6 = false;
    setTab(2, 0);
    $('#divPriceChart').empty();
    $('#divTotalFloorChart').empty();
    $('#divPriceFactor').empty();
    $('#divConstructionAreaChart').empty();
    $(":radio[name='ModifyReason']").attr('checked', false);
    var obj = $('#basePriceList tbody :checkbox[checked="true"]');
    if (obj.length != 1) {
        alert('请选择一条需要编辑的数据');
        return false;
    }
    var selected = obj.attr('id');
    $('#ctl00_content_selFeedbackType').val('-1');
    $('#txtSetIdea').attr('disabled', true);

    AjaxSrv.post({ type: 'GetSetPriceDetail', data: selected }, function (callBackData) {
        var info = JSON.parse(callBackData);
        if (i == 0) {
            if (info.ResponseStatus == '-1') {
                alert('您没有权限操作该小区基价');
                return false;
            } else if (info.ResponseStatus == '0') {
                $('#btnSavePrice').hide();
                $('#txtUnitprice').attr('disabled', true);
                $('#txtBindPrice').attr('disabled', true);
                $('#txtSetPrice').attr('disabled', true);
                $('#txtVerifyPrice').attr('disabled', true);
                //$('#txtSetIdea').attr('disabled', true);
                $('#txtVerifyIdea').attr('disabled', true);
                $('#txtPriceMemo').attr('disabled', true);
                $('#txtUnitDifferenceMemo').attr('disabled', true);
            } else if (info.ResponseStatus == '1') {
                $('#btnSavePrice').show();
                $('#txtUnitprice').attr('disabled', true);
                $('#txtBindPrice').attr('disabled', true);
                $('#txtSetPrice').attr('disabled', false);
                $('#txtVerifyPrice').attr('disabled', true);
                //$('#txtSetIdea').attr('disabled', false);
                $('#txtVerifyIdea').attr('disabled', true);
                $('#txtPriceMemo').attr('disabled', true);
                $('#txtUnitDifferenceMemo').attr('disabled', true);
            } else if (info.ResponseStatus == '2') {
                $('#btnSavePrice').show();
                $('#txtUnitprice').attr('disabled', true);
                $('#txtBindPrice').attr('disabled', true);
                $('#txtSetPrice').attr('disabled', true);
                $('#txtVerifyPrice').attr('disabled', false);
                //$('#txtSetIdea').attr('disabled', true);
                $('#txtVerifyIdea').attr('disabled', false);
                $('#txtPriceMemo').attr('disabled', false);
                $('#txtUnitDifferenceMemo').attr('disabled', false);
            }
        } else if (i == 1) {
            $('#btnSavePrice').hide();
            $('#txtUnitprice').attr('disabled', true);
            $('#txtBindPrice').attr('disabled', true);
            $('#txtSetPrice').attr('disabled', true);
            $('#txtVerifyPrice').attr('disabled', true);
            $('#txtSetIdea').attr('disabled', true);
            $('#txtVerifyIdea').attr('disabled', true);
            $('#txtPriceMemo').attr('disabled', true);
        }
        $('#hdId').val(selected);
        $('#hdStatus').val(info.Status);
        $('#hdSettingsType').val(info.SettingsType);
        $('#hdTenementType').val(info.TenementType);
        $('#spanMonthRange').text(info.RangeString);
        $('#hdMonthStart').val(info.RangeStart);
        $('#hdCompletionYear').val(info.CompletionYear);
        $('#hdMonthEnd').val(info.RangeEnd);
        $('#txtPreviousUnitPrice').val(info.PreviousUnitPrice);
        $('#hdResponseStatus').val(info.ResponseStatus);
        $('#spanProjectId').text(info.ProjectId);
        $('#spanProjectName').text(info.ProjectName);
        $('#spanPublishdate').text(info.PublishDate);
        $('#txtUnitprice').val(info.UnitPrice);
        $('#txtBindPrice').val(info.BindPrice);
        $('#txtFittingValue').val(info.FittingValue);
        $('#txtPlateToUnitPrice').val(info.PlateToUnitPrice);
        $('#txtSetPrice').val(info.SetPriceUnitPrice);
        $('#txtVerifyPrice').val(info.VerifyUnitPrice);
        $('#txtModifyReason').val(info.ModifyPriceReason);
        $('#txtSetIdea').val('');
        $('#txtVerifyIdea').val(info.VerifyIdea);
        $('#txtPriceMemo').val(info.Memo);
        $('#txtUnitDifferenceMemo').val(info.UnitDifferenceMemo);
        $(':radio[name="ModifyReason"][value=' + info.ModifyPriceReasonId + ']').attr('checked', true);
        if (info.ModifyPriceReasonId == "3" || info.ModifyPriceReasonId == "4") {
            $('#txtModifyReason').show();
        }
        else {
            $('#txtModifyReason').hide();
        }
        $('#ctl00_content_selFeedbackType').val('-1');
        var projectid = obj.parent().next().text();
        AjaxSrv.post({ type: 'GetPriceAndFittingValueListByProject', data: projectid }, function (callBackData) {
            GeneratePriceListChart(callBackData);
        });

        $.blockUI({ message: $('#divSetPrice'), css: {
            top: '0px',
            left: ($(window).width() - 750) / 2 + 'px',
            width: '750px',
            height: $(window).height() - 5 + 'px',
            cursor: 'default'
        }, overlayCSS: {
            cursor: 'default'
        }
        });
        $('#divSetPriceDetail').css('height', $(window).height() - 400);
    });
}
function MaxAndMin(obj) {
    if ($(obj).text() == '收缩') {
        $('#divSearchContent #searchTable tbody').hide();
        $(obj).text('展开');
    } else {
        $('#divSearchContent #searchTable tbody').show();
        $(obj).text('收缩');
    }
}
function Feedback() {
    $('#divPriceChart').empty();
    $('#divTotalFloorChart').empty();
    $('#divPriceFactor').empty();
    $('#divConstructionAreaChart').empty();
    var obj = $('#basePriceList tbody :checkbox[checked=true]');
    if (obj.length != 1) {
        alert('请选择一条需要反馈的小区');
        return;
    }

    var projectId = obj.parent().find("input[name='projectId']").val();
    Divwin.show($(window).width() * 2 / 3, $(window).height() * 2 / 3, true, "../feedback/feedbackform.aspx?type=baseprice&projectId=" + projectId, true);
}
function SetMonthRange() {
    Divwin.show($(window).width() * 2 / 3, $(window).height() * 2 / 3, true, "MonthRangeForm.aspx", true);
}


var tipWidth = 260;
var delayTime = 500;
function showInvoiceInfo(e, ths, projectId) {
    currentFocus = ths;
    showtip("请稍后..", tipWidth);

    var timeId = window.setTimeout(function () {
        AjaxSrv.post({ type: 'GetBindProjectList', data: projectId }, function (callBackData) {
            showtip(callBackData);
        });
    }, delayTime);
    currentFocus.onmouseout = function () { hidetip(); window.clearTimeout(timeId) };

}
function showProjectSchoolMemo(e, ths, projectId) {
    currentFocus = ths;
    showtip("请稍后..", tipWidth);

    var timeId = window.setTimeout(function () {
        AjaxSrv.post({ type: 'GetProjectSchoolMemo', data: projectId }, function (callBackData) {
            showtip(callBackData);
        });
    }, delayTime);
    currentFocus.onmouseout = function () { hidetip(); window.clearTimeout(timeId) };

}
function SaveBasePrice(i) {

    obj.IsJoinOrder = i;
    AjaxSrv.post({ type: 'SaveBasePrice', data: JSON.stringify(obj) }, function (callBackData) {
        alert('操作成功');
        $('#divSetPrice').unblock();
        CloseBlockUI();
        divList.loadData();
    });
}
function SaveBindPrice() {
    $('#divPriceChart').empty();
    $('#divTotalFloorChart').empty();
    $('#divPriceFactor').empty();
    $('#divConstructionAreaChart').empty();
    var obj = $('#basePriceList tbody :checkbox[checked=true]');

    var selected = new Array;
    for (i = 0; i < obj.length; i++) {
        selected.push($(obj[i]).attr('id'));
    }
    if (selected.length == 0) {
        alert("请选择需要计算绑定小区的记录！");
    }
    else {
        if (!confirm("确定要计算" + selected.length + "条记录吗？"))
            return false;
        else {
            AjaxSrv.post({ type: 'SaveBindPrice', data: selected }, function (callBackData) {
                alert('操作成功');
                CloseBlockUI();
                divList.loadData();
            });
        }
    }
}
function AllSaveBindPrice() {
    var rtn = prompt("★注意：请谨慎操作！\n请输入\"OK\"确认是否全部计算绑定基价？", "Cancel")
    if (rtn != "ok" && rtn != "OK") {
        return;
    }
    $.blockUI({ message: '<h3><img src="/images/ajax-loader.gif" /> 计算中，请稍后...</h3>' });
    AjaxSrv.post({ type: 'AllSaveBindPrice', data: JSON.stringify(GetCondition()) }, function (callBackData) {
        alert('操作成功');
        divList.loadData();
        $.unblockUI();
    });
}

function MaxAndMin(obj) {
    if ($(obj).text() == '收缩') {
        $('#divSearchContent #searchTable tbody').hide();
        $(obj).text('展开');
    } else {
        $('#divSearchContent #searchTable tbody').show();
        $(obj).text('收缩');
    }
}
function ViewFeedBack(projectId) {
    Divwin.show($(window).width() * 2 / 4, $(window).height() * 2 / 4, true, "/admin/Feedback/FeedbackListView.aspx?projectId=" + projectId, true);
}
function PutIn() {
    $('#divPriceChart').empty();
    $('#divTotalFloorChart').empty();
    $('#divPriceFactor').empty();
    $('#divConstructionAreaChart').empty();
    var obj = $('#basePriceList tbody :checkbox[checked=true]');
    if (obj.length == 0) {
        alert('请选择需要提交的记录');
        return;
    }

    var selected = new Array;
    for (i = 0; i < obj.length; i++) {
        selected.push($(obj[i]).attr('id'));
    }
    if (selected.length == 0) {
        alert("请选择要提交的记录！");
    }
    else {
        if (!confirm("确定要提交" + selected.length + "条记录吗？"))
            return false;
        else {
            AjaxSrv.post({ type: 'BasePricePutIn', data: selected }, function (callBackData) {
                alert('操作成功');
                $('#divSetPrice').unblock();
                CloseBlockUI();
                divList.loadData();
            });
        }
    }

}
function selectAll(obj) {
    if ($(obj).attr('checked') == true) {
        $('#basePriceList tbody :checkbox').attr('checked', 'checkbox');
    } else {
        $('#basePriceList tbody :checkbox').attr('checked', '');
    }
}
function Publish() {
    $('#divPriceChart').empty();
    $('#divTotalFloorChart').empty();
    $('#divPriceFactor').empty();
    $('#divConstructionAreaChart').empty();
    var obj = $('#basePriceList tbody :checkbox[checked=true]');
    if (obj.length == 0) {
        alert('请选择需要发布的记录');
        return;
    }

    var selected = new Array;
    for (i = 0; i < obj.length; i++) {
        selected.push($(obj[i]).attr('id'));
    }

    if (selected.length == 0) {
        alert("请选择要发布的记录！");
    }
    else {
        if (!confirm("确定要发布" + selected.length + "条记录吗？"))
            return false;
        else {
            AjaxSrv.post({ type: 'Publish', data: selected }, function (callBackData) {
                alert('操作成功');
                CloseBlockUI();
                divList.loadData();
            });
        }
    }
}
function AllPublish() {
    var rtn = prompt("★注意：请谨慎操作！\n请输入\"OK\"确认是否全部发布？", "Cancel")
    if (rtn != "ok" && rtn != "OK") {
        return;
    }
    AjaxSrv.post({ type: 'AllPublish', data: JSON.stringify(GetCondition()) }, function (callBackData) {
        alert('操作成功');
        CloseBlockUI();
        divList.loadData();
    });
}
function CancelPublish() {
    $('#divPriceChart').empty();
    $('#divTotalFloorChart').empty();
    $('#divPriceFactor').empty();
    $('#divConstructionAreaChart').empty();
    var obj = $('#basePriceList tbody :checkbox[checked=true]');
    if (obj.length == 0) {
        alert('请选择需要取消发布的记录');
        return;
    }

    var selected = new Array;
    for (i = 0; i < obj.length; i++) {
        selected.push($(obj[i]).attr('id'));
    }

    if (selected.length == 0) {
        alert("请选择要取消发布的记录！");
    }
    else {
        if (!confirm("确定要取消发布" + selected.length + "条记录吗？"))
            return false;
        else {
            AjaxSrv.post({ type: 'CancelPublish', data: selected }, function (callBackData) {
                alert('操作成功');
                CloseBlockUI();
                divList.loadData();
            });
        }
    }
}
function AllAuditingPass() {
    var rtn = prompt("★注意：请谨慎操作！\n请输入\"OK\"确认是否全部审核？", "Cancel")
    if (rtn != "ok" && rtn != "OK") {
        return;
    }
    //JSCallBackHandler.newCallBack("AllAuditingPass", GetCondition(), function() { basePriceList.refresh(); });

    //JSCallBackHandler.newCallBack("AllAuditingPass", JSON.stringify(GetCondition()), function() { divList.loadData(); });
    AjaxSrv.post({ type: 'AllAuditingPass', data: JSON.stringify(GetCondition()) }, function (callBackData) {
        alert('操作成功');
        $('#divSetPrice').unblock();
        CloseBlockUI();
        divList.loadData();
    });
}
function AuditingPass() {
    $('#divPriceChart').empty();
    $('#divTotalFloorChart').empty();
    $('#divPriceFactor').empty();
    $('#divConstructionAreaChart').empty();
    var obj = $('#basePriceList tbody :checkbox[checked=true]');
    if (obj.length == 0) {
        alert('请选择需要审核通过的记录');
        return;
    }

    var selected = new Array;
    for (i = 0; i < obj.length; i++) {
        selected.push($(obj[i]).attr('id'));
    }

    if (selected.length == 0) {
        alert("请选择要审核通过的记录！");
    }
    else {
        if (!confirm("确定要审核通过" + selected.length + "条记录吗？"))
            return false;
        else {
            AjaxSrv.post({ type: 'AuditingPass', data: selected }, function (callBackData) {
                alert('操作成功');
                $('#divSetPrice').unblock();
                CloseBlockUI();
                divList.loadData();
            });
        }
    }

}
function CancelAuditingPass() {
    $('#divPriceChart').empty();
    $('#divTotalFloorChart').empty();
    $('#divPriceFactor').empty();
    $('#divConstructionAreaChart').empty();
    var obj = $('#basePriceList tbody :checkbox[checked=true]');
    if (obj.length == 0) {
        alert('请选择一条需要审核退回通过的记录');
        return;
    }

    var selected = new Array;
    for (i = 0; i < obj.length; i++) {
        selected.push($(obj[i]).attr('id'));
    }

    if (selected.length == 0) {
        alert("请选择要审核退回的记录！");
    }
    else {
        if (!confirm("确定要审核退回通过" + selected.length + "条记录吗？"))
            return false;
        else {
            AjaxSrv.post({ type: 'CancelAuditingPass', data: selected }, function (callBackData) {
                alert('操作成功');
                $('#divSetPrice').unblock();
                CloseBlockUI();
                divList.loadData();
            });
        }
    }

}
function GenerateIndexData() {
    $.blockUI({ message: $('#divCalc'),
        css: {
            top: ($(window).height() - 150) / 2 + 'px',
            left: ($(window).width() - 300) / 2 + 'px',
            width: '300px',
            height: '150px',
            cursor: 'default'
        }, overlayCSS: {
            cursor: 'default'
        }
    });
}
var idList = '';
var projectIdList = '';
var batchPublishdate = '';
function ShowBatchUnitPriceForm() {
    projectIdList = '';
    idList = '';
    batchPublishdate = '';
    var obj = $('#basePriceList tbody :checkbox[checked=true]');
    if (obj.length == 0) {
        alert('请选择需要批量修改价格的记录');
        return;
    }

    for (i = 0; i < obj.length; i++) {
        idList += $(obj[i]).attr('id') + ',';
        projectIdList += $(obj[i]).parent().next().text() + ',';
        if (batchPublishdate == '') {
            batchPublishdate = $(obj).parent().parent().find('td').eq(10).text().replace('.','-') + '-01';
        }
    }
    idList = idList.substring(0, idList.length - 1);
    projectIdList = projectIdList.substring(0, projectIdList.length - 1);

    $.blockUI({ message: $('#divBatchUnitPriceForm'),
        css: {
            top: ($(window).height() - 150) / 2 + 'px',
            left: ($(window).width() - 300) / 2 + 'px',
            width: '300px',
            height: '150px',
            cursor: 'default'
        }, overlayCSS: {
            cursor: 'default'
        }
    });
}
function BatchSaveUnitPrice(btn) {
    if ($('#txtModifyRate').val().trim() == '') {
        alert('请输入幅度');
        return false;
    }
    var obj = new Object();
    obj.idList = idList;
    obj.projectIdList = projectIdList;
    obj.batchPublishdate = batchPublishdate;
    obj.ModifyRate = parseFloat($('#txtModifyRate').val().trim());
    $(btn).attr('disabled', true);
    $(btn).next().css('visibility', 'visible');
    AjaxSrv.post({ type: 'BatchSaveUnitPrice', data: JSON.stringify(obj) }, function (callBackData) {
        if (callBackData == 1) {
            alert('操作成功');
        } else {
            alert('系统错误，请联系管理员');
        }
        $(btn).attr('disabled', false);
        $(btn).next().css('visibility', 'hidden');
        CloseBlockUI();
        divList.loadData();
    });
}
function CalcIndexData(btn) {
    if ($('#txtCalcMonth').val() == '') {
        alert('请选择生成月份');
        return false;
    }
    $(btn).attr('disabled', true);
    var month = $('#txtCalcMonth').val() + '-01';
    $('#sLoading').css('visibility', 'visible');
    AjaxSrv.post({ type: 'GenerateIndexData', data: month }, function (callBackData) {
        if (callBackData == 1) {
            alert('操作成功');
        } else {
            alert('系统错误，请联系管理员');
        }
        $.unblockUI();
        $('#sLoading').css('visibility', 'hidden');
        $(btn).attr('disabled', false);
    });
}
function Statistics() {
    Divwin.show($(window).width() * 2 / 3, $(window).height() * 2 / 3, true, "Popup/StatisticsForm.aspx", true);
}

function CloseBlockUI() {
    $.unblockUI();
}
function Test() {
    AjaxSrv.post({ type: 'test', data: '' }, function (callBackData) {
        if (callBackData == 1) {
            alert('操作成功');
        } else {
            alert('系统错误，请联系管理员');
        }
        
    });
}