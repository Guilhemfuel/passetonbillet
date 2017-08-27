
<template>
    <div>
        <el-time-picker
            v-model="timeValue"
            :placeholder="placeholderInput"
            >
        </el-time-picker>
        <input type="hidden" :name="nameInput" :value="timeValue"/>
    </div>

</template>

<script>
    export default {
        props:  {
            name: null,
            value: null,
            placeholder: null
        },
        data(){
            return {
                nameInput: this.name || 'time',
                placeholderInput: this.placeholder,
                timeValue: this.value ? new Date(this.value) : null,
            }
        }
    }
</script>
