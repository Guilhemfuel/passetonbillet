

<template>
    <div class="row ptb-phone mx-0">
        <template v-if="required">
            <div class="col-country p-0">
                <el-select v-model="activeCountry" name="phone_country">
                    <el-option
                            class="text-center"
                            v-for="country in countries"
                            :key="country"
                            :label="country"
                            :value="country">
                    </el-option>
                </el-select>
            </div>
            <div class="col-prefix p-0">
                <input class="form-control prefix" disabled :value="prefix"/>
            </div>
            <!-- TODO: fix phone validation if required (manually using error bag)-->
            <div class="col p-0 input-phone">
                <cleave type="text"
                        class="form-control"
                        :placeholder="placeholder"
                        :options="cleaveOptions"
                        v-model="actualValue"
                        required
                        v-validate="'required'"
                        ></cleave>
            </div>
            <input type="hidden" name="phone" :value="resultNumber"/>
            <input type="hidden" name="phone_country" :value="activeCountry"/>
            <span v-if="errors.has('phone')" class="invalid-feedback">{{ errors.first('phone') }}</span>
        </template>
        <template v-else>
            <div class="col-country p-0">
                <el-select v-model="activeCountry" name="phone_country">
                    <el-option
                            class="text-center"
                            v-for="country in countries"
                            :key="country"
                            :label="country"
                            :value="country">
                    </el-option>
                </el-select>
            </div>
            <div class="col-prefix p-0">
                <input class="form-control prefix" disabled :value="prefix"/>
            </div>
            <div class="col p-0 input-phone">
                <cleave type="text"
                        class="form-control"
                        :placeholder="placeholder"
                        :options="cleaveOptions"
                        v-model="actualValue"></cleave>
            </div>
            <input type="hidden" name="phone" :value="resultNumber"/>
            <input type="hidden" name="phone_country" :value="activeCountry"/>
        </template>
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
