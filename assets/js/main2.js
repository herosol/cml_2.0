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
$(document).on('submit', '.formAjax', function (e) {
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
    
            error: function (rs) {
                console.log(rs);
            },
            success: function (rs) {
                console.log(rs);
                if (rs.status == 1) {
                    toastr.success(rs.msg, '', optsuccess);
                    setTimeout(function () {
                        frm.reset();
                        frmbtn.attr("disabled", false);
                        if (rs.redirect_url) {
                            window.location.href = rs.redirect_url;
                        } else {
                            
                        }
    
                    }, 3000);
                } else {
                    toastr.error(rs.msg, opterror);
                    setTimeout(function () {
                        if (rs.hide_msg)
                            frmMsg.slideUp(500);
                        frmbtn.attr("disabled", false);
                        if (rs.redirect_url)
                            window.location.href = rs.redirect_url;
                    }, 3000);
                }
            },
            complete: function (rs) {
                needToConfirm = false;
            }
        });
    });
$(function() {
	/*_____ Toggle _____*/
	$(document).on("click", ".toggle", function() {
		$(".toggle").toggleClass("active");
		$("body").toggleClass("flow");
		$("nav").toggleClass("active");
		$(".upperlay").toggleClass("active");
		$("nav > ul > li > .sub").slideUp();
	});
	var offSet = $('body').offset().top;
        var offSet = offSet + 50;
        $(window).scroll(function() {
            var scrollPos = $(window).scrollTop();
            if (scrollPos >= offSet) {
               $('header').addClass('headerFix'); 
            } else {
                $('header').removeClass('headerFix'); 
            }
        });
	w = $(window).width();
	if (w <= 991) {
		$(document).on("click", "nav > ul > li.drop > a", function(e) {
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
		$("nav > ul > li > .sub").removeAttr("style");
	});

/*_____  paypall _____*/
$(function() {
	$(document).on('click', '[data-payment] .topHead input[type="radio"]', function() {
		attrID = $(this).attr('id');
		$('[data-payment] > .inside').slideUp();
		$('[data-payment=' + attrID + '] > .inside').slideDown();
	});
});

/*_____ price slider _____*/
	$(document).on("click", "._price > li > a", function() {
		$(this).next('.sub_price').slideToggle();
	});
	
/*_____ banner products slider _____*/
$(window).on('load', function () {
	$('#owl-SmBanner').owlCarousel({
		nav: true,
            navText: ['<i class="fi-chevron-left"></i>', '<i class="fi-chevron-right"></i>'],
            loop: true,
		margin: 30,
		autoplay: true,
		smartSpeed: 3000,
		// autoplayTimeout: 3000,
		autoplayHoverPause: true,
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 1
			},
			991: {
				items: 1
			}
		}
	});
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
	$(document).on("click", ".dropDown", function(e) {
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
			$("body").removeClass("flow");
			$("#vidBlk").html("");
		}
	});
	$(document).on("click", ".crosBtn", function() {
		$(".popup").fadeOut();
		$("body").removeClass("flow");
		$("#vidBlk").html("");
	});
	$(document).keydown(function(e) {
		if (e.keyCode == 27) $(".popup .crosBtn").click();
	});
	$(document).on("click", ".popBtn", function() {
		var popUp = $(this).data("popup");
		$("body").addClass("flow");
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
	$(".faqLst > .faqBlk:nth-child(1)").addClass("active");

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

	$(document).on("focus", ".txtGrp .txtBox:not(select)", function() {
		$(this)
			.parents(".txtGrp:first")
			.find("label:first")
			.addClass("move");
	});

	$(document).on("blur", ".txtGrp .txtBox:not(select)", function() {
		if (this.value == "")
			$(this)
				.parents(".txtGrp:first")
				.find("label:first")
				.removeClass("move");
	});

});

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
//  SLIDER SIMLILER PRODUCTS
$('#owl-trending').owlCarousel({
	autoplay: false,
	nav: true,
	dots: false,
	navText: ['<i class="fi-chevron-left-circle"></i>', '<i class="fi-chevron-right-circle"></i>'],
	loop: true,
	autoplay: true,
	 margin: 20,
	smartSpeed: 1000,
	autoplayTimeout: 5000,
	autoplayHoverPause: true,
	responsive: {
		0: {
			items: 1
		},
		480: {
			items: 2
		},
		991: {
			items: 3
		},
		1200: {
			items: 4
		}
	}
});
$('#owl-products-1').owlCarousel({
	autoplay: false,
	nav: true,
	dots: false,
	navText: ['<i class="fi-chevron-left-circle"></i>', '<i class="fi-chevron-right-circle"></i>'],
	loop: true,
	autoplay: true,
	 margin: 20,
	smartSpeed: 1000,
	autoplayTimeout: 5000,
	autoplayHoverPause: true,
	responsive: {
		0: {
			items: 1
		},
		480: {
			items: 2
		},
		991: {
			items: 3
		},
		1200: {
			items: 4
		}
	}
});
$('#owl-products-2').owlCarousel({
	autoplay: false,
	nav: true,
	dots: false,
	navText: ['<i class="fi-chevron-left-circle"></i>', '<i class="fi-chevron-right-circle"></i>'],
	loop: true,
	autoplay: true,
	 margin: 20,
	smartSpeed: 1000,
	autoplayTimeout: 5000,
	autoplayHoverPause: true,
	responsive: {
		0: {
			items: 1
		},
		480: {
			items: 2
		},
		991: {
			items: 3
		},
		1200: {
			items: 5
		}
	}
});
$('#owl-products-3').owlCarousel({
	autoplay: false,
	nav: true,
	dots: false,
	navText: ['<i class="fi-chevron-left-circle"></i>', '<i class="fi-chevron-right-circle"></i>'],
	loop: true,
	autoplay: true,
	 margin: 20,
	smartSpeed: 1000,
	autoplayTimeout: 5000,
	autoplayHoverPause: true,
	responsive: {
		0: {
			items: 1
		},
		480: {
			items: 2
		},
		991: {
			items: 3
		},
		1200: {
			items: 5
		}
	}
});

	/*_____ Filter _____*/
	$(document).on("click", "#fltrBtn", function(e) {
		e.preventDefault();
		$("header").addClass("header_zindex");
		$("#fltrBtn").toggleClass("inactive");
		$("#f-filter").toggleClass("active");
		$("#rsltBtn").toggleClass("active");
		
	});
	/*_____ Filter remove _____*/
	$(document).on("click", "#rsltBtn", function(e) {
		e.preventDefault();
		$("header").removeClass("header_zindex");
		$("#fltrBtn").removeClass("inactive");
		$("#f-filter").removeClass("active");
		$("#rsltBtn").removeClass("active");
		
	});

		/*_____ Upload image _____*/
		$(document).on("click", ".uploadImg", function() {
			imgFile = $(this).attr("data-image-src");
			$(this)
			.parents("form")
			.find(".uploadFile")
			.trigger("click");
			});


/*_____ tool tip _____*/
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();   
			  });

