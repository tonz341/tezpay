<template>
    <div class="card">
        <div class="card-header">Settings</div>

        <div class="card-body">
            <form @submit.prevent="submit">
                <div class="row form-group">
                    <div class="col-12 form-group">
                        <label for="address">Tezos Address</label>
                        <input v-model="address" type="text" name="address" class="form-control">
                    </div>

                    <div class="col-12 form-group">
                        <button class="btn btn-primary" type="submit">Update</button>
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
                address : ''
            }
        },
        methods: {
            submit() {
                axios.patch("/settings/update", { address : this.address })
                        .then((response) => {
                    alert('Update Succesfully')
                })
            }
        }
    }
</script>
