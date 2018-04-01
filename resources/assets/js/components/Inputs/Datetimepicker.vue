<template>
    <div class="datetime-picker">
        <div class="date">
            <el-date-picker
                    v-model="tripDate"
                    type="date"
                    :picker-options="datePickerOptions"
                    @change="changeDate"
                    :placeholder="lang.trip_date"
            >
            </el-date-picker>
        </div>
        <div class="time">
            <!--<el-time-select-->
                    <!--v-model="tripTime"-->
                    <!--:picker-options="{-->
                        <!--start: '05:00',-->
                        <!--step: '01:00',-->
                        <!--end: '22:00'-->
                      <!--}"-->
                    <!--:placeholder="lang.trip_time"-->
            <!--&gt;-->
            <!--</el-time-select>-->
            <el-select v-model="tripTime" :placeholder="lang.trip_time" :clearable="true"
                       prefix-icon="el-icon-time"
                       @change="changeTime">
                <el-option
                        v-for="item in timeOptions"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                </el-option>
            </el-select>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            defaultDate: null,
            defaultTime: null,
            lang: {type:Object,required:true},
        },
        data() {
            return {
                tripDate: this.defaultDate || null,
                tripTime: this.defaultTime || window.locale == 'fr'?'Toute la journée':'Any Time',
                datePickerOptions: {
                    disabledDate: function (myDate) {
                        // Disable all date before today
                        return moment(myDate).isBefore(moment().startOf('day'));
                    },
                    firstDayOfWeek: 1
                },
                timeOptions: window.locale == 'fr'?[{
                    value: null,
                    label: 'Toute la journée'
                }, {
                    value: '05:00',
                    label: 'À partir de 05:00'
                }, {
                    value: '06:00',
                    label: 'À partir de 06:00'
                }, {
                    value: '07:00',
                    label: 'À partir de 07:00'
                }, {
                    value: '08:00',
                    label: 'À partir de 08:00'
                }, {
                    value: '09:00',
                    label: 'À partir de 09:00'
                }, {
                    value: '10:00',
                    label: 'À partir de 10:00'
                }, {
                    value: '11:00',
                    label: 'À partir de 11:00'
                }, {
                    value: '12:00',
                    label: 'À partir de 12:00'
                }, {
                    value: '13:00',
                    label: 'À partir de 13:00'
                },{
                    value: '14:00',
                    label: 'À partir de 14:00'
                }, {
                    value: '15:00',
                    label: 'À partir de 15:00'
                }, {
                    value: '16:00',
                    label: 'À partir de 16:00'
                },{
                    value: '17:00',
                    label: 'À partir de 17:00'
                }, {
                    value: '18:00',
                    label: 'À partir de 18:00'
                }, {
                    value: '19:00',
                    label: 'À partir de 19:00'
                },{
                    value: '20:00',
                    label: 'À partir de 20:00'
                }, {
                    value: '21:00',
                    label: 'À partir de 21:00'
                }, {
                    value: '22:00',
                    label: 'À partir de 22:00'
                }
                ]:[{
                    value: '',
                    label: 'Any Time'
                }, {
                    value: '05:00',
                    label: 'From 05:00'
                }, {
                    value: '06:00',
                    label: 'From 06:00'
                }, {
                    value: '07:00',
                    label: 'From 07:00'
                }, {
                    value: '08:00',
                    label: 'From 08:00'
                }, {
                    value: '09:00',
                    label: 'From 09:00'
                }, {
                    value: '10:00',
                    label: 'From 10:00'
                }, {
                    value: '11:00',
                    label: 'From 11:00'
                }, {
                    value: '12:00',
                    label: 'From 12:00'
                }, {
                    value: '13:00',
                    label: 'From 13:00'
                },{
                    value: '14:00',
                    label: 'From 14:00'
                }, {
                    value: '15:00',
                    label: 'From 15:00'
                }, {
                    value: '16:00',
                    label: 'From 16:00'
                },{
                    value: '17:00',
                    label: 'From 17:00'
                }, {
                    value: '18:00',
                    label: 'From 18:00'
                }, {
                    value: '19:00',
                    label: 'From 19:00'
                },{
                    value: '20:00',
                    label: 'From 20:00'
                }, {
                    value: '21:00',
                    label: 'From 21:00'
                }, {
                    value: '22:00',
                    label: 'From 22:00'
                }
                ]

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