/*_____ Filters _____*/

$('#price_range').ionRangeSlider({
	skin: 'square',
	min: 1,
	max: '10000',
	type: 'double',
	
	onFinish: function(data) {
		filterProds();
	},
	grid: true
});

/*_____ Filters _____*/
		$(document).on("change", ".myfilters", function() {
			filterProds();
		});
		
			function filterProds(){
				$('.filterprods').html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
			let model = null;
			let case_material = null;
			let case_size = null;
			let band_material = null;
			let min_price = null;
			let max_price = null;
			let url_segment = null;

			var url = $(location).attr('href');
			var parts = url.split("/");
			url_segment = parts[5];
			
			model = $('#model').find(":selected").val();
			case_material = $('#case_material').find(":selected").val();
			case_size = $('#case_size').find(":selected").val();
			band_material = $('#band_material').find(":selected").val();
			min_price = $('.irs-from').html();
			max_price = $('.irs-to').html();

			
			// Replace all spaces with an empty string
			min_price = min_price.replace(/ /g, '');
			min_price = parseInt(min_price, 10);
			max_price = max_price.replace(/ /g, '');
			max_price = parseInt(max_price, 10);


			let myfilters = {"model" : model, "case_material" : case_material, "case_size" : case_size , "band_material" : band_material , "min_price" : min_price , "max_price" : max_price , "url_segment" : url_segment };
			console.log(myfilters);
			$.ajax({
				method: 'POST',
				url: base_url + 'Ajax/filter_products/',
				data: myfilters,
				dataType: 'JSON',
				error: function (rs) {
					console.log(rs);
				},
				success: function (products) {

					var prods = '';
					products.map((product) => {
						let slug = product.title.replace(/ /g,"-");
						prods += 	'<div class="col"> <div class="itmBlk">	<div class="flex flex-end">	</div>	<div class="image"><a href="'+base_url+'product-detail/'+product.id+'/'+slug+'"><img src="'+base_url+'v/p300x300/'+product.image+'" alt=""></a></div>  <div class="txt">   <span class="sale">'+product.brand+' - '+product.model+'</span> <div class="price">$'+product.price+'.00</div><h4>Ref No. '+product.ref_code+'</h4><h6><a href="'+base_url+'product-detail/'+product.id+'/'+slug+'">'+product.title+'</a></h6>    <div class="bTn "><a href="'+base_url+'product-detail/'+product.id+'/'+slug+'" class="webBtn">View Details</a><a target="_blank" href="'+product.whatsapp_link+'" class="webBtn whatsappbtn"><span class="tooltip">Contact Via Whatsapp</span><img src="'+base_url+'assets/images/social-whatsapp.svg"></a>	</div> 	</div>  </div> </div> ';
					})
					
					setTimeout(
						function() 
						{
							if(prods == '' || prods == null){
								$('.filterprods').html('<h2>No Products Found </h2>');
							}else{
								$('.filterprods').html(prods);
							}
						}, 800);
					
				},
			})

		};

