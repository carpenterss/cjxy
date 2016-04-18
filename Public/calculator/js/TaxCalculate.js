/*汇总计算*/
/*
sumPrice:房屋总价[单位:元]
houseType:房产性质[0普通住宅/1非普通住宅]
onlyBuy:买房家庭唯一住房[0是/1否]
areaHouse:房屋面积[平方米]
isFiveYear：房产购置满5年[0是/1否]
valSellHouse:卖方家庭唯一住房[0是/1否]
levyWay:计征方式[0总价/1差额]
castPrice:房屋购入原价[单位:元]
*/
function CalDues(sumPrice, houseType, onlyBuy, areaHouse, isFiveYear, valSellHouse, levyWay, castPrice) {

    /*计算契税*/
    var deedTax = CalDeedTax(sumPrice, houseType, onlyBuy, areaHouse);
    /*计算营业税*/
    var busTax = DoBusTax(sumPrice, houseType, isFiveYear, castPrice);
    /*计算个人所得税*/
    var incomeTax = CalIncomeTaxPerson(sumPrice, isFiveYear, valSellHouse, levyWay, houseType, castPrice);
    /*计算中介费*/
    sumPrice = Math.abs((sumPrice * 0.01).toFixed(2));
    var taxesObj = {};
    /*
     DeedTax:契税
     BusTax:营业税
     IncomeTax:个人所得税
     SumPrice:中介费[买家/卖家]    
    */
    taxesObj = { DeedTax: deedTax, BusTax: busTax, IncomeTax: incomeTax, SumPrice: sumPrice };
    return taxesObj;
}
/*计算房屋总价*/
function CalSumHouse() {
    var area = $("#txtArea").val();
    var unitPrice = $("#txtUnitPrice").val();
    if($.trim(area).length<=0 || $.trim(unitPrice).length<=0)
    {
        return;
    }
    if ($("#selSumPrice").val() == "万元") {
        $("#txtSumPrice").val(Math.abs(((area * unitPrice) / 10000).toFixed(2)));
    }
    else {
        $("#txtSumPrice").val(Math.abs((area * unitPrice).toFixed(2)));
    }
}

/*计算契税*/
/*
sumPice:房屋价格[元]
houseType:0普通住宅/1非普通住在
onlyBuy:买房家庭唯一住宅[0是/1否]
areaHouse:房屋面积[平方米]
*/
function CalDeedTax(sumPrice, houseType, onlyBuy, areaHouse) {
    var deedTax = 0;    
    if (houseType == "0") {/*普通住宅*/
        if (onlyBuy == 0 && areaHouse < 90)/*买房家庭唯一住宅+ area<90*/
        {
            deedTax = sumPrice * 0.01;
        }
        else if (onlyBuy == 0) {
            deedTax = sumPrice * 0.015;
        }
        else {
            deedTax = sumPrice * 0.03;
        }

    }
    else {
        deedTax = sumPrice * 0.03;
    }
    return deedTax;
}

/*
sumPrice：房屋总价[元]
houseType:0普通住宅/1非普通住宅
IsFiveYear:05年/1不到5年
casePrice：房屋原价[元]
*/
/*营业税计算*/
function DoBusTax(sumPrice, houseType, IsFiveYear,castPrice) {
    var busTax = 0;
    
    if (houseType == 0) {
        if (IsFiveYear == 0) {
            busTax = busTax;
        }
        else {
            busTax = sumPrice * 0.0565;
        }
    }
    else {
        if (IsFiveYear == 0) {
            busTax = (sumPrice - castPrice) * 0.0565;
        }
        else {
            busTax = sumPrice * 0.0565;
        }
    }
    return Math.abs(busTax.toFixed(2));
}

/*
sumPrice:总价[元]
valYear:房产购置是否满5年[0是/1否]
valSelHouse:是否卖方家庭唯一住房[0是/1否]
levyWay:计征方式 总价/差额[0是/1否]
houseType:房产性质 普通/非普通[0是/1否]
castPrice: 原价[元]
*/
/*个人所得税计算*/
function CalIncomeTaxPerson(sumPrice, valYear, valSellHouse, levyWay, houseType,castPrice) 
{
    var incomeTax = 0;
    if (valYear == 0 && valSellHouse == 0) {
        return Math.abs(incomeTax.toFixed(2));
    }
    else {
        
        if (levyWay == 0 && houseType == 0) {
            incomeTax = sumPrice * 0.01;
        }
        else if (levyWay == 0 && houseType == 1) {
            incomeTax = sumPrice * 0.02;
        }
        else {            
            incomeTax = (sumPrice - castPrice) * 0.2;
        }
    }
    return Math.abs(incomeTax.toFixed(2));
}

function ChangeLevyWay()
{
    if($("#selLevyWay").val()==0)
    {
        $("#trCasePrice").hide();
    }
    else
    {
        $("#trCasePrice").show();
    }
}
/*总计算*/
function CalHouseTax() {
    if ($("#selLevyWay").val() == 1 && $.trim($("#txtCastPrice").val()).length <= 0) {
        alert("请输入房屋原价!");
        return;
    }
    /*计算契税*/
    var sumUnit = $("#selSumPrice").val();
    var sumPrice = $("#txtSumPrice").val();
    if (sumUnit == "万元") {
        sumPrice = sumPrice * 10000;
    }
    var castUnitPrice = $("#selCastPrice").val();
    var castPrice = $("#txtCastPrice").val();
    if (castUnitPrice == "万元") {
        castPrice = castPrice * 10000;
    }
    var houseType = $("#selHouseNature").val();
    var onlyBuy = $('input:radio[name="repay_radio2"]:checked').val();
    var areaHouse = $("#txtArea").val();
    var isFiveYear = $('input:radio[name="repay_radio1"]:checked').val();    
    var valSellHouse = $('input:radio[name="repay_radio3"]:checked').val();
    var levyWay = $("#selLevyWay").val();
    //sumPrice = Math.abs((sumPrice * 0.01).toFixed(2));

    var Taxed = CalDues(sumPrice, houseType, onlyBuy, areaHouse, isFiveYear, valSellHouse, levyWay, castPrice);

    $("#txtDeedTax").val(Taxed.DeedTax);
    $("#txtBusinessTax").val(Taxed.BusTax);
    $("#txtIncomeTax").val(Taxed.IncomeTax);
    $("#txtBuyAgencyFee").val(Taxed.SumPrice);
    $("#txtSellAgencyFee").val(Taxed.SumPrice);
}
