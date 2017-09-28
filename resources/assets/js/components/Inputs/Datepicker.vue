
<template>
    <div>
        <el-date-picker
                v-if="isRequired"
                v-model="dateValue"
                :placeholder="placeholderInput"
                v-validate="'required'"
                type="date"
            >
        </el-date-picker>
        <el-date-picker
                v-else
                v-model="dateValue"
                :placeholder="placeholderInput"
                type="date"
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
            isRequired: {type: Boolean, default: false}
        },
        data(){
            return {
                nameInput: this.name || 'date',
                placeholderInput: this.placeholder,
                dateValue: this.value ? new Date(this.value) : null,
            }
        }
    }
</script>
