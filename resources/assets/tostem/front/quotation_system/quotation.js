var quotation_vue = new Vue({
    el: '#page',
    data: {},
    async mounted() {
        let status = await this.checkSessionNewOrReform();
        this.$nextTick(() => {
            if (status) {
                this.saveSessionNewOrReform(0);
            }
        })
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

        async checkSessionNewOrReform() {
            let status = false;
            try {
                await axios.get(_urlBaseLang + '/check-session-new-or-reform')
                .then(res => {
                    if (res.data.status === 'session_error') {
                        status = true;
                    }
                }).catch(error => {
                    console.log(error);
                    if (error.response.status == 401) {
                        this.tokenMismatch();
                    }
                });
            } catch (error) {
                console.log(Object.keys(error), error.message);
                status = true;
            }
            return status;
        },

        checkOpenModalNewOrReform() {
            let _this = this;
            this.$modal.show('dialog', {
                text: lang_text.msg_confirm_new_reform,
                buttons: [
                    {
                        title: lang_text.new,
                        default: true,// Will be triggered by default if 'Enter' pressed.
                        handler: () => {
                            _this.saveSessionNewOrReform(0);
                        }
                    },
                    {
                        title: lang_text.reform,
                        handler: () => {
                            _this.saveSessionNewOrReform(1);
                        }
                    },
                ]
            })
        },

        async saveSessionNewOrReform(status) {
            let _this = this;
            _this.$modal.hide('dialog');
            _loading.css('display','block');
            try {
                await axios.post(_urlBaseLang + '/check-session-new-or-reform/generate', {
                    status: status
                }).catch(error => {
                    console.log(error);
                    if (error.response.status == 401) {
                        this.tokenMismatch();
                    }
                });
            } catch (error) {
                console.log(Object.keys(error), error.message);
            }
            _loading.css('display','none');
        }
    }
});
