(function($) {
	var PHOENIX = (function() {

		var $sel = {};
		$sel.document = $(document);
		$sel.window = $(window);
		$sel.html = $("html");
		$sel.body = $("body", $sel.html);

		return {

			common: {
				go: function(topPos, speed, callback) {
					var curTopPos = $sel.window.scrollTop(),
						diffTopPos = Math.abs(topPos - curTopPos);
					$sel.body.add($sel.html).animate({
						"scrollTop": topPos
					}, speed, function() {
						if(callback) {
							callback();
						}
					});
				}
			},

			content: {
				slider: function() {
					$(".page-slider-holder", $sel.body).each(function() {
						(function($holder) {
							var $slider = $(".page-slider", $holder),
								$nav = $(".page-slider-nav", $holder),
								$prev = $(".page-slider-nav-item--prev", $nav),
								$next = $(".page-slider-nav-item--next", $nav),
								$current = $(".page-slider-nav-counter-current", $nav),
								$all = $(".page-slider-nav-all", $nav);
							$slider.on("fotorama:ready", function(e, fotorama) {
								$prev.on("click", function() {
									fotorama.show("<");
								});
								$next.on("click", function() {
									fotorama.show(">");
								});
								$all.text(fotorama.size);
								$current.text(fotorama.activeIndex + 1);
							}).fotorama().on("fotorama:show", function(e, fotorama) {
								$current.text(fotorama.activeIndex + 1)
							});
						})($(this));
					});
				},
				stickyMenu: function() {
					$(".page-menu", $sel.body).stick_in_parent({});

					/*var $sections = $(".page-section", $sel.body),
						$menuItems = $(".page-menu-item", $sel.body);

					$sections.each(function() {
						var $section = $(this);
						$section.data({
							"top": $section.position().top,
							"bottom": $section.position().top + $section.height()
						});
					});

					$menuItems.on("click", function(e) {
						var $item = $(this);
						PHOENIX.common.go($($item.attr("href")).offset().top - 80, 500);
						e.preventDefault();
					});

					$sel.window.on("scroll", checkScroll);
					checkScroll();

					function checkScroll() {
						var scrollTop = $sel.window.scrollTop() + $sel.window.height() / 2;

						$sections.each(function() {
							var $section = $(this);
							if($section.data("top") < scrollTop && $section.data("bottom") > scrollTop) {
								$menuItems.removeClass("active");
								$menuItems.filter("[href*=" + $section.attr("id") + "]").addClass("active");
								return false;
							}
						});
					}*/
				},
				dropdown: {
					timer: false,
					init: function() {
						var self = this;
						$(".header-menu-item-holder--has-submenu, .header-catalog", $sel.body)
							.on("mouseenter", function() {
								(function($holder) {
									self.show($holder);
								})($(this));
							})
							.on("mouseleave", function() {
								(function($holder) {
									self.hide($holder);
								})($(this));
							});
					},
					show: function($holder) {
						var self = this;
						if(self.timer) {
							clearTimeout(self.timer);
						}
						var $list = $("> nav", $holder);
						$list.css("display", "block");
						self.timer = setTimeout(function() {
							$holder.addClass("hovered");
						}, 50);
					},

					hide: function($holder) {
						var self = this;
						if(self.timer) {
							clearTimeout(self.timer);
						}
						var $list = $("> nav", $holder);
						$holder.removeClass("hovered");
						self.timer = setTimeout(function() {
							$list.css("display", "none");
						}, 220);
					}
				},
				goTop: function() {
					var $dest = $(".go-top", $sel.body);
					$sel.window.on("scroll", function() {
						var sTop = $sel.window.scrollTop();
						(sTop < $sel.window.height()) ? $dest.removeClass("active") : $dest.addClass("active");
					});
					$dest.on("click", function(e) {
						if($dest.hasClass("active")) {
							PHOENIX.common.go(0, 1000);
						}
						e.preventDefault();
					});
				},
				tabs: {
					init: function() {
						var self = this;
						$(".product-features-heading-item, .product-features-content-item-heading", $sel.body).on("click", function(e) {
							var $item = $(this),
								$tabs = $item.closest(".product-features"),
								itemID = $item.data("id");
							if(!$tabs.hasClass("inactive")) {
								if(!$item.hasClass("active")) {
									self.hideAll($tabs);
									self.show(itemID, $tabs);
								}
								e.preventDefault();
							}
						});
					},
					show: function(tabID, $tabs) {
						$(".product-features-heading-item[data-id=" + tabID + "]", $tabs).addClass("active");
						$(".product-features-content-item[id=" + tabID + "]", $tabs).addClass("active");
					},
					hide: function(tabID, $tabs) {
						$(".product-features-heading-item[href*=" + tabID + "]", $tabs).removeClass("active");
						$(".product-features-content-itemid*=" + tabID + "]", $tabs).removeClass("active");
					},
					hideAll: function($tabs) {
						$(".product-features-heading-item", $tabs).removeClass("active");
						$(".product-features-content-item", $tabs).removeClass("active");
					}
				},
				more: function() {
					console.log("323232")
					$(".catalog-heading-description, .success-item-text .page-text", $sel.body).dotdotdot({
						ellipsis: '...',
						after: "a.link"
					});
					$(".catalog-heading-description .link, .success-item-text .page-text .link").on("click", function(e) {
						var $text = $(this).parent();
						if($text.triggerHandler("isTruncated")) {
							$text.empty().append($text.triggerHandler("originalContent")).addClass("full");
							$text.trigger("destroy");
						}
						e.preventDefault();
					});
				},
				init: function() {
					var self = this;

					self.slider();
					self.stickyMenu();
					self.dropdown.init();
					self.goTop();
					self.tabs.init();
					self.more();
				}
			},

			popup: {
				init: function($container) {
					if(!$container) {
						var $container = $sel.body;
					}
					$(".popup", $container).each(function() {
						(function($p) {
							$p.magnificPopup({
								type: $p.data("type") ? $p.data("type") : "ajax",
								mainClass: "mfp-fade",
								removalDelay: 300,
								tClose: "Закрыть (ESC)",
								tLoading: "Загрузка...",
								callbacks: {
									open: PHOENIX.forms.init
								}
							});
						})($(this));
					});
				}
			},

			accordion: {
				$opened: false,
				init: function() {
					var self = this;
					$(".accordion-item-header").on("click", function() {
						var $item = $(this).closest(".accordion-item");
						if($item.hasClass("opened")) {
							self.hide($item);
							return false;
						}
						if(self.$opened) {
							self.hide(self.$opened);
						}
						self.show($item);

						setTimeout(function() {
							PHOENIX.common.go($item.offset().top, 500);
						}, 350);
					});
				},
				show: function($item) {
					var self = this,
						$content = $item.find(".accordion-item-content");
					$item.addClass("opened");
					$content.css("display", "block");
					(function($content) {
						setTimeout(function() {
							$content.addClass("show")
						}, 50);
					})($content);
					self.$opened = $item;


				},
				hide: function($item) {
					var self = this,
						$content = $item.find(".accordion-item-content");
					$item.removeClass("opened");
					$content.removeClass("show");
					(function($content) {
						setTimeout(function() {
							$content.css("display", "none");
						}, 350);
					})($content);

					self.$opened = false;
				}
			},

			home: {
				init: function() {
					if(!$(".home", $sel.body).length) {
						return false;
					}

					$sel.window.on("load", function() {
						setTimeout(function() {
							$(".home", $sel.body).addClass("loaded");
							setTimeout(function() {
								$(".home-shop-video").get(0).play();
							}, 800);
						}, 1000);
					});
				}
			},

			catalog: {
				sections: function() {
					$(".catalog-sections-all-holder .link").on("click", function(e) {
						$(".catalog-sections").toggleClass("show-all");
						if($(".catalog-sections").hasClass("show-all")) {
							$(this).text("Только основные");
						} else {
							$(this).text("Показать все категории");
						}
						e.preventDefault();
					});
				},
				banner: function() {
					$(".catalog-banners").on("fotorama:ready", function(e, fotorama) {
						if($sel.window.width() <= "640") {
							fotorama.setOptions({
								"ratio": "1"
							});
						}
					}).fotorama();
				},
				basket: {
					init: function() {
						var self = this;
						self.tooltip();

						$(".product-buy").on("click", function(e) {
							var $btn = $(this);

							if($btn.hasClass("catalog-item-buy")) {
								$btn.text("В корзине 200");
							}

							PHOENIX.common.go(0, 1000, function() {
								self.show();
							});
							e.preventDefault();
						});
					},
					tooltip: function() {
						$(".header-basket", $sel.body).tooltipster({
							animation: "fade",
							animationDuration: 300,
							content: $("#page-basket"),
							contentAsHTML: true,
							arrow: false,
							theme: "basket-tooltip",
							side: "bottom",
							interactive: true,
							trigger: "custom",
							triggerOpen: {
								mouseenter: false
							},
							triggerClose: {
								click: true,
								//scroll: true
							}
						});
					},
					show: function() {
						$(".header-basket", $sel.body).tooltipster("open");
					}
				},
				quantity: {
					init: function() {
						var self = this;
						$(".product-quantity", $sel.body).on("blur", function() {
							self.checkPack($(this));
						}).tooltipster({
							animation: "fade",
							animationDuration: 300,
							content: "",
							contentAsHTML: true,
							arrow: false,
							theme: "product-tooltip",
							side: "top",
							interactive: true,
							trigger: "custom",
							triggerOpen: {
								mouseenter: false
							},
							triggerClose: {
								click: true,
								scroll: true
							}
						});
					},
					checkPack: function($item) {
						var value = parseInt($item.val()),
							pack = $item.data("pack"),
							num = value % pack;
						if(value == 0 || isNaN(value)) {
							$item.val("");
							$item.tooltipster("content", "Введите число");
							setTimeout(function() {
								$item.tooltipster("open");
							}, 200);
							return false;
						}
						if(num != 0) {
							var count = parseInt(value / pack) + 1,
								newValue = count * pack;
							$item.val(newValue);
							$item.tooltipster("content", "Вы можете заказать кратно " + pack + " шт.");
							setTimeout(function() {
								$item.tooltipster("open");
							}, 200);
							return false;
						} else {
							$item.val(value);
						}
					}
				},
				product: {
					init: function() {
						var self = this;
						self.colors();
					},
					colors: function() {
						$(".product-color-item", $sel.body).on("click", function() {
							var $item = $(this),
								photos = $item.data(photos).photos.split(",");
							$(".product-color-item", $sel.body).removeClass("active");
							$item.addClass("active");

							var fotorama = $(".product-photos", $sel.body).data("fotorama");
							fotorama.splice(0, 3);
							for(var i = 0; i < photos.length; i++) {
								fotorama.push({
									img: photos[i]
								});
							}
						});
					}
				},
				sliders: function() {
					$(".catalog-items[data-slick]").each(function() {
						(function($list) {
							$list.on("init", function(e, slider) {
								$list.closest(".catalog").find(".catalog-nav-item--prev").on("click", function() {
									$list.slick("slickPrev");
								});
								$list.closest(".catalog").find(".catalog-nav-item--next").on("click", function() {
									$list.slick("slickNext");
								});
								$list.closest(".catalog").find(".catalog-nav-counter-all").text(Math.ceil(slider.slideCount / slider.slickGetOption("slidesToScroll")));
							}).slick({
								arrows: false,
								responsive: [
									{
										breakpoint: 1050,
										settings: {
											slidesToShow: 3,
											slidesToScroll: 3
										}
									}, {
										breakpoint: 768,
										settings: {
											slidesToShow: 2,
											slidesToScroll: 2
										}
									}, {
										breakpoint: 500,
										settings: {
											slidesToShow: 1,
											slidesToScroll: 1
										}
									}
								]
							}).on("afterChange", function(e, slick, currentSlide) {
								$list.closest(".catalog").find(".catalog-nav-counter-current").text(Math.ceil(slick.currentSlide == 0 ? 1 : (slick.currentSlide / slick.slickGetOption("slidesToShow") + 1)));
							});
						})($(this));
					});
				},
				init: function() {
					var self = this;

					self.sections();
					self.basket.init();
					self.quantity.init();
					self.product.init();
					self.sliders();
					self.banner();
				}
			},

			basket: {
				$basket: false,
				$empty: false,
				init: function() {
					var self = this;
					self.$basket = $(".basket", $sel.body);
					self.$empty = $(".basket-empty", $sel.body);
					$(".basket-item-quantity", self.$basket).on("change", function() {
						self.calc();
					});
					$(".basket-item-remove", self.$basket).on("click", function(e) {
						self.remove($(this).closest(".basket-item").data("id"));
						e.preventDefault();
					});
					self.tooltips();
				},
				calc: function() {
					var self = this,
						basketPrice = 0;
					$(".basket-item", self.$basket).each(function() {
						var $item = $(this),
							itemPrice = parseFloat($item.data("price")),
							itemQuantity = parseInt($item.find(".basket-item-quantity").val()),
							itemSummary = itemPrice * itemQuantity;
						$(".basket-item-summary span", $item).text(itemSummary);
						basketPrice += itemSummary;

						if(itemQuantity == 0) {
							self.remove($item.closest(".basket-item").data("id"));
						}
					});
					$(".basket-order-summary-item--novat span", self.$basket).text(basketPrice);
					$(".basket-order-summary-item--large span", self.$basket).text(basketPrice);
				},
				remove: function(id, callback) {
					var self = this,
						$item = self.$basket.find(".basket-item[data-id=" + id + "]");
					$item.fadeOut(function() {
						$item.remove();
						self.calc();
						if(self.isEmpty()) {
							self.showEmptyBasket();
						}
					});
				},
				isEmpty: function() {
					var self = this;
					if(self.$basket.find(".basket-item").length) {
						return false;
					}
					return true;
				},
				showEmptyBasket: function() {
					var self = this;
					self.$basket.removeClass("show").addClass("hidden");
					self.$empty.removeClass("hidden").addClass("show");
				},
				tooltips: function() {
					$(".basket-item", $sel.body).each(function() {
						var $item = $(this),
							imgSrc = $item.data("img");
						if(!imgSrc) {
							return true;
						}
						$(".basket-item-name", $item).tooltipster({
							animation: "fade",
							animationDuration: 300,
							content: '<div class="img-holder"><img src="' + imgSrc + '" /></div>',
							contentAsHTML: true,
							arrow: false,
							theme: "product-tooltip",
							side: "top",
							interactive: true,
							trigger: "custom",
							triggerOpen: {
								mouseenter: true
							},
							triggerClose: {
								click: true,
								mouseleave: true,
								//scroll: true
							}
						});
					});
				}
			},

			animation: {
				click: {
					init: function() {
						var self = this;
						/*$sel.body.on("click", ".animation-click", function(e) {
							var $dest = $(this),
								offset = $dest.offset(),
								x = parseInt(e.pageX - offset.left),
								y = parseInt(e.pageY - offset.top);
							self.animate($dest, x, y);
							e.preventDefault();
						});*/
						$sel.body.on("click", ".animation-click", function(e) {
							setTimeout(function() {
								PHOENIX.animation.load.page($(this).closest("a").attr("href"));
							}, 200);
							e.preventDefault();
						});
						Waves.attach(".animation-click");
						Waves.init();
					}
					/*animate: function($holder, x, y) {
						var self = this;
						$holder.append('<div class="animation-circles" style="top: ' + y + 'px; left: ' + x + 'px;">' +
							'<div class="animation-circle-item animation-circle-item--blue"></div>' +
							'<div class="animation-circle-item animation-circle-item--orange"></div>' +
							'<div class="animation-circle-item animation-circle-item--green"></div>' +
						'</div>');
						setTimeout(function() {
							$holder.find(".animation-circles").addClass("active");
							setTimeout(function() {
								PHOENIX.animation.load.page($holder.closest("a").attr("href"));
							}, 200);
						}, 50);
					}*/
				},

				load: {
					isLoad: false,
					$content: null,
					init: function() {
						var self = this;
						self.$content = $(".page-content-inner", $sel.body);

						$(".animation-link").on("click", function(e) {
							PHOENIX.animation.load.page($(this).attr("href"));
							e.preventDefault();
						});
					},
					page: function(url) {
						var self = this;
						if(self.isLoad) {
							return false;
						}
						$(".header-basket").tooltipster("close");
						if($sel.window.scrollTop() < 200) {
							PHOENIX.common.go(0, 50);
						} else {
							PHOENIX.common.go(0, 300);
						}
						setTimeout(function() {
							self.isLoad = true;
							self.$content.addClass("loading");
							setTimeout(function() {
								$.ajax({
									url: url,
									success: function(html) {
										self.isLoad = false;
										var $html = $('<div />').append(html);
										self.$content.empty().append($html.find(".page-content-inner").html());
										self.$content.removeClass("loading");

                                        history.pushState(false, $html.find("title").text(), url);

										PHOENIX.reload();
									}
								});
							}, 200);
						}, 320);
					}
				},

				backLoad: function() {

					$sel.window.on('popstate', function(e) {

						page = $sel.window[0].location.pathname;

						pageSplit = page.split("/");

						namePage = pageSplit[pageSplit.length-1];

						if (namePage != "scheme.html") {
							GORIZONT.load.page(namePage);
						} else {
							$sel.window[0].location.reload();
						}

						return;
					});

				},

				init: function() {
					var self = this;

					self.load.init();
					self.backLoad();
					self.click.init();
				}
			},

			forms: {
				init: function($container) {
					if(!$container) {
						var $container = $sel.body;
					}

					jcf.setOptions("Select", {
						wrapNative: false,
						wrapNativeOnMobile: false
					});
					var $selects = $(".form-item--select", $container);
					$selects.each(function(i) {
						var $select = $(this),
							selectPlaceholder = $select.attr("placeholder");

						if(selectPlaceholder) {
							$select.prepend('<option class="hideme" selected>' + selectPlaceholder + '</option>');
						}

						jcf.replace($select);
					});

					$(".form-item--checkbox", $container).each(function() {
						var $ch = $(this);

						jcf.replace($ch, "Checkbox", {
							addClass: $ch.data("htmlclass") ? $ch.data("htmlclass") : ""
						});
					});

					$(".form-item--radio", $container).each(function() {
						var $rd = $(this);

						jcf.replace($rd, "Radio", {
							addClass: $rd.data("htmlclass") ? $rd.data("htmlclass") : "",
							spanColor: $rd.data("spancolor") ? $rd.data("spancolor") : ""
						});
					});

					jcf.replace($(".form-item--number", $container));
					jcf.replace($(".form-item--range", $container));

					$("[data-mask]").each(function() {
						var $item = $(this);
						$item.mask($item.data("mask"));
					});

					$.validator.setDefaults({
						errorClass: "form-item--error",
						errorElement: "span"
					});
					$.validator.addMethod("mobileRU", function(phone_number, element) {
						phone_number = phone_number.replace(/\(|\)|\s+|-/g, "");
						return this.optional(element) || phone_number.length > 5 && phone_number.match(/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{6,10}$/);
					}, "Error");
					$(".form", $container).each(function() {
						var $form = $(this),
							formParams = {
								rules: {

								},
								messages: {
								}
							},
							$formFields = $form.find("[data-error]");
						$formFields.each(function() {
							var $field = $(this),
								fieldPattern = $field.data("pattern"),
								fieldError = $field.data("error");
							if(fieldError) {
								formParams.messages[$field.attr("name")] = $field.data("error");
							} else {
								formParams.messages[$field.attr("name")] = "Ошибка заполнения";
							}
							if(fieldPattern) {
								formParams.rules[$field.attr("name")] = {};
								formParams.rules[$field.attr("name")][fieldPattern] = true;
							}
						});
						formParams.rules["profile-new-password2"] = {
							equalTo: "#profile-new-password1"
						};
						if($form.data("success")) {
							formParams.submitHandler = function(form) {
								$.magnificPopup.open({
									items: {
										src: $form.data("success"),
										type: "inline"
									},
									mainClass: "mfp-fade",
									removalDelay: 300
								});
							};
						} else if($form.data("order")) {
							formParams.submitHandler = function(form)
                                                        {
                                                            var url = $(form).attr('action');
                                                            var data = $(form).serialize();
                                                            $.post(url, data, function(json)
                                                            {
                                                                if (json.order.REDIRECT_URL.length > 0)
                                                                {
                                                                    document.location = json.order.REDIRECT_URL;
                                                                }
                                                            }, 'json');
                                                        }
						}

						$form.validate(formParams);
					});
					

				}
			},

			filter: {
				init: function() {
					var $filter = $(".filter", $sel.body),
						$balloon = $(".filter-balloon", $filter),
						$items = $(".form-item", $filter),
						balloonTimer = false;

					var $priceFilter = $("#filter-price-range", $sel.body);

					$priceFilter.on("change input", function(e, u) {

						syncPriceFilter("slider");

                                                var $fromInput = $($priceFilter.data("from"));
                                                $fromInput.change();
					});
					$(".filter-slider-field-input", $sel.body).on("change", function() {
						syncPriceFilter("field");
					});
					$filter.on("reset", function() {
						setTimeout(function() {
							syncPriceFilter("field");
						}, 100);
					});

					function syncPriceFilter(source) {
						var $fromInput = $($priceFilter.data("from")),
							$toInput = $($priceFilter.data("to")),
							fromVal, toVal;
						if(source == "slider") {
							fromVal = $priceFilter[0].valueLow,
							toVal = $priceFilter[0].valueHigh;
						} else if(source == "field") {
							fromVal = $fromInput.val().replace(" ", ""),
							toVal = $toInput.val().replace(" ", "");
							var inst = jcf.getInstance($priceFilter);
							inst.values = [fromVal, toVal];
							inst.refresh();
						}
						$fromInput.val(formatValue(fromVal));
						$toInput.val(formatValue(toVal));
					}

					function formatValue(value) {
						return value;

						/*var strValue = value.toString(),
							formatStrValue = [];
						for(var len = strValue.length, i = len, j = 0; i >= 0; i--) {
							formatStrValue.push(strValue[i]);
							if(j == 3) {
								formatStrValue.push(' ');
								j = 0;
							}
							j++;
						}
						return formatStrValue.reverse().join("");*/
					}

					$items.on("change", function() {
						var $item = $(this),
							$itemHolder = $item.closest(".filter-item-variant");



						$balloon.addClass("show").css("top", $itemHolder.position().top);
						clearTimeout(balloonTimer);
						balloonTimer = setTimeout(function() {
							$balloon.removeClass("show");
						}, 2000);
					});

					$(".filter-item-header", $sel.body).on("click", function(e) {
						$(this).closest(".filter-item").toggleClass("open");
						e.preventDefault();
					});

				}
			},

			action: {
				COOKIE_NAME: "TOP_ACTION",
				$block: false,
				$blockClose: false,
				blockID: false,
				init: function() {
					var self = this;

					self.$block = $(".page-action", $sel.body);
					if(!self.$block || !self.$block.length) {
						return false;
					}
					self.$blockClose = $(".page-action-close", self.$block);
					self.blockID = self.$block.data("id");

					$sel.window.on("load", function() {
						setTimeout(function() {
							self.show(self.blockID);
						}, 1000);
					});
					self.$blockClose.on("click", function(e) {
						self.hide(self.blockID);
						e.preventDefault();
					});
				},
				show: function(blockID) {
					var self = this;
					if(Cookies.get(self.COOKIE_NAME + "_" + blockID)) {
						return false;
					}
					self.$block.removeClass("hidden");
				},
				hide: function(blockID) {
					var self = this;
					self.$block.addClass("hidden");
					Cookies.set(self.COOKIE_NAME + "_" + blockID, "Y", {
						expires: 7
					});
				}
			}

		};

	})();

	PHOENIX.accordion.init();
	PHOENIX.content.init();
	PHOENIX.home.init();

	PHOENIX.catalog.init();

	PHOENIX.animation.init();

	PHOENIX.forms.init();

	PHOENIX.filter.init();

	PHOENIX.basket.init();
	PHOENIX.popup.init();

	PHOENIX.action.init();

	PHOENIX.reload = function() {
		PHOENIX.accordion.init();
		PHOENIX.content.init();
		PHOENIX.home.init();

		PHOENIX.catalog.init();

		PHOENIX.animation.init();

		PHOENIX.forms.init();

		PHOENIX.filter.init();

		PHOENIX.basket.init();
		PHOENIX.popup.init();

		PHOENIX.action.init();

		$(".product-photos").fotorama();
	}

})(jQuery);
