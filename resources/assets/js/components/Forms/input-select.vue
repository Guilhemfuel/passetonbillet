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
        <el-custom-select v-model="value" placeholder="Select"
                   :class="{'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
        >
            <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                    :id="item.value">
                {{item.label}}
            </el-option>
        </el-custom-select>
        <small v-if="errors.has(name)" :id="name+'Error'" class="form-text text-danger">
            {{ errors.first(name) }}
        </small>
    </div>
</template>

<script>

    import ElCustomSelect from '../Overrides/select.vue';

    export default {
        components: {
            'el-custom-select': ElCustomSelect,
        },
        inject: ['$validator'],
        props: {
            label: {required: false, type: String},
            name: {required: true, type: String},
            type: {required: false, type: String, default: 'text'},
            defaultValue: {required: false, type: String},
            className: {required: false, type: String},
            validation: {required: false, type: String},
            placeholder: {required: false, type: String},
            options: {required: true, type: Array}, // Each item must have label and value
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
            this.value = this.defaultVal
        },
        data() {
            return {
                value: null,
            }
        }
    }
</script>
