/*
|--------------------------------------------------------------------------
| Lib
|--------------------------------------------------------------------------
*/
import Slick from 'vue-slick'
import Storage from 'vue-web-storage'
import VModal from 'vue-js-modal'

/*
|--------------------------------------------------------------------------
| Variable
|--------------------------------------------------------------------------
*/
var $exterior_ctg = 2,
	$slickOptions = {
	//options can be used from the plugin documentation
	accessibility: true,
	adaptiveHeight: false,
	arrows: true,
	dots: false,
	draggable: true,
	edgeFriction: 0.30,
	// swipe: true,
	infinite: false,
	slidesToShow: 6, // Shows a three slides at a time
	slidesToScroll: 6, // When you click an arrow, it scrolls 1 slide at a time
	responsive: [
        {
            breakpoint: 1400,
            settings: {
                slidesToShow: 5,
                slidesToScroll: 5
            }
        },
		{
			breakpoint: 1024,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 3,
				infinite: true,
				dots: true
			}
		},
		{
			breakpoint: 600,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			}
		},
		{
			breakpoint: 480,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			}
		}
	]
}

/*
|--------------------------------------------------------------------------
| Vue setting
|--------------------------------------------------------------------------
*/
// Vue.config.devtools = true
Vue.use(VModal, { dialog: true })
Vue.use(Storage, {
  prefix: 'o2o-',// default `app_`
  drivers: ['session','local'], // default 'local'
})

