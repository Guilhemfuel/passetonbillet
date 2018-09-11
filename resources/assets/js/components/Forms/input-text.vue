<template>
    <div :class="getClass">
        <template v-if="type!='checkbox'">
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
                   @change="emitChange"
                   @input="emitInput"
            >
        </template>
        <!-- For checkbox only (label required) -->
        <label v-else-if="label && type=='checkbox'" :for="name">
            <input :type="type"
                   :class="{'form-control':true,'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
                   :id="name"
                   :name="name"
                   :placeholder="placeholder"
                   v-validate="validation"
                   v-model="inputValue"
                   @change="emitChange"
                   @input="emitInput"
            >
            <span class="pl-1" v-html="label"></span>
        </label>

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
                if (this.oldValue && this.$root.oldInput && this.$root.oldInput[this.name]) {
                    return this.$root.oldInput[this.name];
                }

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
        },
        methods: {
            emitChange() {
                this.$emit('change',this.inputValue);
            },
            emitInput(value) {
                this.$emit('input',this.inputValue);
            }
        },
    }
</script>
