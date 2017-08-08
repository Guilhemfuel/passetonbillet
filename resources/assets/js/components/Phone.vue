

<template>
    <div class="row lastar-phone">
        <div class="col-xs-3 select-phone">
            <i class="fa fa-caret-down" aria-hidden="true" @click="caretClick"></i>
            <select ref="select" class="form-control" v-model="activeCountry">
                <option class="text-center" v-for="country in countries" :value="country"><span :class="'flag-icon flag-icon-'+country"></span>{{country}}</option>
            </select>
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
    // TODO: do not include all countries + Fix issue when click on carret doesn't open select
    require('cleave.js/dist/addons/cleave-phone.i18n');

    export default {
        props:  {
            countriesDefault: null,
            value: null,
        },
        data(){
            return {
                countries: this.countriesDefault || ['FR', 'GB', 'BE'],
                activeCountry: this.countries ? this.countries[0] : 'FR',
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
