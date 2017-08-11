

<template>
    <div class="row lastar-phone">
        <div class="col-xs-3 select-phone">
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
        <div class="col-xs-9 input-phone">
            <cleave type="text"
                    class="form-control"
                    placeholder="Phone Number"
                    :options="cleaveOptions"
                    v-model="actualValue"></cleave>
            <input type="hidden" name="phone" :value="resultNumber"/>
        </div>
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
                return this.actualValue.replace(/ /g,'');
            }
        },
        methods: {
            caretClick : function () {
                this.$refs.select.click();
            }
        }
    }
</script>
