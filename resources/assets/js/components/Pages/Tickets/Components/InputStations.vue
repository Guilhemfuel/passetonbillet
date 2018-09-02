<template>
    <div class="trip-picker">
        <div class="swap" @click="swap">
            <i class="fa fa-exchange " aria-hidden="true"></i>
        </div>
        <div class="departure">
            <input-station v-model="departStation"
                           :placeholder="trans('tickets.buy.inputs.trippicker.arrival_satation')"
                           @change="changeDeparture"
                           :default-value="departStation"
                           :with-icon="false"
                           class="mb-0"
            >
            </input-station>
        </div>
        <div class="arrival">
            <input-station v-model="arrivalStation"
                           :placeholder="trans('tickets.buy.inputs.trippicker.arrival_satation')"
                           @change="changeArrival"
                           :default-value="arrivalStation"
                           :with-icon="false"
            >
            </input-station>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            defaultDepart: {required:false},
            defaultArrival: {required:false}
        },
        data() {
            return {
                departStation: this.defaultDepart || 4916,
                arrivalStation: this.defaultArrival || 8267,
            }
        },
        methods: {
            changeDeparture(station) {
                this.departStation = station;
                this.$emit('change-departure',this.departStation);
            },
            changeArrival(station) {
                this.arrivalStation = station;
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
