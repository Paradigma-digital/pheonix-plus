<script>
    var orderApp = new Vue({
        el: '#order-form',
        data: {
            ndsInfo: phoenixOrderConstants.get("nds_info"), // Информация о НДС
            userInfo: phoenixOrderConstants.get("user_info"), // Базовая информация о юзере

            basketItems: false,

            summary: { // Итого под корзиной
                count: 1, // чтобы не показывать "ваша корзина пуста" при первой загрузке данных
                sum: null,
                nds: null,
                full: null,
                allSum: null,
                discount: null,
            },

            hasErrors: false,

            orderBtnLoaded: false,

            enableGifts: (phoenixOrderConstants.get("enable_gifts") == "Y" ? true : false),
            userType: phoenixOrderConstants.get("user_type"),

            februaryGifts: {
                "500": {
                    from: 500,
                    to: 899,
                    type: "500",
                    count: 1,
                },
                "900": {
                    from: 900,
                    to: 1399,
                    type: "900",
                    count: 1
                },
                "1400": {
                    from: 1400,
                    type: "1400",
                    to: 9999999999,
                    count: 2,
                }
            },

            prevGiftType: false
        },

        template: "#base__tmpl",

        methods: {

            // Обновление информации
            getProducts: function () {
                var self = this;

                axios
                    .post(phoenixOrderConstants.get("api_url"), phoenixOrderUtils.prepareQuery({
                        basketAction: "recalculate"
                    }))
                    .then(function (response) {
                        self.hasErrors = false;

                        self.updateData(response);
                    });
            },

            // Инициализация данных
            updateData: function (response) {
                var self = this,
                    basket = response.data.BASKET_DATA;

                self.hasErrors = false;


                self.basketItems = basket.GRID.ROWS;


                self.summary.count = parseInt(basket.BASKET_ITEMS_COUNT);
                self.summary.sum = ((self.ndsInfo.BASKET_COL_SUMMARY_VALUE.DISPLAY == "Y") ? basket.allSum_wVAT_FORMATED : basket.PRICE_WITHOUT_DISCOUNT);
                self.summary.nds = (self.ndsInfo.SUMMARY_VAT_TITLE ? basket.allVATSum_FORMATED : null);
                self.summary.full = basket.allSum_FORMATED;

                self.summary.allSum = basket.allSum;

                if (basket.DISCOUNT_PRICE_ALL && basket.DISCOUNT_PRICE_ALL > 0) {
                    self.summary.discount = basket.DISCOUNT_PRICE_ALL_FORMATED;
                } else {
                    self.summary.discount = null;
                }


                if (self.addedGifts > self.giftsCount.count) {
                    self.hasErrors = true;
                }


            },

            // Оформление заказа
            makeOrder: function () {
                var self = this;

                if (self.orderBtnLoaded) {
                    return false;
                }

                self.orderBtnLoaded = true;
                <?
                if($arParams["MODE"] == "Y")
                {
                ?>
                window.location = "/cart/order/?mode=pre_order";
                <?
                }else{
                ?>
                window.location = "/cart/order/?mode=order";
                <?
                }
                ?>
            },

            // Перемещение в избранное
            move2Favorites: function () {
                var self = this,
                    ids = [];

                $.each(self.basketItems, function (i, item) {
                    ids.push(item.PRODUCT_ID);
                });
                axios
                    .post("/ajax/move2favorites.php", {
                        ids: ids
                    })
                    .then(function (response) {
                        window.location = "/personal/favorites/";
                    });
            },

            // Очистка корзины
            clearBasket: function () {
                var self = this;

                $.magnificPopup.open({
                    items: {
                        src: "#basket-clear-notification",
                        type: "inline"
                    },
                    mainClass: "mfp-fade",
                    removalDelay: 300,
                    callbacks: {
                        open: function () {
                            $(this.content).find(".no").on("click", function (e) {
                                e.preventDefault();
                                $.magnificPopup.close();
                            });
                            $(this.content).find(".yes").on("click", function (e) {
                                e.preventDefault();
                                $.magnificPopup.close();
                                self.basketItems = null;
                                axios
                                    .post("/ajax/cleanBasket.php")
                                    .then(function () {
                                        self.getProducts();
                                    });
                            });
                        }
                    }
                });
                /*if(confirm("Будет удалена вся корзина без возможности восстановления.\nПродолжить?")) {

                }*/
            },

            // Экспорт
            exportBasket: function () {
                $.magnificPopup.open({
                    items: {
                        src: "#basket-export-notification",
                        type: "inline"
                    },
                    mainClass: "mfp-fade",
                    removalDelay: 300
                });
            }

        },

        mounted: function () {
            var self = this;

            // Проверка юзера
            //if(self.userInfo && self.userInfo.ID) {
            self.getProducts();
            //}

            this.$root.$on("basketRefresh", function (response = false) {
                if (response) {
                    self.updateData(response);
                    if (!self.addedGifts) {
                        self.prevGiftType = self.giftsCount;
                    }
                } else {
                    self.getProducts();
                }
            });

            $(document).on("basketRefresh", function () {
                self.getProducts();
            });


        },

        computed: {

            // Подсчет количества колонок для стилизации
            columnCountClass: function () {
                var self = this,
                    columnCount = 5;

                if (self.ndsInfo.BASKET_COL_VAT_RATE.DISPLAY == 'Y') {
                    columnCount += 2;
                }
                if (self.ndsInfo.BASKET_COL_SUMMARY_VALUE.DISPLAY == 'Y') {
                    columnCount += 1;
                }

                return ("columns--" + columnCount);
            },


            giftsCount: function () {
                var self = this;


                if (self.userType == "SIMPLE") {
                    for (var code in self.februaryGifts) {
                        var giftItem = self.februaryGifts[code];
                        if (self.summary.allSum >= giftItem.from && self.summary.allSum <= giftItem.to) {
                            return giftItem;
                        }
                    }
                } else if (self.userType == "BUSINESS") {
                    return {
                        "type": "20000",
                        "count": Math.floor(self.summary.allSum / 20000)
                    }
                }

                //return Math.floor(self.summary.allSum / 300);
                return false;
            },

            addedGifts: function () {
                var self = this,
                    count = 0;

                for (var code in self.basketItems) {
                    var item = self.basketItems[code];
                    if (item.PROPS_ALL.IS_GIFT_FEBRUARY) {
                        var countPack = parseInt(item.PRODUCT_PROPS.PACK.VALUE);

                        count += parseInt(item.QUANTITY / countPack);
                    }
                }

                return count;
            },

            giftsError: function () {
                var self = this;

                if (!self.prevGiftType) {
                    return false;
                }

                if (self.prevGiftType.type != self.giftsCount.type && self.addedGifts) {
                    return true;
                }

                return false;
            }
        },

        watch: {
            giftsCount: function (newValue, oldValue) {
                console.log(newValue, oldValue);
                this.prevGiftType = oldValue;
            }
        }
    });

