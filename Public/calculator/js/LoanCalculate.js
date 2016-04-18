/**********************************商业贷款金额计算部分********************************************/
/*
综合计算
*/
/*
yearPeriad:总期数(月)[商业贷款]
money:本金[商业贷款 单位元]
monthInterest:月利息[商业贷款 格式:x.xxxxxx 小数点后六位]
money1:本金[公积金 单位元]
monthInterest1:月利息[公积金 格式x.xxxxxx 小数点后六位]
typeInterest:还息类型[0等额本金/1等额本息]
typeCal:计算类型[0商业贷款/1公积金贷款/2组合贷款]
*/
function CalLoan(yearPeriad, money, monthInterest, money1, monthInterest1, typeInterest, typeCal) {

    var HouseLoanObject = {};
    if (typeInterest == 0) {
        switch (typeCal) {
            case 0:
                HouseLoanObject = CalAverageCapitalComm(yearPeriad, money, monthInterest);
                break;
            case 1:
                HouseLoanObject = CalAverageCapitalComm(yearPeriad, money, monthInterest1);
                break;
            case 2:
                var HouseLoanObject1 = CalAverageCapitalComm(yearPeriad, money, monthInterest);
                var HouseLoanObject2 = CalAverageCapitalComm(yearPeriad, money1, monthInterest1);
                HouseLoanObject.BusInterest = HouseLoanObject1.Result;
                HouseLoanObject.AccuInterest = HouseLoanObject2.Result;
                HouseLoanObject.Result = HouseLoanObject1.Result + HouseLoanObject2.Result;
                HouseLoanObject.ResultCount = HouseLoanObject1.ResultCount + HouseLoanObject2.ResultCount;
                HouseLoanObject.MaxPayment = HouseLoanObject1.MaxPayment + HouseLoanObject2.MaxPayment;
                HouseLoanObject.MaxInterest = HouseLoanObject1.MaxInterest + HouseLoanObject2.MaxInterest;

                var houseLoan = {};
                var houseLoanArray = new Array();

                for (var i = 1; i <= yearPeriad; i++) {
                    houseLoan =
                    {
                        ReplyPrincipalIntreest: (HouseLoanObject1.HouseLoan[i - 1].ReplyPrincipalIntreest + HouseLoanObject2.HouseLoan[i - 1].ReplyPrincipalIntreest),
                        ReplyInterest: (HouseLoanObject1.HouseLoan[i - 1].ReplyInterest + HouseLoanObject2.HouseLoan[i - 1].ReplyInterest),
                        ReplyPrincipal: (HouseLoanObject1.HouseLoan[i - 1].ReplyPrincipal + HouseLoanObject2.HouseLoan[i - 1].ReplyPrincipal),
                        SurplusPrincipal: (HouseLoanObject1.HouseLoan[i - 1].SurplusPrincipal + HouseLoanObject2.HouseLoan[i - 1].SurplusPrincipal)
                    };
                    houseLoanArray.push(houseLoan);
                }
                HouseLoanObject.HouseLoan = houseLoanArray;
                break;
        }
    }
    else if(typeInterest == 1){
        switch (typeCal) {
            case 0:
                HouseLoanObject = CalAverageCapitalPlusInterestComm(yearPeriad, money, monthInterest);
                break;
            case 1:
                HouseLoanObject = CalAverageCapitalPlusInterestComm(yearPeriad, money1, monthInterest1);
                break;
            case 2:
                var HouseLoanObject1 = CalAverageCapitalPlusInterestComm(yearPeriad, money, monthInterest);
                var HouseLoanObject2 = CalAverageCapitalPlusInterestComm(yearPeriad, money1, monthInterest1);
                HouseLoanObject.BusInterest = HouseLoanObject1.Result;
                HouseLoanObject.AccuInterest = HouseLoanObject2.Result;
                HouseLoanObject.Result = HouseLoanObject1.Result + HouseLoanObject2.Result;
                HouseLoanObject.ResultCount = HouseLoanObject1.ResultCount + HouseLoanObject2.ResultCount;
                HouseLoanObject.MonthPayment = HouseLoanObject1.MonthPayment + HouseLoanObject2.MonthPayment;
                HouseLoanObject.MaxPayment = HouseLoanObject1.MaxPayment + HouseLoanObject2.MaxPayment;
                HouseLoanObject.MaxInterest = HouseLoanObject1.MaxInterest + HouseLoanObject2.MaxInterest;

                var houseLoan = {};
                var houseLoanArray = new Array();

                for (var i = 1; i <= yearPeriad; i++) {
                    houseLoan =
                    {
                        ReplyPrincipalIntreest: (HouseLoanObject1.HouseLoan[i - 1].ReplyPrincipalIntreest + HouseLoanObject2.HouseLoan[i - 1].ReplyPrincipalIntreest),
                        ReplyInterest: (HouseLoanObject1.HouseLoan[i - 1].ReplyInterest + HouseLoanObject2.HouseLoan[i - 1].ReplyInterest),
                        ReplyPrincipal: (HouseLoanObject1.HouseLoan[i - 1].ReplyPrincipal + HouseLoanObject2.HouseLoan[i - 1].ReplyPrincipal),
                        SurplusPrincipal: (HouseLoanObject1.HouseLoan[i - 1].SurplusPrincipal + HouseLoanObject2.HouseLoan[i - 1].SurplusPrincipal)
                    };
                    houseLoanArray.push(houseLoan);
                }

                HouseLoanObject.HouseLoan = houseLoanArray;
                break;
        }
    }else {
        switch (typeCal) {
            case 0:
                HouseLoanObject = anyuejie(yearPeriad, money, monthInterest);
                break;
            case 1:
                HouseLoanObject = CalAverageCapitalPlusInterestComm(yearPeriad, money1, monthInterest1);
                break;
            case 2:
                var HouseLoanObject1 = CalAverageCapitalPlusInterestComm(yearPeriad, money, monthInterest);
                var HouseLoanObject2 = CalAverageCapitalPlusInterestComm(yearPeriad, money1, monthInterest1);
                HouseLoanObject.BusInterest = HouseLoanObject1.Result;
                HouseLoanObject.AccuInterest = HouseLoanObject2.Result;
                HouseLoanObject.Result = HouseLoanObject1.Result + HouseLoanObject2.Result;
                HouseLoanObject.ResultCount = HouseLoanObject1.ResultCount + HouseLoanObject2.ResultCount;
                HouseLoanObject.MonthPayment = HouseLoanObject1.MonthPayment + HouseLoanObject2.MonthPayment;
                HouseLoanObject.MaxPayment = HouseLoanObject1.MaxPayment + HouseLoanObject2.MaxPayment;
                HouseLoanObject.MaxInterest = HouseLoanObject1.MaxInterest + HouseLoanObject2.MaxInterest;

                var houseLoan = {};
                var houseLoanArray = new Array();

                for (var i = 1; i <= yearPeriad; i++) {
                    houseLoan =
                    {
                        ReplyPrincipalIntreest: (HouseLoanObject1.HouseLoan[i - 1].ReplyPrincipalIntreest + HouseLoanObject2.HouseLoan[i - 1].ReplyPrincipalIntreest),
                        ReplyInterest: (HouseLoanObject1.HouseLoan[i - 1].ReplyInterest + HouseLoanObject2.HouseLoan[i - 1].ReplyInterest),
                        ReplyPrincipal: (HouseLoanObject1.HouseLoan[i - 1].ReplyPrincipal + HouseLoanObject2.HouseLoan[i - 1].ReplyPrincipal),
                        SurplusPrincipal: (HouseLoanObject1.HouseLoan[i - 1].SurplusPrincipal + HouseLoanObject2.HouseLoan[i - 1].SurplusPrincipal)
                    };
                    houseLoanArray.push(houseLoan);
                }

                HouseLoanObject.HouseLoan = houseLoanArray;
                break;
        }
    }
    /*
    BusInterest:组合计算商业贷款利息总额
    AccuInterest：组合计算公积金贷款利息总额
    Result:利息总额
    ResultCount:累计还款总额
    MonthPayment:每月月供
    MaxPayment:最高月供
    MaxInterest:最高利息
    HouseLoan:累计偿还利息集合
    */
    return HouseLoanObject;
}
/*计算公式=（总期数(月)+1）* 本金 *(月利率)/2 
月利率=年利率/12
*/
/*
通用等额本金计算规则
利息总额=(总期数+1)*本金*月利率/2
累计还款总额=本金+利息总额
最高月供=（本金/总期数）+（本金-0）*月利息
最高月付利息=本金*月利息^1
*/
/*
yearPeriad:总期数(月)
money:本金[元]
monthInterest:月利率
*/
function CalAverageCapitalComm(yearPeriad, money, monthInterest) {

    /*最高月供=(本金/总期数(月))+(本金-0)*月利息*/
    var maxPayment = (money / yearPeriad) + (money - 0) * monthInterest;
    maxPayment = Math.abs(maxPayment.toFixed(2));

    /*商贷利息总额=（总期数(月)+1）* 本金 *(月利率)/2 */
    var result = ((money / yearPeriad + money * monthInterest) + money / yearPeriad * (1+ monthInterest))/2*yearPeriad - money;
    result = Math.abs(result.toFixed(2));

    /*累计还款总额=利息+本金*/
    var resultCount = parseFloat(result.toFixed(2)) + parseFloat(money);
    resultCount = Math.abs(resultCount);

    /*最高利息=本金*(年利率/12)^1*/
    var maxInterest = money * Math.pow(monthInterest, 1);
    maxInterest = Math.abs(maxInterest.toFixed(2));

    var houseLoan = {};
    var houseLoanArray = new Array();
    for (var i = 1; i <= yearPeriad; i++) {
        var replyPrincipalIntreest = (i != 1 ? ((money - (money / yearPeriad) * (i - 1)) * monthInterest) + (money / yearPeriad) : maxPayment); //偿还本息
        var replyInterest = (i != 1 ? ((money - (money / yearPeriad) * (i - 1)) * monthInterest) : maxInterest); //偿还利息
        var replyPrincipal = money / yearPeriad; //偿还本金
        var surplusPrincipal = money - (money / yearPeriad) * i; //剩余本金
        houseLoan = { ReplyPrincipalIntreest: replyPrincipalIntreest, ReplyInterest: replyInterest, ReplyPrincipal: replyPrincipal, SurplusPrincipal: surplusPrincipal };
        houseLoanArray.push(houseLoan);
    }
    var HouseLoanObject = {};
    HouseLoanObject.Result = result;
    HouseLoanObject.ResultCount = resultCount;
    HouseLoanObject.MaxPayment = maxPayment;
    HouseLoanObject.MaxInterest = maxInterest;
    HouseLoanObject.HouseLoan = houseLoanArray;
    return HouseLoanObject;
}
function anyue(yearPeriad, money, monthInterest) {

    /*最高月供=(本金/总期数(月))+(本金-0)*月利息*/
    var maxPayment = money * monthInterest
    maxPayment = Math.abs(maxPayment.toFixed(2));

    /*商贷利息总额=（总期数(月)+1）* 本金 *(月利率)/2 */
    var result = ((money / yearPeriad + money * monthInterest) + money / yearPeriad * (1+ monthInterest))/2*yearPeriad - money;
    result = Math.abs(result.toFixed(2));

    /*累计还款总额=利息+本金*/
    var resultCount = parseFloat(result.toFixed(2)) + parseFloat(money);
    resultCount = Math.abs(resultCount);

    /*最高利息=本金*(年利率/12)^1*/
    var maxInterest = money * Math.pow(monthInterest, 1);
    maxInterest = Math.abs(maxInterest.toFixed(2));

    var houseLoan = {};
    var houseLoanArray = new Array();
    for (var i = 1; i <= yearPeriad; i++) {
        var replyPrincipalIntreest = (i != 1 ? ((money - (money / yearPeriad) * (i - 1)) * monthInterest) + (money / yearPeriad) : maxPayment); //偿还本息
        var replyInterest = (i != 1 ? ((money - (money / yearPeriad) * (i - 1)) * monthInterest) : maxInterest); //偿还利息
        var replyPrincipal = money / yearPeriad; //偿还本金
        var surplusPrincipal = money - (money / yearPeriad) * i; //剩余本金
        houseLoan = { ReplyPrincipalIntreest: replyPrincipalIntreest, ReplyInterest: replyInterest, ReplyPrincipal: replyPrincipal, SurplusPrincipal: surplusPrincipal };
        houseLoanArray.push(houseLoan);
    }
    var HouseLoanObject = {};
    HouseLoanObject.Result = result;
    HouseLoanObject.ResultCount = resultCount;
    HouseLoanObject.MaxPayment = maxPayment;
    HouseLoanObject.MaxInterest = maxInterest;
    HouseLoanObject.HouseLoan = houseLoanArray;
    return HouseLoanObject;
}
/*二次封装*/
function CalAverageCapitalPlusInterestCommT(yearPeriad, money, monthInterest, money1, monthInterest1, typeInterest, typeCal) {

    var HouseLoanObject = CalLoan(yearPeriad, money, monthInterest, money1, monthInterest1, typeInterest, typeCal);
    if (typeCal == 2) {
        /*商贷利息总额*/
        $("#txtInterestResult").val(HouseLoanObject.BusInterest);
        /*公积金利息总额*/
        $("#txtReservedFunds").val(HouseLoanObject.AccuInterest);
    }
    $("#txtInterestCount").val(HouseLoanObject.Result);
    $("#txtRepayment").val(HouseLoanObject.ResultCount);

    $("#txtMonthPayment").val(HouseLoanObject.MonthPayment.toFixed(2));
    $("#txtMonthMaxPayment").val(HouseLoanObject.MaxPayment);

    $("#tblResult tbody").empty();
    var strHtml = ""
    for (var i = 1; i <= HouseLoanObject.HouseLoan.length; i++) {
        strHtml += "<tr style='line-height:30px;'>"
                        + "<td>" + i + "</td>"
                        + "<td>" + Math.abs(HouseLoanObject.HouseLoan[i - 1].ReplyPrincipalIntreest.toFixed(2)) + "</td>"
                        + "<td>" + Math.abs(HouseLoanObject.HouseLoan[i - 1].ReplyInterest.toFixed(2)) + "</td>"
                        + "<td>" + Math.abs(HouseLoanObject.HouseLoan[i - 1].ReplyPrincipal.toFixed(2)) + "</td>"
                        + "<td>" + Math.abs(HouseLoanObject.HouseLoan[i - 1].SurplusPrincipal.toFixed(2)) + "</td>"
                        + "</tr>";
    }
    $("#tblResult tbody").append(strHtml);
}
/*二次封装*/
function anyuejiexical(yearPeriad, money, monthInterest, money1, monthInterest1, typeInterest, typeCal) {

    var last = parseFloat(money) + money * monthInterest;
    var HouseLoanObject = CalLoan(yearPeriad, money, monthInterest, money1, monthInterest1, typeInterest, typeCal);
    if (typeCal == 2) {
        /*商贷利息总额*/
        $("#txtInterestResult").val(HouseLoanObject.BusInterest);
        /*公积金利息总额*/
        $("#txtReservedFunds").val(HouseLoanObject.AccuInterest);
    }
    $("#txtInterestCount").val(HouseLoanObject.Result);
    $("#txtRepayment").val(HouseLoanObject.ResultCount);

    $("#txtMonthPayment").val(HouseLoanObject.MonthPayment.toFixed(2));
    $("#txtMonthMaxPayment").val(HouseLoanObject.MaxPayment);
    $("#mrlx").val(Math.abs(parseFloat(money * monthInterest).toFixed(2)));

    $("#tblResult tbody").empty();
    var strHtml = ""
    for (var i = 1; i < yearPeriad; i++) {
        strHtml += "<tr style='line-height:30px;'>"
                        + "<td>" + i + "</td>"
                        + "<td>" + Math.abs(parseFloat(money * monthInterest).toFixed(2)) + "</td>"
                        + "<td>" + Math.abs(parseFloat(money * monthInterest).toFixed(2)) + "</td>"
                        + "<td>" + Math.abs(0) + "</td>"
                        + "<td>" + Math.abs(parseFloat(money).toFixed(2)) + "</td>"
                        + "</tr>";
    }
    strHtml += "<tr style='line-height:30px;'>"
    + "<td>" + i + "</td>"
    + "<td>" + Math.abs(parseFloat(last).toFixed(2)) + "</td>"
    + "<td>" + Math.abs(parseFloat(money * monthInterest).toFixed(2)) + "</td>"
    + "<td>" + Math.abs(parseFloat(money).toFixed(2)) + "</td>"
    + "<td>" + Math.abs(0) + "</td>"
    + "</tr>";
    $("#tblResult tbody").append(strHtml);
}
/*二次封装*/
function CalAverageCapitalCommT(yearPeriad, money, monthInterest, money1, monthInterest1, typeInterest, typeCal) {

    var HouseLoanObject = CalLoan(yearPeriad, money, monthInterest, money1, monthInterest1, typeInterest, typeCal);
    if (typeCal == 2) {
        /*商贷利息总额*/
        $("#txtInterestResult").val(HouseLoanObject.BusInterest);
        /*公积金利息总额*/
        $("#txtReservedFunds").val(HouseLoanObject.AccuInterest);
    }
    /*商贷利息总额*/
    $("#txtInterestCount").val(HouseLoanObject.Result.toFixed(2));
    /*累计还款总额*/
    $("#txtRepayment").val(HouseLoanObject.ResultCount);
    /*最高月供*/
    $("#txtMonthPayment").val(HouseLoanObject.MaxPayment);
    /*最高利息*/
    $("#txtMonthMaxPayment").val(HouseLoanObject.MaxInterest);

    $("#tblResult tbody").empty();
    var strHtml = ""
    for (var i = 1; i <= HouseLoanObject.HouseLoan.length; i++) {
        strHtml += "<tr style='line-height:30px;'>"
                        + "<td>" + i + "</td>"
                        + "<td>" + Math.abs(HouseLoanObject.HouseLoan[i - 1].ReplyPrincipalIntreest.toFixed(2)) + "</td>"
                        + "<td>" + Math.abs(HouseLoanObject.HouseLoan[i - 1].ReplyInterest.toFixed(2)) + "</td>"
                        + "<td>" + Math.abs(HouseLoanObject.HouseLoan[i - 1].ReplyPrincipal.toFixed(2)) + "</td>"
                        + "<td>" + Math.abs(HouseLoanObject.HouseLoan[i - 1].SurplusPrincipal.toFixed(2)) + "</td>"
                        + "</tr>";
    }
    $("#tblResult tbody").append(strHtml);
}
/*商业贷款等额本金计算*/
function  CalAverageCapitalBus() {
    var writeOrCommerical = $("#business_rate_select").val();
    var yearInterest = ""
    yearInterest = $("#txtInterest").val() / 100; //计算年利息
    var money = $("#txtMoney").val();         //本金
    var monthInterest = yearInterest/10 ;          //月利息
    var yearPeriad = $("#loan_period_select").val();  //总期数
    if(yearInterest.length == 0||money.length==0||monthInterest.length==0||yearPeriad.length==0)
    {
        alert('信息填写有误，请重新输入');
        return;
    }
    $("#divMaxMonthMoney").val("最高月供");
    CalAverageCapitalCommT(yearPeriad, money, monthInterest, 0, 0, 0, 0);

}
/*公积金贷款等额本金计算*/
function CalAverageCapitalReserve() {
    var writeOrCommerical = $("#selPAFrate").val();
    var yearInterest = ""
    if (writeOrCommerical != -1)                    //非手动输入
    {
        yearInterest = $("#txtInterest1").val() / 100; //计算年利息
    }
    else {
        yearInterest = $("#txtWrite1").val() / 100;    //手动输入年利息
    }
    var money = $("#txtMoney1").val() * 10000;         //本金
    var monthInterest = yearInterest / 12;          //月利息
    var yearPeriad = $("#loan_period_select2").val() * 12;  //总期数
    $("#divMaxMonthMoney").val("最高月供");

    CalAverageCapitalCommT(yearPeriad, 0, 0, money, monthInterest, 0, 1);
}
/*
商业贷款等额本息计算通用方法
偿还本息 = （本金*月利息）*(1+月利息)^贷款期限)/((1+月利息)^贷款期限-1）
利息总额 = 偿还本息*总期数-本金
累计还款总额 = 偿还本息 * 总期数
每月月供=偿还本息
最高月付利息=本金*月利息^1
*/
/*
yearPeriad:总期数(月)
money:本金
monthInterest:月利率
*/
function CalAverageCapitalPlusInterestComm(yearPeriad, money, monthInterest) {
    /*偿还本息=(（本金*月利息）*(1+月利息)^贷款期限)/((1+月利息)^贷款期限-1）*/
    var repleyInterest = (money * monthInterest * Math.pow(1 + monthInterest, yearPeriad)) / (Math.pow(1 + monthInterest, yearPeriad) - 1);

    /*利息总额=偿还本息*总期数 - 本金*/
    var result = repleyInterest * yearPeriad - money;
    result = Math.abs(result.toFixed(2));

    /*累计还款总额=偿还本息* 总期数*/
    var resultCount = repleyInterest * yearPeriad;
    resultCount = Math.abs(resultCount.toFixed(2));

    /*每月月供=偿还本息*/
    var monthPayment = Math.abs(repleyInterest.toFixed(2));
    

    /*最高付款利息= 本金 * 月息^期次*/
    var maxPayment = money * Math.pow(monthInterest, 1);
    maxPayment = Math.abs(maxPayment.toFixed(2));
    var houseLoan = {};
    var houseLoanArray = new Array();
    for (var i = 1; i <= yearPeriad; i++) {
        var surplusPrincipal1 = money * Math.pow(1 + monthInterest, i) - repleyInterest * (Math.pow(1 + monthInterest, i) - 1) / monthInterest; /*剩余本金*/
        var surplusPrincipal2 = money * Math.pow(1 + monthInterest, i - 1) - repleyInterest * (Math.pow(1 + monthInterest, i - 1) - 1) / monthInterest; /*取上一次的本金计算每月偿还利息*/
        var repeyInt = surplusPrincipal2 * monthInterest; /*每月偿还利息*/
        var repeyPrincipal1 = Math.abs((repleyInterest - repeyInt).toFixed(2)); /*每月偿还本金*/

        var replyPrincipalIntreest = monthPayment; //偿还本息
        var replyInterest = (i != 1 ? repeyInt : maxPayment); //偿还利息
        var replyPrincipal = (i != 1 ? repeyPrincipal1 : (repleyInterest - maxPayment)); //偿还本金
        var surplusPrincipal = (i != 1 ? surplusPrincipal1 : (money - repleyInterest + maxPayment)); //剩余本金
        houseLoan = { ReplyPrincipalIntreest: replyPrincipalIntreest, ReplyInterest: replyInterest, ReplyPrincipal: replyPrincipal, SurplusPrincipal: surplusPrincipal };
        houseLoanArray.push(houseLoan);
    }
    var HouseLoanObject = {};
    HouseLoanObject.Result = result;
    HouseLoanObject.ResultCount = resultCount;
    HouseLoanObject.MonthPayment = monthPayment;
    HouseLoanObject.MaxPayment = maxPayment;
    HouseLoanObject.HouseLoan = houseLoanArray;
    return HouseLoanObject;
}

