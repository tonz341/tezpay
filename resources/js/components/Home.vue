<template>
        <div class="card card-custom" style="margin-top: 50px">
            <div class="card-header card-header-custom text-center">
                <img src="/images/logo.png" alt="Tezpay.jpg" class="third-width">
            </div>
            <div class="card-body" style="padding: 0.50rem">
                <form @submit.prevent="generate">
                    <div class="row">
                        <div class="form-group col-12">
                            <label class="form-label"> Fill in your product name </label>
                            <input v-model="data.name" type="text" class="form-control" required placeholder="Electric Bicycle">
                        </div>

                        <div class="form-group col-6">
                            <label class="form-label"> Currency </label>
                            <select v-model="data.currency"  class="form-control" required>
                                <option value="tezos">TEZOS</option>
                                <option value="usd" selected>USD</option>
                            </select>
                        </div>

                        <div class="form-group col-6">
                            <label class="form-label"> Price </label>
                            <input v-model="data.price" type="number" class="form-control" required>
                        </div>

                        <div class="form-group col-12">
                            <label class="form-label"> Tezos wallet</label>
                            <input v-model="data.address" :class="{'is-invalid' : validTezos == 1}"  type="text" class="form-control" required>
                            <div class="valid-feedback" v-show="validTezos == 2">
                                Looks good!
                            </div>

                            <div class="invalid-feedback" v-show="validTezos == 1">
                                Please provide a valid Tezos address.
                            </div>
                        </div>


                        <div class="form-group col-12 ">
                            <button class="btn btn-primary form-control btn-lg btn-custom" type="submit">Create shortlink</button>
                        </div>


                    </div>

                </form>
            </div>
        </div>
</template>

<script>

    const WAValidator = require('@swyftx/api-crypto-address-validator');


    export default {
        name: 'home',
        data() {
            return {
                data: {
                    name: '',
                    currency: 'usd',
                    price: '',
                    address: ''
                },

                validTezos: 0
            }
        },
        mounted() {
//
        },

        methods: {
            generate(uid) {

                if(!(WAValidator.validate(this.data.address, 'XTZ'))) {
                    this.validTezos = 1;
                    return;
                }

                axios.post("/link/store", this.data )
                 .then((response) => {
                    this.data = {
                        'name': '',
                        'currency': 'usd',
                        'price': '',
                        'address': '',
                    }

                    window.location = "/"+response.data.link;
                 })
            },

            testAddress() {
                if((WAValidator.validate(this.data.address, 'XTZ'))) {
                    this.validTezos = 2;
                    return;
                }

            }
        }
    }
</script>
