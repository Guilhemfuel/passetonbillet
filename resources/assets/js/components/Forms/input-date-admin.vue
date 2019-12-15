<template>
    <div :class="getClass">
        <label v-if="label" :for="name">
            {{label}}
        </label>
        <input :name="name"
               :class="{'form-control':true,'invalid':errors.has(name),'animated pulse':pulse&&errors.has(name)}"
               v-validate="validation"
               :id="name"
               v-model="date"
               @change="emitChange"
               @input="onInput"
               :placeholder="placeholder"
               @focus="$emit('focus');"
               @blur="emitBlur"

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
            name: {required: false, type: String},
            type: {required: false, type: String},
            defaultValue: {required: false},
            defaultValueFormat: {required: false, type: String},
            format: {required: false, type: String},
            valueFormat: {required: false, type: String},
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
        watch: {
            defaultValue: function (newVal) {
                this.date = newVal;
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
            onInput() {
                // On input add slash and limit to 10 chars
                let value = this.date;

                var numChars = value.length;

                if (numChars>10) {
                    value = this.date.slice(0,10);
                }

                if(numChars === 2 || numChars === 5){
                    value += '/';
                } else {
                    if (!"0123456789\\".includes(value.slice(-1))) {
                        value = this.date.slice(0,numChars - 1);
                    }
                }

                this.date = value;

                this.emitInput();

            },
            cleanValue () {
                let value = this.date;
                // Emit change but change value before hand

                let moment = this.$moment(value, 'DD/MM/YYYY',true);
                if (!moment.isValid() ) {
                    this.date = null;
                }
            },
            emitBlur(value) {
              this.emitChange();
              this.$emit('blur');
            },
            emitChange() {
                this.cleanValue();
                this.$emit('input',this.date);
            },
            emitInput() {
                this.$emit('input',this.date);
            }
        }
    }
</script>
