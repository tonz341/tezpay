<template>
        <div class="card card-custom" style="margin-top: 50px">
            <div class="card-header card-header-custom text-center">
                <a href="/">
                    <img src="/images/logo.png" alt="Tezpay.jpg" class="third-width">
                </a>
            </div>
            <div class="card-body" style="padding: 0.50rem">
                <!--{{ link }}-->

                    <div class="row" v-if="link.address">
                        <div class="form-group col-12">
                            <label class="form-label"> Pay for {{ link.name }} </label>

                            <span class="float-right">
                                <h3 class="custom-usd">{{ _usdPrice }}</h3>
                                <strong class="float-right">USD</strong>
                            </span>
                        </div>

                        <div class="form-group col-12">
                            <div class="text-center" v-show="_tezosPrice">
                                <p class="custom-price"> {{ _tezosPrice }} <img src="/images/uA729.png" class="tezos-logo"  alt=""></p>
                                <small> USD {{ usd_value }}/XTZ</small>
                            </div>
                        </div>

                        <div class="form-group col-12">
                            <div  v-show="showQr" class="text-center">
                                <vue-qrcode :value="link.address" :options="{ width: 200 }" style="border: 1px solid lightgray "></vue-qrcode>
                            </div>
                        </div>

                        <div class="form-group col-12">
                            <label class="form-label"> Shortlink </label>
                            <div class="custom-link" @click="copyLink">
                                <span>
                                    {{ generatedLink }}
                                </span>
                                <span class="float-right">
                                    <span v-if="!success">
                                        Copy
                                    </span>
                                    <span v-else style="color: green">
                                        Copied
                                    </span>
                                </span>
                            </div>

                            <small class="float-right" style="margin-top: 5px">Valid until: {{ link.expired_at }}</small>
                        </div>
                    </div>

                <div class="row" v-else>
                    <div class="form-group col-12 text-center">
                        <h1 class="form-label"> Oops!</h1> <br>
                        <label class="form-label"> Product not found</label><br>
                        <label class="form-label"> Click <a href="/"> here </a> to create new one</label>
                    </div>
                </div>

            </div>
        </div>
</template>

<script>

    import VueQrcode from '@chenfengyuan/vue-qrcode';


    export default {
        name: 'home',
        props: ['link', 'usd'],
        components: { VueQrcode },
        data() {
            return {
                showQr: false,
                success: false,
                usd_value: 0.00,
                theInterval: null
            }
        },
        computed: {
            generatedLink(){
                return window.location.origin +'/'+this.link.uid;
            },

            _usdPrice() {

                if(!this.link.price) {
                    return 0.00;
                }

                if(this.link.currency != 'usd') {
                    return this.link.price * this.usd_value;
                }

                return this.link.price;

            },

            _tezosPrice() {

                if(this.link.currency != 'tezos') {
                    if(this.usd_value) {
                        let data = (this.link.price / this.usd_value).toFixed(2);
                        return data > 0 ? data : 0.00;
                    }

                    return 0;
                }
                return this.link.price;
            }
        },

        beforeDestroy() {
            clearInterval(this.theInterval);
        },

        mounted() {
            setTimeout(() => {
                this.showQr = true;
                this.usd_value = this.usd.toFixed(2);
            },500)

            this.theInterval = setInterval(() => {
                axios.post("/conversion", this.data )
                    .then((response) => {
                    this.usd_value = (response.data.conversion).toFixed(2);
                })
             }, 5000);

        },

        methods: {
            copyLink() {
                this.copyToClipboard(this.generatedLink);
            },

            copyToClipboard(text) {
                if (window.clipboardData && window.clipboardData.setData) {
                    return clipboardData.setData("Text", text);

                } else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
                    var textarea = document.createElement("textarea");
                    textarea.textContent = text;
                    textarea.style.position = "fixed";
                    document.body.appendChild(textarea);
                    textarea.select();
                    try {
                        this.success = true;
                        return document.execCommand("copy");  // Security exception may be thrown by some browsers.
                    } catch (ex) {
                        console.warn("Copy to clipboard failed.", ex);
                        return false;
                    } finally {
                        document.body.removeChild(textarea);
                    }
                }
            }
        }
    }
</script>
