
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });

import VModal from 'vue-js-modal';

Vue.use(VModal, { dialog: true });

/**
 * Vueカスタムディレクティブ
 */
Vue.directive('init', {
    bind: function (el, binding, vnode) {
        // プロパティ名をケバブケースからキャメルケースに変換する
        let property = binding.arg.replace(/-([a-z])/g, function (g) { return g[1].toUpperCase(); });

        // プロパティに引数を格納する
        vnode.context[property] = binding.value;
    }
})

/**
 * Vueコンポーネント
 */
// 選択したローカルの画像をブラウザ上に表示する
var fileUpload = {
    template: `
    <div>
        <input
        accept="image/jpeg, image/png"
        type="file"
        v-bind:name="name"
        v-on:change="onFileChange"
        v-bind:uploadedImage="image"><br>
        <p class="mt10">
            <img
            v-show="uploadedImage"
            v-bind:src="uploadedImage"
            v-bind:class="imageCls"
            v-bind:width="imageWidth"
            v-bind:height="imageHeight">
        </p>
    </div>`,

    props: {
        name: {
            type: String,
            default: null
        },
        image: {
            type: String,
            default: null,
        },
        imageCls: {
            type: String,
            default: null,
        },
        imageWidth: {
            type: Number,
            default: null,
        },
        imageHeight: {
            type: Number,
            default: null,
        }
    },

    data: function () {
        return {
            uploadedImage: this.image,
        }
    },

    methods: {
        onFileChange(event) {
            let files = event.target.files || e.dataTransfer.files;
            this.createImage(files[0]);
        },

        createImage(file) {
            let reader = new FileReader();
            reader.onload = (event) => {
                this.uploadedImage = event.target.result;
            };
            reader.readAsDataURL(file);
        },

        clear() {
            this.uploadedImage = null;
        }
    }
}


// 確認ダイアログを表示させる
var confirmDialog = {
    template: `<input type="submit" value="削除" class="button _delete" v-on:click="onClick">`,

    props: {
        message: {
            type: String,
            default: null
        },
        action: {
            type: String,
            default: null,
        }
    },

    methods: {
        onClick(event) {
            if (! window.confirm(this.message)) {
                event.preventDefault();
            } else {
                this.$parent.setAction(this.action);
            }
        }
    }
}

/**
 * Vueインスタンス
 */
// 確認ダイアログを表示させる
if (document.getElementById('confirm-dialog')) {
    const confirmDialogVM = new Vue({
        el: '#confirm-dialog',
        components: {
            'confirmDialog': confirmDialog,
        },
        data: {
            action: '',
        },
        methods: {
            setAction(action) {
                this.action = action;
            },
            onSubmit(event) {
                let form = event.target;
                form.action = this.action;
                form.submit();
            }
        }
    })
}

// submitボタンが複数ある場合、個別にルートを振り分けるために用いる
if (document.getElementById('confirm-complete')) {
    const confirmCompleteVM = new Vue({
        el: '#confirm-complete',
        data: {
            action: '',
        },
        methods: {
            onSubmit(event) {
                let form = event.target;
                form.action = this.action;
                form.submit();
            },

            onClick(action){
                this.action = action;
            },
        }
    })
}

// 事例編集画面
if (document.getElementById('message-length')) {
    const messageCountVM = new Vue({
        el: '#message-length',
        components: {
            'fileUpload': fileUpload,
        },
        data: {
            message: '',
            message2: '',
        },
        computed: {
            messageLength: function () {
                return this.message.length;
            },
            message2Length: function () {
                return this.message2.length;
            }
        }
    })
}

// LIXIL管理画面: 加盟店編集, 加盟店管理画面: 会社情報編集
// 都道府県プルダウンに変更があった際、市区町村プルダウンを再構築する
if (document.getElementById('pref-city')) {
    const prefToCityVM = new Vue({
        el: '#pref-city',
        components: {
            'fileUpload': fileUpload,
        },
        data: {
            cityList: [],
            selectedCity: null,
        },
        methods: {
            async onPrefChange(event) {
                if (event.target.value !== '0') {
                    let response = await axios.get(`/api/pref/${event.target.value}/city`);
                    this.cityList = response.data;
                    this.selectedCity = 0;

                } else {
                    this.cityList = [];
                }
            },
        },
    })
}

// スタッフ編集画面
if (document.getElementById('clear-staff')) {
    const clearStaffVM = new Vue({
        el: '#clear-staff',
        components: {
            'fileUpload': fileUpload,
        },
        data: {
            nameList: ['post', 'name', 'message','certificate','hobby','case'],
            pictureName: 'picture',
        },
        methods: {
            onClick(event, rank) {
                let form = event.target.form;
                for (let name of this.nameList) {
                    // nameListに含まれている要素を全て空にする
                    let element = form.querySelector(`[name="${name}_${rank}"]`);
                    element.value = '';
                }

                // 画像の選択状況を取り消す
                let child = this.$refs[rank];
                child.clear();
            }
        }
    })
}

