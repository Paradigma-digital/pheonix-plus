<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>



<script>
	Vue.component("fastadd", {
		template: "#fastadd__tmpl",
		data: function() {
			return {
				barcode: null, // Код (артикул или ШК)
				
				isLoaded: false, // Подгрузка,
				
				result: null, // Результат зарпоса
				
			}
		},
		methods: {
			send: function() {
				var self = this;
				
				if(self.isLoaded) {
					return false;
				}
				
				//console.log(self.barcode);
				
				self.isLoaded = true;
				axios
					.post(phoenixOrderConstants.get("fastadd_url"), phoenixOrderUtils.prepareQuery({
						barcode: self.barcode,
						quantity: 1,
						action: "addProduct"
					}))
					.then(function(response) {
						self.isLoaded = false;
						
						self.barcode = "";
						
						if(response.data.result != -1) {
							self.$root.$emit("itemAdd", response.data.item);
						}
					});
			}
		},
		
		mounted: function() {
			var self = this;
			
			(function($, $item, model) {
				
				// Для сканера ШК
				var arString = [],
					timer = null;
				$(document).on("keydown", function(e) {
					timer = setTimeout(function() {
						arString = [];
					}, 500);
					
					if(e.which == 13) {
						model.barcode = arString.join('');
						model.send();
						arString = [];
						return false;
					}
					arString.push(e.key);
				});
				
			})(jQuery, self.$el, self);
		}
	});
</script>

<script type="text/x-template" id="fastadd__tmpl">
	<div class="basket-fastadd-holder" v-bind:class="{loaded: isLoaded}">
		<div class="basket-fastadd-title">Вы можете использовать сканер штрихкода для добавления товаров</div>
		<form action="/cart/add/" class="basket-fastadd" v-on:submit.prevent="send()">
			<input type="text" autocomplete="off" class="form-item form-item--text" name="product_barcode" placeholder="ШК или артикул" required v-model="barcode" v-on:keydown.stop />
			<span class="basket-fastadd-result" v-if="result" v-bind:class="[(result && result.result == -1) ? 'error' : 'success']" v-html="result.message"></span>
			<button type="submit" class="btn btn--blue">Добавить</button>
		</form>
	</div>
</script>






