<script>
    const purchase_items = {!! isset($purchaseItems) ? $purchaseItems : collect() !!};
    vm = new Vue({
        el: '#purchase_item',
        data: {
            products: purchase_items,
        },
        computed: {
            totalQTy: function () {
                let total = 0;
                this.products.forEach(item => {
                    total += +item.quantity;
                });
                return total;
            },
            totalSubtotal: function () {
                let total = 0;
                this.products.forEach(item => {
                    total += +item.net_cost;
                });
                return total.toFixed(2);
            },
        },
        mounted() {
            this.$nextTick(() => {
                $("#add_item").autocomplete(productSuggestions((item) => {
                    this.add_product_item({...item, product_id: item.id, quantity: 1, net_cost: item.price})
                }));
            });
        },
        methods: {
            add_product_item(item) {
                $('#add_item').val('');
                let update = false;
                this.products = this.products.map(el => {
                    if (el.id === item.id) {
                        update = true;
                        el.quantity++;
                        el.net_cost = (el.price * el.quantity).toFixed(2)
                    }
                    return el;
                });
                if (!update) {
                    this.products.push(item);
                }

                this.$nextTick(() => {
                    $('.datepicker').datetimepicker(datepickerConfig);
                });
            },
            remove_product_item(id) {
                this.products = this.products.filter(item => item.id !== id);
            },
            handleChangeQty() {
                this.products = this.products.map(item => ({
                    ...item,
                    net_cost: (item.price * item.quantity).toFixed(2)
                }));
            },
            formatDate(date) {
                if (date) {
                    return moment(date).format('DD-MM-YYYY');
                }
                return '';
            }
        }
    });
</script>
