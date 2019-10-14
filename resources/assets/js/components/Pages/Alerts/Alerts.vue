<template>
    <div class="col-12 mt-0 mt-md-3">

        <h1 class="card-title mb-0">{{trans('tickets.alerts.page.title')}}</h1>

        <div class="card">
            <ul class="list-group list-group-flush">
                <li class="list-group-item" v-for="alert in alerts" :key="alert.id">
                    <span class="text-primary">{{ucFirst(formatDate(alert.travel_date_start))}} - {{ucFirst(formatDate(alert.travel_date_end))}}</span> :
                    {{alert.departure_city.name}}
                    <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    {{alert.arrival_city.name}}
                    <span class="pull-right">
                        <button class="btn btn-sm btn-outline-danger" @click.prevent="deleteAlert(alert)">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </span>
                </li>
            </ul>
            <div class="card-body text-center p-2">
                <alert-modal @alert-created="onAlertCreated">
                    <a href="#">
                        <i class="fa fa-bell" aria-hidden="true"></i>
                        {{trans('tickets.alerts.page.btn_create_new')}}
                    </a>
                </alert-modal>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        props: {
            defaultAlerts: {type: Array, required: true}
        },
        data() {
            return {
                alerts: this.defaultAlerts,
                user: this.$root.user
            }
        },
        computed: {},
        mounted() {
        },
        methods: {
            formatDate(date, input_format = 'YYYY-MM-DD', output_format = 'dddd Do MMMM') {
                return (new moment(date, input_format)).format(output_format);
            },
            ucFirst(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },
            onAlertCreated(alert) {
                this.alerts.push(alert);
            },
            deleteAlert(alert) {
                this.$http.delete(this.route('api.alerts.delete',[alert.id])).then(response => {

                    var removeIndex = this.alerts.map(function(item) { return item.id; }).indexOf(alert.id);
                    ~removeIndex && this.alerts.splice(removeIndex, 1);

                    this.$message({
                        message: response.body.message,
                        type: 'success',
                        duration: 5000
                    });

                }, response => {

                    // failure
                    this.$message({
                        message: response.body.message,
                        type: 'error',
                        duration: 5000
                    });
                    this.modalAlertOpened = false;
                });
            }
        }
    }
</script>