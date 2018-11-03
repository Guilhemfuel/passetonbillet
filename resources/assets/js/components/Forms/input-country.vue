<template>
    <div :class="getClass">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <input type="hidden"
               :name="name"
               v-validate="validation"
               :value="country"
        >
        <el-select v-model="country" filterable
                   :id="name"
                   :placeholder="placeholder"
                   :class="{'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
                   @change="emitChange"
                   @input="emitInput"
        >
            <el-option
                    v-for="country in countries"
                    :key="country.code_iso3"
                    :label="country.name_fr"
                    :value="country.code_iso3">
                <span style="float: left">{{ country.name_fr }}</span>
                <span style="float: right; color: #8492a6; font-size: 13px">{{ country.name_en }}</span>
            </el-option>
        </el-select>
        <small v-if="errors.has(name)" :id="name+'Error'" class="form-text text-danger">
            {{ errors.first(name) }}
        </small>
    </div>
</template>

<script>
    import countries from '../../../data/countries.json';

    export default {
        inject: ['$validator'],
        props: {
            label: {required: false, type: String},
            name: {required: true, type: String},
            type: {required: false, type: String, default: 'text'},
            defaultValue: {required: false, type: String},
            format: {required: false, type: String},
            valueFormat: {required: false, type: String},
            className: {required: false, type: String},
            validation: {required: false, type: String},
            placeholder: {required: false, type: String},
            oldValue: {required: false, type: Boolean, default: true},
        },
        computed: {
            getClass(){
                return this.className?('form-group '+this.className):'form-group';
            },
            pulse(){
                return this.$parent.pulse;
            },
            defaultVal() {
                if (this.defaultValue != null && this.defaultValue != undefined) {
                    return this.defaultValue;
                }
                if (this.oldValue && this.$root.oldInput && this.$root.oldInput[this.name]) {
                    return this.$root.oldInput[this.name];
                }
                return null;
            }
        },
        mounted(){
            this.country = this.defaultVal
        },
        data() {
            return {
                country: null,
                countries: countries
            }
        },
        methods: {
            emitChange() {
                this.$emit('change',this.country);
            },
            emitInput(value) {
                this.$emit('input',this.country);
            }
        },
    }
</script>
