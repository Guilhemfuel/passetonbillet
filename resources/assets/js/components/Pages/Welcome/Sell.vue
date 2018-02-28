<template>

    <form class="row mt-4">
        <div class="col-12 col-sm-12 col-md-6 mb-4 mb-md-0 form-group">
            <input id="last_name" type="text"
                   :class="{'form-control': true, 'is-invalid': errors.has('last_name') }"
                   name="last_name" required v-validate="'required'"
                   :placeholder="lang.sell.inputs.last_name" v-model="form.last_name">
            <span v-if="errors.has('last_name')"
                  class="invalid-feedback">{{ errors.first('last_name')}}</span>

        </div>
        <div class="col-12 col-sm-12 col-md-6 mb-4 mb-md-0 form-group">
            <input id="booking_code" type="text"
                   :class="{'form-control': true, 'is-invalid': errors.has('booking_code') }"
                   name="booking_code" required v-validate="'required|max:6|min:6'"
                   :placeholder="lang.sell.inputs.booking_code" v-model="form.booking_code">
            <span v-if="errors.has('booking_code')"
                  class="invalid-feedback">{{ errors.first('booking_code')}}</span>

        </div>
    </form>

</template>

<script>
    export default {
        props: {
            routes: {type: Object, required: true},
            lang: {type: Object, required: true},
            csrf: {type: String, required:true}
        },
        data() {
            return {
                form: {last_name: '', _token: this.csrf},
            }
        },
        computed: {

        },
        methods: {

        }
    }
</script>