</script>

<script type="text/x-template" id="base__tmpl">
    <div class="page-inner page-inner--w1">

        <div v-if="1">


            <div v-if="hasErrors" class="basket-errors">В корзине обнаружены ошибки</div>

            <div class="basket-preloader" v-if="!basketItems"></div>

            <div class="basket" v-bind:class="columnCountClass" v-if="basketItems && summary.count > 0">
                <div class="basket-row basket-row--heading">
                    <div class="basket-col basket-col--name basket-heading-item">Товары в корзине</div>
                    <div class="basket-col basket-col--price basket-heading-item">Цена за 1 шт.</div>
                    <div class="basket-col basket-col--quantity basket-heading-item">Количество шт.</div>
                    <div class="basket-col basket-col--summary basket-heading-item">Стоимость</div>

                    <div class="basket-col basket-col--nds basket-heading-item"
                         v-if="ndsInfo.BASKET_COL_VAT_RATE.DISPLAY == 'Y'">Ставка НДС
                    </div>
                    <div class="basket-col basket-col--nds basket-heading-item"
                         v-if="ndsInfo.BASKET_COL_VAT_RATE.DISPLAY == 'Y'">Сумма НДС
                    </div>
                    <div class="basket-col basket-col--nds basket-heading-item"
                         v-if="ndsInfo.BASKET_COL_SUMMARY_VALUE.DISPLAY == 'Y'">{{
                        ndsInfo.BASKET_COL_SUMMARY_VALUE.TITLE }}
                    </div>

                    <div class="basket-col basket-col--remove basket-heading-item"></div>
                </div>

                <basket-item v-for="(item, index) in basketItems" v-bind:key="item.ID" v-bind:item="item"
                             v-bind:nds-info="ndsInfo" v-if="!item.PROPS_ALL.IS_GIFT_FEBRUARY"></basket-item>


                <div v-if="((giftsCount && giftsCount.count) || addedGifts > 0) && enableGifts"
                     class="basket-row basket-row--gifts">
                    <div class="basket-gift-block">
                        <div class="page-text">

                            <div v-if="!giftsError">
                                <div v-if="enableGifts && giftsCount && giftsCount.count > 0 && userInfo">
                                    <span v-if="giftsCount"
                                          v-bind:data-href="'/gifts/february/?type=' + giftsCount.type + '&count=' + giftsCount.count"
                                          class="basket-item-add-gifts btn btn--red btn--large">Выбрать подарки</span>
                                    <br/>
                                    <span class="gray">Общее количество доступных подарков: <b>{{ giftsCount.count }}</b></span>
                                </div>

                                <div v-if="!enableGifts || !userInfo">
                                    <b class="red">Авторизуйтесь, чтобы выбрать подарок</b>
                                    <br/>
                                    <span class="gray" v-if="0">(только для розничных покупателей)</span>
                                </div>

                                <p v-if="addedGifts > giftsCount.count" style="color: #CD0520;"><b>Вам нужно удалить
                                        часть подарков :(</b></p>
                            </div>

                            <div v-if="giftsError">
                                <p style="color: #CD0520;"><b>Изменилась сумма покупки. Вам нужно удалить выбранные
                                        подарки для применения новых условий</b></p>
                            </div>

                            <h2 v-if="addedGifts && enableGifts">Выбранные подарки ({{ addedGifts }}):</h2>
                        </div>

                    </div>
                </div>


                <basket-item v-for="(item, index) in basketItems" v-bind:key="item.ID" v-bind:item="item"
                             v-bind:nds-info="ndsInfo"
                             v-if="item.PROPS_ALL.IS_GIFT_FEBRUARY && enableGifts"></basket-item>


                <div class="basket-row basket-row--footer">

                    <div class="basket-actions">
                        <div class="basket-action-item-holder">
                            <button type="button"
                                    class="link link--black basket-action-item basket-action-item--favorites"
                                    v-on:click="move2Favorites()">Добавить всё в избранное
                            </button>
                        </div>
                        <div class="basket-action-item-holder" v-if="userType != 'SIMPLE'">
                            <button type="button" class="link link--black basket-action-item basket-action-item--clear"
                                    v-on:click="clearBasket()">Очистить корзину
                            </button>
                            <div id="basket-clear-notification" class="page-popup mfp-hide">
                                <div class="page-popup-title">Очистка корзины</div>
                                <div class="page-text">
                                    <div class="center">
                                        <p>Будет удалена вся корзина без возможности восстановления.<br/>Продолжить?</p>
                                        <p>
                                            <a href="#" class="btn btn--blue yes" style="width: 80px;">Да</a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="#" class="btn btn--blue no" style="width: 80px;">Нет</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="basket-action-item-holder" v-if="userType != 'SIMPLE'">
                            <a href="/ajax/getBasketXls.php"
                               class="link link--black basket-action-item basket-action-item--export"
                               v-on:click="exportBasket()">Экспорт в таблицу</a>
                            <div id="basket-export-notification" class="page-popup mfp-hide">
                                <div class="page-popup-title">Экспорт корзины</div>
                                <div class="page-text">Корзина экспортирована и будет загружена на ваш компьютер.<br/>Вы
                                    сможете найти файл в папке с загруженными файлами.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="basket-col basket-col--results">
                        <div class="basket-order">
                            <div class="basket-order-summary">
                                <div class="basket-order-summary-item basket-order-summary-item--novat">Товарных
                                    позиций: {{ summary.count }}
                                </div>

                                <div class="basket-order-summary-item basket-order-summary-item--novat">На сумму: <span
                                            v-html="summary.sum"></span></div>

                                <div class="basket-order-summary-item"
                                     v-if="summary.nds && ndsInfo.BASKET_COL_SUMMARY_VALUE.DISPLAY == 'Y'">{{
                                    ndsInfo.SUMMARY_VAT_TITLE }} <span v-html="summary.nds"></span></div>

                                <div class="basket-order-summary-item basket-order-summary-item--novat basket-order-summary-item--discount"
                                     v-if="summary.discount">Скидка: <span v-html="summary.discount"></span></div>

                                <div class="basket-order-summary-item basket-order-summary-item--large">Итого: <span
                                            v-html="summary.full"></span></div>
                            </div>
                            <button type="button" class="basket-order-submit btn btn--red btn--large animation-link"
                                    v-bind:class="{loaded: orderBtnLoaded}" v-if="!hasErrors && !giftsError"
                                    v-on:click="makeOrder()">Оформить заказ
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="basket-empty" v-if="!summary.count">
            <div class="basket-empty-title">Ваша корзина пуста.</div>
            <a href="/catalog/" class="link link--larrow">
                <span class="link-icon"></span>
                <span class="link-text">Перейти к покупкам</span>
            </a>
        </div>


        <fastadd></fastadd>


    </div>

</script>
