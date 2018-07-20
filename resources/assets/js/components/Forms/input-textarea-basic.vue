<template>
    <div :class="getClass">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <input type="hidden" :name="name" :value="actualValue" v-validate="validation">
        <textarea
               :class="{'form-control':true,'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
               :id="name"
               :placeholder="placeholder"
               v-model="inputValue"
        ></textarea>
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
            defaultValue: {required: false, type: String, default: ''},
            className: {required: false, type: String},
            validation: {required: false, type: String},
            placeholder: {required: false, type: String},
            specialCharDisabled: {required:false, default: false, type: Boolean}
        },
        computed: {
            getClass(){
                return this.className?('form-group '+this.className):'form-group';
            },
            pulse(){
                return this.$parent.pulse;
            },
            actualValue(){
                if (!this.specialCharDisabled) return this.inputValue;
                return this.inputValue.replace( /\r?\n/gi, '' );
            }
        },
        data() {
            return {
                inputValue: this.defaultValue,
            }
        }
    }
</script>
