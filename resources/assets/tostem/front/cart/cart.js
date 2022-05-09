(function ($) {
    var timer;
    if (typeof cart_vue == "undefined") {
        Vue.config.devtools = true;
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
                quotation_no: '',
                validate_mail: null,
                button_click:null,
                user_name: '', //Add BP_O2OQ-4 hainp 20200605
                max_decimal: 0, //Add BP_O2OQ-7 hainp 20200710
                disable_button: false, //Add BP_O2OQ-25 hainp 20210625
                length_reference_no: 8, //Add BP_O2OQ-25 hainp 20210625
            },
            mounted: function () {
                this.loadItems();
            },
            methods: {

            	/**
		         * Redirect if token expired
		         */
		        tokenMismatch () {
		        	_loading.css('display', 'none')
		        	this.$modal.show('dialog', {
						text: lang_text.session_expired,
						buttons: [
							{
								title: lang_text.ok,
								default: true,// Will be triggered by default if 'Enter' pressed.
								handler: () => {
									window.location.href = _urlBaseLang
								}
							},
						]
					})
		        },

                async addItem () {

                    let _this = this;

                    try {
                        let response = await axios.post(_urlBaseLang + '/cart', {
                            id: _this.item.id,
                            name: _this.item.name,
                            price: _this.item.price,
                            qty: _this.item.qty
                        }).catch(error => {
                        	if (error.response.status == 401) {
					        	this.tokenMismatch()
					        }
				        })

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
                        await axios.post(_urlBaseLang + '/cart/update_quantity', {
                            id: id,
                            quantity: quantity,
                        }).catch(error => {
                        	if (error.response.status == 401) {
	                        	this.tokenMismatch()
	                        }
                        })

                        select.children("option").attr('selected', false);
                        _this.items[itemObjKey].quantity = quantity;
                        select.children("option:selected").attr('selected', 'selected');
                        await _this.loadCartDetails();
                    } catch (error) {
                        console.log(Object.keys(error), error.message);
                    }

                },

                // Edit Start BP_O2OQ-25 hainp 20210621
                async uploadRefenceNo(el_target, id, itemObjKey) {
                    let _this = this,
                        input = $(el_target.target),
                        reference_no = input.val(),
                        regex = /[,'"]/g;

                    // nếu max lenght > default thì return
                    if (reference_no.length > _this.length_reference_no) {
                        input.val(el_target.target._value);
                        _this.items[itemObjKey].reference_no = el_target.target._value;
                        return;
                    }

                    if (reference_no.match(regex)) {
                        _this.items[itemObjKey].reference_no_error = true;
                        _this.setStatusButton();
                        input.addClass('error');

                        // gán lại selection cũ trước khi mở popup
                        el_target.target.oldValue = el_target.target._value;
                        el_target.target.oldSelectionStart = el_target.target.selectionStart;
                        el_target.target.oldSelectionEnd = el_target.target.selectionEnd;

                        this.$modal.show('dialog', {
                            text: lang_text.mes_reference_no_input_error,
                            buttons: [
                                {
                                    title: lang_text.ok,
                                    default: true,
                                    handler: async () => {
                                        _this.$modal.hide('dialog');

                                        // 3 line: disable button và xóa border error
                                        _this.items[itemObjKey].reference_no_error = false;
                                        _this.setStatusButton();
                                        input.removeClass('error');

                                        // 3 line: replace các kí tự ,''
                                        reference_no = reference_no.replace(/[,'"]/ig, '');
                                        input.val(reference_no);
                                        _this.items[itemObjKey].reference_no = reference_no;

                                        // call ajax save reference no
                                        await _this.saveReferenceNo(input, id, itemObjKey, reference_no);

                                        // 2 line: focus lại input và gán lại selection cũ
                                        input.focus();
                                        input[0].setSelectionRange(el_target.target.oldSelectionStart, el_target.target.oldSelectionEnd);
                                    }
                                },
                            ]
                        });
                    } else {
                        clearTimeout(timer);
                        // Nếu text không có các kí tự ,'" thì input 1,5s sau sẽ call ajax save reference no
                        timer = setTimeout(async function(){
                            await _this.saveReferenceNo(input, id, itemObjKey, reference_no);
                        }, 1500);
                    }
                },

                async saveReferenceNo(input, id, itemObjKey, reference_no) {
                    let _this = this;
                    input.prop('readonly', true);
                    try {
                        await axios.post(_urlBaseLang + '/cart/update_reference_no', {
                            id: id,
                            reference_no: reference_no,
                        }).catch(error => {
                            if (error.response.status == 401) {
                                _this.tokenMismatch()
                            }
                        })

                        _this.items[itemObjKey].reference_no = reference_no;
                        _this.items[itemObjKey].reference_no_error = false;
                        await _this.loadCartDetails();
                        _this.setStatusButton();
                        input.prop('readonly', false);
                    } catch (error) {
                        console.log(Object.keys(error), error.message);
                        _this.items[itemObjKey].reference_no_error = true;
                        _this.setStatusButton();
                        input.addClass('error');
                        input.prop('readonly', false);
                    }
                },

                setStatusButton() {
                    let _this = this,
                        count = 0;

                    _this.items.forEach(element => {
                        if (typeof element.reference_no_error !== "undefined" && element.reference_no_error == true) {
                            _this.disable_button = true;
                        } else {
                            count++;
                        }
                    });

                    if (_.size(_this.items) == count) {
                        _this.disable_button = false;
                    }
                },
                // Edit End BP_O2OQ-25 hainp 20210621

                async confirmRemove(id, itemObjKey) {
                    let _this = this;
                    _this.id_product = id;
                    _this.itemObjKey = itemObjKey;
                    _this.$modal.show('remove-product');
                },

                async removeItem () {
                    let _this = this;
                    if (_this.id_product == null || _this.itemObjKey == null) {
                        console.error('not found product to remove');
                        _this.$modal.hide('remove-product')
                    } else {
                        axios.delete(_urlBaseLang + '/cart/' + _this.id_product)
                            .then(response => {
                                _this.items.splice(_this.itemObjKey, 1);
                                _this.loadCartDetails();
                                _this.$modal.hide('remove-product')
                            })
                            .catch(error => {
                                console.log(error.response);
                                _this.$modal.hide('remove-product')
                                if (error.response.status == 401) {
	                                this.tokenMismatch()
	                            }
                            });
                    }
                },
                async loadItems () {
                    _loading.css('display','block');
                    let totals_elm = $('.totals');
                    let _this = this;
                    try {
                        let response = await axios.get(_urlBaseLang+  '/cart').catch(error => {
                        	if (error.response.status == 401) {
					        	this.tokenMismatch()
					        }
				        })
                        _this.items = response.data.data;
                        _this.itemCount = response.data.data.length;
                        await _this.loadCartDetails();
                        _this.fixHeightCart();
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
                        let response = await axios.get(_urlBaseLang + '/cart/details');
                        axios.get(_urlBaseLang+'/cart/get_quantity_cart')
                            .then(res => {
                                 $('#cart-number').text(res.data)
                            })
                        _this.details = response.data.data;
                        _this.quotation_no = response.data.data.quotation_no;
                        _this.user_name = response.data.data.user_name; //Add BP_O2OQ-4 hainp 20200605
                        _this.max_decimal = response.data.data.max_decimal; //Add BP_O2OQ-7 hainp 20200710
                        //await _this.createQuotation();
                    } catch (error) {
                        console.log(Object.keys(error), error.message);
                        // this.tokenMismatch()
                    }

                },


                async mail() {
                    let _this = this;
                    _this.validate_mail = null;

                    // Edit Start BP_O2OQ-25 hainp 20210625
                    _this.setStatusButton();

                    if (_this.disable_button) {
                        return false;
                    }
                    // Edit End BP_O2OQ-25 hainp 20210625

                    _this.$modal.show('send-mail');

                },

                async sendMail() {
                    let _this = this;
                    _this.button_click = 0;
                    _loading.css('display','block');
                    let email = $('#email-send').val();
                    if (email == "" || await _this.validateEmail(email) == false)
                    {
                        _this.validate_mail = lang_text.mes_email_error;
                        _loading.css('display','none');
                        return false;
                    }
                    _this.validate_mail = null;

                    let make_html_cart   = await _this.make_html_cart();
                    await _this.createQuotation();
                    if (make_html_cart == true) {
	                    await axios.post(_urlBaseLang + '/cart/mail', {
	                         email: email
	                    }).then(response => {
	                        _this.$modal.hide('send-mail');
	                        console.log(response.status);
	                        if (response.data.status != 'OK') {
	                            _this.message = response.data.messagepage;
	                            _this.$modal.show('notification');
	                        } else {
	                            _this.message = response.data.messagepage;
	                            _this.$modal.show('notification');
	                        }
	                        _loading.css('display','none');
	                    });
                    } else {
                    	_loading.css('display','none');
                    }


                },
                async validateEmail(email) {
                    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                     return re.test(String(email).toLowerCase());
                },
                async downloadPdfCart() {
                    let _this = this;
                    _this.button_click = 1;
                    _loading.css('display','block');

                    // Edit Start BP_O2OQ-25 hainp 20210625
                    _this.setStatusButton();

                    if (_this.disable_button) {
                        _loading.css('display','none');
                        return false;
                    }
                    // Edit End BP_O2OQ-25 hainp 20210625

                    try {

                    	axios.get(_base_app +'/check-token-expired').then(async () => {

	                        await _this.make_html_cart();
	                        await _this.createQuotation();

		             window.location.href = _urlBaseLang + '/cart/downloadpdf';

	                    }).catch((error) => {
	                    	if (error.response.status == 401) {
		                    	this.tokenMismatch()
		                    }
	                    })

                    } catch (error) {
                        console.log(Object.keys(error), error.message);
                        _loading.css('display','none');
                    }
                    _loading.css('display','none');

                },

                async make_html_cart () {
                    try {

                        let html = $('#cart-content').html();
                        await axios.post(_urlBaseLang + '/cart/downloadpdf', {
                            html: html,
                        }).catch(error => {
	                        console.log(error);
	                        if (error.response.status == 401) {
		                        this.tokenMismatch()
		                    }
	                    });
                    } catch (error) {
                        console.log(Object.keys(error), error.message);
                        _loading.css('display','none');
                        // this.tokenMismatch()
                        return false
                    }

                    return true

                },

                async createQuotation () {
                    let _this = this;
                    await axios.post(_urlBaseLang + '/cart/quotation',{
                                  button_click:_this.button_click
	                    }).then(response => {
                        if (response.data.status === 'success') {
                            _this.quotation_no = response.data.file_name;
                            _this.user_name = response.data.user_name; //Add BP_O2OQ-4 hainp 20200608
                            _this.max_decimal = response.data.max_decimal; //Add BP_O2OQ-7 hainp 20200710
                        } else {
                            console.log(response);
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        if (error.response.status == 401) {
	                        this.tokenMismatch()
	                    }
                    });
                },

                async downloadCsvCart() {
                    let _this = this;
                    _this.button_click = 2;
                    _loading.css('display','block');
                    let make_html_cart   = await _this.make_html_cart();
                    await _this.createQuotation();
                    _loading.css('display','none');

                    if (make_html_cart == true) {
	                    window.location.href = _urlBaseLang + '/cart/downloadcsv';
                    }

                },

                formatPrice(value) {
                    let val = (value/1).toFixed(this.max_decimal); //Edit BP_O2OQ-7 hainp 20200710
                    //console.log(val);
                    // return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");//Remove BP_O2OQ-7 hainp 20200709

                    //Add Start BP_O2OQ-7 hainp 20200709
                    //Know whether there is a decimal point in the number, and use different regular expressions depending on that:
                    // /(\d)(?=(\d{3})+$)/g for integers
                    // /(\d)(?=(\d{3})+\.)/g for decimals
                    // Use two regular expressions, one to match the decimal portion, and a second to do a replace on it.
                    return val.toString().replace(/^[+-]?\d+/, function(int) {
                        return int.replace(/(\d)(?=(\d{3})+$)/g, '$1,');
                    });
                    //Add End BP_O2OQ-7 hainp 20200709
                },

                fixHeightCart: function () {
                    let orders_no_element = $('.product-series');
                    orders_no_element.each(function (key, item) {
                        let children = $(item).find('.series-name');
                        if (children.length > 1) {
                            let parents = children.closest('.product');
                            let product_order = parents.find('.product-order_no').find('.order-no');
                            let product_price = parents.find('.product-price').find('.price-item');
                            let product_total_price = parents.find('.product-line-price').find('.total-item');
                            children.each(function (child_key, child_item) {
                                let height = $(child_item).height();
                                product_order.eq(child_key).height(height);
                                product_price.eq(child_key).height(height);
                                product_total_price.eq(child_key).height(height);

                            });
                        }
                    });
                },



            }
        });
    }





})(jQuery);