<script>
	BX.Currency.setCurrencyFormat("RUB", <?php echo CUtil::PhpToJSObject(CCurrencyLang::GetFormatDescription("RUB"), false, true); ?>);  
	
	var phoenixOrderConstants = (function() {
		var consts = {
			"api_url": "/local/components/aheadstudio/personal.order.doc/ajax.php",
			"fastadd_url": "/local/components/aheadstudio/personal.order.doc/ajax.php"
		};
		return({
			get: function(name) {
				return consts[name];
			}
		});
	}());
	
	var phoenixOrderUtils = {
		
		// Подготовка запроса
		prepareQuery: function(params) {
			
			// Базовые параметры
			var urlParams = {
				site_id: "<?php echo SITE_ID; ?>",
				order_id: "<?php echo $arParams["ORDER_ID"]; ?>",
				upd_id: "<?php echo $arParams["UPD_ID"]; ?>",
			};
			
			// Дополнительные параметры
			for(var code in params) {
				urlParams[code] = params[code];
			}

			return urlParams;
		}
	};



	var docApp = new Vue({
		el: '#doc-form',
		data: {
			items: [], // Товары в документе
			visibleCount: 0,
			success: false,
			order_id: "<?php echo $arParams["ORDER_ID"]; ?>",
			
			loadingItems: false,
			
			loadingSave: false,
			
			can_edit: false,
			upd_id: false,
			upd_date: false,
			act_id: false,
			act_date: false,
			act_status: "",
			
			comment: "",
			
			show: false,
		},
		
		template: "#base__tmpl",

		methods: {
			
			getInfo: function() {
				var self = this;
				
				axios
					.post(phoenixOrderConstants.get("api_url"), phoenixOrderUtils.prepareQuery({
						action: "getInfo"
					}))
					.then(function(response) {
						self.can_edit = ((!response.data.ACT || (response.data.ACT && response.data.ACT.UF_STATUS == "Формируется")) ? true : false);
						
						self.upd_id = response.data.UF_NOMERUPD;
						self.upd_date = response.data.UF_DATA;
						if(response.data.ACT) {
							self.act_num = response.data.ACT.UF_NOMER; 
							self.act_id = response.data.ACT.ID;
							self.act_date = response.data.ACT.UF_DATA;
							
							self.act_status = response.data.ACT.UF_STATUS;
							
							self.comment = response.data.ACT.UF_KOMMENTARIY;
						}
						
						
						//if(!self.can_edit) {
							self.getOrderItems();
						//}
						
						
						self.show = true;
					});
			},
			
			// Получение товаров из заказа
			getOrderItems: function() {
				var self = this;
				
				self.loadingItems = true;
				
				axios
					.post(phoenixOrderConstants.get("api_url"), phoenixOrderUtils.prepareQuery({
						action: "getOrderItems",
						act_id: self.act_id,
					}))
					.then(function(response) {
						self.updateData(response);
						
						self.loadingItems = false;
					});
			},
			
			// Инициализация данных
			updateData: function(response) {
				var self = this;
					
				self.items = response.data;
			
			},
			
			// Добавление товара
			addProduct: function(newItem) {
				var self = this,
					addFlag = true;
				
				self.items.forEach(function(item, i) {
					if(item.PRODUCT.ID == newItem.ID) {
						addFlag = false;
						
						var newQuantity = parseInt(item.QUANTITY) + 1;
						item.quantity = newQuantity;
						item.QUANTITY = newQuantity;
						self.items[i].quantity = newQuantity;
						self.items[i].QUANTITY = newQuantity;
						//Vue.set(self.items[i], 'quantity', newQuantity);

					}
				});
				if(addFlag) {
					self.items.push(newItem);
				}
			},
			
			// Удаление товара
			removeProduct: function(itemID) {
				var self = this;
				
				self.items.forEach(function(item, i) {
					if(item.PRODUCT.ID == itemID) {
						Vue.delete(self.items, i);
					}
				});
			},
			
			// Обновление количества			
			updateCount: function() {
				var self = this,
					count = 0;
			
				self.items.forEach(function(item) {
					if(!item.hide) {
						count++;
					}
				});
				self.visibleCount = count;
			},
			
			// Сохранение
			save: function() {
				var self = this;
				
				self.loadingSave = true;
				
				axios
					.post(phoenixOrderConstants.get("api_url"), phoenixOrderUtils.prepareQuery({
						action: "save",
						act_id: self.act_id,
						items: self.items,
						comment: self.comment,
					}))
					.then(function(response) {
						self.success = true;
						
						//self.loadingSave = false;
						
						window.location.reload();
					});	
			},
			
			// Фиксация
			fix: function() {
				var self = this;
				
				self.loadingSave = true;
				
				axios
					.post(phoenixOrderConstants.get("api_url"), phoenixOrderUtils.prepareQuery({
						action: "fix",
						act_id: self.act_id,
						items: self.items,
						comment: self.comment,
					}))
					.then(function(response) {
						self.success = true;
						
						//self.loadingSave = false;
						
						window.location.reload();
					});	
			},
			
			// Отправка
			submit: function() {
				var self = this;
				
				//console.log(self.items); return false;
				
				self.loadingSave = true;
				
				axios
					.post(phoenixOrderConstants.get("api_url"), phoenixOrderUtils.prepareQuery({
						action: "submit",
						items: self.items,
					}))
					.then(function(response) {
						self.success = true;
						
						self.loadingSave = false;
					});
			}
			
		},
		
		watch: {
			items: {
				immediate: true,
				handler: function() {
					var self = this;
					
					self.updateCount();
				}
			}
		},
		
		mounted: function() {
			var self = this;
			
			self.getInfo();
			
			this.$root.$on("itemAdd", function(item) {
				self.addProduct(item);
			});
			
			this.$root.$on("itemRemove", function(itemID) {
				self.removeProduct(itemID);
			});
			
			this.$root.$on("itemsRefresh", function(item) {
				self.updateCount();
			});
		}
	});
	
</script>




