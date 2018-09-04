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

        <!-- With Icon -->

        <div :class="{'animated pulse':pulse&&errors.has(name),'icon-form':true}" v-if="withIcon">
            <i class="fa fa-clock-o text-primary" aria-hidden="true"></i>
            <cleave type="text"
                    :class="{'invalid':errors.has(name),'form-control':true,'animated pulse':pulse&&errors.has(name)}"
                    :placeholder="placeholder"
                    :options="cleaveOptions"
                    v-model="value"
            ></cleave>
        </div>

        <!-- Without Icon -->

        <cleave v-else
                type="text"
                :class="{'invalid':errors.has(name),'form-control':true,'animated pulse':pulse&&errors.has(name)}"
                :placeholder="placeholder"
                :options="cleaveOptions"
                v-model="value"
        ></cleave>

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
            className: {required: false, type: String},
            validation: {required: false, type: String},
            placeholder: {required: false, type: String},
            oldValue: {required: false, type: Boolean, default: true},
            defaultValue: {required: false, type: String}
        },
        computed: {
            getClass(){
                return this.className?('form-group input-time '+this.className):'form-group';
            },
            pulse(){
                return this.$parent.pulse;
            },
            defaultVal() {
                if (this.defaultValue != null && this.defaultValue != undefined) {
                    return this.defaultValue;
                }
                if (this.oldValue && this.$root.oldInput) {
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
                cleaveOptions: {  time: true, timePattern: ['h', 'm'] }
            }
        }
    }
</script>