function anyuejie(yearPeriad, money, monthInterest) {
    /*偿还本息=(（本金*月利息）*(1+月利息)^贷款期限)/((1+月利息)^贷款期限-1）*/
    var repleyInterest = money + money*yearPeriad*monthInterest*30;

    /*利息总额=偿还本息*总期数 - 本金*/
    var result = money * (yearPeriad*1+1) * monthInterest  ;
    result = Math.abs(result.toFixed(2));

    /*累计还款总额=偿还本息* 总期数*/
    var resultCount = money*1 + result*1;
    resultCount = Math.abs(parseFloat(resultCount).toFixed(2));

    /*每月月供=偿还本息*/
    var monthPayment = money * monthInterest * 30 ;


    /*最高付款利息= 本金 * 月息^期次*/
    var maxPayment = money * monthInterest * 30 ;
    maxPayment = Math.abs(maxPayment.toFixed(2));

    var houseLoan = {};
    var houseLoanArray = new Array();
    for (var i = 1; i <= yearPeriad; i++) {
        var surplusPrincipal1 = money; /*剩余本金*/
        var surplusPrincipal2 = money * monthInterest * 30; /*取上一次的本金计算每月偿还利息*/
        var repeyInt = money * monthInterest * 30; /*每月偿还利息*/
        var repeyPrincipal1 = 0; /*每月偿还本金*/

        var replyPrincipalIntreest = monthPayment; //偿还本息
        var replyInterest = maxPayment; //偿还利息
        var replyPrincipal = money; //偿还本金
        var surplusPrincipal = money; //剩余本金
        houseLoan = { ReplyPrincipalIntreest: replyPrincipalIntreest, ReplyInterest: replyInterest, ReplyPrincipal: replyPrincipal, SurplusPrincipal: surplusPrincipal };
        houseLoanArray.push(houseLoan);
    }
    var HouseLoanObject = {};
    HouseLoanObject.Result = result;
    HouseLoanObject.ResultCount = resultCount;
    HouseLoanObject.MonthPayment = monthPayment;
    HouseLoanObject.MaxPayment = maxPayment;
    HouseLoanObject.HouseLoan = houseLoanArray;
    return HouseLoanObject;
}

