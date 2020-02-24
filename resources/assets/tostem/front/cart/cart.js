(function ($) {
    if (typeof cart_vue == "undefined") {
        var cart_vue = new Vue({
            el: '#cart-vue',
            data: {
                details: {
                    sub_total: 0,
                    total: 0,
                    total_quantity: 0
                },
                itemCount: 0,
                items: [],
                item: {
                },
                product_: 'product_',
                id_product: null,
                itemObjKey: null,
                message: null,

            },
            mounted: function () {
                this.loadItems();

            },
            methods: {
                async addItem () {

                    let _this = this;

                    try {
                        let response = await axios.post(_base_app + '/cart', {
                            id: _this.item.id,
                            name: _this.item.name,
                            price: _this.item.price,
                            qty: _this.item.qty
                        });
                        await _this.loadItems();
                    } catch (error) {
                        console.log(Object.keys(error), error.message);
                    }
                },
                async uploadQuantityItem (id, itemObjKey) {
                    let _this = this;
                    let select = $('#'+_this.product_+id+" [name=quantity]");
                    let quantity = select.val();

                    try {
                        await axios.post(_base_app + '/cart/update_quantity', {
                            id: id,
                            quantity: quantity,
                        });
                        select.children("option").attr('selected', false);
                        _this.items[itemObjKey].quantity = quantity;
                        select.children("option:selected").attr('selected', 'selected');
                        await _this.loadCartDetails();
                    } catch (error) {
                        console.log(Object.keys(error), error.message);
                    }

                },

                async confirmRemove(id, itemObjKey) {
                    let _this = this;
                    _this.id_product = id;
                    _this.itemObjKey = itemObjKey;
                    _this.$modal.show('remove-product');
                },

                async removeItem () {
                    let _this = this;
                    if (_this.id_product == null || _this.itemObjKey == null) {
                        console.log('not found product to remove');
                        _this.$modal.hide('remove-product')
                    } else {
                        axios.delete(_base_app + '/cart/' + _this.id_product)
                            .then(response => {
                                _this.items.splice(_this.itemObjKey, 1);
                                _this.loadCartDetails();
                                _this.$modal.hide('remove-product')
                            })
                            .catch(error => {
                                console.log(error.response);
                                _this.$modal.hide('remove-product')
                            });
                    }
                },
                async loadItems () {
                    _loading.css('display','block');
                    let totals_elm = $('.totals');
                    let _this = this;
                    try {
                        let response = await axios.get(_base_app+  '/cart');
                        _this.items = response.data.data;
                        _this.itemCount = response.data.data.length;
                        await _this.loadCartDetails();
                    } catch (error) {
                        console.log(Object.keys(error), error.message);
                        _loading.css('display','none');
                        totals_elm.css('display','block');
                    }
                    _loading.css('display','none');
                    totals_elm.css('display','block');
                },

                async loadCartDetails () {
                    let _this = this;
                    try {
                        let response = await axios.get(_base_app + '/cart/details');
                        _this.details = response.data.data;
                    } catch (error) {
                        console.log(Object.keys(error), error.message);
                    }

                },


                async mail() {
                    let _this = this;
                    _this.$modal.show('send-mail');

                },

                async sendMail() {
                    let _this = this;
                    _loading.css('display','block');
                    let html = $('#cart-vue').html();
                    let email = $('#email-send').val();
                    await axios.post(_base_app + '/cart/downloadpdf', {
                        html: html,
                    });
                    await axios.post(_base_app + '/cart/mail', {
                        email: email
                    }).then(response => {
                        _loading.css('display','none');
                        _this.$modal.hide('send-mail');
                        console.log(response.status);
                        if (response.data.status != 'OK') {
                            _this.message = "Error: please contact to admin website";
                            _this.$modal.show('notification');
                        } else {
                            _this.message = "success";
                            _this.$modal.show('notification');
                        }
                    });

                },

                async downloadPdfCart() {
                    _loading.css('display','block');
                    try {
                        let html = $('#cart-vue').html();
                        await axios.post(_base_app + '/cart/downloadpdf', {
                            html: html,
                        });
                        window.location.href = _base_app + '/cart/downloadpdf';
                    } catch (error) {
                        console.log(Object.keys(error), error.message);
                        _loading.css('display','none');
                    }
                    _loading.css('display','none');
                },

                async downloadCsvCart() {
                    window.location.href = _base_app + '/cart/downloadcsv';
                },

                formatPrice(value) {
                    let val = (value/1).toFixed(0);
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }


            }
        });
    }
})(jQuery);