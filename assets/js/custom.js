// var sndMsg = true;
// window.onbeforeunload = confirmExit;
var optsuccess = {
	closeButton: true,
	debug: false,
	positionClass: "toast-top-right",
	onclick: null,
	showDuration: "300",
	hideDuration: "5000",
	timeOut: "5000",
	extendedTimeOut: "1000",
	showEasing: "swing",
	hideEasing: "linear",
	showMethod: "slideDown",
	hideMethod: "slideUp",
};

var opterror = {
	closeButton: true,
	debug: false,
	positionClass: "toast-top-right",
	onclick: null,
	showDuration: "300",
	hideDuration: "5000",
	timeOut: "5000",
	extendedTimeOut: "1000",
	showEasing: "swing",
	hideEasing: "linear",
	showMethod: "slideDown",
	hideMethod: "slideUp",
};

/*========== FORM SUBMIT ==========*/
$(document).on("submit", ".formAjax", function (e) {
	e.preventDefault();
	needToConfirm = true;
	var frmbtn = $(this).find("button[type='submit']");
	var frmMsg = $(this).find("div.alertMsg:first");
	var frm = this;
	console.log(frm);
	frmbtn.attr("disabled", true);
	frmMsg.hide();
	$.ajax({
		url: $(this).attr("action"),
		data: new FormData(frm),
		processData: false,
		contentType: false,
		dataType: "JSON",
		method: "POST",

		error: function (rs) {
			console.log(rs);
		},
		success: function (rs) {
			console.log(rs);
			if (rs.status == 1) {
				toastr.success(rs.msg, "", optsuccess);
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
					if (rs.hide_msg) frmMsg.slideUp(500);
					frmbtn.attr("disabled", false);
					if (rs.redirect_url) window.location.href = rs.redirect_url;
				}, 3000);
			}
		},
		complete: function (rs) {
			needToConfirm = false;
		},
	});
});

//TEST
$(document).ready(function () {
	$(document).on("submit", ".frmAjax", function (e) {
		e.preventDefault();
		needToConfirm = true;
		var frmbtn = $(this).find("button[type='submit']");
		var frmIcon = $(this).find("button[type='submit'] i.spinner");
		var frmMsg = $(this).find("div.alertMsg:first");
		var frm = this;

		frmbtn.attr("disabled", true);
		frmMsg.hide();
		frmIcon.removeClass("hidden");
		$.ajax({
			url: $(this).attr("action"),
			data: new FormData(frm),
			processData: false,
			contentType: false,
			dataType: "JSON",
			method: "POST",
		})
			.done(function (rs) {
				frmMsg.removeClass("alert alert-danger alert-sm text-white");
				if (rs.status == 1) frmMsg.html(rs.msg).slideDown(500);
				else
					frmMsg
						.addClass("alert alert-danger alert-sm text-white")
						.html(rs.msg)
						.slideDown(500);

				if (rs.scroll_to_msg)
					$("html, body").animate(
						{ scrollTop: frmMsg.offset().top - 300 },
						"slow"
					);

				if (typeof recaptcha !== "undefined" && recaptcha) grecaptcha.reset();

				if (rs.status == 1) {
					setTimeout(function () {
						if (typeof rs.dp_image !== undefined) {
							$("#dp-image-head").html(rs.dp_image);
						}
						if (typeof rs.name_head !== undefined) {
							$("#name-head").html(rs.name_head);
						}

						if (rs.frm_reset) {
							frm.reset();
							$(".popup").fadeOut();
							$("html").removeClass("flow");
							if (rs.updated_email != "") {
								$("#currently-signin-email").html(
									`<strong>${rs.updated_email}</strong>`
								);
							}
						}
						if (rs.hide_msg) frmMsg.slideUp(500);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) {
							window.location.href = rs.redirect_url;
						} else {
							frmbtn.attr("disabled", false);
						}
					}, 3000);
				} else {
					setTimeout(function () {
						if (rs.hide_msg) frmMsg.slideUp(500);
						frmbtn.attr("disabled", false);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) window.location.href = rs.redirect_url;
					}, 2000);
				}
			})
			.fail(function (rs) {
				console.log(rs);
				// alert('Network error has occurred please try again!');
			})
			.always(function () {
				needToConfirm = false;
			});
	});
});

