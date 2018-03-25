<template>
    <div class="trip-picker">
        <div class="swap" @click="swap">
            <i class="fa fa-exchange " aria-hidden="true"></i>
        </div>
        <div class="departure">
            <el-select v-model="departStation" :placeholder="lang.departure_station" filterable popper-class="trip-picker-dropdown" @change="changeDeparture">
                <el-option
                        v-for="station in stations"
                        :key="station.id"
                        :label="station.name"
                        :value="station.id"
                        :disabled="arrivalStation==station.id"
                >
                    <span class="station"><span :class="'flag-icon flag-icon-'+station.country"></span> {{station.name}}</span>
                </el-option>
            </el-select>
        </div>
        <div class="arrival">
            <el-select v-model="arrivalStation" :placeholder="lang.arrival_station" filterable popper-class="trip-picker-dropdown" @change="changeArrival">
                <el-option
                        v-for="station in stations"
                        :key="station.id"
                        :label="station.name"
                        :value="station.id"
                        :disabled="departStation==station.id"
                >
                    <span class="station"><span :class="'flag-icon flag-icon-'+station.country"></span> {{station.name}}</span>
                </el-option>
            </el-select>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            stations: {required: true},
            defaultDepart: null,
            defaultArrival: null,
            lang: {type:Object,required:true}
        },
        data() {
            return {
                departStation: this.defaultDepart || null,
                arrivalStation: this.defaultArrival || null,
            }
        },
        methods: {
            changeDeparture() {
                this.$emit('change-departure',this.departStation);
            },
            changeArrival() {
                this.$emit('change-arrival',this.arrivalStation);
            },
            swap() {
                var temp = this.arrivalStation;
                this.arrivalStation = this.departStation;
                this.departStation = temp;
                this.$emit('change-departure',this.departStation);
                this.$emit('change-arrival',this.arrivalStation);
            }
        }
    }
</script>
