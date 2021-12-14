//$(window).bind("pageshow", function(event) {
//    console.log(111);
//    console.log(event);
//    if (event.originalEvent.persisted) {
////        window.location.reload()
//    }
//});
$.validator.addMethod("login_active", function(value, element, param) {

    var ret = true;

    if (not_active_u.indexOf($.md5(value)) >= 0)
    {
        ret = false;
    }

    return ret;
}, "Пользователь еще не прошел проверку");
$.validator.addMethod("login_has", function(value, element, param) {

    var ret = true;

    if (total_u.indexOf($.md5(value)) < 0)
    {
        ret = false;
    }

    return ret;
}, "Пользователь не найден");

$(document).ready(function() {
    if ($('#basket_form').length > 0) {
      $('#basket_form input').keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          $(this).blur();
          return false;
      }
   });
      }
});
var PHOENIX;
//PHOENIX.catalog.quantity.checkPack($(this));
(function($) {
	PHOENIX = (function() {

		var $sel = {};
		$sel.document = $(document);
		$sel.window = $(window);
		$sel.html = $("html");
		$sel.body = $("body", $sel.html);

		return {
			
			
			
			vote: {
				init: function() {
					$(".vote-photo-item input:checkbox").on("change", function(e) {
						var $chk = $(this),
							$section = $chk.closest(".profile-section-inner-row"),
							$fields = $section.find(".form-item--text"),
							$chks = $section.find("input:checkbox:checked");
						
						if($chks.length > 3) {
							setTimeout(function() {
								$chk.prop("checked", false);
								jcf.refresh($chk);
							}, 0);
							$.magnificPopup.open({
								items: {
									src: "#vote-info",
									type: "inline"
								},
								mainClass: "mfp-fade",
								removalDelay: 300
							});
							event.preventDefault();
							event.stopPropagation();
							return false;
						}
						
						$fields.val("");
						$chks.each(function(i) {
							var $chk = $(this);
							$fields[i].value = $chk.val();
						});
					});
				}	
			},
			
			
			shops: {
				init: function() {
					var $shops = $(".buy-item", $sel.body);
					
					$("#buy-select", $sel.body).on("change", function() {
						var $sel = $(this),
							city = $sel.val();
						
						if(city == "all") {
							$shops.show();
						} else {
							$shops.hide();
							$shops.filter("[data-city='" + city + "']").show();
						}

					});
				}	
			},
			
			personalShops: {
				init: function() {
					$sel.body.on("submit", ".shop-form", function(e) {
						e.preventDefault();
						
						var $form = $(this);
						$form.find("button:submit").attr("disabled", "disabled");
						
						$.ajax({
							url: $form.attr("action"),
							type: "post",
							dataType: "json",
							data: $form.serialize(),
							success: function(result) {
								if(result.SUCCESS_ADD) {
									$form.parent().append('<div class="form-success">Магазин успешно добавлен. Страница будет перезагружена автоматически.</div>');
									$form.remove();
								}
								if(result.ERROR_ADD) {
									$form.parent().prepend('<div class="form-error">Ошибка в добавлении магазина.</div>');
								}
								
								if(result.SUCCESS_UPDATE) {
									$form.parent().prepend('<div class="form-success">Магазин успешно обновлен.</div>');
									setTimeout(function() {
										$form.parent().find(".form-success").remove();
									}, 3000);
								}
								if(result.ERROR_UPDATE) {
									$form.parent().prepend('<div class="form-error">Возникли ошибки в обновлении магазина.</div>');
									setTimeout(function() {
										$form.parent().find(".form-error").remove();
									}, 3000);
								}
								
								if(result.RELOAD) {
									setTimeout(function() {
										window.location.reload();
									}, 350);
								}
								
								$form.find("button:submit").removeAttr("disabled");
							}
						});
						
						
					});
				}
			},
			
			
			
			
			gifts: {
				$holder: null,
				$bar: null,
				$current: null,
				
				info: false,
				
				divide: {},
				
				current: 0,
				
				init: function() {
					var self = this;
					
					self.basketBtn();
					
					if(/*$sel.body.hasClass("page-gifts") && */$sel.window.width() > 1100) {
						//self.snow();
					}
				},
				
				
				snow: function() {					
					$sel.body.flurry({
						character: "❄❅❆",
						color: "paleturquoise",
						frequency: 400,
						speed: 40000,
						height: parseInt($sel.body.height()*2.6),
						small: 16,
						large: 48,
						wind: -100,
						windVariance: 200,
						rotation: 90,
						rotationVariance: 180,
						startOpacity: 1,
						endOpacity: 0,
						opacityEasing: "cubic-bezier(1,.3,.6,.74)",
						blur: true,
						overflow: "hidden",
						zIndex: 9999
					});	
				},
				
				
				
				basketBtn: function() {
					var self = this;
					
					/*$(".basket-item-remove.has-gifts", $sel.body).on("click", function(e) {
						alert("44444");
					});*/
					
					$sel.body.on("click", ".basket-item-add-gifts", function(e) {
						e.preventDefault();
						
						var $a = $(this);
						
						
						$.magnificPopup.open({
							items: {
								src: $a.attr("data-href"),
								type: "ajax"
							},
							mainClass: "mfp-fade gifts-popup",
							removalDelay: 300,
							callbacks: {
								ajaxContentAdded: function() {
									self.handleGiftsBlock($(this.content));
								}
							}
						});
					});
				},
				
				
				
				handleGiftsBlock: function($block) {
					var self = this;
					
					self.$holder = $block;
					if(!self.$holder || !self.$holder.length) {
						return false;
					}
					
					self.$bar = $(".gifts-bar", $block);
					self.info = self.$bar.data("info");
	
					self.$current = $(".gifts-bar-counter-num-current", self.$bar);
					
					PHOENIX.catalog.sliders(self.$holder);
					
					self.plusMinus();
					
					
					/*$(".catalog-item--gift .product-quantity", self.$holder).on("blur", function() {
						self.calc();
						setTimeout(function() {
							self.setAndCheck();
						}, 50);
					});*/
					
					self.calc();
					self.setAndCheck();
					
					
					
					
					$(".gifts-add", self.$holder).on("click", function(e) {
						e.preventDefault();
						self.send(function() {
							$.magnificPopup.close();
							setTimeout(function() {
								//window.location.reload();
								$sel.body.trigger("basketRefresh");
								//self.$root.$emit("basketRefresh", response);
							}, 75);
						});
					});
				},
				
				
				plusMinus: function() {
					var self = this;
					$(".catalog-item-spinner-plus, .catalog-item-spinner-minus", self.$holder).on("click", function() {
						var $btn = $(this),
							btnAdd = parseInt($btn.data("add")),
							$q = $btn.closest(".catalog-item-spinner").find("input"),
							qVal = parseInt($q.val()),
							qMax = parseInt($q.data("max"));
						
						//console.log(qVal, btnAdd);
						if((qVal + btnAdd) < 0 || (qVal + btnAdd) > qMax) {
							return false;
						} else {
							$q.removeAttr("readonly").val(qVal + btnAdd).attr("readonly", "readonly");
							self.calc();
							setTimeout(function() {
								self.setAndCheck();
							}, 50);
						}
					});
				},
				
				send: function(callback) {
					var self = this;
					
					if(self.$bar.hasClass("success")) {
						var data = {};
						
						//data.base_product = self.info.basket_id;
						data.items = [];
						$(".catalog-item--gift .product-quantity", self.$holder).each(function() {
							var $q = $(this);
							if(!$q.val() || parseInt($q.val()) == 0) {
								return true;
							}
							data.items.push({
								"id": $q.data("id"),
								"quantity": parseInt($q.val() * ($q.data("pack") ? $q.data("pack") : 1)),
								"price": $q.data("price")
							});
						});
						
						$.ajax({
							url: "/gifts/february/buy.php",
							data: data,
							success: function(res) {
								console.log(res);
								if(callback) {
									callback();
								}
							}
						})
					}
				},
				
				calc: function() {
					var self = this;
					
					self.current = 0;
					self.divide = {};
					$(".catalog-item--gift .product-quantity", self.$holder).each(function() {
						var $q = $(this);
						if($q.val()) {
							self.current += parseInt($q.val());
						}
						
						if($q.data("category")) {
							if(!self.divide[$q.data("category")]) {
								self.divide[$q.data("category")] = parseInt($q.val());
							} else {
								self.divide[$q.data("category")] += parseInt($q.val());
							}
						}
					});
					
					console.log(self.current);
				},
				
				setAndCheck: function() {
					var self = this;
					
					self.$current.text(self.current);
					
					console.log(self.info.divide, self.divide);
					
					if(self.info.divide) {
						if(self.info.divide["500"] == self.divide["500"] && self.info.divide["900"] == self.divide["900"]) {
							self.$bar.removeClass("error process").addClass("success");
						} else {
							self.$bar.removeClass("process success").addClass("error");
						}
					} else {
						if(self.current > self.info.max) {
							self.$bar.removeClass("process success").addClass("error");
						} else if(self.current < self.info.max) {
							self.$bar.removeClass("error success").addClass("process");
						} else if(self.current == self.info.max) {
							self.$bar.removeClass("error process").addClass("success");
						}	
					}
					

				}
			},
			
			

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
								
								if(!fotorama.data[0].img) {
									fotorama.shift();
								}

								
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
//					$(".page-menu", $sel.body).stick_in_parent({});

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
					isSubShow: false,
					init: function() {
						var self = this;
						
						
						
						
						
						
						$(".header-catalog .header-catalog-title", $sel.body).off("click");
						$(".header-catalog .header-catalog-title", $sel.body)
							.on("click", function(e) {
								
								if(!self.isSubShow) {
									
									(function($holder) {
										self.show($holder);
									})($(this).parent());
								} else {
									
									(function($holder) {
										self.hide($holder);
									})($(this).parent());
								}
								e.preventDefault();
								e.stopPropagation();
							});
						
						$(".header-menu-item-holder--has-submenu", $sel.body)
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
							
						/*$(".header-menu-item-holder--has-submenu, .header-catalog .header-catalog-title", $sel.body)
							.on("click", function(e) {
								e.preventDefault();
							});*/
							
						$(window).on("click", function(e) {
						
							if(e.target && $(e.target).closest(".catalog-menu").length && !$(e.target).closest(".animation-link").length) {
								return false;
							}
							if($(".header-catalog").hasClass("hovered")) {
								PHOENIX.content.dropdown.hide($(".header-catalog", $sel.body));
							}
						});
						
						$(".catalog-menu-sub-inner").each(function() {
							var $inner = $(this),
								$lis = $inner.find("li");
							if($lis.length < 3) {
								$inner.append($('<li class="catalog-menu-sub-item-holder">&nbsp;</li>'));
							}
						});
						
						$(".catalog-menu-item", $sel.body)
					
							.on("mouseenter", function() {
								(function($holder) {
                                                                    if ($('#catalog-menu-sub' + $holder.attr('data-id')).length > 0)
                                                                    {
                                                                        $('#catalog-menu-sub' + $holder.attr('data-id')).show();
                                                                        $('#catalog-menu-sub' + $holder.attr('data-id')).addClass('show');
																		
																		$("body").css("min-height", $('#catalog-menu-sub' + $holder.attr('data-id')).height() + 300);
																		
                                                                    }
//									self.show($holder);
								})($(this));
							})
							.on("mouseleave", function() {
								(function($holder) {
                                                                    if ($('#catalog-menu-sub' + $holder.attr('data-id')).length > 0)
                                                                    {
                                                                        $('#catalog-menu-sub' + $holder.attr('data-id')).removeClass('show');
                                                                        $('#catalog-menu-sub' + $holder.attr('data-id')).hide();
                                                                    }
								})($(this));
							});
						$(".catalog-menu-sub", $sel.body)
							.on("mouseenter", function() {
								(function($holder) {
                                                                        $holder.show();
                                                                        $holder.addClass('show');
//									self.show($holder);
								})($(this));
							})
							.on("mouseleave", function() {
								(function($holder) {
                                                                        $holder.removeClass('show');
                                                                        $holder.hide();
								})($(this));
							});
							
						

							
							
					},
					show: function($holder) {
						console.log("show");
						var self = this;
						if(self.timer) {
							clearTimeout(self.timer);
						}
						var $list = $("> nav", $holder);
						$list.css("display", "block");
						self.timer = setTimeout(function() {
							$holder.addClass("hovered");
						}, 50);
						PHOENIX.content.dropdown.isSubShow = true;
					},

					hide: function($holder) {
						console.log("hide");
						var self = this;
						if(self.timer) {
							clearTimeout(self.timer);
						}
						var $list = $("> nav", $holder);
						$holder.removeClass("hovered");
						self.timer = setTimeout(function() {
							$list.css("display", "none");
						}, 220);
						PHOENIX.content.dropdown.isSubShow = false;
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
						
						$(".catalog-item-youtube-link").on("click", function(e) {
							var $tabs = $(".product-features", $sel.body);

							self.hideAll($tabs);
							self.show("t5", $tabs);	
							PHOENIX.common.go($(".product-features-content-item[id='t5']", $tabs).offset().top - 75);

							
							e.preventDefault();
							return false;
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
					$(".catalog-heading-description, .success-item-text .page-text", $sel.body).dotdotdot({
						ellipsis: '...',
						after: "a.link"
					});
					$(".catalog-heading-description .link, .success-item-text .page-text .link").on("click", function(e) {
						var $text = $(this).closest("div");
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
					
					$("#header-catalog-container").load("/ajax/getMenuSections.php", function() {
						$("#header-catalog-container > nav").unwrap();
						self.dropdown.init();
					});
					
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
								closeOnBgClick: (($p.data("modal") !== undefined) ? false : true),
								callbacks: {
									open: function() {
										PHOENIX.forms.init;
										
										/*if($(this.content).attr("id") == "login") {
											console.log($(this.content).find("form"));
											$(this.content).find("form").on("submit", function(e) {
												var $form = $(this);
												$.ajax({
													url: $form.attr("action"),
													type: "post",
													data: $form.serialize(),
													success: function(r) {
														console.log(r);
													}
												});
												e.preventDefault();
												return false;
											});
										}*/
										
										if($(this.content).attr("id") == "filter") {
											PHOENIX.filter.options.init();
										}
										
										if($(this.content).attr("id") == "product-360") {
											var $img = $("img", $(this.content));
											$img.reel({
												image: $img.data("image"),
												frames: $img.data("frames"),
												footage: $img.data("footage"),
												responsive: true,
												cw: true,
												speed: "0.15",
												loops: 1,
												delay: 1,
												width: $(this.content).width(),
												height: $(this.content).height()
												//cursor: "/local/templates/.default/i/reel.cur"
											});
										}
										
									},
									ajaxContentAdded: function() {
										PHOENIX.forms.init($(this.content));
									}
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
						//setTimeout(function() {
							$(".home", $sel.body).addClass("loaded");
							setTimeout(function() {
								$(".home-shop-video").get(0).play();
							}, 500);
						//}, 1000);
					});
					

					$(".hide-video-checkbox", $sel.body).on("change", function() {
						var $chk = $(this);
						
						if($chk.prop("checked")) {
							Cookies.set("HIDE_VIDEO", "Y", {
								expires: 365
							});
						} else {
							Cookies.remove("HIDE_VIDEO")
						}
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
								"ratio": "3"
							});
						}
					}).fotorama();
				},
				basket: {
					init: function() {
						var self = this;
						self.tooltip();
					
						self.checkOldbasket();
						self.popupCart = $('#page-basket');
						
						                        $(".catalog-item-pre_buy").on("click", function (e) {
                            var $btn = $(this);
                            var id = $btn.prevAll('.product-quantity').first().attr('data-id');
                            var val = $btn.prevAll('.product-quantity').first().val();
                            var pack = $btn.prevAll('.product-quantity').first().data("pack");

                            if (val == '') {
                                return false;
                            }
                            if (isNaN(val)) {
                                val = 0;
                            }
                            val = parseInt(val);
                            var lastval = parseInt($btn.attr('data-q'));
                            if (isNaN(lastval)) {
                                lastval = 0;
                            }

                            $btn.attr('data-q', (val + lastval));
                            BX.ajax({
                                url: '/ajax/preAdd2basket.php',
                                dataType: "json",
                                method: 'POST',
                                data: {
                                    'action': 'addToCart',
                                    'mode': 'UF_PRE_ORDER_CART',
                                    'id': id,
                                    'quantity': val,
                                    'increase': 'Y',
                                },
                                processData: true,
                                emulateOnload: true,
                                async: true,
                                scriptsRunFirst: true,
                                cache: false,
                                timeout: 30,
                                onsuccess: BX.delegate(function (result) {
                                        BX.adjust(this, {
                                            text: 'Предзаказ ' + this.getAttribute("data-q")
                                        });
                                    },
                                    this
                                ),
                                onfailure: function () {
                                    alert('Error connecting server');
                                }
                            })
                        });
						
						$(".product-buy").on("click", function(e) {
							var $btn = $(this);

							var id = $btn.prevAll('.product-quantity').first().attr('data-id');
							var val = $btn.prevAll('.product-quantity').first().val();
                                                        if (val == '') {return false;}

                                                        if (isNaN(val)) {
                                                            val = 0;
                                                        }

                                                        val = parseInt(val);
                                                        var lastval = parseInt($btn.attr('data-q'));
                                                        if (isNaN(lastval)) {
                                                            lastval = 0;
                                                        }
                                                        $btn.attr('data-q', (val+lastval));



							self.add(id, val, $btn.prevAll('.product-quantity').first().data("pack"), function(json) {
								//console.log(json);
								if($btn.hasClass("catalog-item-buy")) {
									$btn.text("В корзине " + json.quantity);
								}
								if($btn.hasClass("product-quantity-add")) {
									$btn.text("В корзине " + json.quantity);
								}
								//$btn.prevAll('.product-quantity').first().val("");
							});

                                                        if ($('.product').length > 0)
                                                        {
//                                                            PHOENIX.common.go(0, 1000, function() {
//                                                                    self.show();
//                                                            });
                                                        }
							e.preventDefault();
						});
						
						

						
						if($(".basket-fastadd") && $(".basket-fastadd").length) {
							self.fast.init();
						}
						
						
					},
					
					
					checkOldbasket: function() {
						var $msg = $("#old-basket-message", $sel.body),
							cookie_name = "old-basket-message";
						if(!$msg || !$msg.length) {
							return false;
						}
						
						if(!Cookies.get(cookie_name)) {
							$sel.window.on("scroll", function() {
								var sTop = $sel.window.scrollTop();
								if(sTop > 250) {
									$msg.addClass("show");
								} else {
									$msg.removeClass("show");
								}
							});	
						}
						$(".page-message-close", $msg).on("click", function(e) {
							e.stopPropagation();
							e.preventDefault();
							
							$msg.removeClass("show");
							setTimeout(function() {
								$msg.remove();
							}, 350);
							Cookies.set(cookie_name, "Y", {
								expires: 7
							});
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
					},
					add: function(id, quantity, pack, callback) {
						var self = this;
						
						$.post('/ajax/add2basket.php', {id:id, quantity:quantity, pack: pack}, function(html)
						{
						    var $html = $('<div>'+html+'</div>');
						    $('.header-basket').html($html.find('.header-basket').html());
//                                                    console.log($('.page-basket'));
//                                                    console.log($html.find('#page-basket_in').length);
						    self.popupCart.html($html.find('#page-basket_in').html());

							
							$(".mobile-header-basket .mobile-header-basket-count").text($html.find('.header-basket .header-basket-count').text());

                                                    $html.remove();
                            
                            if(callback) {
	                            callback({
		                            quantity: $html.find('[data-quantity]').data("quantity")
	                            });
                            }                   
                           
						});
						
						if(window.ym && window.ym != undefined) {
							ym(48640211, "reachGoal", "event_basket_add");
							console.log("Goal event_basket_add");
						}
						
					},
					
					fast: {
						$form: false,
						$barcode: false,
						$msg: false,
						$submit: false,
						
						states: {
							sended: false
						},
						
						init: function() {
							var self = this;
	
							self.$form = $(".basket-fastadd");
							self.$barcode = self.$form.find("input[name='product_barcode']");
							self.$msg = self.$form.find(".basket-fastadd-result");
							self.$submit = self.$form.find("button:submit");
							
							self.$form.on("submit", function(e) {
								e.preventDefault();
								self.send();
							});
							
							self.$barcode.on("keydown", function(e) {
								//console.log(e);
								if(e.which == 13) {
									self.send();
								}
							});
							
							self.handleScanner();
							
							/*$(document).scannerDetection({
								timeBeforeScanTest: 200, // wait for the next character for upto 200ms
								startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
								endChar: [13], // be sure the scan is complete if key 13 (enter) is detected
								avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
								onComplete: function(barcode, qty) {
									alert(barcode);
								},
								onKeyDetect: function(e) {
									console.log(e.which)
								}
							});*/
						},
						
						handleScanner: function() {
							var self = this,
								timer = null,
								arString = [];
							
							$(document).on("keydown", function(e) {
								timer = setTimeout(function() {
									arString = [];
								}, 500);
								
								if(e.which == 13) {
									self.$barcode.val(arString.join(''));
									self.send();
									arString = [];
									
									return false;
								}
								arString.push(e.key);
							});
						},
						
						send: function() {
							var self = this;
							
							if(self.states.sended) {
								return false;
							}
							
							$.ajax({
								url: self.$form.attr("action"),
								type: "post",
								dataType: "json",
								data: {
									barcode: self.$barcode.val(),
									quantity: 1
								},
								beforeSend: function() {
									self.states.sended = true;
								},
								complete: function() {
									self.states.sended = false;
									self.$barcode.val('');
								},
								success: function(r) {
									self.$msg.removeClass("success error");
									if(r.message) {
										self.$msg.html(r.message);
									}
									if(r.result == -1) {
										self.$msg.addClass("error");
									} else {
										self.$msg.addClass("success");
										window.location.reload();
										//$("#basket-holder").load("/cart/basket.php");
									}
									
									//updateBasketTable();
									//updateBasket();
								}
							});
						}

						

					}
				},
				quantity: {
					
					
					
					/*
					$("input.product-quantity").on("keypress", function(e) {
						var $field = $(this);
						if(e.keyCode == 13) {
							console.log($field.parent());
							$field.parent().find(".product-buy").trigger("click");
						}
					});
					*/


					
					
					init: function() {
						var self = this;
						$(".product-quantity", $sel.body).on("blur", function() {
							self.checkPack($(this));
						}).on("keypress", function(e) {
							if(e.keyCode == 13) {
								if(self.checkPack($(this))) {
									//console.log("thur");
									$(this).parent().find(".product-buy").trigger("click");
								}
								e.preventDefault();
								e.stopPropagation();
							}
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
							return true;
						}
					}
				},
				product: {
					init: function() {
						var self = this;
						self.colors();
						
						$(".product-photos", $sel.body).on("fotorama:ready", function(e, fotorama) {
							if(!fotorama.data[0].img) {
								fotorama.shift();
							}
						}).on("fotorama:show", function(e, fotorama, extra) {
							console.log(e, fotorama, extra);
							if(fotorama.activeFrame.image) {
								$("img", fotorama.activeFrame.$stageFrame).reel({
									image: fotorama.activeFrame.image,
									frames: 36,
									footage: 6
								});
							}
						}).fotorama();
					},
					colors: function() {
//						$(".product-color-item", $sel.body).on("click", function() {
//							var $item = $(this),
//								photos = $item.data(photos).photos.split(",");
//							$(".product-color-item", $sel.body).removeClass("active");
//							$item.addClass("active");
//
//							var fotorama = $(".product-photos", $sel.body).data("fotorama");
//							fotorama.splice(0, 3);
//							for(var i = 0; i < photos.length; i++) {
//								fotorama.push({
//									img: photos[i]
//								});
//							}
//						});
					}
				},
				sliders: function($holder) {
					if(!$holder) {
						$holder = $sel.body;
					}
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
								
								
								
								if($sel.window.width() > 1000) {
									if(slider.options.rows && slider.options.rows == 2) {
										var maxHeight = 0;
										slider.$slider.find(".catalog-item.catalog-item--w1").each(function() {
											var $i = $(this);
											if($i.height() > maxHeight) {
												maxHeight = $i.height();
											}
										});
										slider.$slider.find(".catalog-item.catalog-item--w1").height(maxHeight);
									}									
								}

								
								
								
							}).slick({
								arrows: false,
								responsive: [
									{
										breakpoint: 1050,
										settings: {
											rows: 1,
											slidesPerRow: 1,
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
				
				quantityLine: function() {
					var params = {
						steps: [
							0,
							16.67,
							33.33,
							50,
							66.67,
							83.33,
						],
						labels: {
							"little": {
								"title": "мало",
								"class": "red"
							},
							"middle": {
								"title": "есть в наличии",
								"class": "yellow"
							},
							"many": {
								"title": "много",
								"class": "green"
							}
						}	
					};
					
					$(".catalog-quantity-line", $sel.body).each(function() {
						var $line = $(this),
							value = parseInt($line.data("value"));
						if($line.hasClass("build")) {
							return true;
						}
						if(!value || value == 0 || value < 10) {
							value = 10
						}
						if(value <= 0) {
							value = 0;
						}
						if(value > 100) {
							value = 100;
						}
						var $lineItems = '';
						for(var i = 0; i < params.steps.length; i++) {
							$lineItems += '<span ' + (value >= params.steps[i] ? 'class="active"' : '') + '></span>';
						}
						var label = "";
						if(value >= 10 && value <= 33.3) {
							label = "little";
						} else if(value > 33.3 && value <= 66.67) {
							label = "middle";
						} else if(value > 66.67) {
							label = "many";
						}
						$line.addClass(params.labels[label].class).addClass("build").attr("title", "Наличие: " + params.labels[label].title).append($lineItems);
					});
				},
				
				
				favorite: function() {
					$(".catalog-item-add2favorites").tooltipster({
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
					
					
					$(".catalog-item-add2basket").tooltipster({
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
					
					$("body").on("click", ".basket-item-add2favorites, .catalog-item-add2favorites", function(e) {
						var $f = $(this);
						
						e.preventDefault();
						e.stopPropagation();
						
						if($f.hasClass("added")) {
							return false;
						}
						
						(function($f) {
							$.ajax({
								url: "/ajax/add2favorite.php",
								data: {
									id: $f.data("id")
								},
								success: function() {
									$f.tooltipster("content", "Добавлено в <a href='/personal/favorites/' class='link link--black'>избранное</a>");
									setTimeout(function() {
										$f.tooltipster("open");
									}, 100);
									setTimeout(function() {
										$f.tooltipster("hide");
									}, 2000);
									$f.addClass("added");
								}
							});
						})($f);

						
						return false;
					});
					
					$(".catalog-item-removeFromfavorites").on("click", function(e) {
						var $f = $(this);
						
						e.preventDefault();
						e.stopPropagation();
						
						(function($f) {
							$.ajax({
								url: "/ajax/removeFromfavorites.php",
								data: {
									id: $f.data("id")
								},
								success: function() {
									$f.closest(".catalog-item").hide(300, function() {
										if(!$(".catalog-item:visible").length) {
											window.location.reload();
										}
									});
									
								}
							});
						})($f);

						
						return false;
					});
					
					
					

					$(".catalog-item-add2basket").on("click", function(e) {
						var $f = $(this);
						
						e.preventDefault();
						e.stopPropagation();
						
						(function($f) {
							$.ajax({
								url: "/ajax/move2basket.php",
								data: {
									ids: [$f.data("id")]
								},
								success: function() {
									$f.tooltipster("content", "Добавлено в <a href='/cart/' class='link link--black'>корзину</a>");
									setTimeout(function() {
										$f.tooltipster("open");
									}, 100);
									setTimeout(function() {
										$f.tooltipster("hide");
									}, 2000);
									$f.addClass("added");
								}
							});
						})($f);

						
						return false;
					});					
					
					
					$(".move2basket").on("click", function(e) {
						var $f = $(this);
						
						e.preventDefault();
						e.stopPropagation();
						
						(function($f) {
							$.ajax({
								url: "/ajax/move2basket.php",
								data: {
									ids: $f.data("ids")
								},
								success: function() {
									window.location = "/cart/";
								}
							});
						})($f);

						
						return false;
					});
					
					
				},
				
				init: function() {
					var self = this;

					self.favorite();
					
					self.sections();
					self.basket.init();
					self.quantity.init();
					self.product.init();
					self.sliders();
					self.banner();
					self.quantityLine();
					
					
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
					
					
					$(".header-search-field", $sel.body).on("keydown", function(e) {
						if(e.which == 13) {
							e.stopPropagation();
						}
					});
				},
				calc: function() {
					var self = this,
						basketPrice = 0;
//					$(".basket-item", self.$basket).each(function() {
//						var $item = $(this),
//							itemPrice = parseFloat($item.data("price")),
//							itemQuantity = parseInt($item.find(".basket-item-quantity").val()),
//							itemSummary = itemPrice * itemQuantity;
//						$(".basket-item-summary span", $item).text(itemSummary);
//						basketPrice += itemSummary;
//
//						if(itemQuantity == 0) {
//							self.remove($item.closest(".basket-item").data("id"));
//						}
//					});
//					$(".basket-order-summary-item--novat span", self.$basket).text(basketPrice);
//					$(".basket-order-summary-item--large span", self.$basket).text(basketPrice);
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

                backLoad: function() {

                    $sel.window.on('popstate', function(e) {

                        page = $sel.window[0].location.pathname;

                        $sel.window[0].location.reload();

                        return;
                    });

                },

				load: {
					isLoad: false,
					$content: null,
					init: function() {
						var self = this;
						self.$content = $(".page-content-inner", $sel.body);
						
						$(".animation-link:not(.header-catalog-title)").off("click");
						
						if(document.location.pathname != '/cart/' && document.location.pathname != '/cart/order/') {
							/*$(".animation-link:not(.header-catalog-title)").on("click", function(e) {
	                            $('.header-catalog').removeClass('hovered');
	                            PHOENIX.content.dropdown.hide($(".header-catalog", $sel.body));
								PHOENIX.animation.load.page($(this).attr("href"));
								e.preventDefault();
							});*/						
						}

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
				init: function(params) {
					var self = this;
					self.load.init();
					self.backLoad();
					
					
					self.click.init();
				
					self.wow.init();
				},
				
				


				wow: {
					blocks: [],
					$container: $sel.body,
					init: function($container, useCustomDivScrolling) {
						var self = this;

						if($container && $container.length) {
							self.$container = $container;
						}
						self.blocks = [];

						if(!useCustomDivScrolling) {
							$sel.window.on("scroll", function() {
								self.check();
							});
						} else {
							self.$container.on("scroll", function() {
								self.check(true);
							});
						}

						setTimeout(function() {
							self.prepare(useCustomDivScrolling);
							self.check(false, true);
						}, 250);
					},
					prepare: function(useCustomDivScrolling) {
						var self = this;
						$(".wow:not(.animated)", self.$container).each(function() {
							var $item = $(this),
								itemAnimation = $item.data("animationtype"),
								itemAnimationDuration = $item.data("animationduration"),
								itemTransitionDelay = $item.data("transitiondelay");

							if (!itemAnimationDuration) {
								itemAnimationDuration = 0;
							}

							self.blocks.push({
								"html": $item,
								"top": (useCustomDivScrolling ? $item.position().top : $item.offset().top),
								"typeAnimation": itemAnimation,
								"animation-duration" : itemAnimationDuration
							});

							//$item.addClass("before-" + itemAnimation);
							$item.css("animation-duration", itemAnimationDuration);

							if(itemTransitionDelay) {
								$item.css("transition-delay", itemTransitionDelay);
							}


						});
						
						//console.log(self.blocks);

					},
					check: function(useCustomDivScrolling, firstLoad) {
						var self = this,
							block = false,
							blockTop = false,
							top = (useCustomDivScrolling ? self.$container.scrollTop() : $sel.window.scrollTop()),
							buffer = (firstLoad ? parseInt($sel.window.height() + 100) : parseInt($sel.window.height()) / 1.15),
							delay = 0;

						for(var i = 0, len = self.blocks.length; i < len; i++) {
							block = self.blocks[i],
							blockTop = parseInt(block.top, 10);
							if(block.html.hasClass("animated")) {
								continue;
							}

							if(top + buffer >= blockTop) {
								block.html.css("transition-delay", (delay / 1000) + "s");
								block.html.addClass("animated");
								delay += 200;
							}

						}
					}
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

					$("input.form--number").each(function() {
						var $item = $(this);
						$item.mask('0#');
					});
					
					$("[data-cmask]").each(function() {
						var $item = $(this);
						switch($item.data("cmask")) {
							case "phone":
								$item.mask("+7 (000) 000 00 00", {
									placeholder: "+7 (999) 999 99 99",
									clearIfNotMatch: true
								});
							break;
						}
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
						formParams.rules["USER_LOGIN"] = {
                                                        required: true,
							//login_has: true,
							//login_active: true
						};
						formParams.rules["USER_EMAIL"] = {
                                                        required: true,
							//login_has: true,
							//login_active: true
						};
//                                                formParams.messages["USER_LOGIN"] = {
//                                                    required: "Ошибка заполнения",
//                                                    minlength: "Ошибка заполнения2"
//                                                };
                                                //console.log(formParams);
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
						}else if($form.data("order")) {
							formParams.submitHandler = function(form)
                                                        {
                                                            var url = $(form).attr('action');
                                                            var data = $(form).serialize();
                                                            $.post(url, data, function(json)
                                                            {
                                                                if ((typeof(json.order.REDIRECT_URL) != "undefined") && json.order.REDIRECT_URL.length > 0)
                                                                {
                                                                    document.location = json.order.REDIRECT_URL;
                                                                }
                                                            }, 'json');
                                                        }
						}
						$form.validate(formParams);
						
						

					});
					
				},
				order: function() {
					
					
					
					$sel.body.on("submit", ".order-cancel-form", function(e) {
						e.preventDefault();
						
						var $form = $(this);
						$form.find("button:submit").attr("disabled", "disabled");
						
						$.ajax({
							url: $form.attr("action"),
							type: "post",
							dataType: "json",
							data: $form.serialize(),
							success: function(result) {
								if(result.SUCCESS) {
									$form.parent().append('<div class="form-success">Запрос на отмену заказа успешно отправлен.</div>');
									$form.remove();
								}
								if(result.RELOAD) {
									setTimeout(function() {
										window.location.reload();
									}, 350);
								}
								$form.find("button:submit").removeAttr("disabled");
							}
						});
					});
					
					
					

					$("form[name='ORDER_FORM']").on("submit", function() {
						$(this).find(":submit").addClass("loaded").attr("disabled", "disabled");
					});
					
					if(!$("#order-profile") || !$("#order-profile").length) {
						return false;
					}
					var jsonProfiles = $("#order-profile").data("profiles");
					console.log((jsonProfiles));
					$("#order-profile").on("change", function() {
						updateOrderProfile();
					});
					updateOrderProfile();
					
					function updateOrderProfile() {
						var currentCompany = $("#order-profile").find("option:selected").val(),
							currentProfile = jsonProfiles[currentCompany] ? jsonProfiles[currentCompany] : false;
						if(currentProfile) {
							for(var code in currentProfile) {
								
								$(".profile input[data-fieldcode=" + code + "]").val((currentProfile[code]));
							}
						}
					}
					

					
					

				},
				
				
				captcha: function() {
					$(".form-captcha-holder .link").on("click", function(e) {
						e.preventDefault();
						
						var $holder = $(this).closest(".form-captcha-holder");
						if($holder.hasClass("loaded")) {
							return false;
						}
						
						(function($holder) {
							$.ajax({
								beforeSend: function() {
									$holder.addClass("loaded");
								},
								url: "/tools/getNewCaptcha.php",
								complete: function() {
									$holder.removeClass("loaded");	
								},
								success: function(sid) {
									$holder.find("img").attr("src", "/bitrix/tools/captcha.php?captcha_sid=" + sid);
									$holder.find("[name=captcha_sid]").val(sid);
								}
							});
						})($holder);

					});
				}
				
				
			},

			filter: {
				init: function() {
					var $filter = $(".filter", $sel.body),
						$balloon = $(".filter-balloon", $filter),
						$items = $(".form-item", $filter),
						balloonTimer = false;

					
					
					/*
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
					*/
					
					
					
	
					$(".filter-range").on("change input", function(e, u) {
						var $slider = $(this);
						syncPriceFilter("slider", $slider);
						var $fromInput = $($slider.data("from"));
                        $fromInput.change();
					});
					
					$(".filter-slider-field-input", $sel.body).on("change", function() {
						var $slider = $(this).closest(".filter-slider").find(".filter-range");
						syncPriceFilter("field", $slider);
					});
					
					/*$filter.on("reset", function() {
						setTimeout(function() {
							syncPriceFilter("field");
						}, 100);
					});*/

					function syncPriceFilter(source, $slider) {
						var $fromInput = $($slider.data("from")),
							$toInput = $($slider.data("to")),
							fromVal, toVal;
						if(source == "slider") {
							fromVal = $slider[0].valueLow,
							toVal = $slider[0].valueHigh;
						} else if(source == "field") {
							fromVal = $fromInput.val().replace(" ", ""),
							toVal = $toInput.val().replace(" ", "");
							var inst = jcf.getInstance($slider);
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



						/*$balloon.addClass("show").css("top", $itemHolder.position().top);
						clearTimeout(balloonTimer);
						balloonTimer = setTimeout(function() {
							$balloon.removeClass("show");
						}, 2000);*/
						
						
						var baloonPosition = $itemHolder.position().top;
						console.log(baloonPosition);
						if($itemHolder.closest(".jcf-scrollable-wrapper").length) {
							//console.log($itemHolder.closest(".jcf-scrollable-wrapper").position());
							baloonPosition += $itemHolder.closest(".jcf-scrollable-wrapper").position().top;
						}
						console.log(baloonPosition);
						$balloon.css("top", baloonPosition);
						
						
					});

					$(".filter-item-header", $sel.body).on("click", function(e) {
						var $parent = $(this).closest(".filter-item");
						$parent.toggleClass("open");
						
						if(!$parent.hasClass("open") && $parent.find(".filter-more").length) {
							$parent.find("filter-more").removeClass(".filter-more--hidden");
							$parent.find(".jcf-scrollable-wrapper").hide();
						} else if($parent.hasClass("open") && $parent.find(".filter-more").length) {
							$parent.find(".jcf-scrollable-wrapper").show();
						}
						
						e.preventDefault();
					});
					
					
					var self = this;
					
					self.options.init();

				},
				
				options: {
					minLengthMore: 8,
					showLengthMore: 5,
					minLengthScroll: 9,
					init: function() {
						var self = this;
						
						self.build();
						self.bind();
					},
					build: function() {
						var self = this;

						$(".filter-item-content", $sel.body).each(function() {
							var $content = $(this),
								$items = $content.find(".filter-checkbox");
								
							if($items.length < self.minLengthMore) {
								return true;
							}
							
							var defaultContentHeight = 0,
								scrollContentHeight = 0,
								$parent = $content.closest(".filter-item");
							
							$parent.addClass("open");
							
							$items.each(function(i) {
								if(i < self.showLengthMore) {
									defaultContentHeight += $(this).outerHeight();
								}
								if(i < self.minLengthScroll) {
									scrollContentHeight += $(this).outerHeight();
								}
							});
							//scrollContentHeight -= 30; // Последний ээлемент
							
							$parent.removeClass("open");
							
							// Переинициализация
							if($parent.find(".filter-more").length) {
								$parent.find(".filter-more").remove();
							}
								
							$content
								.data("defaultContentHeight", defaultContentHeight)
								.data("scrollContentHeight", scrollContentHeight)
								.css({
									"height": defaultContentHeight
								})
								.after(
									$('<a href="#" class="link link--black filter-more">Еще ' + ($items.length - self.showLengthMore) + '</a>')
										.data(
											{
												"opened": false, 
												"moreText": "Еще " + ($items.length - self.showLengthMore)
											}
										)
									);
							
						});
					},
					bind: function() {
						$(".filter-more", $sel.body).on("click", function(e) {
							var $more = $(this),
								$content = $more.parent().find(".filter-item-content");
							
							//console.log($content.data());
							
							if($more.data("opened")) {
								$content.removeClass("jcf-scrollable");
								jcf.destroy($content);
								$content.css({
									"height": $content.data("defaultContentHeight")
								});
								$more
									.data("opened", false)
									.text($more.data("moreText"));
							} else {
								$content
									.css({
										"height": $content.data("scrollContentHeight")
									})
									.addClass("jcf-scrollable");
								jcf.replace($content, "Scrollable");
								$more
									.data("opened", true)
									.text("Скрыть");
							}
							

							
							e.preventDefault();
						});
					}
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
			},
			
			goals: {
				init: function() {
					$(".doc-item--video").on("click", function() {
						var $doc = $(this);
						
						ym(48640211,'reachGoal','video_click', {
							"video_title": $doc.find(".doc-item-name").text(),
							"user_login": window.user_login
						});
					});
					

					$(".doc-item--video .doc-item-download").on("click", function(e) {
						e.stopPropagation();	
						
						var $doc = $(this).closest(".doc-item--video");
						
						ym(48640211,'reachGoal','video_download', {
							"video_title": $doc.find(".doc-item-name").text(),
							"user_login": window.user_login
						});
					});
				}
			}

		};

	})();
	
	PHOENIX.gifts.init();
	
	PHOENIX.personalShops.init();

	PHOENIX.accordion.init();
	PHOENIX.content.init();
	PHOENIX.home.init();

	PHOENIX.catalog.init();

	PHOENIX.animation.init();

	PHOENIX.forms.init();
	
	PHOENIX.forms.order();
	
	PHOENIX.forms.captcha();

	PHOENIX.filter.init();

	PHOENIX.basket.init();
	PHOENIX.popup.init();

	PHOENIX.action.init();
	
	PHOENIX.shops.init();
	
	
	
	PHOENIX.vote.init();
	
	
	PHOENIX.goals.init();
	
	
		$(".catalog-sectionslist-show").on("click", function() {
			$(".catalog-menu-sub-inner").toggle();
		});
	

	PHOENIX.reload = function() {
		PHOENIX.accordion.init();
		PHOENIX.content.init();
		PHOENIX.home.init();

		PHOENIX.catalog.init();

		PHOENIX.animation.init({
			withoutClick: true
		});

		PHOENIX.forms.init();

		PHOENIX.filter.init();

		PHOENIX.basket.init();
		PHOENIX.popup.init();

		PHOENIX.action.init();
		
		if(window.Recaptchafree !== undefined) {
			Recaptchafree.reset();
		}
		
		
		PHOENIX.goals.init();
		
		
		PHOENIX.shops.init();
				

		$(".product-photos").on("fotorama:ready", function(e, fotorama) {
			if(!fotorama.data[0].img) {
				fotorama.shift();
			}
		}).fotorama();
		

	}

})(jQuery);