$(document).ready(function () {
	$(document).on("submit", ".frmCompleteOrder", function (e) {
		e.preventDefault();
		needToConfirm = true;
		var frmbtn = $(this).find("button[type='submit']");
		var frmIcon = $(this).find("button[type='submit'] i.spinner");
		var frmMsg = $(this).find("div.alertMsg:first");
		var frm = this;

		frmbtn.attr("disabled", true);
		frmMsg.hide();
		frmIcon.removeClass("hidden");
		$.ajax({
			url: $(this).attr("action"),
			data: new FormData(frm),
			processData: false,
			contentType: false,
			dataType: "JSON",
			method: "POST",
		})
			.done(function (rs) {
				console.log(rs);

				frmMsg.removeClass("alert alert-danger alert-sm text-white");
				if (rs.status == 1) frmMsg.html(rs.msg).slideDown(500);
				else
					frmMsg
						.addClass("alert alert-danger alert-sm text-white")
						.html(rs.msg)
						.slideDown(500);

				if (rs.scroll_to_msg)
					$("html, body").animate(
						{ scrollTop: frmMsg.offset().top - 300 },
						"slow"
					);

				if (typeof recaptcha !== "undefined" && recaptcha) grecaptcha.reset();

				if (rs.status == 1) {
					setTimeout(function () {
						$(".popup").fadeOut();
						$("html").removeClass("flow");
						$("#order-completion-section").remove();
						$("#order-status-dropdown").empty().append(rs.status_dropdown);
						$("#delivery-proof").empty().append(rs.delivery_proofs);
						/*$("[gallery]").lightGallery({
							thumbnail: true,
						});*/
						if (rs.frm_reset) {
							frm.reset();
						}

						if (rs.hide_msg) frmMsg.slideUp(500);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) {
							window.location.href = rs.redirect_url;
						} else {
							frmbtn.attr("disabled", false);
						}
					}, 3000);
				} else {
					setTimeout(function () {
						if (rs.hide_msg) frmMsg.slideUp(500);
						frmbtn.attr("disabled", false);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) window.location.href = rs.redirect_url;
					}, 2000);
				}
			})
			.fail(function (rs) {
				console.log(rs);
				// alert('Network error has occurred please try again!');
			})
			.always(function () {
				needToConfirm = false;
			});
	});
});

$(document).ready(function () {
	$(document).on("submit", ".frmAmendInvoice", function (e) {
		e.preventDefault();
		needToConfirm = true;
		var frmbtn = $(this).find("button[type='submit']");
		var frmIcon = $(this).find("button[type='submit'] i.spinner");
		var frmMsg = $(this).find("div.alertMsg:first");
		var frm = this;

		frmbtn.attr("disabled", true);
		frmMsg.hide();
		frmIcon.removeClass("hidden");
		$.ajax({
			url: $(this).attr("action"),
			data: new FormData(frm),
			processData: false,
			contentType: false,
			dataType: "JSON",
			method: "POST",
		})
			.done(function (rs) {
				console.log(rs);

				frmMsg.removeClass("alert alert-danger alert-sm text-white");
				if (rs.status == 1) frmMsg.html(rs.msg).slideDown(500);
				else
					frmMsg
						.addClass("alert alert-danger alert-sm text-white")
						.html(rs.msg)
						.slideDown(500);

				if (rs.scroll_to_msg)
					$("html, body").animate(
						{ scrollTop: frmMsg.offset().top - 300 },
						"slow"
					);

				if (typeof recaptcha !== "undefined" && recaptcha) grecaptcha.reset();

				if (rs.status == 1) {
					setTimeout(function () {
						$(".popup").fadeOut();
						$("html").removeClass("flow");
						$("#amended-invoice").empty().append(rs.html);
						if (rs.frm_reset) {
							frm.reset();
						}

						if (rs.hide_msg) frmMsg.slideUp(500);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) {
							window.location.href = rs.redirect_url;
						} else {
							frmbtn.attr("disabled", false);
						}
					}, 3000);
				} else {
					setTimeout(function () {
						if (rs.hide_msg) frmMsg.slideUp(500);
						frmbtn.attr("disabled", false);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) window.location.href = rs.redirect_url;
					}, 2000);
				}
			})
			.fail(function (rs) {
				console.log(rs);
				// alert('Network error has occurred please try again!');
			})
			.always(function () {
				needToConfirm = false;
			});
	});
});

