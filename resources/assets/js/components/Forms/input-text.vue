<template>
    <div :class="getClass">
        <template v-if="type!='checkbox'">
            <label v-if="label" :for="name">
                {{label}}
                <el-tooltip class="item"
                            effect="dark"
                            :content="help"
                            placement="top" v-if="help">
                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                </el-tooltip>

            </label>

            <input-prepend-append>
                <template slot="prepend" v-if="$slots.prepend">
                    <slot name="prepend"></slot>
                </template>
                <input :type="type"
                       :class="{'form-control':true,'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
                       :id="name"
                       :name="name"
                       :placeholder="placeholder"
                       :disabled="disabled"
                       v-validate="validation"
                       v-model="inputValue"
                       @change="emitChange"
                       @input="emitInput"
                       @focus="$emit('focus');" @blur="$emit('blur');"
                >
                <template slot="append" v-if="$slots.append">
                    <slot name="apend"></slot>
                </template>
            </input-prepend-append>
        </template>

        <!-- For checkbox only (label required) -->
        <label v-else-if="label && type=='checkbox'" :for="name">
            <input :type="type"
                   :class="{'form-control':true,'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
                   :id="name"
                   :name="name"
                   :placeholder="placeholder"
                   :disabled="disabled"
                   v-validate="validation"
                   v-model="inputValue"
                   @change="emitChange"
                   @input="emitInput"
                   @focus="$emit('focus');" @blur="$emit('blur');"

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
            disabled: {required: false, type: Boolean, default: false},
            help: {required: false, type: String, default: null},
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
