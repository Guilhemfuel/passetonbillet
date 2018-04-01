
<template>
    <div class="input-date">
        <el-date-picker
                v-if="isRequired"
                v-model="inputValue"
                @change="changeDate"
                :placeholder="placeholderInput"
                v-validate="'required'"
                type="date"
                format="dd/MM/yyyy"
                value-format="yyyy-MM-dd"
                :clearable="false"
            >
        </el-date-picker>
        <el-date-picker
                v-else
                v-model="inputValue"
                @change="changeDate"
                :placeholder="placeholderInput"
                type="date"
                format="dd/MM/yyyy"
                value-format="yyyy-MM-dd"
                :popper-class="popperClass"
                :clearable="false"
        >
        </el-date-picker>
        <input type="hidden" :name="nameInput" :value="dateValue"/>
    </div>

</template>

<script>
    export default {
        props:  {
            name: null,
            value: null,
            placeholder: null,
            popperClass: null,
            isRequired: {type: Boolean, default: false}
        },
        data(){
            return {
                nameInput: this.name || 'date',
                placeholderInput: this.placeholder,
                dateValue: this.value ? this.value : null,
                inputValue:  this.value
            }
        },
        methods: {
            changeDate: function () {
                let date = new moment(this.inputValue);
                this.dateValue = date.format('YYYY-MM-DD');
            }
        }
    }
</script>
