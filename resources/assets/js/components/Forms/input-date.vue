<template>
    <div :class="getClass">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <input type="hidden"
               :name="name"
               v-validate="validation"
               :value="date"
        >

        <!-- With Icon -->

        <div :class="{'animated pulse':pulse&&errors.has(name),'icon-form':true}" v-if="withIcon">
            <i class="fa fa-calendar text-primary" aria-hidden="true"></i>
            <el-date-picker
                    :class="{'invalid':errors.has(name)}"
                    v-model="date"
                    :type="type"
                    :format="format"
                    :value-format="valueFormat"
                    :placeholder="placeholder"
                    :id="name"
                    prefix-icon=" "
                    :picker-options="pickerOptions"
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
            name: {required: true, type: String},
            type: {required: false, type: String},
            defaultValue: {required: false, type: Object},
            defaultValueFormat: {required: false, type: String},
            format: {required: false, type: String},
            valueFormat: {required: false, type: String},
            className: {required: false, type: String},
            validation: {required: false, type: String},
            placeholder: {required: false, type: String},
            pickerOptions: {required:false, type: Object}
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
                date: this.defaultValue?(new this.$moment(this.defaultValue.date)).format(this.defaultValueFormat):null,
            }
        }
    }
</script>
