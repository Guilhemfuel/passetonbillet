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
                   :class="{'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}">
            <el-option
                    v-for="country in countries"
                    :key="country.code"
                    :label="country.name"
                    :value="country.code">
                <span style="float: left">{{ country.name }}</span>
                <span style="float: right; color: #8492a6; font-size: 13px">{{ country.code }}</span>
            </el-option>
        </el-select>
        <small v-if="errors.has(name)" :id="name+'Error'" class="form-text text-danger">
            {{ errors.first(name) }}
        </small>
    </div>
</template>

<script>
    import countries from '../../data/countries.json';

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
        },
        computed: {
            getClass(){
                return this.className?('form-group '+this.className):'form-group';
            },
            pulse(){
                return this.$parent.pulse;
            }
        },
        data() {
            return {
                country: this.defaultValue,
                countries: countries
            }
        }
    }
</script>
