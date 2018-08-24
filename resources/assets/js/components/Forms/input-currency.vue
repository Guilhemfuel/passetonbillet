<template>
    <div :class="getClass">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <input type="hidden"
               :name="name"
               v-validate="validation"
               :value="currency"
        >
        <el-select v-model="currency" placeholder="Select"
                   :class="{'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
        >
            <el-option
                    v-for="currency in currencies"
                    :key="currency.name"
                    :label="currency.icon +' - '+currency.name"
                    :value="currency.label"
                    :id="name">
                <span style="float: left">{{ currency.name }}</span>
                <span style="float: right; color: #8492a6; font-size: 13px">{{ currency.label }} - {{ currency.icon }}</span>
            </el-option>
        </el-select>
        <small v-if="errors.has(name)" :id="name+'Error'" class="form-text text-danger">
            {{ errors.first(name) }}
        </small>
    </div>
</template>

<script>
    export default {
        inject: ['$validator'],
        props: {
            label: {required: false, type: String},
            name: {required: true, type: String},
            type: {required: false, type: String, default: 'text'},
            defaultValue: {required: false, type: String},
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
                if (this.oldValue && this.$root.oldInput[this.name]) {
                    return this.$root.oldInput[this.name];
                }
                return null;
            }
        },
        mounted(){
            this.currency = this.defaultVal
        },
        data() {
            return {
                currency: null,
                currencies: [{
                    name: 'Euro',
                    icon: '€',
                    label: 'EUR'
                }, {
                    name: 'Dollars',
                    icon: '$',
                    label: 'USD'
                },{
                    name: 'British Pound',
                    icon: '£',
                    label: 'GBP'
                }],
            }
        }
    }
</script>
