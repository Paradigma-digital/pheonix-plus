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

                console.log(self.barcode);

                self.isLoaded = true;
                axios
                    .post(phoenixOrderConstants.get("fastadd_url"), phoenixOrderUtils.prepareQuery({
                        barcode: self.barcode,
                        quantity: 1
                    }))
                    .then(function(response) {
                        self.isLoaded = false;

                        self.barcode = "";
                        self.result = response.data;

                        if(self.result.result != -1) {
                            self.$root.$emit("basketRefresh");
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