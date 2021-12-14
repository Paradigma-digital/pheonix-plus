<script>
    Vue.component("basket-item", {
        props: {
            item: Object,
            ndsInfo: Object
        },
        template: "#basket-item__tmpl",
        data: function() {
            return {
                id: null, // ID записи в корзине
                price: null, // Цена за единицу
                quantity: null, // Количество в заказе
                avilable: null, // Доступное количество
                sum: null, // Стоимость всего количества
                pictureSrc: null, // Картинка

                inFavorites: false,

                productId: false,

                vatRate: null, // Ставка НДС

                pack: null, // Количество в упаковке
                prevQuantity: null, // Предыдущее корректное количество (для проверок)

                isLoaded: false, // Подгрузка

                isGift: false,
            }
        },
        methods: {

            // Удаление товара
            remove: function() {
                var self = this;

                self.isLoaded = true;

                // Формирование параметров
                var params = {
                    basketAction: "recalculate",
                };
                params["DELETE_" + self.id] = "Y";

                if(BX("orderMode")) {
                    BX.ajax.post(
                        '/ajax/preAdd2basket.php',
                        {
                            'mode': BX("orderMode").getAttribute("data-mode"),
                            'action': 'changeFromUserCartOrder',
                            'id': self.productId,
                            'quantity': 0
                        }
                    );
                }

                /*axios
                    .post(phoenixOrderConstants.get("api_url"), phoenixOrderUtils.prepareQuery({
                        api_method: "delete_item",
                        id: self.id,
                    }))
                    .then(function(response) {
                        self.$root.$emit("basketRefresh");

                        self.isLoaded = false;
                    });*/
                axios
                    .post(phoenixOrderConstants.get("api_url"), phoenixOrderUtils.prepareQuery(params))
                    .then(function(response) {
                        self.$root.$emit("basketRefresh", response);
                        self.isLoaded = false;
                    });
            },

            // Изменение количества
            changeQuantity: function() {
                var self = this;

                // ПРОВЕРКИ
                var error = {
                    code: null,
                    message: "",
                };


                // Проверка на число
                if(self.quantity == 0 || isNaN(self.quantity)) {
                    self.quantity = self.prevQuantity;
                    error.message = "Введите число";
                    error.code = -1;
                }

                // Проверка максимального количества
                if(self.quantity > self.available) {
                    self.quantity = self.available;
                    console.log(self);
                    error.message = "Доступное количество – " + self.available + " шт.";
                } else {
                    if(BX("orderMode")) {
                        BX.ajax.post(
                            '/ajax/preAdd2basket.php',
                            {
                                'mode': BX("orderMode").getAttribute("data-mode"),
                                'action': 'changeFromUserCartOrder',
                                'id': self.item.PRODUCT_ID,
                                'quantity': self.quantity,
                                'increase': "N"
                            }
                        );
                    }
                }

                // Проверка на количество в упаковке
                var balance = self.quantity % self.pack;
                if(balance != 0) {
                    var newQuantity = ((parseInt(self.quantity / self.pack) + 1) * self.pack);
                    self.quantity = newQuantity;
                    error.message = "Вы можете заказать кратно " + self.pack + " шт.";
                }

                // Отображение ошибки
                if(error && error.message) {
                    self.$quantityInput.tooltipster("content", error.message);
                    setTimeout(function() {
                        self.$quantityInput.tooltipster("open");
                    }, 100);

                    // Прерываем только в одном случае
                    if(error.code == -1) {
                        return false;
                    }
                }

                // //

                self.prevQuantity = self.quantity;

                // Формирование параметров
                var params = {
                    basketAction: "recalculate",
                };
                params["QUANTITY_" + self.id] = self.quantity;

                self.isLoaded = true;
                axios
                    .post(phoenixOrderConstants.get("api_url"), phoenixOrderUtils.prepareQuery(params))
                    .then(function(response) {
                        self.$root.$emit("basketRefresh", response);
                        self.isLoaded = false;
                    });
            }
        },

        watch: {

            // Обновление данных при изменении свойства
            item: {
                immediate: true,
                handler: function() {
                    var self = this;

                    self.quantity = self.item.QUANTITY;
                    self.prevQuantity = self.item.QUANTITY;
                    self.id = self.item.ID;
                    self.price = self.item.PRICE_FORMATED;
                    self.vatRate = parseFloat(self.item.VAT_RATE);
                    self.pictureSrc = self.item.PREVIEW_PICTURE_SRC;
                    self.available = parseInt(self.item.AVAILABLE_QUANTITY);
                    self.sum = self.item.SUM_FULL_PRICE_FORMATED;
                    self.productId = self.item.PRODUCT_ID;

                    self.inFavorites = self.item.IN_FAVORITES;

                    self.pack = parseInt(self.item.PRODUCT_PROPS.PACK.VALUE);


                    self.isGift = (self.item.PROPS_ALL.IS_GIFT_FEBRUARY ? true : false);

                    // Проверка на доступность и формирование ошибки
                    if(self.quantity > self.available || !self.available) {
                        this.$root.$data.hasErrors = true;
                    }
                }
            }
        },

        computed: {

            // Расчет процента НДС
            vatRatePercent: function() {
                var self = this;

                return ((self.vatRate * 100) + "%");
            },

            // Расчет значения НДС и общей суммы
            vatValue: function() {
                var self = this,
                    vatValueTmp = null;

                if(self.ndsInfo.TYPE == "OVER") {
                    var nds = (self.item.SUM_VALUE * self.vatRate).toFixed(2);
                    vatValueTmp = BX.Currency.currencyFormat(nds, "RUB", true);
                    self.sumWithVat = BX.Currency.currencyFormat((parseFloat(nds) + self.item.SUM_VALUE).toFixed(2), "RUB", true);
                } else {
                    vatValueTmp = BX.Currency.currencyFormat((self.item.VAT_VALUE * self.quantity).toFixed(2), "RUB", true);
                }
                return vatValueTmp;
            },


        },

        mounted: function() {
            var self = this;


            // Стилизация
            (function($, $item, model) {

                model.$quantityInput = $($item).find(".basket-item-quantity");

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

                // Информационный тип для поля ввода количества
                model.$quantityInput.tooltipster({
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

                // Тултип для избранного
                $($item).find(".basket-item-add2favorites").tooltipster({
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


            })(jQuery, this.$el, self);

        },


    });

</script>

<script type="text/x-template" id="basket-item__tmpl">
    <div class="basket-row" v-bind:class="{loaded: isLoaded, error: (quantity > available), 'basket-row--is_gift': isGift}">

        <div class="basket-col basket-col--name basket-item-name-holder">
            <div class="basket-item-name">
                арт. {{ item.PRODUCT_PROPS.ARTICLE.VALUE }}<br>
                <a :href="item.DETAIL_PAGE_URL" class="link link--black link--inverse animation-link">{{ item["~NAME"] }}</a>
            </div>
            <div class="basket-item-add2favorites" v-bind:class="{added : inFavorites}" :data-id="productId"></div>
        </div>

        <div class="basket-col basket-col--price basket-item-price-holder">
            <div class="basket-item-mobile-title">Цена за 1 шт.</div>
            <div class="basket-item-price" v-html="price"></div>
        </div>

        <div class="basket-col basket-col--quantity basket-item-quantity-holder">
            <div class="basket-item-mobile-title">Количество шт.</div>
            <input type="text" v-model="quantity" v-on:change="changeQuantity()" v-on:keydown.stop class="form-item form--number form-item--text product-quantity basket-item-quantity" />
            <div v-if="quantity > available" class="basket-item-quantity-error">
                <span v-if="available > 0">Доступно: {{ available }} шт.</span>
                <span v-if="!available">Нет в наличии</span>
            </div>
        </div>

        <div class="basket-col basket-col--summary basket-item-summary-holder">
            <div class="basket-item-mobile-title">Стоимость</div>
            <div class="basket-item-summary" v-html="sum"></div>
        </div>

        <div class="basket-col basket-col--nds basket-item-tax-holder" v-if="ndsInfo.BASKET_COL_VAT_RATE.DISPLAY == 'Y'">
            <div class="basket-item-mobile-title">Ставка НДС</div>
            {{ vatRatePercent }}
        </div>
        <div class="basket-col basket-col--nds basket-item-tax-holder" v-if="ndsInfo.BASKET_COL_VAT_RATE.DISPLAY == 'Y'">
            <div class="basket-item-mobile-title">Сумма НДС</div>
            <span v-html="vatValue"></span>
        </div>
        <div class="basket-col basket-col--nds basket-item-tax-holder" v-if="ndsInfo.BASKET_COL_SUMMARY_VALUE.DISPLAY == 'Y'">
            <div class="basket-item-mobile-title">{{ ndsInfo.BASKET_COL_SUMMARY_VALUE.TITLE }}</div>
            <span v-html="sumWithVat"></span>
        </div>

        <div class="basket-col basket-col--remove basket-item-remove-holder">
            <span title="Удалить" class="basket-item-remove" v-on:click="remove()"></span>
        </div>

    </div>

</script>