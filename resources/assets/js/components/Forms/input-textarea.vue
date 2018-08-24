<template>
    <div :class="getClass">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <input type="hidden"
               :name="name"
               v-validate="validation"
               :value="value"
        >
        <vue-editor
                :class="{'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
                :id="name"
                :placeholder="placeholder"
                :editorToolbar="customToolbar"
                v-model="value"
        ></vue-editor>
        <small v-if="errors.has(name)" :id="name+'Error'" class="form-text text-danger">
            {{ errors.first(name) }}
        </small>
    </div>
</template>

<script>
    import {VueEditor} from "vue2-editor";

    export default {
        inject: ['$validator'],
        props: {
            label: {required: false, type: String},
            name: {required: true, type: String},
            customToolbar: {
                required: false, type: Array, default: function () {
                    return [[{header: [1, 2, false]}], ['bold', 'italic', 'underline'],
                        [{'list': 'ordered'}, {'list': 'bullet'}],];
                }
            },
            defaultValue: {required: false, type: String},
            className: {required: false, type: String},
            validation: {required: false, type: String},
            placeholder: {required: false, type: String},
            oldValue: {required: false, type: Boolean, default: true},

        },
        computed: {
            getClass() {
                return this.className ? ('form-group ' + this.className) : 'form-group';
            },
            pulse() {
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
            this.value = this.defaultVal
        },
        data(){
            return {
                value: null
            }
        }
    }
</script>
