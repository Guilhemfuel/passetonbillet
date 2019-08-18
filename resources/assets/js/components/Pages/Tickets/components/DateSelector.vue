<template>
    <div class="row date-selector p-3 justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="row">
                <button :disabled="previousDisabled || loading" class="left-arrow arrow" @click="changeDate(momentDate.clone().add(-1, 'days'))">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>
                <div class="col current-date">
                    <p class="text-center mb-0">{{momentDate.format('dddd Do MMMM YYYY')}}</p>
                </div>
                <button :disabled="loading" class="right-arrow arrow" @click="changeDate(momentDate.clone().add(1, 'days'))">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            date: {required:true},
            loading: {required: false, default:false}
        },
        data() {
            return {

            }
        },
        computed: {
            momentDate() {
                let date = new moment(this.date, 'DD/MM/YYYY');
                if (this.isPast(date)) {
                    return new moment();
                } else {
                    return (new moment(this.date, 'DD/MM/YYYY'));
                }
            },
            previousDisabled() {
                return this.isPast(this.momentDate.clone().add(-1, 'days'));
            }
        },
        methods: {
            changeDate(newDate) {
                if (!this.isPast(newDate)) {
                    this.$emit('change-date',newDate.format('DD/MM/YYYY'));
                }
            },
            isPast(date) {
                return date.isBefore(new moment().startOf('day'));
            }
        }
    }
</script>