<script>
	Vue.component("basket-item", {
		props: {
			item: Object,
			can_edit: Boolean,
		},
		template: "#basket-item__tmpl",
		data: function() {
			return {
				id: null, // ID записи в корзине
				quantity: null, // Количество в заказе
				pictureSrc: null, // Картинка
				quantityBad: null, // Брак
				
				hide: false,
			}
		},
		methods: {
			
			// Удаление из списка
			remove: function() {
				var self = this;
				
				self.$root.$emit("itemRemove", self.id);
			}

		},
		
		watch: {
			
			// Обновление данных при изменении свойства
			item: {
				immediate: true,
				handler: function() {
					var self = this;
					
					self.quantity = parseInt(self.item.UF_KOLICHESTVO);
					self.quantity_bad = parseInt(self.item.UF_KOLICHESTVOBRAK);
					self.id = parseInt(self.item.PRODUCT.ID);
					self.pictureSrc = self.item.PRODUCT.PREVIEW_PICTURE_SRC;
				}
			}

		},
		
		computed: {
			

			
			
		},

		mounted: function() {
			var self = this;


			// Стилизация
			(function($, $item, model) {
				
				// Появление картинки при наведении на название	
				$($item).find(".basket-item-name").tooltipster({
					animation: "fade",
					animationDuration: 300,
					content: '<div class="img-holder"><img src="' + model.pictureSrc + '" /></div>',
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
				
			
			})(jQuery, this.$el, self);

		},
		
		
	});

</script>

<script type="text/x-template" id="basket-item__tmpl">
	
	<div class="basket-row">
		
		<div class="basket-col basket-col--name basket-item-name-holder">
			<div class="basket-item-name">
				арт. {{ item.PRODUCT.PROPERTY_CML2_ARTICLE_VALUE }}<br>
				<a :href="item.DETAIL_PAGE_URL" target="_blank" class="link link--black link--inverse">{{ item.PRODUCT["~NAME"] }}</a>
			</div>
		</div>
		
		<div class="basket-col basket-col--quantity basket-item-quantity-holder">
			<div class="basket-item-mobile-title">Заказано шт.</div>
			<span v-html="parseInt(item.UF_REAL_QUANTITY)"></span>
		</div>
		
		<div class="basket-col basket-col--quantity basket-item-quantity-holder">
			<div class="basket-item-mobile-title">Количество шт.</div>
			<input type="text" v-model="item.UF_KOLICHESTVO" v-bind:disabled="!can_edit" class="form-item form--number form-item--text product-quantity basket-item-quantity" />
		</div>
		
		<div class="basket-col basket-col--quantity basket-item-quantity-holder">
			<div class="basket-item-mobile-title">Количество брак шт.</div>
			<input type="text" v-model="item.UF_KOLICHESTVOBRAK" v-bind:disabled="!can_edit" class="form-item form--number form-item--text product-quantity basket-item-quantity" />
		</div>
		
		<div class="basket-col basket-col--remove basket-item-remove-holder">
			<span title="Удалить" class="basket-item-remove" v-on:click="remove()" v-if="can_edit && !parseInt(item.UF_REAL_QUANTITY)"></span>
		</div>
		
	</div>
	
</script>











<script type="text/x-template" id="base__tmpl">
	
	<div class="doc-form">
		
		<a href="/personal/orders/<?php echo $arParams["ORDER_ID"]; ?>/">← Вернуться в заказ</a>
		
		<div v-if="show">
			
			<div v-if="can_edit">
				<div v-if="act_id">
					<h2>Редактирование акта приемки <span v-if="act_num">№{{ act_num }}</span> <span v-if="act_date">от {{ act_date }}</span></h2>
					<button class="btn btn--red" v-show="0" v-on:click="getOrderItems" v-bind:disabled="loadingItems">Загрузить товары из акта</button>
				</div>
				
				<div v-if="!act_id">
					<h2>Создание акта приемки для заказа №{{ order_id }} УПД {{ upd_id }} от {{ upd_date }}</h2>
					<button class="btn btn--red" v-show="0" v-on:click="getOrderItems" v-bind:disabled="loadingItems">Загрузить товары из УПД</button>
				</div>

			</div>
			
			<div v-if="!can_edit">
				<h2>Акт <span v-if="act_num">№{{ act_num }}</span> от {{ act_date }} для УПД {{ upd_id }} от {{ upd_date }}</h2>
			</div>
			
			<div class="basket-preloader" v-if="loadingItems"></div>
			
			<div v-if="items && items.length && !loadingItems">
				<div class="basket basket--doc columns--5" v-bind:class="{readonly: !can_edit}">
					<div class="basket-row basket-row--heading">
						<div class="basket-col basket-col--name basket-heading-item">Товар</div>
						<div class="basket-col basket-col--quantity basket-heading-item">Заказано шт.</div>
						<div class="basket-col basket-col--quantity basket-heading-item">Количество шт.</div>
						<div class="basket-col basket-col--quantity basket-heading-item">Количество брак шт.</div>
						<div class="basket-col basket-col--remove basket-heading-item"></div>
					</div>
					
					<basket-item v-for="item in items" v-bind:key="item.ID" v-bind:can_edit="can_edit" v-bind:item="item"></basket-item>
					
					

					
					<div v-if="can_edit">
						<fastadd></fastadd>
					</div>
					


					<div class="doc-comment-holder">
						<div class="form-row">
							<div class="form-item-holder form-item-holder--block">
								<textarea type="text" id="doc_form_comment" name="comment" v-bind:disabled="!can_edit" placeholder="Комментарий" v-model="comment" class="form-item form-item--textarea"></textarea>
							</div>
						</div>
					</div>
					
					
					
					<div v-if="can_edit" class="basket-row basket-row--footer">
						<div class="basket-col basket-col--results">
							<div class="basket-order">
								<div class="basket-order-summary">
									<div class="basket-order-summary-item basket-order-summary-item--novat">Товарных позиций: <span v-html="visibleCount"></span></div>
								</div>
								<button type="button" v-on:click="save()" class="basket-order-submit btn btn--red btn--large" v-bind:class="{loaded: loadingSave}">Сохранить</button>
								
								<button type="button" v-on:click="fix()" class="basket-order-submit btn btn--blue btn--large" v-bind:class="{loaded: loadingSave}">Передать в работу</button>
							</div>
						</div>
					</div>
					
					<div v-if="!can_edit">
						<div class="page-text">
							<p>Статус: <b v-html="act_status"></b></p>
						</div>
					</div>
									
				</div>
			</div>
			

			
		</div>
		
	</div>

</script>


<div id="doc-form"></div>


