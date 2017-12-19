<template>

    <div>
        <div class="col-xs-12 form-group">
            <label for="old_password" class="control-label">{{lang.old_password}}
                <small class="text-muted">(8 char. min)</small>
            </label>
            <input id="old_password" type="password"
                   :class="{'form-control': true, 'is-invalid': errors.has('old_password') }"
                   name="old_password" v-validate="'required|min:8'"
                   required :placeholder="lang.old_password">
            <span v-if="errors.has('old_password')" class="invalid-feedback">{{ errors.first('old_password')
                }}</span>
        </div>

        <div class="col-xs-12 form-group">
            <label for="password" class="control-label">{{lang.password}}
                <small class="text-muted">(8 char. min)</small>
            </label>
            <input id="password" type="password"
                   :class="{'form-control': true, 'is-invalid': errors.has('password') }"
                   name="password" v-validate="'required|min:8'"
                   required :placeholder="lang.password">
            <span v-if="errors.has('password')" class="invalid-feedback">{{ errors.first('password')
                }}</span>
        </div>

        <div class="col-xs-12 form-group">
            <label for="password-confirm"
                   class="control-label">{{lang.password_confirm}}</label>

            <input id="password-confirm" type="password"
                   :class="{'form-control': true, 'is-invalid': errors.has('password_confirmation') }"
                   name="password_confirmation" v-validate="'required|confirmed:password|min:8'"
                   required :placeholder="lang.password">
            <span v-if="errors.has('password_confirmation')"
                  class="invalid-feedback">{{ errors.first('password_confirmation') }}</span>

        </div>
    </div>
</template>

<script>

    export default {
        props: {
            lang: {type: Object, required: true},
        },
        data() {
            return {}
        },
        computed: {}
    }
</script>