/*商业贷款等额本息计算*/
function CalAverageCapitalPlusInterestBus() {
    var writeOrCommerical = $("#business_rate_select").val();
    var yearInterest = ""
        yearInterest = $("#txtInterest").val() / 100; //计算年利息
    var money = $("#txtMoney").val();         //本金
    var monthInterest = yearInterest/10 ;           //月利息
    var yearPeriad = $("#loan_period_select").val();  //总期数
    if(yearInterest.length == 0||money.length==0||monthInterest.length==0||yearPeriad.length==0)
    {
        alert('信息填写有误，请重新输入');
        return;
    }
    $("#divMaxMonthMoney").val("每月月供");
    CalAverageCapitalPlusInterestCommT(yearPeriad, money, monthInterest, 0, 0, 1, 0);
}

/*商业贷款等额本息计算*/
function anyuejiexi() {
    var writeOrCommerical = $("#business_rate_select").val();
    var yearInterest = ""
    yearInterest = $("#txtInterest").val() / 100; //计算年利息
    var money = $("#txtMoney").val();         //本金
    var monthInterest = yearInterest / 300 ;           //日利率
    var yearPeriad = getDateDiff($("#startdate").val(),$("#enddate").val());  //总期数
    if(yearInterest.length == 0||money.length==0||monthInterest.length==0||yearPeriad.length==0)
    {
        alert('信息填写有误，请重新输入');
        return;
    }
    $("#divMaxMonthMoney").val("每月月供");
    anyuejiexical(yearPeriad, money, monthInterest, 0, 0, 2, 0);
}

