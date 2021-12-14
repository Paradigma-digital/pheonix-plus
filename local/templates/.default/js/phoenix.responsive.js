(function($) {

	var phoenixResponsive = (function() {

		// Selections
		var $sel = {};
		$sel.document = $(document);
		$sel.window = $(window);
		$sel.body = $("body");
		$sel.menuBurger = $(".mobile-header-burger", $sel.body);

		return {

			// Initialize and add actions for menu burger
			menu: {
				isShow: false,
				init: function() {
					var self = this;
					$sel.body.append('<div class="menu-overlay"></div>');
					$sel.menuBurger.on("click", function() {
						self.isShow ? self.hide() : self.show();
					});
					$(".menu-overlay", $sel.body).on("click", function() {
						self.hide();
					});
				},
				show: function() {
					this.isShow = true;
					$sel.menuBurger.addClass("active");
					$sel.body.addClass("show-menu");
				},
				hide: function() {
					this.isShow = false;
					$sel.menuBurger.removeClass("active");
					$sel.body.removeClass("show-menu");
				}
			},
			// Initialize scripts for each window size
			initSSM: function() {
				var self = this;

				ssm.addStates([
					{
						// Tablets in landscape orientation
						id: "tabletLandscape",
						query: "(max-width: 1000px)",
						onEnter: function() {
							self.menu.init();
							$(".mobile-header-search, .mobile-search-close").on("click", function(e) {
								$(".mobile-search").toggleClass("show");
								e.preventDefault();
							});
							$(".catalog--responsive .catalog-items").each(function() {
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
										//console.log(slick.slickGetOption("slidesToShow"), slick.currentSlide);
										$list.closest(".catalog").find(".catalog-nav-counter-current").text(Math.ceil(slick.currentSlide == 0 ? 1 : (slick.currentSlide / slick.slickGetOption("slidesToShow") + 1)));
									});
								})($(this));
							});

						},
						onLeave: function() {
							$(".catalog--responsive .catalog-items").slick("destroy");
						}
					}, {
						id: "mobile",
						query: "(max-width: 800px)",
						onEnter: function() {
							$(".articles--responsive .articles-items").each(function() {
								(function($list) {
									$list.on("init", function(e, slider) {
										$list.closest(".articles").find(".catalog-nav-item--prev").on("click", function() {
											$list.slick("slickPrev");
										});
										$list.closest(".articles").find(".catalog-nav-item--next").on("click", function() {
											$list.slick("slickNext");
										});
										$list.closest(".articles").find(".catalog-nav-counter-all").text(Math.ceil(slider.slideCount / slider.slickGetOption("slidesToScroll")));
									}).slick({
										arrows: false,
										responsive: [
											{
												breakpoint: 801,
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
										//console.log(slick.slickGetOption("slidesToShow"), slick.currentSlide);
										$list.closest(".articles").find(".catalog-nav-counter-current").text(Math.ceil(slick.currentSlide == 0 ? 1 : (slick.currentSlide / slick.slickGetOption("slidesToShow") + 1)));
									});
								})($(this));
							});
						},
						onLeave: function() {
							$(".articles--responsive .articles-items").slick("destroy");
						}
					}
				]);
			}
		}

	})();

	phoenixResponsive.initSSM();

})(jQuery);