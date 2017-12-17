<template>

    <!--- TODO: faire ce composant et le back-end pour changer le mot de passe -->

    <div class="col-xs-12 form-group">
        <label for="password" class="control-label">{{lang.register.password}}
            <small class="text-muted">(8 char. min)</small>
        </label>
        <input id="password" type="password"
               :class="{'form-control': true, 'is-invalid': errors.has('password') }"
               name="password" v-validate="'required|min:8'"
               required :placeholder="lang.register.password">
        <span v-if="errors.has('password')" class="invalid-feedback">{{ errors.first('password')
            }}</span>
    </div>

    <div class="col-xs-12 form-group">
        <label for="password" class="control-label">{{lang.register.password}}
            <small class="text-muted">(8 char. min)</small>
        </label>
        <input id="password" type="password"
               :class="{'form-control': true, 'is-invalid': errors.has('password') }"
               name="password" v-validate="'required|min:8'"
               required :placeholder="lang.register.password">
        <span v-if="errors.has('password')" class="invalid-feedback">{{ errors.first('password')
            }}</span>
    </div>

    <div class="col-xs-12 form-group">
        <label for="password-confirm"
               class="control-label">{{lang.register.password_confirm}}</label>

        <input id="password-confirm" type="password"
               :class="{'form-control': true, 'is-invalid': errors.has('password_confirmation') }"
               name="password_confirmation" v-validate="'required|confirmed:password|min:8'"
               required :placeholder="lang.register.password">
        <span v-if="errors.has('password_confirmation')"
              class="invalid-feedback">{{ errors.first('password_confirmation') }}</span>

    </div>
</template>

<script>

    // Phone formatter
    // TODO: do not include all countries (reduce file size)
    require('cleave.js/dist/addons/cleave-phone.i18n');

    export default {
        props:  {
            countriesDefault: null,
            value: null,
            countryValue: null,
            required: {type: Boolean, default: false}
        },
        data(){
            return {
                countries: this.countriesDefault || ['FR', 'GB', 'BE'],
                activeCountry: this.countryValue ? this.countryValue : (this.countries ? this.countries[0] : 'FR'),
                actualValue: this.value
            }
        },
        computed: {
            cleaveOptions: function() {
                return {  phone: true, phoneRegionCode: this.activeCountry };
            },
            resultNumber: function() {
                if (!this.actualValue) return null;
                return this.actualValue.replace(/ /g,'');
            },
            placeholder: function(){
                switch (this.activeCountry){
                    case 'FR':
                        return '06 12 34 56 56'
                        break;
                    case 'GB':
                        return '07123 456789'
                        break;
                    case 'BE':
                        return '01 234 56 78'
                        break;
                }
            },
            prefix: function(){
                switch (this.activeCountry){
                    case 'FR':
                        return '+33'
                        break;
                    case 'GB':
                        return '+44'
                        break;
                    case 'BE':
                        return '+32'
                        break;
                }
            },
        },
        methods: {
            caretClick : function () {
                this.$refs.select.click();
            }
        }
    }
</script>
