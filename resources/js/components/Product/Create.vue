<template>
    <div class="card">
        <div class="card-header">Create Product</div>

        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="row form-group">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="address">Name</label>
                            <input v-model="product.name" type="text" name="address" class="form-control">
                        </div>

                         <div class="form-group">
                            <label for="description">Description</label>
                            <textarea v-model="product.description" type="text" name="description" class="form-control"> </textarea>
                        </div>

                         <div class="form-group">
                           <div class="row">
                               <div class="col-md-6">
                                    <label for="amount">Amount</label>
                                    <input v-model="product.amount" type="number" name="amount" class="form-control">
                               </div>

                                 <div class="col-md-6">
                                    <label for="currency">Currency</label>
                                    <select  v-model="product.currency" class="form-control">
                                        <option value="tezos" selected>Tezos</option>
                                        <option value="usd">USD</option>
                                    </select>
                               </div>

                           </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        {{ product.image }}
                        <div class="row">
                            <div class="col-12" >
                                <br>

                                <img class="preview" :src="preview" width="100%" v-show="preview" />

                                <div class="block-upload-box" @click="triggerUpload" v-if="!preview">
                                    Click to add image
                                </div>

                                <div class="block-upload-box" @click="preview=''" v-if="preview">
                                    Remove
                                </div>
                            </div>
                        </div>

                         <input
                            class="hidden"
                            id="file-photo-image"
                            type="file"
                            @change="previewImage"
                            accept="image/*"
                        />

                    </div>

                    <div class="col-12 form-group">
                        <button class="btn btn-primary" type="submit">Create</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return{
                product: {
                    name: '',
                    amount: '',
                    description: '',
                    image: '',
                    currency: 'tezos'
                },

                preview: ""
            }
        },
        methods: {
            submit() {
                // axios.post("/product/store", this.product)
                //         .then((response) => {
                //     alert('Create Succesfully')
                // })

                    var formData = new FormData();
                    formData.append("image", this.product.image);
                    formData.append("name", this.product.name);
                    formData.append("amount", this.product.amount);
                    formData.append("description", this.product.description);
                    formData.append("currency", this.product.currency);


                    axios.post('/product/store', formData).then(
                        function(response) {
                            console.log(response)
                            alert('Create Succesfully')
                            // this.formLoading = false;
                            // this.ty = true;
                            // this.status = 0;
                            // this.page = 3;
                            // window.scrollTo(50, 0);
                        },
                        function(response) {
                            // this.formLoading = false;
                            // alert("Something went wrong. Please try again");
                        }
                    );
            },

            triggerUpload() {
                document.getElementById("file-photo-image").click();
            },

          previewImage() {
            // Reference to the DOM input element
            var input = event.target;
            // Ensure that you have a file before attempting to read it
            if (input.files && input.files[0]) {
                this.product.image = event.target.files[0];
                // create a new FileReader to read this image and convert to base64 format
                var reader = new FileReader();
                // Define a callback function to run, when FileReader finishes its job
                reader.onload = e => {
                // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
                // Read image as base64 and set to imageData
                    this.preview = e.target.result;
                };
                // Start the reader job - read file as a data url (base64 format)
                reader.readAsDataURL(input.files[0]);
            }
            },
        }
    }
</script>
