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
var $exterior_ctg = 2;
var $slickOptions = {
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
	}]
}

/*
|--------------------------------------------------------------------------
| Vue setting
|--------------------------------------------------------------------------
*/
//Vue.config.devtools = true
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
let cImageDescription = Vue.component('image-description', require('./components/cImageDescrition.vue').default)
app = new Vue({
    el: '#page',
    components: {
    	Slick,
    	'image-description': cImageDescription
    },
    data() {
		const queryString = window.location.search;
		const urlParams = new URLSearchParams(queryString);
		let pid = null;
		let mid = null;
		let pc = 0;
		if (urlParams.has('pid')) {
			pid = urlParams.get('pid');
			pc += 1;
		}
		if (urlParams.has('mid')) {
			mid = urlParams.get('mid');
			pc += 1;
		}
        return {
        	ctg_id : ctg_id,
            slug_name : slug_name,
			lang: lang,
            products : [],
            product_id: pid,
            product_name : null,

            spec1: null,
            spec1_name: null,

            models : [],
            model_id: mid,
			param_cnt: pc,
            m_color_id_default: null,

            featured_img: null,

            colors: {},
            color_id: null,
            color_name: null,
            color_code: null,

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

            options: {},//use to foreach option of spec
            list_spec: [],//list spec and option in  data_option
            list_spec_trans: [],//list spec and option name
			list_spec_order: [],
			spec_code_order: {},
            option_code_order: {},
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
            	config_fence_quantity: []
            },
            data_options_result : [],//last data options
            spec29_special: false,

            is_fence: false,
            fence : {
            	f0: null //size input
            	//f1: dup number
            	//f2: size/f1
            },
            gate_pole_available: false,
            spec10_description_rule: false, //display description for spec10 model casement window
            folding_door_image_manual_description: false, //display description for folding door image description
            config_stack_number: {},
            config_picture_show_r_movement: false,
            configDisplayImageDescription: [],
            configAlwayDisplaySpecItem: [],
            configRuleCompareItemSpec: [],
            configCloneOptionAtProudct: [],//Add edit BP_O2OQ-14 - Hunglm - 021220
            sizeLimit: {},
            max_decimal: 0, //Add BP_O2OQ-7 hainp 20200714
            sub_menus: [], //Add BP_O2OQ-25 antran 20200622
            color_exclude: {},//Add task BP_O2OQ-29 antran 20211102
            check_add_gapcover: false//Add task BP_O2OQ-29 antran 20211102
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

	    checkDisabledOption () {
	    	let result = false

	    	if(this.size.data_height.length > 0 && this.size.height == null) {
	    		result = true
		    } else if(this.size.data_width.length > 0 && this.size.width == null) {
		    	result = true
		    }

		    return result
	    },

	    getImageResultPath () {
	    	return '/tostem/img/data/' + this.featured_img;
	    }
    },
    watch: {
    	product_id () {
	        this.initProduct()
	        this.getSizeLimit() //hiện tại chỉ xài cho hanging door (product_id 9)
	        if(ctg_id != $exterior_ctg) {
	        	this.getModels(this.product_id);
	        }
    	},

    	spec1 () {
	        this.initProduct();
            this.getModels(this.product_id, this.spec1);
    	},

	    colors () {
	    	let keys = _.keys(this.colors)

	    	if(keys.length == 1) {
	    		this.selectColor(keys[0])
	    	} else if(keys.length > 1) {
	    		_.each(this.colors, (value, index) => {
	    			if(value.m_color_id == this.m_color_id_default ) {
	    				this.selectColor(index)
	    				return false
	    			}
	    		})
	    	}
	    }
    },
    methods: {
    	next () {
            this.$refs.slick.next();
        },

        prev () {
            this.$refs.slick.prev();
        },

        reInitSlider() {
            // Helpful if you have to deal with v-for to update dynamic lists
            let currIndex = 0;
            // currIndex = this.$refs.carousel.currentSlide()
	        this.$refs.carousel.destroy()
	        this.$nextTick(() => {
		        this.$refs.carousel.create()
		        _.forEach(this.models, (rowValue, rowIndex) => {
					if (rowValue.m_model_id == this.model_id) {
						this.$refs.carousel.goTo(rowIndex, true);
                        this.selectModels(this.model_id, rowValue.m_color_id_default);
					}
				})
	        })
        },

        log (log) {
        	console.log(this.$data[log]);
        },

        async created () {
        	await this.getProduct()
	    	// this.getDataSellingSpec()
	    	this.getCartContentCount()
	    	this.getConfigAlwayDisplaySpecItem()
	    	this.getConfigRuleCompareItemSpec()
            this.getSubMenu()
        },

		/**
		 * Check show amount & add_to_cart
		 */
	    async validateShow () {

	    	let check = () => {

	    		if(_.keys(this.specs.key).length> 0 && _.keys(this.spec_selected).length != _.keys(this.specs.key).length) {
		    		return false
		    	}

		    	if(_.keys(this.options).length > 0 && _.keys(this.option_selected).length != _.keys(this.options).length) {
		    		return false
		    	}

		    	if(_.keys(this.colors).length > 0 && this.color_id == null) {
		    		return false
		    	}

		    	if(this.size.data_width.length > 0 && this.size.width == null) {
		    		return false
		    	}

		    	if(this.size.data_height.length > 0 && this.size.height == null) {
		    		return false
		    	} else if(this.is_fence == true && this.size.data_height.length == 0) {
		    		return false
		    	}

		    	return true
	    	}

	    	if(check()) {

	    		_loading.css('display', 'block')

	        	this.total_price = 0


	        	let data_options_result = [],
	        		argDataOptionResult = []

	        	if(this.ctg_id == 2) {
	        		_.forEach(this.filterData(['height', 'width']), rowValue => {
		        		if((rowValue.width == null || rowValue.width == this.size.width) && (rowValue.height == null || rowValue.height == this.size.height)) {
		        			data_options_result.push(rowValue)
		        		}
		        	})

	        	} else {
        			data_options_result = _.filter(this.filterData())
	        	}

	        	if(data_options_result.length == 1) {
	        		if(data_options_result[0].img_name_spec29 != null) {
	        			this.featured_img = data_options_result[0].img_path_spec29 + '/' + data_options_result[0].img_name_spec29
	        		}
	        	}

	        	_.each(data_options_result, (row) => {

	        		//Add edit start BP_O2OQ-14 - Hunglm - 021220 (Dup row for hanging door)
	        		if (this.configCloneOptionAtProudct.length > 0) {
	        			let conditionClone = _.filter(this.configCloneOptionAtProudct, { 'def_value2': row.spec33, 'def_value3': row.spec35 })
	        			if (conditionClone.length) {
	        				//Chỉ dup nếu define > 1 (sau khi dup các rule khác xử lý bình thường)
	        				if (conditionClone[0].def_value4 > 1) {
	        					for (let i = 1; i < conditionClone[0].def_value4; i++) {
			        				if(row.amount != null) {
					    				this.total_price += parseFloat(row.amount)
					    			}
					        		argDataOptionResult.push(row)
					        	}
	        				}
	        			}
	        		}
	        		//Add edit end BP_O2OQ-14

	    			if(row.stack_number == null) {
		    			if(this.is_fence == true && row.fence_type == 'PANEL') {
			    			for(let i = 1; i <= this.fence["f1"]; i++) {
			    				if(row.amount != null) {
				    				this.total_price += parseFloat(row.amount)
				    			}
				        		argDataOptionResult.push(row)
				        	}
				        } else {

			    			let config_fence_quantity_rule = false
			    			if (this.data_query.config_fence_quantity.length > 0) {
			    				//Kiểm tra selling code có match với data cofig_fence_quantity?
			    				var filter_match_selling_code = _.find(this.data_query.config_fence_quantity, {selling_code: row.selling_code})
			    				if (typeof(filter_match_selling_code) != 'undefined') {

			    					if(this.fence['f1'] >= filter_match_selling_code.compare_value) {
			    						config_fence_quantity_rule = true
			    					}
			    				}
			    			}

			    			if ( config_fence_quantity_rule == true ) {

			    				let dup_number = parseInt(this.fence["f1"]) + parseInt(filter_match_selling_code.add_qty)
			    				for ( let i = 1; i <= dup_number; i++ ) {
			    					argDataOptionResult.push(row)
				    				if (row.amount != null) {
					    				this.total_price += parseFloat(row.amount)
					    			}
	    						}

			    			} else {

			    				argDataOptionResult.push(row)
			    				if (row.amount != null) {
				    				this.total_price += parseFloat(row.amount)
				    			}
			    			}
				        }

	    			} else {

	    				row.amount = 0

	    				axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_cornerfix_amount', {
			        		selling_code : row.selling_code,
			        		width        : row.width,
							height       : row.stack_height

			        	}).then(response => {
			        		_.each(response.data, (value) => {
				        		this.total_price += parseFloat(value.amount)
			        			row.amount = value.amount
				        	})
			        	}).catch(error => {
			        		if (error.response.status == 401) {
				        		this.tokenMismatch()
				        	}
			        	})

			        	argDataOptionResult.push(row)
		    		}
		    	})

		    	//<GET_CONFIG_STACK_NUMBER_DISPLAY>
		    	await axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_config_stack_number', {
		    		m_model_id: this.model_id
		    	}).then(response => {
		    		if(response.data != 0) {
		    			this.config_stack_number = response.data
						if (response.data.spec_value == "" && (response.data.product_id == "" || response.data.product_id == this.product_id)) { //Dup row ko cần thoả đk spec
							_.each(data_options_result, (row) => {
								for (let i = 1; i < response.data.stack_number; i++) {
									this.total_price += parseFloat(row.amount)
									argDataOptionResult.push(row)
								}
							})
						} else {
							let specCode = 'spec' + response.data.spec_value.replace(/\.+[0-9]+/, '')
							_.each(data_options_result, (row) => {
								if (row[specCode] == response.data.spec_value && (response.data.product_id == "" || response.data.product_id == this.product_id)) {
									for (let i = 1; i < response.data.stack_number; i++) {
										this.total_price += parseFloat(row.amount)
										argDataOptionResult.push(row)
									}
								}
							})
						}
		    		}
		    	})
		    	//</GET_CONFIG_STACK_NUMBER_DISPLAY>

		    	//Order by order no
		    	argDataOptionResult = _.orderBy(argDataOptionResult, ['order_no'])
		    	this.data_options_result = argDataOptionResult

		    	if(this.data_options_result.length > 0) {
		    		let celling_code_option_amount = await this.getCellingCodeOption()
		        	this.total_price += celling_code_option_amount
		        	this.show_total_price = true
		    		this.add_to_cart      = true
		    	}

	    		_loading.css('display', 'none')

	    	} else {
	    		this.show_total_price = false
	    		this.add_to_cart      = false
	    	}
	    },

        initProduct () {
            this.models = []
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

            this.spec29_special = false
            this.is_fence = false
            this.fence = {
            	f0: null
            },
            this.gate_pole_available = false
            this.spec10_description_rule = false
            this.folding_door_image_manual_description = false
            this.config_stack_number = {}
            this.configDisplayImageDescription = []
        },

        buildQuery (exclude = []) {

	    	let all_value_selected = {},
	    		keySelected = _.without(['spec', 'option', 'color', 'width', 'height'], ...exclude, ...this.spec_exclude)

	    	_.forIn(keySelected, (value) => {
	    		switch (value) {
	    			case 'spec':
	    				if(_.keys(this.spec_selected).length > 0) {
			        		_.each(this.spec_selected, (value, key) => {
			        			all_value_selected[key] = value
			        		})
			        	}

			        	if(_.keys(this.itemDisplay).length > 0) {
			        		_.each(this.itemDisplay, (value, key) => {
			        			if(!['spec3', 'spec5'].includes(key)) {
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

        sortOption (objSpec) {
        	let sortable = [],
        		objSorted = {}

            _.each(objSpec, (_value, _specCode) => {

                _value.sort((a, b) => {
                    return this.list_spec_order[a] - this.list_spec_order[b]
                })

                sortable.push([_specCode, _value])
            })

            sortable.sort((a, b) => {
                return this.option_code_order[a[0]] - this.option_code_order[b[0]]
            });

            _.each(sortable, (item) => {
                objSorted[item[0]] = item[1]
            })

            return objSorted
        },

        getSizeLimit () {
        	axios.get(`${_base_app}/get-size-limit/${this.product_id}`)
        		.then(response => {
        			this.sizeLimit = response.data
        		})
        },

        getProduct () {
        	_loading.css('display', 'block');
    		axios.get(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/list')
        		.then(response => {
				    this.products = response.data;
				    if(response.data.length == 1) {
				    	let product = response.data[0]
				    	this.selectProduct(product.product_id, product.product_name)
				    } else if (this.product_id != null) {
						let selectedProducts = this.products.filter(x => x.product_id == this.product_id)
						if (selectedProducts.length > 0) {
							let product = selectedProducts[0]
                            //if(this.ctg_id != $exterior_ctg) {
							this.selectProduct(product.product_id, product.product_name)
							this.getModels(this.product_id);
                            //}
						}
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

    	getModelSpec () {
        	return this.queryModelSpec().then(response => {
        		return response.data
        	}).catch(error => {
        		if (error.response.status == 401) {
	        		this.tokenMismatch()
	        	}
        	})
        },

        getMItemDisplay () {
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
        	await this.querySpecTrans().then(response => {
            	this.list_spec_trans = response.data.list_spec_trans
				this.list_spec_order = response.data.list_spec
				this.spec_code_order = response.data.spec_code_order
                this.option_code_order = response.data.option_code_order
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
                    let target = this.models.filter(x => x.m_model_id == this.model_id)
                    if (this.ctg_id == $exterior_ctg && target.length>0) {
                        this.models = this.models.filter(x => x.spec1 == target[0].spec1)
                    }
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
		    	this.mItemDisplay = data.m_item_display
		    	this.is_fence     = data.is_fence
		    	this.config_picture_show_r_movement = data.config_picture_show_r_movement
		    	this.spec10_description_rule = data.spec10_description_rule
                this.color_exclude = data.color_exclude//Add task BP_O2OQ-29 antran 20211102
                this.check_add_gapcover = data.check_add_gapcover//Add task BP_O2OQ-29 antran 20211102

		    	if (data.folding_door_image_manual == true) {
		    		this.folding_door_image_manual_description = true
		    	}

		    	if (data.is_fence == true) {
		    		this.data_query.config_fence_quantity = data.config_fence_quantity
		    	}

				this.max_decimal = data.max_decimal //Add BP_O2OQ-7 hainp 20200714

                //Start  BP_O2OQ-27_new antran 20210913
                //filter data option with spec display of product_id=10 (Window series - ATIS)
                if (this.isAtis()) {
                    let spec_display = {};
                    _.forEach(this.mItemDisplay, (rowValue, rowIndex) => {
                        _.forIn(rowValue, (value, colName) => {
                            if(value == null) {
                                return;
                            }

                            if(_.startsWith(colName, "spec")) {
                                spec_display[colName] = value;
                            }
                        })
                    })

                    data.option = _.filter(data.option, spec_display);
                }
                //End BP_O2OQ-27_new antran 20210913

                this.data_options = Object.freeze(data.option)
		    	await this.fetchAllData();
	            this.scrollToAddToCart()
        	} else {
        		this.$modal.show('dialog', {
					text: lang_text.option_not_found,
					buttons: [
						{
							title: lang_text.ok,
							default: true,// Will be triggered by default if 'Enter' pressed.
						},
					]
				})
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
                    //Start O2OQ-27_new antran 20210913
                    //handle duplicate label Movement in description, show all Movement on cart.
                    if (typeof(key) == 'string' && key.trim().toLowerCase() == 'movement') {
                        let _count_break = 0;
                        while (typeof(description[key]) != 'undefined') {
                            key += ' ';
                            if (++_count_break == 100) {
                                break;
                            }
                        }
                    }
                    //End O2OQ-27_new antran 20210913

                    description[key] = lstTrans[value];
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

                //Add task BP_O2OQ-29 antran 20211102
                //o10: Chain length, o9: Limit arm
                if (
                    _.includes(['o10.1','o10.2', 'o9.1'], value) &&
                    typeof(lstTrans[value+'_transform']) != 'undefined'
                ) {
                    description[key] = lstTrans[value+'_transform']
                }
                //End task BP_O2OQ-29 antran 20211102
			})

			if(lstUndefined.length > 0) {
                description['undefined'] = lstUndefined
			}

			return description
        },

        getSpecLabel (specCode, type = 'spec') {
        	let
        		replace = (type == 'option') ? 'o' : '',
        		label = this.group_label[specCode.replace(type, replace)]

        	if(label != null) {
        		return label
        	}

        	return 'Label not found'
        },

        async getCellingCodeOption () {
        	let celling_code_option_amount = 0

        	//NOTE: chỗ này sai ở chỗ đã update lại
        	if(_.keys(this.itemDisplay).includes('spec3')) {
        		this.itemDisplay['spec3'] = this.data_options_result[0].spec3
        	}

        	if(_.keys(this.itemDisplay).includes('spec5')) {
        		this.itemDisplay['spec5'] = this.data_options_result[0].spec5
        	}

        	await axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_celling_code_option', {
        		spec        : this.spec_selected,
        		width       : this.size.width,
				height      : this.size.height,
        		option      : this.option_selected,
				product_id  : this.product_id,
        		m_color_id  : this.color_id,
				m_model_id  : this.model_id,
				item_display: this.itemDisplay,
        	}).then(response => {

				let data = []

				//NOTE: Rule dup option(Rail)
					// 1) number_of_option = 1 hoặc NULL thì đều là giữ nguyên không dup option
					// 2) number_of_option = 0 thì xóa option đó luôn
					// 3) number_of_option >= 2 thì nhân bản option tương ứng

				_.each(response.data, (row) => {
					//1)
					if(row.number_of_option == 1 || row.number_of_option == null)
					{
						if (this.is_fence == true) {

							let config_fence_quantity_rule = false
			    			if (this.data_query.config_fence_quantity.length > 0) {
			    				//Kiểm tra selling code có match với data cofig_fence_quantity?
			    				var filter_match_selling_code = _.find(this.data_query.config_fence_quantity, {selling_code: row.selling_code})
			    				if (typeof(filter_match_selling_code) != 'undefined') {

			    					if(this.fence['f1'] >= filter_match_selling_code.compare_value) {
			    						config_fence_quantity_rule = true
			    					}
			    				}
			    			}

			    			if (config_fence_quantity_rule == true) {
			    				let dup_number = parseInt(this.fence["f1"]) + parseInt(filter_match_selling_code.add_qty)
			    				for ( let i = 1; i <= dup_number; i++ ) {
				    				celling_code_option_amount += parseFloat(row.amount)
					    			data.push(row)
	    						}
			    			} else {
			    				celling_code_option_amount += parseFloat(row.amount)
			    				data.push(row)
			    			}

						} else {

							if(_.keys(this.config_stack_number).length > 0) {
								if(_.startsWith(this.config_stack_number.spec_value, 'o')){
									let specCode =  this.config_stack_number.spec_value.replace(/o([0-9])+\.[0-9]+/, 'option$1')
									if ( this.option_selected[specCode] == this.config_stack_number.spec_value && (this.config_stack_number.product_id == "" || this.config_stack_number.product_id == this.product_id)) {
										for(let i = 1; i < this.config_stack_number.stack_number; i++) {
											celling_code_option_amount += parseFloat(row.amount)
											data.push(row)
										}
									}
								}
							}

							celling_code_option_amount += parseFloat(row.amount)
							data.push(row)
						}
					}
					//3)
					else if (row.number_of_option != 0) {
						for (let i = 1; i <= row.number_of_option; i++) {
							celling_code_option_amount += parseFloat(row.amount)
							data.push(row)
						}
					}
				})

				this.data_query.celling_code_option = data
			}).catch(error => {
				if (error.response.status == 401) {
					this.tokenMismatch()
				}
			})

        	return celling_code_option_amount
        },

        getConfigAlwayDisplaySpecItem () {
        	axios.get(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_config_alway_display_spec_item').then(response => {
        		this.configAlwayDisplaySpecItem = response.data
            })
        },

        getConfigRuleCompareItemSpec () {
        	axios.get(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_config_rule_compare_item_spec').then(response => {
        		this.configRuleCompareItemSpec = response.data
            })
        },

        //Add edit start BP_O2OQ-14 - Hunglm - 021220 (Dup row for hanging door)
        getConfigCloneOptionAtProduct () {
        	axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_config_clone_option_at_product', {
        		'product_id': this.product_id,
        		'model_id' : this.model_id
        	}).then(response => {
        		this.configCloneOptionAtProudct = response.data
            })
        },
        //Add edit start BP_O2OQ-14 - Hunglm - 021220 (Dup row for hanging door)

        queryOptions () {
        	_loading.css('display', 'block')
    		return axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_options', {
                product_id: this.product_id,
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

    	querySpecTrans () {
        	return axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_spec_stran', {
                list_spec : this.list_spec
            }).catch(error => {
            	if (error.response.status == 401) {
	            	this.tokenMismatch()
	            }
            })
        },

        queryModelSpec () {
        	return axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get_model_spec', {
				m_model_id: this.model_id
			}).catch(error => {
				if (error.response.status == 401) {
					this.tokenMismatch()
				}
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
        	//console.time('fetchAllData')

    		let
    			objFind= {},
    			objTmp = {
    				specs: {},
	    			options: {},
	    			widths: [],
	    			heights: [],
	    			colors: {},
	    			mItemDisplay: {}
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
		    					}

		    					if(this.list_spec.indexOf(value) == -1) {
		    						this.list_spec.push(value);
		    					}
    						}
    					}

    				} else if(_.startsWith(colName, "option")) {

    					if(objTmp.options.hasOwnProperty(colName) === false) {
                            objTmp.options[colName] = [];
    					}

                        if(!objTmp.options[colName].includes(value)) {
                            objTmp.options[colName].push(value);
    					}

    					if(this.list_spec.indexOf(value) == -1) {
    						this.list_spec.push(value);
    					}
    				}
    			});

    			//SIZE
                if(rowValue.exterior_panel_type == 'EXTERIOR_PANEL' || rowValue.exterior_panel_type == null) {
    				if(objTmp.widths.indexOf(rowValue.width) == -1 && rowValue.width != null) {
						objTmp.widths.push(rowValue.width);
					}

					if(objTmp.heights.indexOf(rowValue.height) == -1 && rowValue.height != null) {
						objTmp.heights.push(rowValue.height);
					}
    			}

				//Color
				if(objTmp.colors.hasOwnProperty(rowValue.m_color_id) === false) {
					if(rowValue.color_name == 'No Color') {
						this.featured_img = rowValue.img_path_result + '/' + rowValue.img_name_result
                    } else if (this.checkColorExclude(rowValue.m_color_id) == false) {
						objTmp.colors[rowValue.m_color_id] = {
							'm_color_id'       : rowValue.m_color_id,
							'color_name'       : rowValue.color_name,
							'color_code_price' : rowValue.color_code_price,
							'img_path'         : rowValue.img_path,
							'img_path_result'  : rowValue.img_path_result,
							'img_name'         : rowValue.img_name,
							'img_name_result'  : rowValue.img_name_result,
							'img_name_spec10'  : rowValue.img_name_spec10
						};
					}
				}

				if(rowValue.gate_type == 'GATE POLE') {
					this.gate_pole_available = true
				}
    		});

    		//Nếu list_spec có value => query lên db lấy [spec | option]_name và [spec | option]_group_name
    		if(this.list_spec.length >0 && _.keys(this.list_spec_trans).length == 0){
    			await this.getSpecTrans();
                
    		}

			if(objTmp.widths.length >0) {
				objTmp.widths.sort(function(a, b){return a - b});
			}

			if(objTmp.heights.length >0) {
				objTmp.heights.sort(function(a, b){return a - b});
			}

			//Remove spec trong spec_exclude
			_.each(this.spec_exclude, (value) => {
				_.unset(objTmp.specs, value)
				_.unset(objTmp.options, value)
			})

			//Chọn sẵn spec nếu chỉ có 1 value
			if(_.keys(objTmp.specs).length > 0 ) {

				objTmp.specs   = this.sortSpec(objTmp.specs)

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

			objTmp.options = this.sortOption(objTmp.options)
			this.specs.disable = objTmp.specs
			this.options = objTmp.options;
			this.colors = objTmp.colors;

			this.size.data_width  = objTmp.widths
			this.size.data_height = objTmp.heights
			this.size.width = null
			this.size.height = null
			this.itemDisplay = objTmp.mItemDisplay
			this.mItemDisplay = _.chain(this.mItemDisplay).groupBy('item_display_name').keys().value()
			this.validateShow()
        },

        buildQueryAcceptNull (exclude = []) {
        	let all_value_selected = {},
	    		keySelected = _.without(['spec', 'option', 'color', 'width', 'height'], ...exclude, ...this.spec_exclude)

	    	_.forIn(keySelected, (value) => {
	    		switch (value) {
	    			case 'spec':
	    				if(_.keys(this.spec_selected).length > 0) {
			        		_.each(this.spec_selected, (value, key) => {
			        			all_value_selected[key] = [value, null]
			        		})
			        	}

			        	if(_.keys(this.itemDisplay).length > 0) {
			        		_.each(this.itemDisplay, (value, key) => {
			        			if(!['spec3', 'spec5'].includes(key)) {
			        				all_value_selected[key] = [value]
			        			}
			        		})
			        	}
	    				break
	    			case 'option':
	    				if(_.keys(this.option_selected).length > 0) {
			        		_.each(this.option_selected, (value, key) => {
			        			all_value_selected[key] = [value]
			        		})
			        	}
	    				break
	    			case 'color':
	    				if(_.keys(this.colors).length > 0 && this.color_id != null) {
			        		all_value_selected['m_color_id'] = [this.color_id]
			        	}
	    				break
	    			case 'width':
		    			if(this.size.width != null) {
			        		all_value_selected['width'] = [this.size.width, null]
			        	}
	    				break
	    			case 'height':
	    				if(this.size.height != null) {
			        		all_value_selected['height'] = [this.size.height, null]
			        	}
	    				break
	    		}
	    	})

        	return all_value_selected
        },

        filterData (exclude = []) {
        	var data = []

        	if (this.configRuleCompareItemSpec.includes(this.product_id)) {

 				let filterBy = this.buildQueryAcceptNull(exclude)
				data = this.data_options.filter(function (row) {
			        return Object.keys(filterBy).every(function (k) {
			            return filterBy[k].some(function (f) {
			                return row[k] === f
			            })
			        })
			    })

        	} else {
        		data = _.filter(this.data_options, this.buildQuery())
        	}

        	return data
        },

        fetchDataSelected () {
        	// console.time('fetchDataSelected')

        	let data = this.filterData()
    		let argKeySpecSelected = _.keys(this.spec_selected)
    		let argKeyMItemDisplay = _.keys(this.itemDisplay)
        	let objTmp = {
    			specs: {},
    			options: {},
    			colors: {},
    			width: [],
    			height: [],
    		}

    		_.forEach(data, (rowValue, rowIndex) => {

    			if(rowValue.img_path_spec29 != null) {
					this.spec29_special = true
				}

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

    						if(colName == 'spec29' && this.spec29_special) {
    							objTmp.specs[colName]['img'] = {}
    						}
    					}

    					if(!objTmp.specs[colName].data.includes(value)) {
    						objTmp.specs[colName].data.push(value);
    					}

    					if(this.list_spec.indexOf(value) == -1) {
    						this.list_spec.push(value);
    					}

    					//Xử lý show hình ảnh cho spec29 (chỉ cho mullion và transom)
    					if(colName == 'spec29' && this.spec29_special) {
							objTmp.specs[colName]['img'][value] = [rowValue.img_path_spec29, rowValue.img_name_spec29]
						}

    				} else if(_.startsWith(colName, "option")) {

    					if(objTmp.options.hasOwnProperty(colName) === false) {
    						objTmp.options[colName] = [];
    					}

    					if(!objTmp.options[colName].includes(value)) {
    						objTmp.options[colName].push(value);
    					}

    					if(this.list_spec.indexOf(value) == -1) {
    						this.list_spec.push(value);
    					}
    				}
    			})

    			//SIZE
    			if(rowValue.exterior_panel_type == 'EXTERIOR_PANEL' || rowValue.exterior_panel_type == null) {
					if(objTmp.width.indexOf(rowValue.width) == -1 && rowValue.width != null) {
						objTmp.width.push(rowValue.width);
					}

					if(objTmp.height.indexOf(rowValue.height) == -1 && rowValue.height != null) {
						objTmp.height.push(rowValue.height);
					}
				}

				//Color
				if(objTmp.colors.hasOwnProperty(rowValue.m_color_id) === false) {
					if(rowValue.color_name == 'No Color') {
						this.featured_img = rowValue.img_path_result + '/' + rowValue.img_name_result
					} else if (this.checkColorExclude(rowValue.m_color_id) == false) {
						objTmp.colors[rowValue.m_color_id] = {
							'm_color_id'       : rowValue.m_color_id,
							'color_name'       : rowValue.color_name,
							'color_code_price' : rowValue.color_code_price,
							'img_path'         : rowValue.img_path,
							'img_path_result'  : rowValue.img_path_result,
							'img_name'         : rowValue.img_name,
							'img_name_result'  : rowValue.img_name_result,
						};
					}
				}
    		})

    		//Remove spec trong spec_exclude
			_.each(this.spec_exclude, (value) => {
				_.unset(objTmp.specs, value)
				_.unset(objTmp.options, value)
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

			if (Object.keys(this.spec_selected).includes('spec35')) {

				let sizeLimit = _.filter(this.sizeLimit, {'spec35': this.spec_selected.spec35, 'spec33': this.itemDisplay.spec33})
				let widths = []
				let heights = []

				_.forEach(objTmp.width , (value, key) => {
					if (parseInt(value) >= parseInt(sizeLimit[0].min_width) && parseInt(value) <= parseInt(sizeLimit[0].max_width)) {
						widths.push(value)
					}
				})
				objTmp.width = widths

				_.forEach(objTmp.height , (value, key) => {
					if (parseInt(value) >= parseInt(sizeLimit[0].min_height) && parseInt(value) <= parseInt(sizeLimit[0].max_height)) {
						heights.push(value)
					}
				})
				objTmp.height = heights
			}

			this.specs.disable    = objTmp.specs
			this.colors           = objTmp.colors
			this.size.data_width  = this.sortArray(objTmp.width)
			this.size.data_height = this.sortArray(objTmp.height)
			this.options          = this.sortOption(objTmp.options)
			this.size.width       = null
			this.size.height      = null

			this.validateShow()
	    	// console.timeEnd('fetchDataSelected')
        },

        sortArray (args) {
        	return args.sort((a, b) => {
        		return a - b
        	})
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
            this.configDisplayPitchList()
            this.getConfigCloneOptionAtProduct()//Add edit BP_O2OQ-14 - Hunglm - 021220
			history.pushState(
                {},
                null,
                location.pathname + "?mid=" + this.model_id + "&pid=" + this.product_id
            )
        },

        configDisplayPitchList () {
        	axios.post(_base_app + '/' + lang + '/quotation_system/'+slug_name+'/product/get-config-display-image-description', {
        		product_id: this.product_id,
        		model_id:   this.model_id
        	}).then(response => {
        		this.configDisplayImageDescription = response.data
        	})
        },

        selectColor (key) {
        	let color_obj       = this.colors[key],
        		color_id        = color_obj.m_color_id,
        		color_name      = color_obj.color_name,
        		color_code      = color_obj.color_code_price,
        		img_name_result = color_obj.img_name_result,
        		img_path_result = color_obj.img_path_result


        	this.color_id     = color_id
        	this.color_name   = color_name
        	this.color_code   = color_code

            //Add task BP_O2OQ-29 antran 20211102
            //22:Out-swing door (Single), 23:Out-swing door (Double), 70:Awning (Slit)
            if (this.isAtis() && _.includes(['22','23','70'], this.model_id)) {
                //option5: handle, opiton10:Chain Length
                _.each(this.list_spec_trans, (value, key) => {
                    if (_.includes(['o10.1','o10.2'], key)) {
                        this.list_spec_trans[key+'_transform'] = value + '('+color_code+')';
                    }
                    if (_.includes(['o5.1','o5.2'], key)) {
                        if (!this.list_spec_trans.hasOwnProperty(key+'_origin')) {
                            this.list_spec_trans[key+'_origin'] = value;
                        }

                        this.list_spec_trans[key] = this.list_spec_trans[key+'_origin'] + '('+color_code+')';
                    }
                })
            }
            //End task BP_O2OQ-29 antran 20211102

        	if(!(this.spec29_special && this.spec_selected.hasOwnProperty('spec29'))) {
        		this.featured_img = img_path_result + '/' + img_name_result
        	}

        	this.validateShow()
        },

        selectHeightOnChange (event) {
        	let size = event.target.value,
        		objOptions = {},
        		data = []

            //Add task BP_O2OQ-29 antran 20211102
            this.resetLabelLimitArm(size);
			this.option_selected = {}
        	if(size == 'null') {//TH bỏ chọn
    			this.size.height  = null
        	} else {
        		this.size.height = size
        	}

        	if(this.ctg_id == 2) {
        		_.forEach(this.filterData(['height', 'option', 'width']), rowValue => {
	        		if(rowValue.width == null || rowValue.width == this.size.width) {
	        			data.push(rowValue)
	        		}
	        	})
        	} else {
        		data = this.filterData(['height', 'option'])
        	}

        	_.forEach(data, rowValue => {
        		_.forEach(rowValue, (value, colName) => {
                    if(_.startsWith(colName, "option") && value != null && !this.spec_exclude.includes(colName)) {
	    				if(objOptions.hasOwnProperty(colName) === false) {
							objOptions[colName] = [];
						}

						if(!objOptions[colName].includes(value)) {
							objOptions[colName].push(value);
						}
					}
    			})
        	})

        	objOptions = this.sortOption(objOptions)
    		this.options = objOptions
    		this.selectOptionOnly1Value(objOptions)
        	this.validateShow()	
        },

        selectWidthOnChange (event) {
        	let size = event.target.value,
        		argDataHeight  = [],
        		objOptions = {},
        		data = []

        	if(size == 'null') {//TH bỏ chọn
    			this.size.width  = null
        	} else {
        		this.size.width = size
        	}

        	this.option_selected = {}
        	this.size.height = null

        	if(this.ctg_id == 2) {
        		_.forEach(this.filterData(['height', 'option', 'width']), rowValue => {
	        		if(rowValue.width == null || rowValue.width == this.size.width) {
	        			data.push(rowValue)
	        		}
	        	})
        	} else {
        		data = this.filterData(['height', 'option'])
        	}

        	_.forEach(data, rowValue => {
        		_.forEach(rowValue, (value, colName) => {
                    if(_.startsWith(colName, "option") && value != null && !this.spec_exclude.includes(colName)) {
	    				if(objOptions.hasOwnProperty(colName) === false) {
							objOptions[colName] = [];
						}

						if(!objOptions[colName].includes(value)) {
							objOptions[colName].push(value);
						}
					}
    			})

        		if(rowValue.height != null) {
        			argDataHeight.push(rowValue.height)
        		}
        	})

        	argDataHeight = _.uniq(argDataHeight)

        	if (Object.keys(this.spec_selected).includes('spec35')) {

				let sizeLimit = _.filter(this.sizeLimit, {'spec35': this.spec_selected.spec35, 'spec33': this.itemDisplay.spec33})
				let heights = []

				_.forEach(argDataHeight , (value, key) => {
					if (parseInt(value) >= parseInt(sizeLimit[0].min_height) && parseInt(value) <= parseInt(sizeLimit[0].max_height)) {
						heights.push(value)
					}
				})
				argDataHeight = heights
			}

    		this.size.data_height = this.sortArray(argDataHeight)

    		objOptions = this.sortOption(objOptions)
    		this.options = objOptions
    		this.selectOptionOnly1Value(objOptions)

        	this.validateShow()

        },

        selectOptionOnly1Value (objOptions) {
        	_.each(objOptions, (value, key) => {
        		let argKeyOptions = _.keys(value)
				if(argKeyOptions.length == 1) {
					this.$set(this.option_selected, key, value[0])
				}
        	})
        },

        selectSpec (specCode, specValue) {
            //console.log(specCode)
            //console.log(specValue)

        	let
        		argKeySpecSelected = _.keys(this.spec_selected),
        		objSpecKey = this.specs.select,
        		boolStartRemove = false

        	this.$set(this.spec_selected, specCode, specValue)
        	if(argKeySpecSelected.includes(specCode)) {//đã chứa spec_code đó rồi
        		//xóa các specCode tiếp theo khi chọn lại
        		_.forIn(objSpecKey, (_specValue, _specCode) => {

        			if(boolStartRemove == true) {
        				this.$delete(this.specs.select, _specCode)
        				this.$delete(this.spec_selected, _specCode)
        			}

        			if(_specCode == specCode) {
        				boolStartRemove = true
        			}

        		})//End _.forIn
        	}

        	if(specCode == 'spec29' && this.spec29_special) {
        		let objSpec29 = this.specs.select.spec29
        		this.featured_img = objSpec29.img[specValue][0] + '/' + objSpec29.img[specValue][1]
        	}

        	this.color_id = null
        	this.size.width = null
        	this.size.height = null
        	this.option_selected = {}

        	if (this.is_fence) {
        		this.$refs.fence_width.value = ''
        	}

        	this.fetchDataSelected()
        	this.validateShow()
        },

        selectSpecOnchange (event) {

        	let specValue = event.target.value,
        		specCode = event.target.getAttribute('data-spec-code'),
        		argKeySpecSelected = _.keys(this.spec_selected),
        		boolStartRemove = false

        	if(specValue != '') {
        		this.$set(this.spec_selected, specCode, specValue)
        	} else {
        		this.$delete(this.spec_selected, specCode)
        	}

        	if(argKeySpecSelected.includes(specCode)) {//đã chứa spec_code đó rồi
        		//xóa các specCode tiếp theo khi chọn lại
        		_.forIn(this.specs.select, (_specValue, _specCode) => {

        			if(boolStartRemove == true) {
        				this.$delete(this.specs.select, _specCode)
        				this.$delete(this.spec_selected, _specCode)
        			}

        			if(_specCode == specCode) {
        				boolStartRemove = true
        			}

        		})//End _.forIn
        	}

        	this.color_id = null
        	this.size.width = null
        	this.size.height = null
        	this.option_selected = {}

        	if (this.is_fence) {
        		this.$refs.fence_width.value = ''
        	}

        	this.fetchDataSelected()
        	this.validateShow()
        },

        selectSpecOption (specCode, specValue) {
            if (this.checkDisabledOption) {
                return;
            }
			
			//Add by An Lu AKT on 22/2/2024			
			if (
				!this.isAtis() &&
				specCode == 'option6' &&
				!this.isAwningCasement()
			) {
				if (specValue != 'o6.3') {
					if (!this.isSlidingDoor()) {
						this.$set(this.options, 'option13', ['o13.1', 'o13.2']);
					} else {
						this.options['option13'] = ['o13.2'];
						this.option_selected['option13'] = 'o13.2';
						//this.$set(this.option_selected, 'option13', 'o13.2');
					}

				} else {
					_.unset(this.option_selected, 'option13');
					_.unset(this.options, 'option13');					    
				}
			}


            //Add task BP_O2OQ-29 Antran 20211101
            if (
                this.isAtis() &&
                specCode == 'option6' &&
                this.check_add_gapcover == true
            ) {
                //o6: Insect Screen
                //o6.3: Without
                if (specValue != 'o6.3') {
                    //o6.3: Without,o11.1: gap cover
                    _.unset(this.option_selected, 'option11');
                    _.unset(this.options, 'option11');
                } else {
                    //set gap cover:gap cover
                    this.$set(this.option_selected, 'option11', 'o11.1');
                    this.$set(this.options, 'option11', ['o11.1']);
                }
            }
            //End task BP_O2OQ-29 Antran 20211101

        	this.$set(this.option_selected, specCode, specValue);
        	this.validateShow()
        },

        selectSpecOptionOnchange (event) {
        	let specValue = event.target.value,
        		specCode  = event.target.getAttribute('data-spec-code')

			//Add by An Lu AKT on 22/2/2024	
			if (
				!this.isAtis() &&
				specCode == 'option6' &&
				!this.isAwningCasement()
			) {
				if (specValue != 'o6.3') {
					if (specValue != 'o6.3') {
						if (!this.isSlidingDoor()) {
							this.$set(this.options, 'option13', ['o13.1', 'o13.2']);
						} else {
							this.options['option13'] = ['o13.2'];
							this.option_selected['option13'] = 'o13.2';
							//this.$set(this.option_selected, 'option13', 'o13.2');
						}
	
					} else {
						_.unset(this.option_selected, 'option13');
						_.unset(this.options, 'option13');					    
					}					    
				}
			}

			//Add task BP_O2OQ-29 Antran 20211101
            if (
                this.isAtis() &&
                specCode == 'option6' &&
                this.check_add_gapcover == true
            ) {
                //o6: Insect Screen
                //o6.3: Without,o11.1: gap cover
                if (specValue != 'o6.3') {
                    //unset gap cover:gap cover
                    _.unset(this.option_selected, 'option11');
                    _.unset(this.options, 'option11');

                } else {
                    //set gap cover:gap cover
                    this.$set(this.option_selected, 'option11', 'o11.1');
                    this.$set(this.options, 'option11', ['o11.1']);

                }			
            }
            //End task BP_O2OQ-29 Antran 20211101

        	if(specValue != '') {
        		this.$set(this.option_selected, specCode, specValue);
        	} else {
        		Vue.delete(this.option_selected, specCode);
        	}

        	this.validateShow()
        },

		async add__cart () {

			if(lang == 'en') {
				var cart_uri = _base_app + '/cart'
			} else {
				var cart_uri = _base_app + '/' + lang + '/cart'
			}

			let lang = this.lang
			let description = await this.getDescriptionCart()

			this.data_options_result = _.filter(this.data_options_result, item => {
				return item.order_no != 'no_selling_code'
			})

			let display_pitch_list = false
			_.each(this.configDisplayImageDescription, value => {
				if (value.title == 'pitch_list') {
					display_pitch_list = true
					return false
				}
			})

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
				display_pitch_list: display_pitch_list,
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
					description           : description,
					is_fence              : this.is_fence,
					fence                 : this.fence
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

        scrollToAddToCart () {
        	setTimeout(function() {
        		$('html, body').animate({
	        		scrollTop: $("#line").offset().top - 187
	        	}, 1500);
        	}, 1000);
        },

        formatNumber (item) {
        	if(item != null) {
				return item.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			} else{
				return item;
			}
        },

        allownumericwithdecimal (e) {
        	// console.log('allownumericwithdecimal')
        	// let size = e.target.value
        	if (
	            // (e.which != 44 || size.indexOf(',') != -1) &&
	            (e.which < 48 || e.which > 57)
	        ) {
	            e.preventDefault();
	        }
        },

        inputFenceWidth: _.debounce(function (e) {

        	let size = e.target.value
        		size = size.replace(/,/g, "")

        	if(size != this.fence.f0){
	        	// console.log('inputFenceWidth')

	        	if(size%100 === 0) {
	        		this.fence['f0'] = size

		        	let
		        		f1 = _.ceil(size/2000),
		        		argDataHeight  = [],
		        		objOptions = {},
		        		data = []

		        	if(f1 == 0) {
		        		this.size.width = null
		        	} else {
			        	let
		        			f2 = _.ceil(size / f1),
		 					width = _.ceil(f2, -2)

			        	this.size.width = width.toString()
			        	this.fence['f1'] = f1
			    		this.fence['f2'] = f2
		        	}

		        	this.option_selected = {}
		        	this.size.height = null

		        	if(_.filter(this.data_options, this.buildQuery(['height','option'])).length != 0) {
		        		_.forEach(_.filter(this.data_options, this.buildQuery(['height','option','width'])), rowValue => {
			        		if(rowValue.width == null || rowValue.width == this.size.width) {
			        			data.push(rowValue)
			        		}
			        	})
		        	}

		        	_.forEach(data, rowValue => {
		        		_.forEach(rowValue, (value, colName) => {
                            if(_.startsWith(colName, "option") && value != null) {
			    				if(objOptions.hasOwnProperty(colName) === false) {
									objOptions[colName] = [];
								}

								if(!objOptions[colName].includes(value)) {
									objOptions[colName].push(value);
								}
							}
		    			})

		        		if(rowValue.height != null) {
		        			argDataHeight.push(rowValue.height)
		        		}
		        	})

		        	argDataHeight = _.uniq(argDataHeight)
		    		argDataHeight.sort(function(a, b){
		    			return a - b
		    		});

		    		this.size.data_height = argDataHeight
		    		objOptions = this.sortOption(objOptions)
		    		this.options = objOptions
		    		this.selectOptionOnly1Value(objOptions)
		        	this.validateShow()
	        	}


        	}
	    }, 500),

        removeFormatNumber (e) {
        	// console.log('removeFormatNumber')
        	let size = e.target.value
        		size = size.replace(/,/g, "")
        	e.target.value = size
        },

        formatWidthFence (e) {
        	// console.log('formatWidthFence')
        	let size = e.target.value
        		size = size.replace(/,/g, "")
        	if(size % 100 === 0){
	        	e.target.value = size.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        	} else {
        		this.$modal.show('dialog', {
					text: lang_text.number_validate_msg,
					buttons: [
						{
							title: lang_text.ok,
							default: true,
							handler: () => {
								this.size.width = null
								this.fence.f0 = null
								this.$refs.fence_width.focus()
								this.$modal.hide('dialog')
							}
						},
					]
				})
        	}
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

        /**
         * Redirect if token expired
         */
        tokenMismatch () {
        	_loading.css('display', 'none')
			if (this.param_cnt >= 2) {
				try {
					axios.post(_urlBaseLang + '/check-session-new-or-reform/generate', {
						status: 0
					}).catch(error => {
						console.log(error);
					});
				} catch (error) {
					console.log(Object.keys(error), error.message);
				}
				return 1;
			}
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

        //Add task BP_O2OQ-29 antran 20211102
        checkColorExclude (color_id) {
            let check_color = false;
            _.each(this.color_exclude, (value, index) => {
                if (color_id == value) {
                    check_color = true;
                }
            });

            return check_color;
        },

		//Added by An Lu AKT on 23/2/2024
		isAwningCasement () {
			if ((this.model_id >= 13 && this.model_id <= 17) || this.model_id == 58) {
                return true;
            }

            return false;
		},

		//Added by An Lu AKT on 23/2/2024
		isSlidingDoor () {
            if (this.model_id >= 6 && this.model_id <= 12) {
                return true;
            }

            return false;
        },

        isAtis () {
            if (this.product_id == 10) {
                return true;
            }

            return false;
        },

        resetLabelLimitArm (height = '') {
            // o9: Limit arm
            // model_id 67: Casement (Operator)
            _.unset(this.list_spec_trans, 'o9.1_transform');
            if (
                height != '' &&
                this.isAtis() &&
                this.model_id == 67 &&
                this.list_spec_trans.hasOwnProperty('o9.1')
            ) {
                if (parseInt(height) >= 1000) {
                    this.list_spec_trans['o9.1_transform'] = 'Limit arm A';
                } else {
                    this.list_spec_trans['o9.1_transform'] = 'Limit arm B';
                }
            }
        },

        checkShowSpecButton (specCode) {
            return this.isAtis() && ['spec40','spec41'].includes(specCode);//Atis: spec41:Frame Depth, spec40: Type
        },

        checkShowOptionButton (value, optionCode) {
            //Show 3 button with Atis: Insect Screen, option6
            if (
                //this.isAtis() &&   // Canceled by An Lu AKT on 23/2/2024
                optionCode == 'option6' &&
                value.length == 3
            ) {
                return true;
            }

            return false;
        }

        //End task BP_O2OQ-29 antran 20211102
    }
});

