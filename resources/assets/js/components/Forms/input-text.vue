<template>
    <div :class="getClass">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <input :type="type"
               :class="{'form-control':true,'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
               :id="name"
               :name="name"
               :placeholder="placeholder"
               v-validate="validation"
               v-model="inputValue"
        >
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
                    console.log('no');

                    return this.defaultValue;
                }
                if (this.oldValue && this.$root.oldInput[this.name]) {
                    console.log('ok');
                    return this.$root.oldInput[this.name];
                }
                console.log('null');

                return null;
            }
        },
        mounted(){
            this.inputValue = this.defaultVal
        },
        data() {
            return {
                inputValue: null,
            }
        }
    }
</script>
