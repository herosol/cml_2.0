var optsuccess = {
    "closeButton": true,
    "debug": false,
    "positionClass": "toast-top-right",
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "5000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "slideDown",
    "hideMethod": "slideUp"
};

var opterror = {
    "closeButton": true,
    "debug": false,
    "positionClass": "toast-top-right",
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "5000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "slideDown",
    "hideMethod": "slideUp"
};


/*========== FORM SUBMIT ==========*/
$(document).on('submit', '.formAjax', function(e) {
    e.preventDefault();
    needToConfirm = true;
    var frmbtn = $(this).find("button[type='submit']");
    var frmMsg = $(this).find("div.alertMsg:first");
    var frm = this;
    console.log(frm);
    frmbtn.attr("disabled", true);
    frmMsg.hide();
    $.ajax({
        url: $(this).attr('action'),
        data: new FormData(frm),
        processData: false,
        contentType: false,
        dataType: 'JSON',
        method: 'POST',

        error: function(rs) {
            console.log(rs);
        },
        success: function(rs) {
            console.log(rs);
            if (rs.status == 1) {
                toastr.success(rs.msg, '', optsuccess);
                setTimeout(function() {
                    frm.reset();
                    frmbtn.attr("disabled", false);
                    if (rs.redirect_url) {
                        window.location.href = rs.redirect_url;
                    } else {

                    }

                }, 3000);
            } else {
                toastr.error(rs.msg, opterror);
                setTimeout(function() {
                    if (rs.hide_msg)
                        frmMsg.slideUp(500);
                    frmbtn.attr("disabled", false);
                    if (rs.redirect_url)
                        window.location.href = rs.redirect_url;
                }, 3000);
            }
        },
        complete: function(rs) {
            needToConfirm = false;
        }
    });
});