$(document).ready(function () {
	$(document).on("submit", ".runTimeSignin", function (e) {
		e.preventDefault();
		needToConfirm = true;
		var frmbtn = $(this).find("button[type='submit']");
		var frmIcon = $(this).find("button[type='submit'] i.spinner");
		var frmMsg = $(this).find("div.alertMsg:first");
		var frm = this;

		frmbtn.attr("disabled", true);
		frmMsg.hide();
		frmIcon.removeClass("hidden");
		$.ajax({
			url: $(this).attr("action"),
			data: new FormData(frm),
			processData: false,
			contentType: false,
			dataType: "JSON",
			method: "POST",
		})
			.done(function (rs) {
				console.log(rs);

				frmMsg.removeClass("alert alert-danger alert-sm text-white");
				if (rs.status == 1) frmMsg.html(rs.msg).slideDown(500);
				else
					frmMsg
						.addClass("alert alert-danger alert-sm text-white")
						.html(rs.msg)
						.slideDown(500);

				if (rs.scroll_to_msg)
					$("html, body").animate(
						{ scrollTop: frmMsg.offset().top - 300 },
						"slow"
					);

				if (rs.status == 1) {
					let mem = rs.mem_data;
					setTimeout(function () {
						if (rs.frm_reset) {
							frm.reset();
						}

						if (rs.hide_msg) frmMsg.slideUp(500);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) {
							window.location.href = rs.redirect_url;
						} else {
							frmbtn.attr("disabled", false);
						}

						$(".popup").fadeOut();
						$("html").removeClass("flow");
						$("#account-info").remove();
						$("#enter-address").remove();
						$("#customer-name").text(`${mem.mem_fname} ${mem.mem_lname}`);
						$("#customer-phone").text(`${mem.mem_phone}`);
						$("#customer-email").text(`${mem.mem_email}`);
						$("#nav").html(`${rs.header_nav}`);
						let select_address = "";
						select_address += `<h6>Select your address</h6>
                        <div class="flexGrp"><div class="txtGrp">
                        <label for="address" class="move">Address</label>
                        <select name="address" id="address" class="text_box" onchange="setAddress(this)">
                        <option value="">Select</option>`;
						if (
							$.trim(mem.mem_city).length != 0 &&
							$.trim(mem.mem_address).length != 0 &&
							$.trim(mem.mem_zip).length != 0
						) {
							select_address += `<option data-type="home" value="${mem.mem_city} - ${mem.mem_address} - ${mem.mem_zip}" data-lat="${mem.mem_map_lat}" data-long="${mem.mem_map_lng}" data-full-address="Home: ${mem.mem_city} - ${mem.mem_address} - ${mem.mem_zip}">
                            Home: ${mem.mem_city} - ${mem.mem_address} - ${mem.mem_zip}
                            </option>`;
						}
						if (
							$.trim(mem.mem_business_city).length != 0 &&
							$.trim(mem.mem_business_address).length != 0 &&
							$.trim(mem.mem_business_zip).length != 0
						) {
							select_address += ` <option data-type="office" value="${mem.mem_business_city} - ${mem.mem_business_address} - ${mem.mem_business_zip}" data-lat="${mem.mem_business_map_lat}" data-long="${mem.mem_business_map_lng}" data-full-address="Office: ${mem.mem_business_city} - ${mem.mem_business_address} - ${mem.mem_business_zip}">
                            Office: ${mem.mem_business_city} - ${mem.mem_business_address} - ${mem.mem_business_zip}
                            </option>`;
						}
						if (
							$.trim(mem.mem_hotel_city).length != 0 &&
							$.trim(mem.mem_hotel_address).length != 0 &&
							$.trim(mem.mem_hotel_zip).length != 0
						) {
							select_address += `<option data-type="hotel" value="${mem.mem_hotel_city} - ${mem.mem_hotel_address} - ${mem.mem_hotel_zip}" data-lat="${mem.mem_hotel_map_lat}" data-long="${mem.mem_hotel_map_lng}" data-full-address="Hotel: ${mem.mem_hotel_city} - ${mem.mem_hotel_address} - ${mem.mem_hotel_zip}">
                            Hotel: ${mem.mem_hotel_city} - ${mem.mem_hotel_address} - ${mem.mem_hotel_zip}
                            </option>`;
						}
						select_address += `</select></div>`;
						if (
							$.trim(mem.mem_zip).length == 0 &&
							$.trim(mem.mem_business_zip).length == 0 &&
							$.trim(mem.mem_hotel_zip).length == 0
						) {
							select_address += `<div class="bTn">
                                <button type="button" class="webBtn lightBtn" id="addAddressRuntime">Add Address</button>
                            </div>`;
						}

						select_address += `</div><div class="br"></div>`;
						console.log(select_address);
						$("#select-address-after-login").html(select_address);
					}, 3000);
				} else {
					setTimeout(function () {
						if (rs.hide_msg) frmMsg.slideUp(500);
						frmbtn.attr("disabled", false);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) window.location.href = rs.redirect_url;
					}, 2000);
				}
			})
			.fail(function (rs) {
				console.log(rs);
				// alert('Network error has occurred please try again!');
			})
			.always(function () {
				needToConfirm = false;
			});
	});
});

