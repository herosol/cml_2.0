$(function () {
	/*_____ Toggle _____*/
	$(document).on("click", ".toggle", function () {
		$(".toggle").toggleClass("active");
		$("html").toggleClass("flow");
		$("#nav").toggleClass("active");
		$("#nav > ul > li > .sub").slideUp();
	});

	w = $(window).width();
	if (w <= 991) {
		$(document).on("click", "#nav > ul > li.drop > a", function (e) {
			e.preventDefault();
			$(".sub").not($(this).parent().children(".sub").slideToggle()).slideUp();
		});
	}

	$(window).on("resize", function () {
		$("#nav > ul > li > .sub").removeAttr("style");
	});

	/*_____ Upload File _____*/

	var upldFile;

	$(document).on(
		"click",
		".uploadImg[data-upload]:not(.uploaded)",
		function () {
			upldFile = $(this).attr("data-upload");
			$(this).data("preText", $(this).attr("data-text"));
			$(this)
				.parents("form")
				.find(`input[type="file"][data-upload="${upldFile}"]`)
				.trigger("click");
		}
	);

	$(document).on("click", ".uploadImg[data-upload].uploaded", function () {
		upldFile = $(this).attr("data-upload");
		$(this).attr("data-text", $(this).data("preText")).removeClass("uploaded");
		$(this)
			.parents("form")
			.find(`input[type="file"][data-upload="${upldFile}"]`)
			.get(0).value = "";
	});

	$(document).on("change", ".uploadFile[data-upload]", function () {
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
	});

	/*_____ Drop Down _____*/
	$(document).on("click", ".drop_btn", function (e) {
		e.stopPropagation();
		if ($(this).parents(".drop_cnt:first").hasClass("active"))
			$(this)
				.parents(".drop_cnt:first")
				.find(".drop_cnt:first")
				.addClass("active");
		else {
			$(".drop_cnt")
				.not($(this).parent().children(".drop_cnt"))
				.removeClass("active");
			$(this)
				.parents(".drop_down:first")
				.find(".drop_cnt:first")
				.toggleClass("active");
		}
	});

	$(document).on("click", ".drop_cnt", function (e) {
		e.stopPropagation();
	});

	$(document).on("click", function () {
		$(".drop_cnt").removeClass("active");
	});

	/*_____ Popup _____*/

	$(document).on("click", ".popup", function (e) {
		if ($(e.target).closest(".popup ._inner, .popup .inside").length === 0) {
			$(".popup").fadeOut("3000");
			$("html").removeClass("flow");
			$("#vid_blk").html("");
		}
	});

	$(document).on("click", ".cross_btn", function () {
		$(".popup").fadeOut();
		$("html").removeClass("flow");
		$("#vid_blk").html("");
	});

	$(document).keydown(function (e) {
		if (e.keyCode == 27) $(".popup .cross_btn").click();
	});

	$(document).on("click", ".pop_btn", function () {
		var popUp = $(this).data("popup");
		$("html").addClass("flow");
		$(".popup[data-popup= " + popUp + "]").fadeIn();
	});

	$(document).on("click", ".pop_btn[data-store]", function () {
		var vcode = $(this).data("store");
		$("#vid_blk").html(
			'<iframe src="https://www.youtube.com/embed/' +
				vcode +
				'?autoplay=1&loop=1&rel=0&wmode=transparent&modestbranding=1" allow="autoplay;" frameborder="0" wmode="Opaque"></iframe>'
		);
	});

	/*_____ FAQ's _____*/

	$(document).on("click", ".faq_blk > h5", function () {
		$(".faq_blk")
			.not($(this).parent().toggleClass("active"))
			.removeClass("active");
		$(".faq_blk > .txt")
			.not($(this).parent().children(".txt").slideToggle())
			.slideUp();
	});

	$(".faq_lst > .faq_blk:nth-child(1)").addClass("active");
	$(document).on("click", ".form_blk.pass_blk > i.icon-eye", function () {
		$(this).addClass("icon-eye-slash");
		$(this).removeClass("icon-eye");
		$(this).parent().find(".text_box").attr("type", "text");
	});

	$(document).on("click", ".form_blk.pass_blk > i.icon-eye-slash", function () {
		$(this).addClass("icon-eye");
		$(this).removeClass("icon-eye-slash");
		$(this).parent().find(".text_box").attr("type", "password");
	});

	$(document).on(
		"focus",
		".form_blk .text_box:not(select):not(.uploadImg)",
		function () {
			$(this).parents(".form_blk:first").find("label:first").addClass("move");
		}
	);

	$(".form_blk .text_box:not(select)").each(function (e) {
		if ($(this).val() != "")
			$(this).parents(".form_blk:first").find("label:first").addClass("move");
	});

	$(document).on(
		"blur",
		".form_blk .text_box:not(select):not(.uploadImg)",
		function () {
			if (this.value == "")
				$(this)
					.parents(".form_blk:first")
					.find("label:first")
					.removeClass("move");
		}
	);

	$(document).on(
		"change",
		"[data-payment='wallet'] .lbl_btn > input.tglBlk",
		function () {
			let checked = this.checked;
			if (checked == true) {
				$(this)
					.parents("[data-payment='wallet']")
					.find(".inside_blk")
					.slideToggle();
			} else
				$(this)
					.parents("[data-payment='wallet']")
					.find(".inside_blk")
					.slideUp();
		}
	);

	$(".form_blk select.text_box")
		.parents(".form_blk")
		.find("label:first")
		.addClass("move");

	$(document).on("click", "[inbox] .frnds li", function () {
		$("[inbox] .chatBlk").addClass("active");
	});

	$(document).on("click", "[inbox] .chatPerson .backBtn", function () {
		$("[inbox] .chatBlk").removeClass("active");
	});

	// data_list
	$("table.data_list thead th").each(function (i, e) {
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

$(window).on("load", function () {
	$("img").parent("a:not(.site_btn)").css("display", "block");
	$(".loader").delay(700).fadeOut();
	$("#pageloader").delay(1200).fadeOut("slow");
});