$(function() {
    /*_____ Toggle _____*/
    $(document).on("click", ".toggle", function() {
        $(".toggle").toggleClass("active");
        $("html").toggleClass("flow");
        $("[nav]").toggleClass("active");
        // $(".upperlay").toggleClass("active");
        $("[nav] > ul > li > .sub").slideUp();
    });
    w = $(window).width();
    if (w <= 991) {
        $(document).on("click", "[nav] > ul > li.drop > a", function(e) {
            e.preventDefault();
            $(".sub")
                .not(
                    $(this)
                    .parent()
                    .children(".sub")
                    .slideToggle()
                )
                .slideUp();
        });
    }
    $(window).on("resize", function() {
        $("[nav] > ul > li > .sub").removeAttr("style");
    });

    /*_____ Upload File _____*/
    var upldFile;
    $(document).on("click", ".uploadImg[data-upload]:not(.uploaded)", function() {
        upldFile = $(this).attr("data-upload");
        $(this).data("preText", $(this).attr("data-text"));
        $(this)
            .parents("form")
            .find(`input[type="file"][data-upload="${upldFile}"]`)
            .trigger("click");
    });
    $(document).on("click", ".uploadImg[data-upload].uploaded", function() {
        upldFile = $(this).attr("data-upload");
        $(this)
            .attr("data-text", $(this).data("preText"))
            .removeClass("uploaded");
        $(this)
            .parents("form")
            .find(`input[type="file"][data-upload="${upldFile}"]`)
            .get(0).value = "";
    });
    $(document).on("change", ".uploadFile[data-upload]", function() {
        // alert(imgFile);
        let file = $(this).val();
        let preText = $(`.uploadImg[data-upload="${upldFile}"]`).data("preText");
        if (this.files.length > 0) {
            $(`.uploadImg[data-upload="${upldFile}"]`)
                .addClass("uploaded")
                .attr("data-text", file);
        } else {
            $(`.uploadImg[data-upload="${upldFile}"]`)
                .removeClass("uploaded")
                .attr("data-text", preText);
        }
        // console.log(this.files.length);
        // $(`.uploadImg[data-upload="${upldFile}"]`).html(file);
    });

    /*_____ Drop Down _____*/
    $(document).on("click", ".dropBtn", function(e) {
        e.stopPropagation();
        if (
            $(this)
            .parents(".dropCnt:first")
            .hasClass("active")
        )
            $(this)
            .parents(".dropCnt:first")
            .find(".dropCnt:first")
            .addClass("active");
        else {
            $(".dropCnt")
                .not(
                    $(this)
                    .parent()
                    .children(".dropCnt")
                )
                .removeClass("active");
            $(this)
                .parents(".dropDown:first")
                .find(".dropCnt:first")
                .toggleClass("active");
        }
    });
    $(document).on("click", ".dropCnt", function(e) {
        e.stopPropagation();
    });
    $(document).on("click", function() {
        $(".dropCnt").removeClass("active");
    });

    /*_____ Popup _____*/
    $(document).on("click", ".popup", function(e) {
        if ($(e.target).closest(".popup ._inner, .popup .inside").length === 0) {
            $(".popup").fadeOut("3000");
            $("html").removeClass("flow");
            $("#vidBlk").html("");
        }
    });
    $(document).on("click", ".crosBtn", function() {
        $(".popup").fadeOut();
        $("html").removeClass("flow");
        $("#vidBlk").html("");
    });
    $(document).keydown(function(e) {
        if (e.keyCode == 27) $(".popup .crosBtn").click();
    });
    $(document).on("click", ".popBtn", function() {
        var popUp = $(this).data("popup");
        $("html").addClass("flow");
        $(".popup[data-popup= " + popUp + "]").fadeIn();
    });
    $(document).on("click", ".popBtn[data-store]", function() {
        var vcode = $(this).data("store");
        $("#vidBlk").html('<iframe src="https://www.youtube.com/embed/' + vcode + '?autoplay=1&loop=1&rel=0&wmode=transparent&modestbranding=1" allow="autoplay;" frameborder="0" wmode="Opaque"></iframe>');
    });

    /*_____ FAQ's _____*/
    $(document).on("click", ".faqBlk > h5", function() {
        $(".faqBlk")
            .not(
                $(this)
                .parent()
                .toggleClass("active")
            )
            .removeClass("active");
        $(".faqBlk > .txt")
            .not(
                $(this)
                .parent()
                .children(".txt")
                .slideToggle()
            )
            .slideUp();
    });
    // $(".faqLst > .faqBlk:nth-child(1)").addClass("active");

    $(document).on("click", ".txtGrp.pasDv > i.icon-eye", function() {
        $(this).addClass("icon-eye-slash");
        $(this).removeClass("icon-eye");
        $(this)
            .parent()
            .find(".txtBox")
            .attr("type", "text");
    });
    $(document).on("click", ".txtGrp.pasDv > i.icon-eye-slash", function() {
        $(this).addClass("icon-eye");
        $(this).removeClass("icon-eye-slash");
        $(this)
            .parent()
            .find(".txtBox")
            .attr("type", "password");
    });

    $(document).on("click", ".blk.collap > ._header > .downBtn", function() {
        $(this)
            .parent()
            .next("._content:first")
            .slideToggle();
    });

    $(document).on("focus", ".txtGrp .txtBox:not(select):not(.uploadImg)", function() {
        $(this)
            .parents(".txtGrp:first")
            .find("label:first")
            .addClass("move");
    });

    $(".txtGrp .txtBox:not(select)").each(function(e) {
        if ($(this).val() != "")
            $(this)
            .parents(".txtGrp:first")
            .find("label:first")
            .addClass("move");
    });

    $(document).on("blur", ".txtGrp .txtBox:not(select):not(.uploadImg)", function() {
        if (this.value == "")
            $(this)
            .parents(".txtGrp:first")
            .find("label:first")
            .removeClass("move");
    });

    $(document).on("change", "[data-payment] .lblBtn > input.tglBlk", function() {
        let checked = this.checked;
        if (checked == true) {
            $(this)
                .parents("[data-payment]")
                .find(".insideBlk")
                .slideToggle();
        } else
            $(this)
            .parents("[data-payment]")
            .find(".insideBlk")
            .slideUp();
    });

    /*$(".runBtn").on("click", function(event) {
    	if (this.hash !== "") {
    		event.preventDefault();
    		var hash = this.hash;
    		console.log(hash);
    		$("html, body").animate(
    			{
    				scrollTop: $(hash).offset().top - 60
    			},
    			800
    		);
    	}
    });*/
    $(document).on("click", "#srchBtn > button", function() {
        $("header .srchBar").toggleClass("active");
    });

    $(document).on("click", "[inbox] .frnds li", function() {
        $("[inbox] .chatBlk").addClass("active");
    });
    $(document).on("click", "[inbox] .chatPerson .backBtn", function() {
        $("[inbox] .chatBlk").removeClass("active");
    });

    /*_____ Form Button _____*/
    $(".nextBtn").click(function() {
        // fieldset
        currStep = $(this).parents("fieldset");
        nextStep = currStep.next("fieldset");
        currStep.hide();
        nextStep.fadeIn();
    });
    $(".prevBtn").click(function() {
        // fieldset
        currStep = $(this).parents("fieldset");
        prevStep = currStep.prev("fieldset");
        currStep.hide();
        prevStep.fadeIn();
    });

    // This button will increment the value
    $(document).on("click", ".qtyPlus", function(e) {
        e.preventDefault();
        var parnt = $(this)
            .parent()
            .children(".qty");
        var currentVal = parnt.val();
        if (!isNaN(currentVal)) {
            parnt.val(parseInt(currentVal) + 1);
        } else {
            parnt.val(0);
        }
    });
    // This button will decrement the value till 0
    $(document).on("click", ".qtyMinus", function(e) {
        e.preventDefault();
        var parnt = $(this)
            .parent()
            .children(".qty");
        var currentVal = parnt.val();
        if (!isNaN(currentVal) && currentVal > 0) {
            parnt.val(parseInt(currentVal) - 1);
        } else {
            parnt.val(0);
        }
    });

    // data_list
    $("table.data_list thead th").each(function(i, e) {
        // console.log($(this).text());
        $("table.data_list tbody tr")
            .find(`td:eq(${i})`)
            .attr("data-title", $(this).text());
    });
});

function textAreaAdjust(o) {
    o.style.height = "1px";
    o.style.height = 4 + o.scrollHeight + "px";
}

$(window).on("load", function() {
    $("img")
        .parent("a:not(.webBtn)")
        .css("display", "block");
    $(".loader")
        .delay(700)
        .fadeOut();
    $("#pageloader")
        .delay(1200)
        .fadeOut("slow");
});