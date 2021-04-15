<script>
    const transfer_items = {!! isset($transferItems) ? $transferItems : collect() !!};
    vm = new Vue({
        el: '#transfer_item',
        data: {
            products: transfer_items,
            from_warehouse_id: '{!! old('from_warehouse_id', $data->from_warehouse_id ?? $warehouses->first()->id) !!}',
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
                const _this = this;
                $('#add_item').val('');
                let update = false;
                this.products = this.products.map(el => {
                    if (el.product_id === item.id) {
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
                    $('.expiry_date').datetimepicker({
                        ...datepickerConfig,
                        onChangeDateTime: function (currentDateTime, el) {
                            _this.handleChangeExpiryDate(+el.attr('data-id'), currentDateTime)
                        }
                    });
                });
            },
            remove_product_item(id) {
                this.products = this.products.filter(item => item.product_id !== id);
            },
            handleChangeQty() {
                this.products = this.products.map(item => ({
                    ...item,
                    net_cost: (item.price * item.quantity).toFixed(2)
                }));
            },
            handleChangeExpiryDate(id, value) {
                this.products = this.products.map(item => {
                    if (id === item.product_id) {
                        item.expiry_date = value;
                    }
                    return item;
                });
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
