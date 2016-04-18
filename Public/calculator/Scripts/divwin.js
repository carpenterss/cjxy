var Divwin = {
    divwins: []
    , create: function () {
        var divwin = {};
        divwin.mask = $("<div class='divwinMask' />").appendTo(document.body);
        divwin.win = $("<div class='divwinWindow' />").appendTo(document.body);
        divwin.title = $("<div class='divwinTitle' />").appendTo(divwin.win);
        divwin.closeBtn = $("<div class='divwinClose' />").appendTo(divwin.win);
        divwin.ifr = $("<iframe class='divwinIfr' frameborder='0' />").appendTo(divwin.win);

        return divwin;
    }
    , closeAll: function () {
        for (var i = 0; i < this.divwins.length; i++)
            this.divwins[i].close();
    }
    , show: function (pWidth, pHeight, pIsLoad, pURLorID, pRefreshUrl, pTitle, onClose) {

        var divwin = this.create();
        this.divwins.push(divwin);

        var maskWidth = $(document).width();
        var maskHeight = $(document).height();

        var windowWidth = $(window).width();
        var windowHeight = $(window).height();

        pWidth = pWidth || (windowWidth * 3 / 4);
        pHeight = pHeight || (windowHeight * 3 / 4);

        //resize
        divwin.resize = function () {

            divwin.mask.css({ 'width': maskWidth, 'height': maskHeight });

            divwin.win.css('top', windowHeight / 2 - pHeight / 2 - (parseInt($(divwin.win).css("padding-top")) || 0) / 2 + $(document).scrollTop());
            divwin.win.css('left', maskWidth / 2 - pWidth / 2 - (parseInt($(divwin.win).css("padding-left")) || 0) / 2);
            divwin.win.css({ 'width': pWidth, 'height': pHeight });

            divwin.closeBtn.css('left', divwin.win.width() + 15);
        };
        divwin.resize();
        $(window).resize(divwin.resize);

        //close
        divwin.close = (function (_inst) {
            return function () {
                divwin.mask.hide();
                divwin.win.hide();

                for (var i = 0; i < _inst.divwins.length; i++)
                    if (divwin == _inst.divwins[i])
                        _inst.divwins.splice(i, 1); //删除

                if (onClose) onClose();
            }
        })(this);
        divwin.closeBtn.one("click", divwin.close);

        //mask
        divwin.mask.show();

        //title
        $(divwin.title).html(pTitle);

        //show window
        divwin.win.fadeIn(100);

        //load dom
        //$("#" + pURLorID).show();
        if (!pIsLoad) {
            divwin.ifr.hide();

            Divwin.pURLorID = Divwin.pURLorID ? Divwin.pURLorID : $("#" + pURLorID);

            Divwin.pURLorID.show();
            
            divwin.win.append(Divwin.pURLorID);

        }

        //load page
        if (pIsLoad && (!$(divwin.ifr).attr("src") || pRefreshUrl))
            $(divwin.ifr).attr("src", pURLorID);

        //return
        return divwin;

    }
};
