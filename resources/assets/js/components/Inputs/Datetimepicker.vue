<template>
    <div class="datetime-picker">
        <div class="date">
            <el-date-picker
                    v-model="tripDate"
                    type="date"
                    :picker-options="datePickerOptions"
                    @change="changeDate"
                    :placeholder="lang.trip_date">
            </el-date-picker>
        </div>
        <div class="time">
            <el-time-select
                    v-model="tripTime"
                    :picker-options="{
                        start: '05:00',
                        step: '01:00',
                        end: '22:00'
                      }"
                    @change="changeTime"
                    :placeholder="lang.trip_time">
            </el-time-select>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            defaultDate: null,
            defaultTime: null,
            lang: {type:Object,required:true}
        },
        data() {
            return {
                tripDate: this.defaultDate || null,
                tripTime: this.defaultTime || null,
                datePickerOptions: {
                    disabledDate: function (myDate) {
                        // Disable all date before today
                        return moment(myDate).isBefore(moment().startOf('day'));
                    }
                },
            }
        },
        methods: {
            changeDate() {
                this.$emit('change-date',this.tripDate);
            },
            changeTime() {
                this.$emit('change-time',this.tripTime);
            }
        }
    }
</script>
