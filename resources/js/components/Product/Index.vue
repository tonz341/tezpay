<template>
    <div class="card" v-if="product.uid">
        <div class="body">
            <div class="row" style="padding:100px">
                <div class="col-6">
                    <img :src="product['800_800']" width="100%">
                </div>

                 <div class="col-6">
                     <div style="">
                         <div class="row">
                             <div class="col-12">
                                Name:  {{ product.name }}
                             </div>
                             <div class="col-12">
                                Description:  {{ product.description }}
                             </div>
                             <div class="col-12">
                                Price:  {{ product.amount }} {{ product.currency }}
                             </div>
                             <div class="col-12">
                                Estimated in USD:
                             </div>
                         </div>
                     </div>

                     <div style="position: absolute; bottom: 0;" v-show="showQr">
                         <div class="row">
                             <div class="col-12" >
                                <strong>Scan me!</strong> <br>
                                <vue-qrcode :value="product.uid" :options="{ width: 200 }" style="border: 1px solid lightgray "></vue-qrcode>
                             </div>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueQrcode from '@chenfengyuan/vue-qrcode';

    export default {
        props: ['product'],
        components: { VueQrcode },
        data(){
            return {
                showQr: false
            }
        },

        mounted() {

            setTimeout(() => {
                this.showQr = true;
            },500)

        }

    }
</script>