/*公积金贷款等额本息计算*/
function CalAverageCapitalPlusInterestReserve() {
    var writeOrCommerical = $("#selPAFrate").val();
    var yearInterest = ""
    if (writeOrCommerical != -1)                    //非手动输入
    {
        yearInterest = $("#txtInterest1").val() / 100; //计算年利息
    }
    else {
        yearInterest = $("#txtWrite1").val() / 100;    //手动输入年利息
    }
    var money = $("#txtMoney1").val() * 10000;         //本金    
    var monthInterest = yearInterest / 12;          //月利息
    var yearPeriad = $("#loan_period_select2").val() * 12;  //总期数
    CalAverageCapitalPlusInterestCommT(yearPeriad, 0, 0, money, monthInterest, 1, 1);
}
/*组合计算等额本金*/
function CalAverageCapitalGropReserve() {
    /*商业贷款基本参数*/
    var writeOrCommerical = $("#business_rate_select1").val();
    var yearInterest = ""
    if (writeOrCommerical != -1)                    //非手动输入
    {
        yearInterest = $("#txtInterest2").val() / 100; //计算年利息
    }
    else {
        yearInterest = $("#txtWrite3").val() / 100;    //手动输入年利息
    }
    var money = $("#txtMoney3").val() * 10000;         //本金    
    var monthInterest = yearInterest / 12;             //月利息
    var yearPeriad = $("#loan_period_select3").val() * 12;  //总期数

    /*公积金贷款基本参数*/
    var writeOrCommerical1 = $("#selPAFrate3").val();
    var yearInterest1 = ""
    if (writeOrCommerical1 != -1)                       //非手动输入
    {
        yearInterest1 = $("#txtInterest4").val() / 100; //计算年利息
    }
    else {
        yearInterest1 = $("#txtWrite4").val() / 100;    //手动输入年利息
    }
    var money1 = $("#txtMoney4").val() * 10000;         //本金    
    var monthInterest1 = yearInterest1 / 12;            //月利息

    CalAverageCapitalCommT(yearPeriad, money, monthInterest, money1, monthInterest1, 0, 2);

}
/*组合计算等额本息*/
function CalAverageCapitalGropInsterest() {
    /*商业贷款*/
    var writeOrCommerical = $("#business_rate_select1").val();
    var yearInterest = ""
    if (writeOrCommerical != -1)                       //非手动输入
    {
        yearInterest = $("#txtInterest2").val() / 100; //计算年利息
    }
    else {
        yearInterest = $("#txtWrite3").val() / 100;    //手动输入年利息
    }
    var money = $("#txtMoney3").val() * 10000;         //本金    
    var monthInterest = yearInterest / 12;             //月利息
    var yearPeriad = $("#loan_period_select3").val() * 12;  //总期数

    var writeOrCommerical1 = $("#selPAFrate3").val();
    var yearInterest1 = ""
    if (writeOrCommerical1 != -1)                       //非手动输入
    {
        yearInterest1 = $("#txtInterest4").val() / 100; //计算年利息
    }
    else {
        yearInterest1 = $("#txtWrite4").val() / 100;    //手动输入年利息
    }
    var money1 = $("#txtMoney4").val() * 10000;         //本金    
    var monthInterest1 = yearInterest1 / 12;            //月利息

    CalAverageCapitalPlusInterestCommT(yearPeriad, money, monthInterest, money1, monthInterest1, 1, 2);

}
/*商业贷款手动输入控制*/
function ChangeWrite() {
    var writeValue = $("#business_rate_select").val();
    if (writeValue == -1) {
        $("#txtWrite").show();
        $("#divWrite").hide();
    }
    else {
        $("#txtWrite").hide();
        $("#divWrite").show();
    }
}
function ChangeWrite2() {
    var writeValue = $("#business_rate_select1").val();
    if (writeValue == -1) {
        $("#txtWrite3").show();
        $("#divWrite3").hide();
    }
    else {
        $("#txtWrite3").hide();
        $("#divWrite3").show();
    }
}
/*商业贷款不同年限的无折扣贷款利率计算*/
function ChangeLoanPeriad() {
    var loadPeriad = $("#loan_period_select").val(); /*贷款期限 年*/
    loadPeriad = parseInt(loadPeriad);
    var businessRate = $("#txtInterest").val(); /*商业贷款利息*/
    businessRate = parseInt(businessRate);
    $("#txtInterest").val(interest);
}
function ChangeLoanPeriad1() {
    $("#business_discount3").get(0).selectedIndex = 0;
    var loadPeriad = $("#loan_period_select3").val(); /*贷款期限 年*/
    loadPeriad = parseInt(loadPeriad);
    var businessRate = $("#business_rate_select1").val(); /*商业贷款利息*/
    businessRate = parseInt(businessRate);
    var interest = "";
    if (businessRate == -1) {
        return;
    }
    if (loadPeriad == 1) {
        switch (businessRate) {
            case 1:
                interest = 6.00;
                break;
            case 2:
                interest = 6.31;
                break;
            case 3:
                interest = 6.56;
                break;
            case 4:
                interest = 6.31;
                break;
            case 5:
                interest = 6.06;
                break;
            default: break;
        }
    }
    else if (loadPeriad == 2 || loadPeriad == 3) {
        switch (businessRate) {
            case 1:
                interest = 6.15;
                break;
            case 2:
                interest = 6.40;
                break;
            case 3:
                interest = 6.65;
                break;
            case 4:
                interest = 6.40;
                break;
            case 5:
                interest = 6.10;
                break;
            default: break;
        }
    }
    else if (loadPeriad == 4 || loadPeriad == 5) {
        switch (businessRate) {
            case 1:
                interest = 6.40;
                break;
            case 2:
                interest = 6.65;
                break;
            case 3:
                interest = 6.90;
                break;
            case 4:
                interest = 6.65;
                break;
            case 5:
                interest = 6.45;
                break;
            default: break;
        }
    }
    else {
        switch (businessRate) {
            case 1:
                interest = 6.55;
                break;
            case 2:
                interest = 6.80;
                break;
            case 3:
                interest = 7.05;
                break;
            case 4:
                interest = 6.80;
                break;
            case 5:
                interest = 6.60;
                break;
            default: break;
        }
    }
    $("#txtInterest2").val(interest);
}
/*商业贷款利息选择*/
function ChangeBusinessRate() {
    ChangeLoanPeriad();
}
function ChangeBusinessRate1() {
    ChangeLoanPeriad1();
}
/*计算利率乘集*/
function CalculateRide() {
    var interestNum = $("#txtInterest").val();
    var multipleNum = $("#business_discount").val();
    var interestNum1 = 0;
    switch (parseInt(multipleNum)) {
        case 0:
            ChangeLoanPeriad();
            break;        
        case 4:
            interestNum1 = 0.85 * interestNum;
            $("#txtInterest").val(interestNum1);
            break;
        case 5:
            interestNum1 = 0.9 * interestNum;
            $("#txtInterest").val(interestNum1);
            break;
        case 6:
            interestNum1 = 0.95 * interestNum;
            $("#txtInterest").val(interestNum1);
            break;
        case 7:
            interestNum1 = 1.05 * interestNum;
            $("#txtInterest").val(interestNum1);
            break;
        case 8:
            interestNum1 = 1.1 * interestNum;
            $("#txtInterest").val(interestNum1);
            break;
        case 9:
            interestNum1 = 1.15 * interestNum;
            $("#txtInterest").val(interestNum1);
            break;
        case 10:
            interestNum1 = 1.2 * interestNum;
            $("#txtInterest").val(interestNum1);
            break;
    }
}
/*计算利率乘集*/
function CalculateRide3() {
    var interestNum = $("#txtInterest2").val();
    var multipleNum = $("#business_discount3").val();
    var interestNum1 = 0;
    switch (parseInt(multipleNum)) {
        case 0:
            ChangeLoanPeriad1();
            break;       
        case 4:
            interestNum1 = 0.85 * interestNum;
            $("#txtInterest2").val(interestNum1);
            break;
        case 5:
            interestNum1 = 0.9 * interestNum;
            $("#txtInterest2").val(interestNum1);
            break;
        case 6:
            interestNum1 = 0.95 * interestNum;
            $("#txtInterest2").val(interestNum1);
            break;
        case 7:
            interestNum1 = 1.05 * interestNum;
            $("#txtInterest2").val(interestNum1);
            break;
        case 8:
            interestNum1 = 1.1 * interestNum;
            $("#txtInterest2").val(interestNum1);
            break;
        case 9:
            interestNum1 = 1.15 * interestNum;
            $("#txtInterest2").val(interestNum1);
            break;
        case 10:
            interestNum1 = 1.2 * interestNum;
            $("#txtInterest2").val(interestNum1);
            break;
    }
}
/*计算商业贷款利息*/
function CalculateValue() {
    if(checkdkje() == false)
        return false;
    else if(checkdkqx() == false)
        return false;
    else if(checklv() == false)
        return false;
    else {

        var val = $('input:radio[name="repay_radio"]:checked').val();
        if (val == 1) {/*等额本金*/
            CalAverageCapitalBus();
        }
        else if (val == 2) { /*等额本息*/
            CalAverageCapitalPlusInterestBus();
        } else {
            anyuejiexi();
        }
    }
}
/*计算公积金贷款利息*/
function CalculateReserveValue() {
    var val = $('input:radio[name="repay_radio1"]:checked').val();
    if (val == 1) {/*等额本金*/
        CalAverageCapitalReserve();
    }
    else {
        CalAverageCapitalPlusInterestReserve();
    }
}
/*公积金贷款 选择基准利率*/
function ChangePAFrate() {
    var writeValue = $("#selPAFrate").val();
    if (writeValue == -1) {
        $("#txtWrite1").show();
        $("#divWrite2").hide();
    }
    else {
        $("#txtWrite1").hide();
        $("#divWrite2").show();
    }
    ChangeLoanPeriod();
}
function ChangePAFrate1() {
    var writeValue = $("#selPAFrate3").val();
    if (writeValue == -1) {
        $("#txtWrite4").show();
        $("#divWrite4").hide();
    }
    else {
        $("#txtWrite4").hide();
        $("#divWrite4").show();
    }
    ChangeLoanPeriod1();
}
/*切换选项卡 清空内容*/
$(function () {
    $('.easyui-tabs').tabs({
        border: false,
        onSelect: function (title) {
            $("#txtInterestCount").val("");
            $("#txtRepayment").val("");
            $("#txtMonthPayment").val("");
            $("#txtMonthMaxPayment").val("");
            $("#txtInterestResult").val("");
            $("#txtReservedFunds").val("");
            $("#tblResult tbody").empty();
            if (title == "组合贷款计算") {
                $("#trInterest").show();
            }
            else {
                $("#trInterest").hide();
            }
        }
    });
});
/*选择公积金利率*/
function ChangeLoanPeriod() {
    var loanPeriod = $("#loan_period_select2").val();
    var businessRate = $("#selPAFrate").val();   
    var interest = "";
    if (loanPeriod <= 5) {
        switch (parseInt(businessRate)) {
            case 0:
                interest = 4.00;
                break;
            case 1:
                interest = 4.20;
                break;
            case 2:
                interest = 4.45;
                break;
            case 3:
                interest = 4.20;
                break;
            case 4:
                interest = 4.00;
                break;
        }
    }
    else {
        switch (parseInt(businessRate)) {
            case 0:
                interest = 4.50;
                break;
            case 1:
                interest = 4.70;
                break;
            case 2:
                interest = 4.90;
                break;
            case 3:
                interest = 4.70;
                break;
            case 4:
                interest = 4.50;
                break;
        }
    }
    var businessDiscount = $("#business_discount1").val();
    var discount = "";
    if (businessDiscount == 1) {
        discount = 1.0;
    }
    else {
        discount = 1.1;
    }
    $("#txtInterest1").val(Math.abs(interest * discount));
}
function ChangeLoanPeriod1() {
    var loanPeriod = $("#loan_period_select3").val();
    var businessRate = $("#selPAFrate3").val();
    var interest = "";
    if (loanPeriod <= 5) {
        switch (parseInt(businessRate)) {
            case 0:
                interest = 4.00;
                break;
            case 1:
                interest = 4.20;
                break;
            case 2:
                interest = 4.45;
                break;
            case 3:
                interest = 4.20;
                break;
            case 4:
                interest = 4.00;
                break;
        }
    }
    else {
        switch (parseInt(businessRate)) {
            case 0:
                interest = 4.50;
                break;
            case 1:
                interest = 4.70;
                break;
            case 2:
                interest = 4.90;
                break;
            case 3:
                interest = 4.70;
                break;
            case 4:
                interest = 4.50;
                break;
        }
    }
    var businessDiscount = $("#business_discount4").val();
    var discount = "";
    if (businessDiscount == 1) {
        discount = 1.0;
    }
    else {
        discount = 1.1;
    }
    $("#txtInterest4").val(Math.abs(interest * discount));
}
/*计算折扣*/
function CalculateRide1() {
    ChangeLoanPeriod();
}
function CalculateRide2() {
    ChangeLoanPeriod1();
}
/*组合计算*/
function CalculateReserveAndBusValue() {
    var val = $('input:radio[name="repay_radio3"]:checked').val();
    if (val == 1) {/*等额本金*/
        CalAverageCapitalGropReserve();
    }
    else {
        CalAverageCapitalGropInsterest();
    }
}
    function getDateDiff(date1,date2){
        var arr1=date1.split('-');
        var arr2=date2.split('-');
        var d1=new Date(arr1[0],arr1[1],arr1[2]);
        var d2=new Date(arr2[0],arr2[1],arr2[2]);
        return(d2.getTime()-d1.getTime())/(1000*3600*24);
    }

function checkdkje() {
    var name = $('#txtMoney').val();
    if (name == null || name == "") {
        alert("请填写贷款金额");
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
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
        return false;
    } else if (name.match(/^(-)?(([1-9]{1}\d*)|([0]{1}))(\.(\d){1,2})?$/) == null) {
        alert('贷款利率只能填写大于0的正数')
        return false;
    } else {
        return true;
    }
}
function checkdkqx() {
    if($('input:radio[name="repay_radio"]:checked').val() == 1 ||$('input:radio[name="repay_radio"]:checked').val() ==2) {
        var name = $('#loan_period_select').val();
        if (name == null || name == "") {
            alert("贷款期限不能为空!")
            return false;
        } else if (name.match(/^[1-9]\d*$/) == null) {
            alert("贷款期限只能填写大于0的正整数")
            return false;
        } else {
            return true;
        }
    }else{
        return true;
    }
}