$(document).ready(function () {
	$(document).on("submit", ".acceptDeliveryAndRating", function (e) {
		e.preventDefault();
		needToConfirm = true;
		var frmbtn = $(this).find("button[type='submit']");
		var frmIcon = $(this).find("button[type='submit'] i.spinner");
		var frmMsg = $(this).find("div.alertMsg:first");
		var frm = this;

		frmbtn.attr("disabled", true);
		frmMsg.hide();
		frmIcon.removeClass("hidden");
		$.ajax({
			url: $(this).attr("action"),
			data: new FormData(frm),
			processData: false,
			contentType: false,
			dataType: "JSON",
			method: "POST",
		})
			.done(function (rs) {
				console.log(rs);

				frmMsg.removeClass("alert alert-danger alert-sm text-white");
				if (rs.status == 1) frmMsg.html(rs.msg).slideDown(500);
				else
					frmMsg
						.addClass("alert alert-danger alert-sm text-white")
						.html(rs.msg)
						.slideDown(500);

				if (rs.scroll_to_msg)
					$("html, body").animate(
						{ scrollTop: frmMsg.offset().top - 300 },
						"slow"
					);

				if (typeof recaptcha !== "undefined" && recaptcha) grecaptcha.reset();

				if (rs.status == 1) {
					setTimeout(function () {
						$(".popup").fadeOut();
						$("html").removeClass("flow");
						$("#deliveryProofRequest")
							.empty()
							.append(
								`<div class="alert alert-success alert-sm text-white" style="">Request has been accepted successfully.</div>`
							);
						$("#delivery_proof").empty();
						$(
							"#btn_order_status"
						).empty().append(`<span class="webBtn mdBtn blockBtn completed>Completed</span>
                        `);
						if (rs.frm_reset) {
							frm.reset();
						}

						if (rs.hide_msg) frmMsg.slideUp(500);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) {
							window.location.href = rs.redirect_url;
						} else {
							frmbtn.attr("disabled", false);
						}
					}, 3000);
				} else {
					setTimeout(function () {
						if (rs.hide_msg) frmMsg.slideUp(500);
						frmbtn.attr("disabled", false);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) window.location.href = rs.redirect_url;
					}, 2000);
				}
			})
			.fail(function (rs) {
				console.log(rs);
				// alert('Network error has occurred please try again!');
			})
			.always(function () {
				needToConfirm = false;
			});
	});
});

