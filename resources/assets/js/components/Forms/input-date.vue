<template>
    <div :class="getClass">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <input type="hidden"
               :name="name"
               v-validate="validation"
               :value="date"
               v-if="name"
        >

        <!-- With Icon -->

        <div :class="{'animated pulse':pulse&&errors.has(name),'icon-form':true}" v-if="withIcon">
            <i class="fa fa-calendar text-primary" aria-hidden="true"></i>
            <el-date-picker
                    :class="{'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
                    v-model="date"
                    :type="type"
                    :format="format"
                    :value-format="valueFormat"
                    :placeholder="placeholder"
                    :id="name"
                    prefix-icon=" "
                    :picker-options="pickerOptions"
                    @change="emitChange"
            >
            </el-date-picker>
        </div>

        <!-- Without Icon -->

        <el-date-picker v-else
                :class="{'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
                v-model="date"
                :type="type"
                :format="format"
                :value-format="valueFormat"
                :placeholder="placeholder"
                :id="name"
                prefix-icon=" "
                :picker-options="pickerOptions"
                @change="emitChange"
        >
        </el-date-picker>

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
            withIcon: {required: false, default: false, type: Boolean},
            name: {required: false, type: String},
            type: {required: false, type: String},
            defaultValue: {required: false},
            defaultValueFormat: {required: false, type: String},
            format: {required: false, type: String},
            valueFormat: {required: false, type: String},
            className: {required: false, type: String},
            validation: {required: false, type: String},
            placeholder: {required: false, type: String},
            pickerOptions: {required:false, type: Object},
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
            if (typeof this.defaultVal === 'object') {
                this.date = this.defaultVal?(new this.$moment(this.defaultVal.date)).format(this.defaultValueFormat):null
            } else {
                this.date = this.defaultVal
            }
        },
        data() {
            return {
                date: null,
            }
        },
        methods: {
            emitChange(value) {
                this.$emit('change',value);
            }
        }
    }
</script>
