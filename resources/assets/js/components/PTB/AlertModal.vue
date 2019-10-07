<template>
    <div class="alert-component">

        <div class="open-alert-modal" @click.prevent="modalAlertOpened=true">
            <slot></slot>
        </div>

        <modal :is-open="modalAlertOpened"
               @close-modal="modalAlertOpened=false"
               :title="trans('tickets.alerts.modal.title')"
               class="review-modal">

            <p class="text-justify">
                {{trans('tickets.alerts.modal.explanation')}}
            </p>

            <vue-form class="container-fluid p-0 text-left" :callback="createAlert">

                <input-text
                        v-if="!user"
                        type="email"
                        v-model="alert.email"
                        validation="required|email"
                        placeholder="Email"
                        label="Email"
                        name="email"
                ></input-text>

                <input-station
                        v-model="alert.departure_city"
                        validation="required"
                        :placeholder="trans('tickets.alerts.modal.form.departure_station')"
                        :label="trans('tickets.alerts.modal.form.departure_station')"
                        :default-value="alert.departure_city"
                        name="departure_city"
                        :with-icon="false"
                ></input-station>

                <input-station
                        v-model="alert.arrival_city"
                        validation="required"
                        :placeholder="trans('tickets.alerts.modal.form.arrival_station')"
                        :label="trans('tickets.alerts.modal.form.arrival_station')"
                        :default-value="alert.arrival_city"
                        name="arrival_city"
                        :with-icon="false"
                ></input-station>

                <div class="row">
                    <div class="col">
                        <input-date
                                v-model="alert.travel_date_start"
                                :placeholder="trans('tickets.alerts.modal.form.departure_date_start')"
                                :label="trans('tickets.alerts.modal.form.departure_date_start')"
                                name="departure_date"
                                validation="required"
                                placeholder="DD/MM/YYYY"
                                format="dd/MM/yyyy"
                                value-format="dd/MM/yyyy"
                                default-value-format="DD/MM/YYYY"
                                :default-value="alert.travel_date_start"
                                :with-icon="false"
                                :picker-options="startDatePickerOptions"
                                @change="startDateChange()"
                        ></input-date>
                    </div>
                    <div class="col">
                        <input-date
                                v-model="alert.travel_date_end"
                                :placeholder="trans('tickets.alerts.modal.form.departure_date_end')"
                                :label="trans('tickets.alerts.modal.form.departure_date_end')"
                                name="departure_date"
                                validation="required"
                                placeholder="DD/MM/YYYY"
                                format="dd/MM/yyyy"
                                value-format="dd/MM/yyyy"
                                default-value-format="DD/MM/YYYY"
                                :default-value="alert.travel_date_end"
                                :with-icon="false"
                                :picker-options="endDatePickerOptions"
                                @change="travelDateEndChanged=true"
                        ></input-date>
                    </div>
                </div>



                <div id="recaptcha-main" class="g-recaptcha d-flex justify-content-center align-items-center" :data-sitekey="reCaptchaSiteKey"></div>

                <button class="btn btn-block btn-ptb mt-3" type="submit" :disabled="!rendered && !user">
                    <i aria-hidden="true" class="fa fa-bell"></i> {{trans('tickets.alerts.modal.submit')}}
                </button>
            </vue-form>
        </modal>
    </div>
</template>

<script>
    export default {
        props: {
            defaultDepartureStation: {required: false},
            defaultArrivalStation: {required: false},
            defaultTripDate: {required:false},
            modalAlreadyOpened: {type:Boolean, default:false}
        },
        data() {
            return {
                submitted: false,
                user: this.$root.user,
                modalAlertOpened: this.modalAlreadyOpened,
                travelDateEndChanged: false,
                alert: {
                    user_id: this.$root.user ? this.$root.user.id : null,
                    email: "",
                    departure_city: this.defaultDepartureStation,
                    arrival_city: this.defaultArrivalStation,
                    travel_date_start: null,
                    travel_date_end: null,
                },
                rendered: false,
                reCaptchaSiteKey: window.nocaptcha_site_key,
            }
        },
        mounted() {
            // Load script repatcha
            if (typeof grecaptcha === "undefined" && !this.user) {
                var script = document.createElement("script");
                script.src = "https://www.google.com/recaptcha/api.js?render=explicit";
                script.onload = this.renderWait;
                document.head.appendChild(script);
            } else this.render();

            let defaultDate = moment(this.defaultTripDate,'DD/MM/YYYY').isAfter(moment().add(1, 'days').startOf('day')) ?
                this.defaultTripDate : moment().add(1, 'days').startOf('day').format('DD/MM/YYYY');
            this.alert.travel_date_start = defaultDate;
            this.alert.travel_date_end = defaultDate;
            console.log(this.alert);

        },
        computed: {
            startDatePickerOptions() {
                return {
                    disabledDate: (myDate) => {
                        // Disable all date before today
                        return moment(myDate).isBefore(moment().add(1, 'days').startOf('day')) ||
                            ( this.travelDateEndChanged && moment(myDate).startOf('day').isAfter(moment(this.alert.travel_date_end,'DD/MM/YYYY').endOf('day')) );
                    },
                    firstDayOfWeek: 1
                }
            },
            endDatePickerOptions() {
                return {
                    disabledDate: (myDate) => {
                        // Disable all date before today
                        return moment(myDate).isBefore(moment().add(1, 'days').startOf('day')) || moment(myDate).isBefore(moment(this.alert.travel_date_start,'DD/MM/YYYY').endOf('day'));
                    },
                    firstDayOfWeek: 1
                }
            },
        },
        methods: {
            startDateChange() {
                if (!this.travelDateEndChanged) {
                    this.alert.travel_date_end = this.alert.travel_date_start;
                }
            },
            renderWait() {
                if (this.user) return;
                setTimeout(() => {
                    if (typeof grecaptcha !== "undefined" && typeof grecaptcha.render !== "undefined" && this.modalAlertOpened)  this.render();
                    else this.renderWait();
                }, 200);
            },
            render() {
                if (this.user) return;
                setTimeout(() => {
                    grecaptcha.render('recaptcha-main'); // 'recaptcha-main' is the id that was assigned to the widget
                    this.rendered = true;
                }, 2000);
            },
            createAlert() {

                let data = this.alert;
                if (!this.user) {
                    data['g-recaptcha-response'] = grecaptcha.getResponse();
                }

                this.$http.post(this.route('api.alerts.create'), data).then(response => {

                    // Sucess
                    this.modalAlertOpened = false;

                    this.$emit('alert-created',response.body.alert);

                    this.$root.logEvent('create_alert',response.body.alert);

                    this.$message({
                        message: this.trans('tickets.alerts.success'),
                        type: 'success',
                        duration: 5000
                    });

                }, response => {

                    // failure
                    this.$message({
                        message: response.body.message ? response.body.message : this.trans('common.error'),
                        type: 'error',
                        duration: 5000
                    });
                    this.modalAlertOpened = false;
                });
            }
        },
        watch: {
            modalAlertOpened: function(value) {
                if (value==true) {
                    this.render();

                    this.$root.logEvent('open_alert_modal');
                } else {
                    this.rendered = false;
                }
            }
        }
    }
</script>