$(document).ready(function () {
	$(document).on("submit", ".rejectDeliveryAndRating", function (e) {
		e.preventDefault();
		needToConfirm = true;
		var frmbtn = $(this).find("button[type='submit']");
		var frmIcon = $(this).find("button[type='submit'] i.spinner");
		var frmMsg = $(this).find("div.alertMsg:first");
		var frm = this;

		frmbtn.attr("disabled", true);
		frmMsg.hide();
		frmIcon.removeClass("hidden");
		$.ajax({
			url: $(this).attr("action"),
			data: new FormData(frm),
			processData: false,
			contentType: false,
			dataType: "JSON",
			method: "POST",
		})
			.done(function (rs) {
				console.log(rs);

				frmMsg.removeClass("alert alert-danger alert-sm text-white");
				if (rs.status == 1) frmMsg.html(rs.msg).slideDown(500);
				else
					frmMsg
						.addClass("alert alert-danger alert-sm text-white")
						.html(rs.msg)
						.slideDown(500);

				if (rs.scroll_to_msg)
					$("html, body").animate(
						{ scrollTop: frmMsg.offset().top - 300 },
						"slow"
					);

				if (typeof recaptcha !== "undefined" && recaptcha) grecaptcha.reset();

				if (rs.status == 1) {
					setTimeout(function () {
						$(".popup").fadeOut();
						$("html").removeClass("flow");
						$("#deliveryProofRequest")
							.empty()
							.append(
								`<div class="alert alert-success alert-sm text-white" style="">Request has been rejected successfully.</div>`
							);
						$("#delivery_proof").empty();
						if (rs.frm_reset) {
							frm.reset();
						}

						if (rs.hide_msg) frmMsg.slideUp(500);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) {
							window.location.href = rs.redirect_url;
						} else {
							frmbtn.attr("disabled", false);
						}
					}, 3000);
				} else {
					setTimeout(function () {
						if (rs.hide_msg) frmMsg.slideUp(500);
						frmbtn.attr("disabled", false);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) window.location.href = rs.redirect_url;
					}, 2000);
				}
			})
			.fail(function (rs) {
				console.log(rs);
				// alert('Network error has occurred please try again!');
			})
			.always(function () {
				needToConfirm = false;
			});
	});
});

$(document).ready(function () {
	$(document).on("submit", ".vendorBankAccount", function (e) {
		e.preventDefault();
		needToConfirm = true;
		var frmbtn = $(this).find("button[type='submit']");
		var frmIcon = $(this).find("button[type='submit'] i.spinner");
		var frmMsg = $(this).find("div.alertMsg:first");
		var frm = this;

		frmbtn.attr("disabled", true);
		frmMsg.hide();
		frmIcon.removeClass("hidden");
		$.ajax({
			url: $(this).attr("action"),
			data: new FormData(frm),
			processData: false,
			contentType: false,
			dataType: "JSON",
			method: "POST",
		})
			.done(function (rs) {
				console.log(rs);

				frmMsg.removeClass("alert alert-danger alert-sm text-white");
				if (rs.status == 1) frmMsg.html(rs.msg).slideDown(500);
				else
					frmMsg
						.addClass("alert alert-danger alert-sm text-white")
						.html(rs.msg)
						.slideDown(500);

				if (rs.scroll_to_msg)
					$("html, body").animate(
						{ scrollTop: frmMsg.offset().top - 300 },
						"slow"
					);

				if (typeof recaptcha !== "undefined" && recaptcha) grecaptcha.reset();

				if (rs.status == 1) {
					setTimeout(function () {
						$(".popup").fadeOut();
						$("html").removeClass("flow");
						$("#bank-accounts-vendor").empty().append(rs.html);
						if (rs.frm_reset) {
							frm.reset();
						}

						if (rs.hide_msg) frmMsg.slideUp(500);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) {
							window.location.href = rs.redirect_url;
						} else {
							frmbtn.attr("disabled", false);
						}
						location.reload();
					}, 3000);
				} else {
					setTimeout(function () {
						if (rs.hide_msg) frmMsg.slideUp(500);
						frmbtn.attr("disabled", false);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) window.location.href = rs.redirect_url;
					}, 2000);
				}
			})
			.fail(function (rs) {
				console.log(rs);
				// alert('Network error has occurred please try again!');
			})
			.always(function () {
				needToConfirm = false;
			});
	});
});