// バナー編集画面
if (document.getElementById('clear-banner')) {
    const clearStaffVM = new Vue({
        el: '#clear-banner',
        components: {
            'fileUpload': fileUpload,
        },
        data: {
            nameList: ['url'],
            pictureName: 'picture',
        },
        methods: {
            onClick(event, rank) {
                let form = event.target.form;
                for (let name of this.nameList) {
                    // nameListに含まれている要素を全て空にする
                    let element = form.querySelector(`[name="${name}_${rank}"]`);
                    element.value = '';
                }

                // 画像の選択状況を取り消す
                let child = this.$refs[rank];
                child.clear();
                let picture = form.querySelector(`[name="${this.pictureName}_${rank}"]`);
                picture.value = '';
            }
        }
    })
}

// 都道府県を選択すると絞り込み検索画面に遷移する
if (document.getElementById('pref-change')) {
    const prefChangeVM = new Vue({
        el: '#pref-change',
        methods: {
            onChange(event) {
                let prefId = event.target.value;
                if (prefId != 0) {
                    parent.document.location = '/shop/search/' + prefId;
                }
            }
        },
    })
}

if (document.getElementById('svgMap')) {
    const colorboxParentCallVM = new Vue({
        el: '#svgMap',
        methods: {
            onClick(event) {
                event.preventDefault();
                parent.document.location = event.target.parentNode.getAttribute('xlink:href');
            }
        }
    })
}

// 加盟店都道府県検索: googlemapの表示
if (document.getElementById('gmapArea')) {
    const googleMapVM = new Vue({
        el: '#gmapArea',
        data: {
            map: null,
            shopData: null,
            key: null,
            prefCenterPosition: null,
        },
        methods: {
            initMap() {
                // APIのクエリパラメータで指定するコールバックを定義する
                window.initMap = () => {
                    // 初期位置とズーム値の定義
                    let position = JSON.parse(this.$data.prefCenterPosition);
                    this.map = new google.maps.Map(this.$el, {
                        center: {
                            lat: parseFloat(position.lat),
                            lng: parseFloat(position.lng)
                        },
                        zoom: parseInt(position.zoom)
                    });

                    // マーカーの作成
                    let shopData = Object.values(JSON.parse(this.$data.shopData));
                    for (let shop of shopData) {
                        let marker = new google.maps.Marker({
                            position: {
                                lat: parseFloat(shop.latitude),
                                lng: parseFloat(shop.longitude)
                            },
                            map: this.map,
                            icon: {
                                url: '/img/marker.png'
                            }
                        });

                        // 吹き出し情報の作成
                        let info =  new google.maps.InfoWindow({
                            content: '<div class="fukidashi"><a href="' + shop.url + '"/>' + shop.name + '</a></div>'
                        });

                        // マーカーをクリックすると吹き出し情報が表示されるように紐付け
                        marker.addListener('click', function () {
                            info.open(this.map, marker);
                        });
                    }
                };
            },
            initGoogleLibrary() {
                // scriptタグを生成し、属性を追加する
                const scriptElement = document.createElement('script')
                const url = `//maps.google.com/maps/api/js?key=${this.key}&callback=initMap`;
                scriptElement.setAttribute('src', url);
                scriptElement.setAttribute('async', '');
                scriptElement.setAttribute('defer', '');

                // scriptタグをDOMに追加し、ライブラリを読み込む
                document.head.appendChild(scriptElement);
            },
        },
        mounted: function () {
            this.initMap();
            this.initGoogleLibrary();
        }
    })
}

/**
 * TinyMCE
*/
if (document.getElementById('tinymce-article')) {
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#tinymce-article',
            language: 'ja',
            plugins: 'image paste autoresize link preview',
            menubar: false,
            toolbar: [
                // 戻る 進む | 太字 斜体 | 左寄せ 中央寄せ 右寄せ 均等割付 | 箇条書き 段落番号 インデントを減らす インデント
                "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
                // 文字サイズ 文字色 リンク プレビュー
                "fontsizeselect forecolor | link | preview"
            ],
            paste_data_images: true,
            setup : function (editor) {
                editor.on('init', function (e) {
                    editor.getBody().style.fontSize = '14px';
                });
            },

            content_css: '../../../../../common/css/reset.css,../../../../../common/css/common.css,../../../../../common/css/colorbox.css,../../../../../css/shop.css',
            doctype: '<!DOCTYPE html>',
            remove_linebreaks: false,

            forced_root_block: "",
            force_p_newlines: false, //!important
            force_br_newlines: true,
        });
    }
}

