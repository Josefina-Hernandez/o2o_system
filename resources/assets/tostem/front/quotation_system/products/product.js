Vue.config.devtools = true;
import Slick from 'vue-slick';
var app = new Vue({
    el: '#page',
    components: {
    	Slick
    },
    data() {
        return {
            slug_name : slug_name,

            products : [],
            product_id: null,
            product_name : null,

            models : [],
            model_id: null,

            colors: [],
            color_id: null,
            color_name: null,

            data_m_selling_spec: [],
            spec_group: [],
            spec_option: [],

            data_options: [],//data query when choose model
            data_options_selected : [],//data_options after choose spec or option
            specs: {},//use to foreach spec
            options: {},//use to foreach option of spec
            list_spec: [],//list spec and option in  data_option
            list_spec_trans: [],//list spec and option name
            spec_selected: {},// list spec user selected
            option_selected: {},// list spec user selected

            add_to_cart : false,//state enable button add to cart

            slickOptions: {
            	//options can be used from the plugin documentation
            	accessibility: true,
            	adaptiveHeight: false,
            	arrows: true,
            	dots: false,
            	draggable: true,
            	edgeFriction: 0.30,
            	// swipe: true,
            	infinite: false,
				slidesToShow: 7, // Shows a three slides at a time
				slidesToScroll: 1, // When you click an arrow, it scrolls 1 slide at a time
            }
        }
    },
    created: function () {
    	this.fetchProduct();
    	this.getDataSellingSpec();
    },
    watch: {
    	product_id: function () {
	        app.initProduct();
    	},
    	models: function () {
	    	app.initModel();
	    	app.reInitSlider();

	    },
	    data_options_selected: function () {
	    	app.fetchSpecs();
	    },
	    data_m_selling_spec: function () {
    		app.filterDataSellingSpec();
	    },
    },
    methods: {
    	next() {
            this.$refs.slick.next();
        },

        prev() {
            this.$refs.slick.prev();
        },

        reInitSlider() {
            // Helpful if you have to deal with v-for to update dynamic lists
            let currIndex = 0;
            // currIndex = this.$refs.carousel.currentSlide()
	        this.$refs.carousel.destroy()
	        this.$nextTick(() => {
		        this.$refs.carousel.create()
		        this.$refs.carousel.goTo(currIndex, true)
	        });
        },

        async initProduct() {
            app.models = []
            app.model_id = null
        },

        async initModel() {
            app.colors = []
            app.color_id = null
            app.color_name = null

            app.data_options = []
            app.data_options_selected = []

            specs: {}
            options: {}
            list_spec: []
            list_spec_trans: []
            spec_selected: {}
            option_selected: {}
        },

        getDataSellingSpec() {
        	axios.get(_base_app + '/quotation_system/product/get_selling_spec')
        		.then(function (response) {
				    app.data_m_selling_spec = response.data;
				});
        },

    	async fetchProduct() {
    		axios.get(_base_app + '/quotation_system/'+slug_name+'/product/list')
        		.then(function (response) {
				    app.products = response.data;
				});
    	},

        async selectProduct(product_id, product_name) {
            app.product_id = product_id;
            app.product_name = product_name;

            app.fetchModels(product_id);
        },

        async fetchModels(product_id) {
        	_loading.css('display', 'block');
                await axios.post(_base_app + '/quotation_system/'+slug_name+'/product/get_models', {
                product_id: product_id,
            }).then(response => {
                app.models = response.data;
            }).catch(error => {
                console.log(error.response);
                _loading.css('display', 'none');
            });
            _loading.css('display', 'none');
        },

        async selectModels(m_model_id) {
            app.model_id = m_model_id;
            app.fetchOptions();
        },

        async fetchOptions() {
        	_loading.css('display', 'block');
            await axios.post(_base_app + '/quotation_system/'+slug_name+'/product/get_options', {
                product_id: app.product_id,
                m_model_id: app.model_id
            }).then(response => {
                app.fetchColors();
                app.data_options = response.data;
		    	app.data_options_selected = response.data;
            }).catch(error => {
                console.log(error.response)
            });
            _loading.css('display', 'none');
        },

        async getSpecTrans(list_spec) {
        	return await axios.post(_base_app + '/quotation_system/product/get_spec_stran', {
                list_spec : app.list_spec
            });
        },

        async filterDataSellingSpec() {
        	$.each(app.data_m_selling_spec, function(index, value) {
    			if($.isNumeric(value.m_spec_group_id) === true) {
    				if(!app.spec_group.includes('spec' + value.m_spec_group_id)) {
    					app.spec_group.push('spec' + value.m_spec_group_id);
    				}
    			} else {
    				if(!app.spec_option.includes('option' + value.m_spec_group_id)) {
    					app.spec_option.push('option' + value.m_spec_group_id.substr(1));
    				}
    			}
    		});
        },

        async fetchSpecs() {
        	if(app.data_options_selected.length >0) {
	    		let specs_tmp = {},
	    			options_tmp = {}
	    		$.each(app.data_options_selected, function(option_index, row) {
	    			$.each(row, function(index, value) {
	    				if(app.spec_group.includes(index) && value != null) {

	    					if(specs_tmp.hasOwnProperty(index) === false) {
	    						specs_tmp[index] = {
	    							'data': [],
	    							'active': null
	    						};
	    					}

	    					if(!specs_tmp[index].data.includes(value)) {
	    						specs_tmp[index].data.push(value);
	    					}

	    					if(app.list_spec.indexOf(value) == -1) {
	    						app.list_spec.push(value);
	    					}
	    				} else if(app.spec_option.includes(index) && value != null) {

							if(options_tmp.hasOwnProperty(index) === false) {
	    						options_tmp[index] = {
	    							'data': [],
	    							'active': null
	    						};
	    					}

	    					if(!options_tmp[index].data.includes(value)) {
	    						options_tmp[index].data.push(value);
	    					}

	    					if(app.list_spec.indexOf(value) == -1) {
	    						app.list_spec.push(value);
	    					}
	    				}
	    			})
	    		});

				app.specs = specs_tmp;
				app.options = options_tmp;
	    		if(app.list_spec.length >0){
	    			app.getSpecTrans(app.list_spec).then(response => {
		            	app.list_spec_trans = response.data
		            });
	    		}
	    	}
        },

        async fetchColors() {
        	_loading.css('display', 'block');

            await axios.post(_base_app + '/quotation_system/'+slug_name+'/product/get_colors', {
                product_id: app.product_id,
                m_model_id: app.model_id
            }).then(response => {
                app.colors = response.data;
            }).catch(error => {
                console.log(error.response)
            });

            _loading.css('display', 'none');
        },

        selectColor: function (m_color_id, color_name) {
        	app.color_id = m_color_id;
        	app.color_name = color_name
        },

        async selectSpec(spec_code, spec_value) {
        	Vue.set(app.spec_selected, spec_code, spec_value);
        	app.specs[spec_code].active = spec_value; //set active status
        	app.filterDataOptionSelected(app.spec_selected);
        },

        async selectSpecOnchange(event) {
        	if(event.target.value != '') {
        		Vue.set(app.spec_selected, event.target.getAttribute('data-spec-code'), event.target.value);
	        	app.specs[event.target.getAttribute('data-spec-code')].active = event.target.value; //set active status
	        	app.filterDataOptionSelected(app.spec_selected);
        	} else {

        	}
        },

        async selectSpecOption(spec_code, spec_value) {
        	Vue.set(app.option_selected, spec_code, spec_value);
        	app.options[spec_code].active = spec_value; //set active status
        	app.filterDataOptionSelected(app.option_selected);
        },

        async selectSpecOptionOnchange(event) {
        	if(event.target.value != '') {

        	} else {

        	}
        },

        async filterDataOptionSelected(data_selected) {
        	let data_options_tmp = []
        	$.each(app.data_options_selected, function(option_index, row) {

        		let insert = true,
        			hasProperty = false;

    			$.each(row, function(index, value) {
    				if(data_selected.hasOwnProperty(index) === true) {
    					hasProperty = true;
    					if(data_selected[index] != value) {
    						insert = false;
    						return false;
    					}
    				}
    			})

    			if(insert == true && hasProperty == true) {
    				data_options_tmp.push(app.data_options_selected[option_index]);
    			}
    		});

    		app.data_options_selected = data_options_tmp;
        },

        defaultImage(elm_id) {
            let _this = this;
            $('#'+elm_id).attr('src', _this.default_img)
        },

        setDefaultImage (url) {
            let _this = this;
            if (url === '' || url == null) {
                return _this.default_img
            } else {
                return url;
            }
        },
    }
});