$(document).ready(function () {
	$(document).on("submit", ".withdrawForm", function (e) {
		e.preventDefault();
		needToConfirm = true;
		var frmbtn = $(this).find("button[type='submit']");
		var frmIcon = $(this).find("button[type='submit'] i.spinner");
		var frmMsg = $(this).find("div.alertMsg:first");
		var frm = this;

		frmbtn.attr("disabled", true);
		frmMsg.hide();
		frmIcon.removeClass("hidden");
		$.ajax({
			url: $(this).attr("action"),
			data: new FormData(frm),
			processData: false,
			contentType: false,
			dataType: "JSON",
			method: "POST",
		})
			.done(function (rs) {
				console.log(rs);

				frmMsg.removeClass("alert alert-danger alert-sm text-white");
				if (rs.status == 1) frmMsg.html(rs.msg).slideDown(500);
				else
					frmMsg
						.addClass("alert alert-danger alert-sm text-white")
						.html(rs.msg)
						.slideDown(500);

				if (rs.scroll_to_msg)
					$("html, body").animate(
						{ scrollTop: frmMsg.offset().top - 300 },
						"slow"
					);

				if (typeof recaptcha !== "undefined" && recaptcha) grecaptcha.reset();

				if (rs.status == 1) {
					setTimeout(function () {
						$(".popup").fadeOut();
						$("html").removeClass("flow");
						if (rs.frm_reset) {
							frm.reset();
						}

						if (rs.hide_msg) frmMsg.slideUp(500);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) {
							window.location.href = rs.redirect_url;
						} else {
							frmbtn.attr("disabled", false);
						}
						location.reload();
					}, 3000);
				} else {
					setTimeout(function () {
						if (rs.hide_msg) frmMsg.slideUp(500);
						frmbtn.attr("disabled", false);
						frmIcon.addClass("hidden");
						if (rs.redirect_url) window.location.href = rs.redirect_url;
					}, 2000);
				}
			})
			.fail(function (rs) {
				console.log(rs);
				// alert('Network error has occurred please try again!');
			})
			.always(function () {
				needToConfirm = false;
			});
	});
});

const fetchStates = (country_id, append_to) => {
	append_to = "#" + append_to;
	$.ajax({
		url: base_url + "index/fetch_states",
		data: {
			country_id: country_id,
		},
		dataType: "JSON",
		method: "POST",
		success: function (rs) {
			$(append_to).html(rs.html);
		},
		complete: function () {},
	});
};

const fetchTime = (day, mem_id, appendTo) => {
	$.ajax({
		url: base_url + "index/fetch_time",
		data: {
			day: day,
			mem_id: mem_id,
		},
		dataType: "JSON",
		method: "POST",
		success: function (rs) {
			$("#" + appendTo).html(rs.html);
			$(".selectpicker").selectpicker("refresh");
		},
		complete: function () {},
	});
};

$(document).on("submit", ".frm_promo", function (e) {
	e.preventDefault();
	needToConfirm = true;
	var frmbtn = $(this).find("button[type='submit']");
	var frm = this;
	$.ajax({
		url: base_url + "Ajax/search_promo/",
		data: new FormData(frm),
		processData: false,
		contentType: false,
		dataType: "JSON",
		method: "POST",
		error: function (rs) {
			console.log(rs);
		},
		success: function (promotions) {
			var promos = "";
			promotions.map((promotion) => {
				promos +=
					'<div class="col"><div class="promo_blk"><div class="icon"><img src="' +
					base_url +
					"/uploads/promos/" +
					promotion.image +
					'"></div><div class="txt"><h4>' +
					promotion.name +
					"</h4><p>" +
					promotion.tagline +
					'</p><p>This offer will expire on <span class="red-color">' +
					promotion.expiry_date +
					'</span></p></div><div class="btm"><div class="price">£' +
					promotion.price +
					'</div><div class="btn_blk"><a href="' +
					base_url +
					'" class="site_btn md block">Order Now</a></div><div class="by small"><strong>Added By: </strong>' +
					promotion.added_by +
					"</div></div></div></div>";
			});
			$(".filter_promos").html(
				'<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>'
			);
			setTimeout(function () {
				if (promos == "" || promos == null) {
					$(".filter_promos").html(
						'<div class="col full"><p class="text-center">No Promotions Found</p></div>'
					);
				} else {
					$(".filter_promos").html(promos);
				}
			}, 900);
		},
	});
});
