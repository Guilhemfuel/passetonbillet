

<template>
    <div class="row ptb-phone mx-0">
        <template v-if="required">
            <div class="col-country p-0">
                <el-select v-model="activeCountryCode" name="phone_country">
                    <el-option
                            class="text-center"
                            v-for="country in countries"
                            :key="country.name"
                            :label="country.code"
                            :value="country.code">
                        {{country.name +' (+' +country.callingCode+')'}}
                    </el-option>
                </el-select>
            </div>
            <div class="col-prefix p-0">
                <input class="form-control prefix" disabled :value="activeCountry?'+'+activeCountry.callingCode:'+XX'"/>
            </div>
            <!-- TODO: fix phone validation if required (manually using error bag)-->
            <div class="col p-0 input-phone">
                <cleave type="text"
                        class="form-control"
                        placeholder="Your Number"
                        :options="cleaveOptions"
                        v-model="actualValue"
                        required
                        v-validate="'required'"
                        ></cleave>
            </div>
            <input type="hidden" name="phone" :value="resultNumber"/>
            <input type="hidden" name="phone_country" :value="activeCountry.code"/>
            <span v-if="errors.has('phone')" class="invalid-feedback">{{ errors.first('phone') }}</span>
        </template>
        <template v-else>
            <div class="col-country p-0">
                <el-select v-model="activeCountryCode" name="phone_country">
                    <el-option
                            class="text-center"
                            v-for="country in countries"
                            :key="country.name"
                            :label="country.code"
                            :value="country.code">
                        {{country.name +' (+' +country.callingCode+')'}}


                    </el-option>
                </el-select>
            </div>
            <div class="col-prefix p-0">
                <input class="form-control prefix" disabled :value="activeCountry?'+'+activeCountry.callingCode:'+XX'"/>
            </div>
            <div class="col p-0 input-phone">
                <cleave type="text"
                        class="form-control"
                        placeholder="Your Number"
                        :options="cleaveOptions"
                        v-model="actualValue"></cleave>
            </div>
            <input type="hidden" name="phone" :value="resultNumber"/>
            <input type="hidden" name="phone_country" :value="activeCountry.code"/>
        </template>
    </div>
</template>

<script>

    // Phone formatter
    // TODO: do not include all countries (reduce file size)

    import 'cleave.js/dist/addons/cleave-phone.i18n';
    import countries from '../../../data/phones.json';

    export default {
        props:  {
            value: null,
            countryValue: null,
            required: {type: Boolean, default: false}
        },
        mounted() {

        },
        data(){
            return {
                activeCountryCode: this.countryValue ? this.countryValue:'fr',
                actualValue: this.value,
                countries: countries.phones
            }
        },
        computed: {
            activeCountry: function() {
                // Find active country
                let country = null;
                for(var i = 0; i < this.countries.length; i++)
                {
                    if(this.countries[i].code == this.activeCountryCode)
                    {
                        country = this.countries[i];
                    }
                }
                return country;
            },
            cleaveOptions: function() {
                return {  phone: true, phoneRegionCode: this.activeCountry ? this.activeCountry.code.toLowerCase():null };
            },
            resultNumber: function() {
                if (!this.actualValue) return null;
                return this.actualValue.replace(/ /g,'');
            },
        },
        methods: {
            caretClick : function () {
                this.$refs.select.click();
            }
        }
    }
</script>
