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

                <input-date
                        v-model="alert.travel_date"
                        :placeholder="trans('tickets.alerts.modal.form.departure_date')"
                        :label="trans('tickets.alerts.modal.form.departure_date')"
                        name="departure_date"
                        validation="required"
                        placeholder="DD/MM/YYYY"
                        format="dd/MM/yyyy"
                        value-format="dd/MM/yyyy"
                        default-value-format="DD/MM/YYYY"
                        :default-value="alert.travel_date"
                        :with-icon="false"
                        :picker-options="datePickerOptions"
                >

                </input-date>

                <div id="recaptcha-main" class="g-recaptcha d-flex justify-content-center align-items-center" :data-sitekey="reCaptchaSiteKey"></div>

                <!--<input-textarea-basic name="text"-->
                <!--v-model="review.text"-->
                <!--validation="required"-->
                <!--:placeholder="trans('common.review.modal.placeholder')"-->
                <!--class="col-12"-->
                <!--&gt;-->

                <!--</input-textarea-basic>-->

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
            defaultTripDate: {required:false}
        },
        data() {
            return {
                submitted: false,
                user: this.$root.user,
                modalAlertOpened: false,
                alert: {
                    user_id: this.$root.user ? this.$root.user.id : null,
                    email: "",
                    departure_city: this.defaultDepartureStation,
                    arrival_city: this.defaultArrivalStation,
                    travel_date: this.defaultTripDate,
                },
                datePickerOptions: {
                    disabledDate: function (myDate) {
                        // Disable all date before today
                        return moment(myDate).isBefore(moment().endOf('day'));
                    },
                    firstDayOfWeek: 1
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
        },
        computed: {
        },
        methods: {
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