/*
|--------------------------------------------------------------------------
| Main
|--------------------------------------------------------------------------
*/
app = new Vue({
    el: '#page',
    components: {
    	Slick
    },
    data() {
        return {
        	ctg_id : ctg_id,
            slug_name : slug_name,
			lang: lang,
            products : [],
            product_id: null,
            product_name : null,

            spec1: null,
            spec1_name: null,

            models : [],
            model_id: null,
            m_color_id_default: null,

            featured_img: null,
            featured_img_spec51: null,

            colors: {},
            color_id: null,
            color_name: null,
            color_code: null,
            colors_handle: {
            	data: {},
            	id: null,
            	name: null
            },

            spec_group: [],
            spec_option: [],

            data_options: [],//data query when choose model

            modelSpec: {},
            mItemDisplay: [],
            itemDisplay: {},

            specs: {
            	select: {},
	            disable: {},
            },//use to foreach spec
            spec51_img : {},

            options: {},//use to foreach option of spec //có thể sẽ xóa đi
            handler_type: {},
            list_spec: [],//list spec and option in  data_option
            list_spec_trans: [],//list spec and option name
            list_spec_order: [],
            spec_code_order: {},
            spec_exclude: [],
            group_label: [],//list label of group option and spec
            spec_selected: {},// list spec user selected
            option_selected: {},// list option of spec user selected

            size: {
            	data_width: [],
            	data_height: [],
            	width: null,
	            height: null,
	            type: null
            },//list of width and height

            add_to_cart : false,//state enable button add to cart
            total_price : 0,

            slickOptions: $slickOptions,

            show_total_price: false,//check for show total price and add to cart
            cart_content_count: 0, //number of item in cart
            data_query: {
            	celling_code_option: [],
            	data_m_selling_spec: [],
            	option_handle_giesta: [],
            	side_panel: [],
            	hidden_option: []
            },
            data_options_result : [],//last data options
            handle_active: null,
            spec_image: [],
            display_pitch_list: false,
            max_decimal: 0, //Add BP_O2OQ-7 hainp 20200714
            sub_menus: [], //Add BP_O2OQ-25 antran 20200622
        }
    },
    created () {
    	this.created()
    },
    computed: {
    	totalPrice () {
    		//Remove Start BP_O2OQ-7 hainp 20200714
    		// return this.total_price
    		// 	.toFixed(2)
			// 	.replace(/\d(?=(\d{3})+\.)/g, '$&,');
			//Remove End BP_O2OQ-7 hainp 20200714

			//Add Start BP_O2OQ-7 hainp 20200714
			return this.total_price
				.toFixed(this.max_decimal)
				.replace(/^[+-]?\d+/, function(int) {
					return int.replace(/(\d)(?=(\d{3})+$)/g, '$1,');
				});
			//Add End BP_O2OQ-7 hainp 20200714
    	},

    	checkDisabledAddToCart () {
    		let check = true

    		if(this.model_id == null) {
    			return check
    		}

    		//console.log('data_options_result:' + this.data_options_result.length)
	    	if(this.data_options_result.length == 0) {
	    		//console.log('cart_content_count:' + this.cart_content_count)
	    		if(this.cart_content_count > 0) {
	    			check = false
	    		}
	    	} else{
	    		//console.log('add_to_cart:' + this.add_to_cart)
	    		if(this.add_to_cart == true) {
	    			check = false
	    		}
	    	}
	    	//console.log('Enable add to cart: 'check)
	    	return check
	    },

	    checkDisabledSidePanel () {
	    	let numSpecDisabled = _.keys(this.specs.disable).length

	    	if(numSpecDisabled > 0 || (_.keys(this.handler_type).length > 0 && this.handle_active == null)) {
	    		//Trả về false nếu ko còn spec nào disable
	    		return true
	    	}

	    	return false
	    },

	    checkDisabledWidth () {
	    	//true for disabled
	    	let
	    		numSpecChoise   = _.keys(this.specs.select).length,
	    		numSpecDisabled = _.keys(this.specs.disable).length,
	    		numSpecSelect   = _.keys(this.spec_selected).length

	    	if(numSpecChoise == 0) {
	    		return false

	    	} else if(numSpecDisabled == 0 && (numSpecSelect == numSpecChoise)) {
	    		return false
	    	}

	    	return true
	    },

	    checkDisabledHeight () {
	    	//true for disabled
	    	let result = true
	    	if(this.size.data_width.length > 0) {
	    		if(this.size.width != null) {
	    			result = false
	    		}
	    	} else {
	    		let
		    		numSpecChoise   = _.keys(this.specs.select).length,
		    		numSpecDisabled = _.keys(this.specs.disable).length,
		    		numSpecSelect   = _.keys(this.spec_selected).length

		    	if(numSpecChoise == 0) {
		    		result = false

		    	} else if(numSpecDisabled == 0 && (numSpecSelect == numSpecChoise)) {
		    		result = false
		    	}
	    	}
	    	return result
	    },

	    checkDisabledSpec () {
	    	let result = false

	    	if(this.colors.length > 0 && this.color_id == null) {
	    		result = true
	    	} else if(this.size.data_height.length > 0 && this.size.height == null) {
	    		result = true
		    } else if(this.size.data_width.length > 0 && this.size.width == null) {
		    	result = true
		    }

		    return result
	    },

	    checkDisabledColorHandle () {
	    	let result = true,
	    		argKeySpecSelected = _.keys(this.spec_selected)

	    	if(argKeySpecSelected.length > 0 && argKeySpecSelected.includes('spec55')) {
	    		result = false
	    	}

	    	return result
	    },

	    getImageResultPath () {
	    	return '/tostem/img/data/' + this.featured_img
	    }
    },
    watch: {
    	product_id () {
	        this.initProduct();
	        if(ctg_id != $exterior_ctg) {
	        	this.getModels(this.product_id);
	        }
    	},

    	spec1 () {
	        this.initProduct();
            this.getModels(this.product_id, this.spec1);
    	},

	    colors () {
	    	let keys = _.keys(this.colors),
	    		flg = false //flg kiểm tra nếu không có color nào được chọn thì chọn cái đầu tiên

	    	if(keys.length == 1) {
	    		this.selectColor(keys[0])
	    	} else if(keys.length > 1) {
	    		_.each(this.colors, (value, index) => {
	    			if(value.m_color_id == this.m_color_id_default ) {
	    				this.selectColor(index)
	    				flg = true
	    				return false
	    			}
	    		})

	    		if(flg == false) {
	    			this.selectColor(keys[0])
	    		}
	    	}
	    }
    },
    methods: {
        reInitSlider() {
            // Helpful if you have to deal with v-for to update dynamic lists
            let currIndex = 0;
            // currIndex = this.$refs.carousel.currentSlide()
	        this.$refs.carousel.destroy()
	        this.$nextTick(() => {
		        this.$refs.carousel.create()
		        // this.$refs.carousel.goTo(currIndex, true)
	        })
        },

        log (log) {
        	console.log(this.$data[log]);
        },

        alert (msg, title) {
        	title = title || "";
        	this.$modal.show('dialog', {
        		title: title,
				text: msg,
				buttons: [
					{
						title: lang_text.ok,
						default: true,// Will be triggered by default if 'Enter' pressed.
					},
				]
			})
        },

        async created () {
        	await this.getProduct()
	    	// this.getDataSellingSpec()
	    	this.getCartContentCount()
            this.getSubMenu()
        },

		/**
		 * Check show amount & add_to_cart
		 */
	    async validateShow () {

	    	let celling_code_option_amount = 0,
	    		check = () => {

		    		if(_.keys(this.specs.select).length> 0 && _.keys(this.spec_selected).length != _.keys(this.specs.select).length) {
			    		return false
			    	}

			    	if(_.keys(this.colors).length > 0 && this.color_id == null) {
			    		return false
			    	}

			    	if(_.keys(this.colors_handle.data).length > 0 && this.colors_handle.id == null) {
			    		return false
			    	}

			    	if(this.size.data_width.length > 0 && this.size.width == null) {
			    		return false
			    	}

			    	if(this.size.data_height.length > 0 && this.size.height == null) {
			    		return false
			    	}

			    	return true
		    	}

	    	if(check()) {
	    		_loading.css('display', 'block');
	        	await this.queryCellingCodeOption().then(response => {
	        		this.data_query.celling_code_option = response.data
	        		if(this.data_query.celling_code_option.length >0) {
	        			_.each(this.data_query.celling_code_option, function (row) {
	        				celling_code_option_amount += parseFloat(row.amount)
	        			})
	        		}

	        		this.total_price = 0
		        	this.data_options_result = _.filter(this.data_options, this.buildQuery())
		        	_.each(this.data_options_result, (row) => {
			    		if(row.amount != null) {
			    			this.total_price += parseFloat(row.amount)
			    		}
			    	})

		        	this.total_price += celling_code_option_amount
		        }).catch(error => {
		        	if (error.response.status == 401) {
			        	this.tokenMismatch()
			        }
		        })

	        	await this.selectHiddenData()

				let data_handle_option = _.filter(this.data_query.option_handle_giesta, {m_color_id: this.colors_handle.id, option4: this.handle_active})
				_.each(data_handle_option, (row) => {
		    		if(row.amount != null) {
		    			this.total_price += parseFloat(row.amount)
		    		}
		    	})

		    	if(this.data_query.side_panel.length > 0) {
					let side_panel_query = {
						width: this.size.width,
						height: this.size.height,
					}

					_.forEach(this.spec_selected, (value, key) => {
						if(key != 'spec52') {
							side_panel_query[key] = value
						}
					})

					_.forEach(_.filter(this.data_query.side_panel, side_panel_query), row => {
						this.total_price += parseFloat(row.amount)
					})
				}

				if(this.data_options_result.length > 0) {
					this.show_total_price = true
		    		this.add_to_cart      = true
				}

	        	_loading.css('display', 'none');
	    	} else {
	    		this.show_total_price = false
	    		this.add_to_cart      = false
	    	}
	    },

        initProduct () {
            this.models = []
            this.model_id = null
            this.m_color_id_default = null

            this.initModel()
        },

        initModel () {

        	this.data_options = {}
        	this.data_options_result = {}

        	//reset color
        	this.color_id = null
            this.color_name = null
            this.color_code = null
        	this.colors = {}

            //reset featured img
            this.featured_img = null
            this.featured_img_spec51 = null

            //reset size
            this.size = {
            	data_width: [],
            	data_height: [],
            	width: null,
	            height: null,
	            type: null
            }

            //reset spec and option
            this.option_selected = {}
            this.spec_selected = {}
            this.options = {}
            this.mItemDisplay = []
            this.itemDisplay = {}
            this.specs = {
            	select: {},
	            disable: {},
            }//use to foreach spec

            //reset footer
            this.show_total_price = false
            this.total_price = 0
            this.show_footer = false
            this.add_to_cart = false

            //reset spec_trans
            this.list_spec_trans = {}
            this.group_label = {}

            this.colors_handle = {
            	data: {},
            	id: null,
            	name: null
            }
            this.handler_type = {}
            this.handle_active = null
            this.spec_image = []
            this.display_pitch_list = false
        },

        buildQuery (exclude = []) {

	    	let all_value_selected = {},
	    		keySelected = _.without(['spec', 'option', 'color', 'width', 'height'], ...exclude, ...this.spec_exclude)

	    	_.forIn(keySelected, (value) => {
	    		switch (value) {
	    			case 'spec':
	    				if(_.keys(this.spec_selected).length > 0) {
			        		_.each(this.spec_selected, (value, key) => {
			        			if(key != 'spec57') {
			        				all_value_selected[key] = value
			        			}
			        		})
			        	}

			        	if(_.keys(this.itemDisplay).length > 0) {
			        		_.each(this.itemDisplay, (value, key) => {
			        			if(key != 'spec3') {
			        				all_value_selected[key] = value
			        			}
			        		})
			        	}
	    				break
	    			case 'option':
	    				if(_.keys(this.option_selected).length > 0) {
			        		_.each(this.option_selected, (value, key) => {
			        			all_value_selected[key] = value
			        		})
			        	}
	    				break
	    			case 'color':
	    				if(_.keys(this.colors).length > 0 && this.color_id != null) {
			        		all_value_selected['m_color_id'] = this.color_id
			        	}
	    				break
	    			case 'width':
		    			if(this.size.width != null) {
			        		all_value_selected['width'] = this.size.width
			        	}
	    				break
	    			case 'height':
	    				if(this.size.height != null) {
			        		all_value_selected['height'] = this.size.height
			        	}
	    				break
	    		}
	    	})

        	return all_value_selected
        },

        /**
         * Sort spec item và spec value
         * @param  object objSpec
         * @return object
         */
        sortSpec (objSpec) {
        	let sortable = [],
        		objSorted = {}

			_.each(objSpec, (_value, _specCode) => {

				_value.data.sort((a, b) => {
					return this.list_spec_order[a] - this.list_spec_order[b]
				})

				sortable.push([_specCode, _value])
			})

			sortable.sort((a, b) => {
			    return this.spec_code_order[a[0]] - this.spec_code_order[b[0]]
			});

			_.each(sortable, (item) => {
				objSorted[item[0]] = item[1]
			})

			return objSorted
        },

        getProduct () {
        	_loading.css('display', 'block');
    		axios.get(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/list')
        		.then(response => {
				    this.products = response.data;
				    if(response.data.length == 1) {
				    	let product = response.data[0]
				    	this.selectProduct(product.product_id, product.product_name)
				    }
					_loading.css('display', 'none');
				}).catch(error => {
					if (error.response.status == 401) {
						this.tokenMismatch()
					}
				})
    	},

        getSubMenu () {
            _loading.css('display', 'block');
            axios.get(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_submenu')
                .then(response => {
                    this.sub_menus = response.data;
                }).catch(error => {
                    if (error.response.status == 401) {
                        this.tokenMismatch()
                    }
                })
        },

        getDataSellingSpec () {
        	axios.get(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_selling_spec')
        		.then(response => {
				    this.data_query.data_m_selling_spec = response.data;
				    this.filterDataSellingSpec();
				}).catch(error => {
					if (error.response.status == 401) {
						this.tokenMismatch()
					}
				})
        },

    	getCartContentCount () {
    		axios.get(_base_app + '/' + lang + '/cart/get_quantity_cart')
    			.then(response => {
		            this.cart_content_count = response.data
		            $('#cart-number').text(this.cart_content_count)
		        }).catch(error => {
		        	if (error.response.status == 401) {
			        	this.tokenMismatch()
			        }
		        })
    	},

    	getModelSpec() {
        	return this.queryModelSpec().then(response => {
        		return response.data
        	}).catch(error => {
        		if (error.response.status == 401) {
	        		this.tokenMismatch()
	        	}
        	})
        },

        getMItemDisplay() {
        	return axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_m_item_display', {
				m_model_id: this.model_id
			}).then(response => {
        		return response.data
        	}).catch(error => {
        		if (error.response.status == 401) {
	        		this.tokenMismatch()
	        	}
        	})
        },

        async getSpecTrans () {
        	await this.querySpecTrans(this.list_spec).then(response => {
            	this.list_spec_trans = response.data.list_spec_trans
				this.list_spec_order = response.data.list_spec
				this.spec_code_order = response.data.spec_code_order
            	this.spec_exclude = response.data.spec_exclude
            	if(typeof(response.data.group_label) != 'undefined') {
            		this.group_label = response.data.group_label
            	}
            }).catch(error => {
            	if (error.response.status == 401) {
	            	this.tokenMismatch()
	            }
            })
        },

        getModels (product_id, spec1 = null) {
        	_loading.css('display', 'block');
            axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_models', {
                product_id: product_id,
                spec1: spec1
            }).then(response => {
            	_loading.css('display', 'none');
            	if(response.data.length > 0) {
            		this.models = response.data
	                this.reInitSlider()
            	} else {
            		this.$modal.show('dialog', {
						text: lang_text.model_not_found,
						buttons: [
							{
								title: lang_text.ok,
								default: true,// Will be triggered by default if 'Enter' pressed.
							}
						]
					})
            	}
            }).catch(error => {
                console.log(error.response);
                _loading.css('display', 'none');
                if (error.response.status == 401) {
	                this.tokenMismatch()
	            }
            });
        },

        async getOptions () {
            //console.time('fetchAllData')
        	let  data = await this.queryOptions()
        	if(data.option.length > 0) {
        		this.data_options = data.option
                let firstOption = this.data_options[0] 
                if (data.hasOwnProperty("option_color")) {
                    this.colors = data["option_color"]
                }
                if (this.colors.hasOwnProperty(firstOption.m_color_id)) {
                    this.colors[firstOption.m_color_id]["data_options"] = data.option
                }
        		this.data_query.option_handle_giesta   = data.option_handle_giesta
		    	this.mItemDisplay = data.m_item_display
		    	this.spec_image = data.spec_image
				this.max_decimal = data.max_decimal //Add BP_O2OQ-7 hainp 20200714
                
	    		await this.fetchAllData()
	            this.scrollToAddToCart()
        	} else {
        		this.alert(lang_text.option_not_found)
        	}
            //console.timeEnd('fetchAllData')
        },

        async getDescriptionCart () {
        	let
        		description  = {},
				lstUndefined = [],
				groupLabel   = this.group_label,
				lstTrans     = this.list_spec_trans,
				key          = ''

			/** Spec */
			_.each(this.spec_selected, (value, spec) => {
				key = groupLabel[spec.replace('spec', '')]
				if(typeof(key) == 'undefined') {
					lstUndefined.push(lstTrans[value])
				} else {
					description[key] = lstTrans[value]
				}
			})

			/** Option */
			_.each(this.option_selected, (value, option) => {
				key = groupLabel[option.replace('option', 'o')]
				if(typeof(key) == 'undefined') {
					lstUndefined.push(lstTrans[value])
				} else {
					description[key] = lstTrans[value]
				}
			})

			if(lstUndefined.length > 0) {
				description['undefined'] = lstUndefined
			}

			return description
        },

        getHandleType () {
        	let
        		objHandleType = {},
        		objColors = {}
        	_loading.css('display', 'block');
    		axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_giesta_handle_type', {
                product_id: this.product_id,
                specs: this.spec_selected,
                ctg_id: this.ctg_id
            }).then(response => {
            	this.data_query.option_handle_giesta = response.data
			    if(response.data.length > 0) {
			    	_.forEach(response.data, (rowValue, rowIndex) => {

			    		//Color
						if(objColors.hasOwnProperty(rowValue.m_color_id) === false) {
							objColors[rowValue.m_color_id] = {
								'm_color_id'       : rowValue.m_color_id,
								'color_name'       : rowValue.color_name,
								'color_code_price' : rowValue.color_code_price,
								'img_path'         : rowValue.color_handle_img_path,
								'img_name'         : rowValue.color_handle_img_name,
							};
						}

		    			if(rowValue.option4 == null) {
		    				return
		    			}

						if(objHandleType.hasOwnProperty('option4') === false) {
							objHandleType['option4'] = {}
						}

						if(!_.keys(objHandleType['option4']).includes(rowValue.option4)) {
							objHandleType['option4'][rowValue.option4] = {
								name: rowValue.option4_display,
								spec55: rowValue.spec55,
								option4: rowValue.option4
							}
						}
		    		})
			    }
			    this.handler_type  = objHandleType
			    this.colors_handle.data = objColors
				_loading.css('display', 'none');
			}).catch(error => {
				if (error.response.status == 401) {
					this.tokenMismatch()
				}
			})
        },

        getSidePanel (specCode, specValue) {
        	// if(specCode == 'spec53' && specValue == '53.2') {
	        	let objHandleType = {}
	        	_loading.css('display', 'block');
	    		axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_giesta_side_panel', {
	                specs      : this.spec_selected,
	                width      : this.size.width,
	                ctg_id     : this.ctg_id,
	                height     : this.size.height,
	                product_id : this.product_id,
	                m_color_id : this.color_id,
	                m_model_id : this.model_id
	            }).then(response => {
	            	this.data_query.side_panel = response.data
				    if(response.data.length > 0) {
				    	let obj = {active: '', data: []},
				    		argSpecTrans = []
				    	_.forEach(response.data, (rowValue, rowIndex) => {
				    		if(rowValue.spec57 != null && !obj.data.includes(rowValue.spec57)) {
				    			obj.data.push(rowValue.spec57)
				    			argSpecTrans.push(rowValue.spec57)
				    		}
				    	})
				    	if(argSpecTrans.length > 0) {
				    		this.querySpecTrans(argSpecTrans).then(result => {
			    				_.forEach(result.data.list_spec_trans, (value, key) => {
			    					this.$set(this.list_spec_trans, key, value)
			    				})

			    				this.$set(this.group_label, '57', lang_text.side_panel)
			    				//NOTE: Tạm thời hardcode spec57 = Side Panel (Chưa thay đổi theo ngôn ngữ)
			    				/*
			    				if(typeof(response.data.group_label) != 'undefined') {
			    					this.$set(this.group_label, 'spec57', response.data.group_label[0]['spec_group_label'])
				            	}
				            	*/
				            });
						}
						if(obj.data.length == 1) {
							this.selectSpec57(obj.data[0])
						} else {
							this.$set(this.specs.select, 'spec57', obj)
						}

				    } else {
				    	this.$delete(this.specs.select, 'spec57')
				    }
					_loading.css('display', 'none');
				}).catch(error => {
					if (error.response.status == 401) {
						this.tokenMismatch()
					}
				})
	        // }
        },

        getSpecLabel(specCode, type = 'spec') {
        	let
        		replace = (type == 'option') ? 'o' : '',
        		label = this.group_label[specCode.replace(type, replace)]

        	if(label != null) {
        		return label
        	}

        	return 'Label not found'
        },

        queryCellingCodeOption() {
        	return axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_celling_code_option', {
        		product_id  : this.product_id,
        		m_color_id  : this.color_id,
        		spec        : this.spec_selected,
        		option      : this.option_selected,
        		width       : this.size.width,
				height      : this.size.height,
				item_display: this.itemDisplay,
				m_model_id  : this.model_id
        	})
        },

        queryOptions () {
        	_loading.css('display', 'block')
    		return axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_options', {
                product_id: this.product_id,
                color_id: this.color_id ?? 0,
                default_color_id: this.m_color_id_default ?? 0,
                m_model_id: this.model_id
            }).then(response => {
	            _loading.css('display', 'none');
                return response.data
            }).catch(error => {
                console.log(error.response)
                if (error.response.status == 401) {
	                this.tokenMismatch()
	            }
            });
    	},

    	querySpecTrans (list_spec) {
        	return axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_spec_stran', {
                list_spec : list_spec
            });
        },

        queryModelSpec() {
        	return axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_model_spec', {
				m_model_id: this.model_id
			})
        },

        filterDataSellingSpec () {
        	_.forEach(this.data_query.data_m_selling_spec, value => {
    			if($.isNumeric(value.m_spec_group_id) === true) {
    				if(!this.spec_group.includes('spec' + value.m_spec_group_id)) {
    					this.spec_group.push('spec' + value.m_spec_group_id);
    				}
    			} else {
    				if(!this.spec_option.includes('option' + value.m_spec_group_id)) {
    					this.spec_option.push('option' + value.m_spec_group_id.substr(1));
    				}
    			}
    		});
        },

        async fetchAllData () {
        	let
    			objFind= {},
    			objTmp = {
    				specs: {},
	    			options: {},
	    			widths: [],
	    			heights: [],
	    			colors_handle: {},
	    			mItemDisplay: {},
	    			spec51: {}
    			},
    			argKeyMItemDisplay = []


    		if(this.mItemDisplay.length > 0) {
	    		this.mItemDisplay = _.map(this.mItemDisplay, function(p){
					return _.chain(p).pickBy(_.identity).omit('m_model_id').value()
				});
    		}
    		argKeyMItemDisplay = _.keys(this.mItemDisplay)

    		_.forEach(this.data_options, (rowValue, rowIndex) => {

    			_.forIn(rowValue, (value, colName) => {

    				if(value == null) {
    					return;
    				}

    				if(_.startsWith(colName, "spec")) {

    					if(!argKeyMItemDisplay.includes(colName)){
    						objFind = _.find(this.mItemDisplay, colName)
    						if(objFind){
    							objTmp.mItemDisplay[colName] = objFind[colName]
    						} else {

		    					if(objTmp.specs.hasOwnProperty(colName) === false) {
		    						objTmp.specs[colName] = {
		    							active: "",
		    							data: []
		    						}
		    					}

		    					if(!objTmp.specs[colName].data.includes(value)) {
		    						objTmp.specs[colName].data.push(value);
		    						if(colName == 'spec51') {
		    							objTmp.spec51[value] = {
			    							path: rowValue.img_path_spec51,
			    							name: rowValue.img_name_spec51
			    						}
		    						}
		    					}

		    					if(this.list_spec.indexOf(value) == -1) {
		    						this.list_spec.push(value);
		    					}
    						}
    					}
    				}
    			});

    			//SIZE
				if(objTmp.widths.indexOf(rowValue.width) == -1 && rowValue.width != null) {
					objTmp.widths.push(rowValue.width);
				}

				if(objTmp.heights.indexOf(rowValue.height) == -1 && rowValue.height != null) {
					objTmp.heights.push(rowValue.height);
				}
    		})

    		_.forEach(this.data_query.option_handle_giesta, (rowValue, rowIndex) => {

    			if(rowValue.option4 == null) {
    				return
    			}

				if(objTmp.options.hasOwnProperty('option4') === false) {
					objTmp.options['option4'] = {}
				}

				if(!_.keys(objTmp.options['option4']).includes(rowValue.option4)) {
					objTmp.options['option4'][rowValue.option4] = {
						name: rowValue.option4_display,
						spec55: rowValue.spec55,
						option4: rowValue.option4
					}
				}

				//Color
				if(objTmp.colors_handle.hasOwnProperty(rowValue.m_color_id) === false) {
					if(rowValue.color_name == 'No Color') {
						this.featured_img = rowValue.img_path_result + '/' + rowValue.img_name_result
					} else {
						objTmp.colors_handle[rowValue.m_color_id] = {
							'm_color_id'            : rowValue.m_color_id,
							'color_name'            : rowValue.color_name,
							'color_code_price'      : rowValue.color_code_price,
							'img_path' : rowValue.color_handle_img_path,
							'img_name' : rowValue.color_handle_img_name,
						};
					}
				}
    		})

    		//Nếu list_spec có value => query lên db lấy [spec | option]_name và [spec | option]_group_name
    		if(this.list_spec.length >0 && _.keys(this.list_spec_trans).length == 0){
    			await this.getSpecTrans()
    		}

			if(objTmp.widths.length >0) {
				objTmp.widths.sort(function(a, b){return a - b})
			}

			if(objTmp.heights.length >0) {
				objTmp.heights.sort(function(a, b){return a - b})
			}

			//Remove spec trong spec_exclude
			_.each(this.spec_exclude, (value) => {
				_.unset(objTmp.specs, value)
			})

			//Chọn sẵn spec nếu chỉ có 1 value
            if(_.keys(objTmp.specs).length > 0 ) {

				objTmp.specs = this.sortSpec(objTmp.specs)

				let
					argKeyObjTmpSpecs = _.keys(objTmp.specs),
					firstKey          = argKeyObjTmpSpecs[0],
					firstObj          = objTmp.specs[firstKey]

				if(firstObj.data.length == 1) {

					let copyObjTmpSpecs = objTmp.specs

					_.each(copyObjTmpSpecs,(_value, _specCode) => {

						this.$set(this.specs.select, _specCode, _value)

						_.unset(objTmp.specs, _specCode)

						if(_value.data.length == 1) {
							this.$set(this.spec_selected, _specCode, _value.data[0])
						} else {
							return false
						}

					})
				} else {
					this.$set(this.specs.select, firstKey, firstObj)
					_.unset(objTmp.specs, firstKey)
				}
			}

			this.specs.disable      = objTmp.specs
			this.handler_type       = objTmp.options
			this.colors_handle.data = objTmp.colors_handle
			this.spec51_img         = objTmp.spec51

			this.size.data_width  = objTmp.widths
			this.size.data_height = objTmp.heights
			this.itemDisplay      = objTmp.mItemDisplay
			this.mItemDisplay     = _.chain(this.mItemDisplay).groupBy('item_display_name').keys().value()
			this.validateShow()
        },

        async fetchDataSelected () {
        	// console.time('fetchDataSelected')
        	let
        		data               = _.filter(this.data_options, this.buildQuery()),
        		dataHandle         = [],
    			argKeySpecSelected = _.keys(this.spec_selected),
    			argKeyMItemDisplay = _.keys(this.itemDisplay),
        		objTmp             = {
        			specs  : {},
        			options: {},
        			width  : [],
        			height : [],
        			options: {},
        			colors_handle: {}
        		}

    		_.forEach(data, (rowValue, rowIndex) => {
    			_.forIn(rowValue, (value, colName) => {

    				if(value == null || this.spec_exclude.includes(colName)) {
    					return
    				}

    				if(_.startsWith(colName, "spec")) {

    					if(argKeyMItemDisplay.includes(colName) || argKeySpecSelected.includes(colName)) {
    						return
    					}

    					if(objTmp.specs.hasOwnProperty(colName) === false) {
    						objTmp.specs[colName] = {
    							active: "",
    							data: []
    						}
    					}

    					if(!objTmp.specs[colName].data.includes(value)) {
    						objTmp.specs[colName].data.push(value);
    					}

    					if(this.list_spec.indexOf(value) == -1) {
    						this.list_spec.push(value);
    					}
    				}
    			})

    			//SIZE
				if(objTmp.width.indexOf(rowValue.width) == -1 && rowValue.width != null) {
					objTmp.width.push(rowValue.width);
				}

				if(objTmp.height.indexOf(rowValue.height) == -1 && rowValue.height != null) {
					objTmp.height.push(rowValue.height);
				}
    		})


    		let data_filter_option_handle = []
    		_.forEach(this.data_query.option_handle_giesta, (value, key) => {
    			let push_flg = true
    			_.forEach(this.spec_selected, (specCode, specValue) => {
    				if(value[specCode] != null && value[specCode] != specValue) {
    					push_flg = false
    				}
    			})

    			if(push_flg == true) {
    				if(this.handle_active == null) {
	    				data_filter_option_handle.push(value)
	    			} else if(this.handle_active == value.option4) {
    					data_filter_option_handle.push(value)
	    			}
    			}
    		})

    		// console.log(data_filter_option_handle)

    		_.forEach(data_filter_option_handle, (rowValue, rowIndex) => {

    			if(rowValue.option4 == null) {
    				return
    			}

				if(objTmp.options.hasOwnProperty('option4') === false) {
					objTmp.options['option4'] = {}
				}

				if(!_.keys(objTmp.options['option4']).includes(rowValue.option4)) {
					objTmp.options['option4'][rowValue.option4] = {
						name: rowValue.option4_display,
						spec55: rowValue.spec55,
						option4: rowValue.option4
					}
				}

				//Color
				if(objTmp.colors_handle.hasOwnProperty(rowValue.m_color_id) === false) {
					if(rowValue.color_name == 'No Color') {
						this.featured_img = rowValue.img_path_result + '/' + rowValue.img_name_result
					} else {
						objTmp.colors_handle[rowValue.m_color_id] = {
							'm_color_id'            : rowValue.m_color_id,
							'color_name'            : rowValue.color_name,
							'color_code_price'      : rowValue.color_code_price,
							'img_path' : rowValue.color_handle_img_path,
							'img_name' : rowValue.color_handle_img_name,
						};
					}
				}
    		})

    		//Remove spec trong spec_exclude
			_.each(this.spec_exclude, (value) => {
				_.unset(objTmp.specs, value)
			})

			//Chọn sẵn spec nếu chỉ có 1 value
			if(_.keys(objTmp.specs).length > 0 ) {

				objTmp.specs = this.sortSpec(objTmp.specs)

				let
					argKeyObjTmpSpecs = _.keys(objTmp.specs),
					firstKey          = argKeyObjTmpSpecs[0],
					firstObj          = objTmp.specs[firstKey]

				if(firstObj.data.length == 1) {

					let copyObjTmpSpecs = objTmp.specs

					_.each(copyObjTmpSpecs,(_value, _specCode) => {

						this.$set(this.specs.select, _specCode, _value)

						_.unset(objTmp.specs, _specCode)

						if(_value.data.length == 1) {
							this.$set(this.spec_selected, _specCode, _value.data[0])
						} else {
							return false
						}

					})
				} else {
					this.$set(this.specs.select, firstKey, firstObj)
					_.unset(objTmp.specs, firstKey)
				}
			}

			if(objTmp.width.length >0) {
				objTmp.width.sort(function(a, b){return a - b});
			}

			if(objTmp.height.length >0) {
				objTmp.height.sort(function(a, b){return a - b});
			}

			this.size.data_width  = objTmp.width
			this.size.data_height = objTmp.height
			this.size.width = null
			this.size.height = null
			this.specs.disable = objTmp.specs
			if(_.keys(this.spec_selected).includes('spec55') == false) {
				this.handler_type = objTmp.options
			}
             
			this.colors_handle.data = objTmp.colors_handle
			this.colors_handle.id = null
			this.validateShow()
	    	// console.timeEnd('fetchDataSelected')
        },

        async fetchDataSelectedColor () {
        	let
    			objFind= {},
    			objTmp = {
    				specs: {},
	    			options: {},
	    			widths: [],
	    			heights: [],
	    			mItemDisplay: {},
	    			colors_handle: {},
	    			spec51: {}
    			},
                selectedColor = this.colors[this.color_id], 
	    		argKeyMItemDisplay = _.keys(this.itemDisplay)
                
            if (selectedColor && selectedColor.hasOwnProperty("data_options")) {
                this.data_options = this.colors[this.color_id]["data_options"]
            } else {
                await this.getOptions(this.color_id)
            }
    		_.forEach(_.filter(this.data_options, {m_color_id: this.color_id}), (rowValue, rowIndex) => {

    			_.forIn(rowValue, (value, colName) => {

    				if(value == null) {
    					return;
    				}

    				if(_.startsWith(colName, "spec")) {

    					if(argKeyMItemDisplay.includes(colName)) {
    						return
    					}

    					if(objTmp.specs.hasOwnProperty(colName) === false) {
    						objTmp.specs[colName] = {
    							active: "",
    							data: []
    						}
    					}

    					if(!objTmp.specs[colName].data.includes(value)) {
    						objTmp.specs[colName].data.push(value);
    						if(colName == 'spec51') {
    							objTmp.spec51[value] = {
	    							path: rowValue.img_path_spec51,
	    							name: rowValue.img_name_spec51
	    						}
    						}
    					}
    				}
    			});

    			//SIZE
				if(objTmp.widths.indexOf(rowValue.width) == -1 && rowValue.width != null) {
					objTmp.widths.push(rowValue.width);
				}

				if(objTmp.heights.indexOf(rowValue.height) == -1 && rowValue.height != null) {
					objTmp.heights.push(rowValue.height);
				}

    		})

    		_.forEach(this.data_query.option_handle_giesta, (rowValue, rowIndex) => {

    			if(rowValue.option4 == null) {
    				return
    			}

				if(objTmp.options.hasOwnProperty('option4') === false) {
					objTmp.options['option4'] = {}
				}

				if(!_.keys(objTmp.options['option4']).includes(rowValue.option4)) {
					objTmp.options['option4'][rowValue.option4] = {
						name: rowValue.option4_display,
						spec55: rowValue.spec55,
						option4: rowValue.option4
					}
				}

				//Color
				if(objTmp.colors_handle.hasOwnProperty(rowValue.m_color_id) === false) {
					if(rowValue.color_name == 'No Color') {
						this.featured_img = rowValue.img_path_result + '/' + rowValue.img_name_result
					} else {
						objTmp.colors_handle[rowValue.m_color_id] = {
							'm_color_id'            : rowValue.m_color_id,
							'color_name'            : rowValue.color_name,
							'color_code_price'      : rowValue.color_code_price,
							'img_path' : rowValue.color_handle_img_path,
							'img_name' : rowValue.color_handle_img_name,
						};
					}
				}
    		})

			if(objTmp.widths.length >0) {
				objTmp.widths.sort(function(a, b){return a - b})
			}

			if(objTmp.heights.length >0) {
				objTmp.heights.sort(function(a, b){return a - b})
			}


			//Remove spec trong spec_exclude
			_.each(this.spec_exclude, (value) => {
				_.unset(objTmp.specs, value)
			})

			//Chọn sẵn spec nếu chỉ có 1 value
			if(_.keys(objTmp.specs).length > 0 ) {

				objTmp.specs = this.sortSpec(objTmp.specs)

				let
					argKeyObjTmpSpecs = _.keys(objTmp.specs),
					firstKey          = argKeyObjTmpSpecs[0],
					firstObj          = objTmp.specs[firstKey]

				if(firstObj.data.length == 1) {

					let copyObjTmpSpecs = objTmp.specs

					_.each(copyObjTmpSpecs,(_value, _specCode) => {

						this.$set(this.specs.select, _specCode, _value)

						_.unset(objTmp.specs, _specCode)

						if(_value.data.length == 1) {
							this.$set(this.spec_selected, _specCode, _value.data[0])
						} else {
							return false
						}

					})
				} else {
					this.$set(this.specs.select, firstKey, firstObj)
					_.unset(objTmp.specs, firstKey)
				}
			}

			this.specs.disable      = objTmp.specs
			this.handler_type       = objTmp.options
			this.colors_handle.data = objTmp.colors_handle
			this.spec51_img         = objTmp.spec51

			this.size.data_width  = objTmp.widths
			this.size.data_height = objTmp.heights
			this.validateShow()
        },

        selectProduct (product_id, product_name) {
            this.product_id = product_id;
            this.product_name = product_name;
        },

        selectProductProcess2 (product_id, product_name, spec1, spec1_name) {
            this.product_id   = product_id;
            this.product_name = product_name;
            this.spec1        = spec1;
            this.spec1_name   = spec1_name;
        },

        selectModels (m_model_id, m_color_id_default) {
            this.model_id = m_model_id
            this.m_color_id_default = m_color_id_default
            this.initModel()
            this.getOptions()
        },

        async selectColor (key) {
        	let color_obj       = this.colors[key],
        		color_id        = color_obj.m_color_id,
        		color_name      = color_obj.color_name,
        		color_code      = color_obj.color_code_price,
        		img_name_result = color_obj.img_name_result,
        		img_path_result = color_obj.img_path_result


        	this.color_id     = color_id
        	this.color_name   = color_name
        	this.color_code   = color_code
        	this.featured_img = img_path_result + '/' + img_name_result
        	this.featured_img_spec51 = null

			this.spec_selected = {}
			this.specs.select = {}
			await this.fetchDataSelectedColor()

        	this.validateShow()
        },

        selectHeightOnChange (event) {
        	let size = event.target.value

        	if(size == 'null') {//TH bỏ chọn
    			this.size.height  = null
        	} else {
        		this.size.height = size
        	}

        	this.validateShow()
        },

        selectWidthOnChange (event) {
        	let size = event.target.value,
        		argDataHeight  = [],
        		objOptions = {}

        	if(size == 'null') {//TH bỏ chọn
    			this.size.width  = null
        	} else {
        		this.size.width = size
        	}

        	//Reset select data
        	this.size.height = null

    		_.forEach(_.filter(this.data_options, this.buildQuery()), rowValue => {
        		if(rowValue.height != null) {
        			argDataHeight.push(rowValue.height)
        		}
        	})

        	argDataHeight = _.uniq(argDataHeight)
    		argDataHeight.sort(function(a, b){
    			return a - b
    		});
    		this.size.data_height = argDataHeight
        	this.validateShow()
        },

        async selectSpec (specCode, specValue, option4) {
            //console.log(specCode)
            //console.log(specValue)
            if(specCode == 'spec51' && this.model_id == 65) {
                return;
            }

        	let
        		argKeySpecSelected = _.keys(this.spec_selected),
        		objSpecKey = this.specs.select,
        		boolStartRemove = false

        	this.$set(this.spec_selected, specCode, specValue)
        	//Get featured img spec51
        	if(specCode == 'spec51') {
        		this.featured_img_spec51 = '/tostem/img/data/' + this.spec51_img[specValue].path + '/' + this.spec51_img[specValue].name
        	}

        	if(argKeySpecSelected.includes(specCode)) {//đã chứa spec_code đó rồi
        		//xóa các specCode tiếp theo khi chọn lại
        		_.forIn(objSpecKey, (_specValue, _specCode) => {

        			if(boolStartRemove == true) {
        				this.$delete(this.specs.select, _specCode)
        				this.$delete(this.spec_selected, _specCode)

        				if(_specCode == 'spec51') {
        					this.featured_img_spec51 = null
        				} else if(_specCode == 'spec55') {
							this.handle_active = null
						}
        			}

        			if(_specCode == specCode) {
        				boolStartRemove = true
        			}

        		})//End _.forIn
        	}

        	this.size.width = null
        	this.size.height = null

        	if(specCode == 'spec55') {
        		this.handle_active = option4
        		//filter lại color handle
        	}

			this.fetchDataSelected()
			//Xoá spec57 đi
        	this.$delete(this.specs.select, 'spec57')
			this.$delete(this.spec_selected, 'spec57')
			this.getSidePanel(specCode, specValue)
        	if(!argKeySpecSelected.includes('spec55') && specCode != 'spec55') {
	        	this.getHandleType()
        	}

        	this.validateShow()
        },

        async selectSpecOnchange (event) {

        	let specValue = event.target.value,
        		specCode = event.target.getAttribute('data-spec-code'),
        		argKeySpecSelected = _.keys(this.spec_selected),
        		boolStartRemove = false

        	if(specValue != '') {
        		this.$set(this.spec_selected, specCode, specValue)
        		//Get featured img spec51
	        	if(specCode == 'spec51') {
	        		this.featured_img_spec51 = '/tostem/img/data/' + this.spec51_img[specValue].path + '/' + this.spec51_img[specValue].name
	        	}
        	} else {
        		this.$delete(this.spec_selected, specCode)
        		if(specCode == 'spec51') {
					this.featured_img_spec51 = null
				}
        	}

        	if(argKeySpecSelected.includes(specCode)) {//đã chứa spec_code đó rồi
        		//xóa các specCode tiếp theo khi chọn lại
        		_.forIn(this.specs.select, (_specValue, _specCode) => {

        			if(boolStartRemove == true) {
        				this.$delete(this.specs.select, _specCode)
        				this.$delete(this.spec_selected, _specCode)

        				if(_specCode == 'spec51') {
							this.featured_img_spec51 = null
						} else if(_specCode == 'spec55') {
							this.handle_active = null
						}
        			}

        			if(_specCode == specCode) {
        				boolStartRemove = true
        			}

        		})//End _.forIn
        	}

        	this.size.width = null
        	this.size.height = null


        	if(specCode == 'spec55') {
        		if(event.target.options.selectedIndex > -1) {
	        		this.handle_active = event.target.options[event.target.options.selectedIndex].getAttribute('option4')
	        	}
        	}

        	this.fetchDataSelected()
        	//Xoá spec57 đi
        	this.$delete(this.specs.select, 'spec57')
			this.$delete(this.spec_selected, 'spec57')
        	this.getSidePanel(specCode, specValue)
        	if(!argKeySpecSelected.includes('spec55') && specCode != 'spec55') {
	        	this.getHandleType()
        	}

        	//TODO: khi chọn spec55 chưa set handle_active(do select nên ko cần set active)

        	this.validateShow()
        },

        /**
         * Select Side panel
         */
        selectSpec57 (specValue) {
        	this.$set(this.spec_selected, 'spec57', specValue)
        	this.validateShow()
        },

        selectSpec57Onchange () {
        	let specValue = event.target.value
        	if(specValue != '') {
        		this.$set(this.spec_selected, 'spec57', specValue)
        	} else {
        		this.$delete(this.spec_selected, 'spec57')
        	}
        	this.validateShow()
        },

        selectHiddenData() {

    		axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_giesta_hidden_data', {
                specs           : this.spec_selected,
                width           : this.size.width,
                ctg_id          : this.ctg_id,
                height          : this.size.height,
                product_id      : this.product_id,
                m_color_id      : this.color_id,
                m_model_id      : this.model_id,
                handle_color_id : this.colors_handle.id
            }).then(response => {
			    let amount = 0
			    this.data_query.hidden_option = response.data
				_.each(response.data, (data, type) => {
					_.each(data, function (row) {
	    				amount += parseFloat(row.amount)
	    			})
				})
				console.log('total hidden amount: ' + amount)
	        	this.total_price += amount
	        }).catch(error => {
	        	if (error.response.status == 401) {
		        	this.tokenMismatch()
		        }
	        })
        },

        selectColorHandle (m_color_id, color_name) {
        	this.colors_handle.id = m_color_id
        	this.colors_handle.name = color_name
        	this.validateShow()
        },

        /**
         * Add to cart
         */
		async add__cart () {

			if(lang == 'en') {
				var cart_uri = _base_app + '/cart'
			} else {
				var cart_uri = _base_app + '/' + lang + '/cart'
			}

			let lang = this.lang,
				description = await this.getDescriptionCart()

			if(this.colors_handle.id != null) {
				this.$set(this.data_query.hidden_option, 'option_handle', _.filter(this.data_query.option_handle_giesta, {m_color_id: this.colors_handle.id, option4: this.handle_active}))
			} else {
				this.$set(this.data_query.hidden_option, 'option_handle', this.data_query.option_handle_giesta)
			}

			if(this.data_query.side_panel.length > 0) {
				let side_panel_query = {
					width: this.size.width,
					height: this.size.height,
				}

				_.forEach(this.spec_selected, (value, key) => {
					if(key != 'spec52') {
						side_panel_query[key] = value
					}
				})

				this.$set(this.data_query.hidden_option, 'side_panel', _.filter(this.data_query.side_panel, side_panel_query))
			} else {
				this.$set(this.data_query.hidden_option, 'side_panel', [])
			}

			axios.post(_base_app + '/' + lang + '/cart/add-to-cart', {

				ctg_id            : this.ctg_id,
				product_id        : this.product_id,
				spec1             : this.spec1,
				model_id          : this.model_id,
				option_selected   : this.option_selected,
				spec_selected     : this.spec_selected,
				height_selected   : this.formatNumber(this.size.height),
				width_selected    : this.formatNumber(this.size.width),
				color_id          : this.color_id,
				featured_img      : this.featured_img,
				display_pitch_list: this.display_pitch_list,
				[lang]: {
					product_name          : this.product_name,
					spec1_name            : this.spec1_name,
					model                 : _.find(this.models, ['m_model_id', this.model_id]),
					color_name            : this.color_name,
					color_code            : this.color_code,
					spec_selected         : this.spec_selected,
					option_selected       : this.option_selected,
					data_options_selected : this.data_options_result,
					celling_code_option   : this.data_query.celling_code_option,
					hidden_option         : this.data_query.hidden_option,
					description           : description
				}

			}).then(response => {
				this.getCartContentCount()
				this.alert(lang_text.added_to_cart)
			}).catch(error => {
				console.log(error.response);
				if (error.response.status == 401) {
					this.tokenMismatch()
				}
			});

		},

		/**
		 * Scroll to add to cart sau khi chọn model
		 */
        scrollToAddToCart() {
        	setTimeout(function() {
        		$('html, body').animate({
	        		scrollTop: $("#line").offset().top - 187
	        	}, 1500);
        	}, 1000);
        },

        /**
         * Format number cho size
         */
        formatNumber(item) {
        	if(item != null) {
				return item.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			} else{
				return item;
			}
        },

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
							window.location.href = _base_app
						}
					},
				]
			})
        },

        getSpecImage (spec, label) {
	    	return '<img src="/tostem/img/data/' + this.spec_image[spec] + '" /><span> ' + label + '</span>'
	    }
    }
});

