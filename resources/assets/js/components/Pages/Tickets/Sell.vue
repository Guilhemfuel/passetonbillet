<template>
    <div class="col-12">
        <!-- Input and ticket selecting -->

        <h1 class="card-title mb-3" v-if="state=='input'">{{trans('tickets.sell.step_1')}}</h1>
        <h1 class="card-title mb-3" v-else-if="state=='select'">{{trans('tickets.sell.step_1')}}</h1>
        <h1 class="card-title mb-3" v-else-if="state=='searching'">{{trans('tickets.sell.searching')}}</h1>

        <!-- NAME + REFERENCE -->
        <div class="card" v-if="startCardVisible">
            <div class="card-body">
                <transition enter-class="pre-animated"
                            enter-active-class="animated fadeIn"
                            leave-active-class="animated fadeOut">
                    <div v-if="state=='input'">
                        <p class="card-text text-justify">
                            {{trans('tickets.sell.description')}}
                        </p>

                        <div class="row justify-content-center">
                            <form class="col-sm-12 col-md-10 col-lg-6">
                                <div class="col-xs-12 form-group">

                                    <input-text id="email" validation="required|email"
                                                class="animated pulse"
                                                type="email"
                                                :label="trans('tickets.sell.inputs.email')"
                                                :placeholder="trans('tickets.sell.inputs.email')"
                                                v-model="form.email"
                                                required
                                                name="email"
                                                :default-value="form.email"
                                                v-if="formExtraFields"
                                    ></input-text>

                                    <input-text id="last_name" validation="required"
                                                :label="trans('tickets.sell.inputs.last_name')"
                                                :placeholder="trans('tickets.sell.inputs.last_name')"
                                                v-model="form.last_name"
                                                required
                                                name="last_name"
                                                :default-value="form.last_name"
                                    ></input-text>

                                </div>
                                <div class="col-xs-12 form-group">

                                    <input-text id="booking_code" validation="required|max:7|min:6"
                                                :label="trans('tickets.sell.inputs.booking_code')"
                                                placeholder="ex: QNUSHT"
                                                v-model="form.booking_code"
                                                required
                                                name="booking_code"
                                                :default-value="form.booking_code"
                                                :help="trans('tickets.sell.help_booking_code')"
                                    >

                                    </input-text>

                                </div>
                                <button type="submit" class="btn btn-ptb-blue btn-block" @click.prevent="search">
                                    {{trans('tickets.sell.search')}}
                                </button>
                            </form>
                        </div>
                    </div>

                </transition>

                <!-- LOADING -->

                <transition enter-class="pre-animated"
                            enter-active-class="animated fadeIn"
                            leave-active-class="animated fadeOut">
                    <div v-if="state=='searching'">
                        <div class="p-5">
                            <loader :class-name="'mx-auto'"></loader>
                        </div>
                    </div>
                </transition>

                <!-- SELECT TICKET -->

                <transition enter-class="pre-animated"
                            enter-active-class="animated fadeIn"
                            leave-active-class="animated fadeOut">
                    <div v-if="state=='select'">
                        <p class="card-text text-justify">
                            {{trans('tickets.sell.select')}}
                        </p>
                    </div>
                </transition>

            </div>

        </div>

        <!-- SELECT TICKET -->

        <template v-if="state=='select' && tickets.length>1">
            <div class="row mt-4 px-sm-4 px-md-0">
                <div v-for="(ticket,index) in tickets" class="col-12 col-sm-6 col-lg-6 col-xl-4" :key="index">
                    <ticket :ticket="ticket" :selecting="true"
                            v-on:sell="sell(ticket.id)"></ticket>
                </div>
            </div>
        </template>

        <!-- selling details and confirm sale -->
        <div class="row" v-if="state=='selling_details'">
            <div class="col-12 mb-3">
                <h4 class="card-title mb-0" v-if="step==2">
                    {{trans('tickets.sell.step_2')}}
                </h4>
                <h4 class="card-title mb-0" v-if="step==3">
                    {{trans('tickets.sell.step_3')}}
                </h4>
                <h4 class="card-title mb-0" v-if="step==4">
                    {{trans('tickets.sell.step_4')}}
                </h4>
            </div>

            <div v-if="step==2" class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text text-justify">
                            {{trans('tickets.sell.details')}}
                        </p>
                        <form method="post" ref="sell_form">
                            <input type="hidden" name="index" :value="selectedTicket.id">

                            <div class="form-group">
                                <label>{{trans('tickets.sell.inputs.price')}}</label>
                                <div class="input-group">
                                    <!-- Todo: ajouter l'option de la currency-->
                                    <span class="input-group-addon">{{selectedTicket.bought_currency_symbol}}</span>
                                    <input type="text"
                                           :class="'form-control' + (errors.has('price')?' is-invalid':'')"
                                           :aria-label="trans('tickets.sell.inputs.price')"
                                           :placeholder="trans('tickets.sell.inputs.price')"
                                           v-model="selectedTicket.price"
                                           name="price"
                                           v-validate="'required|numeric|min_value:1'">
                                </div>
                                <span v-if="errors.has('price')" class="invalid-feedback">{{ errors.first('price')
                                    }}</span>
                            </div>

                            <input-text
                                    name="cgu"
                                    type="checkbox"
                                    @change="cgu = !cgu"
                                    :label="trans('tickets.sell.manual.form.cgu')">
                            </input-text>

                            <button type="submit" class="btn btn-ptb btn-block mt-4" @click.prevent="step3">
                                {{trans('tickets.sell.submit')}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div v-if="step==3" class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <pdf-viewer @returnData="getPdf"></pdf-viewer>
                    </div>
                </div>
            </div>

            <div v-if="step==4" class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">

                        <transition enter-class="pre-animated"
                                    enter-active-class="animated fadeIn"
                                    leave-active-class="animated fadeOut">
                            <div v-if="loaderSellTicket==true">
                                <div class="p-5">
                                    <loader :class-name="'mx-auto'"></loader>
                                </div>
                            </div>
                        </transition>

                        <p class="text-center">{{trans('tickets.step_4.text_1')}}</p>
                        <p class="text-center">{{trans('tickets.step_4.text_2')}}</p>
                        <p class="text-center">{{trans('tickets.step_4.text_3')}}</p>

                        <vue-form name="formSellTicket" method="post" :action="route('public.ticket.sell.post')" ref="sell_ticket">
                            <input type="hidden" name="index" :value="selectedTicket.id">
                            <input type="hidden" name="price" :value="selectedTicket.price">
                            <input type="hidden" name="file" :value="pdf.file">
                            <input type="hidden" name="page" :value="pdf.page">
                            <input type="hidden" name="cgu" :value="cgu">

                            <input-text
                                    name="unique-ticket"
                                    type="checkbox"
                                    :label="trans('tickets.step_4.text_4')"
                                    validation="required">
                            </input-text>

                            <button type="submit" class="btn btn-ptb btn-block mt-4" @click.prevent="submitForm()">
                                {{trans('tickets.sell.submit')}}
                            </button>
                        </vue-form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-6">
                <ticket :ticket="selectedTicket" :display="true"
                        class-name="mb-0 mt-sm-4 mt-md-0 max-sized"></ticket>
                <p class="text-center">{{trans('tickets.sell.preview')}}</p>
            </div>
        </div>
    </div>

</template>

<script>
    import PdfViewer from "../../PTB/PdfViewer.vue";

    export default {
      components: {PdfViewer},
      props: {
            api: {type: Object, required: true},
            routes: {type: Object, required: true},
            user: {type: Object, required: true},
        },
        data() {
            return {
                csrf: window.csrf,
                state: 'input',
                loaderSellTicket: false,
                step: 2,
                form: {
                    email: null,
                    last_name: this.user.last_name,
                    first_name: this.user.first_name,
                    booking_code: null,
                    _token: this.csrf,
                },
                formExtraFields: false,
                tickets: [],
                selectedTicket: {},
              pdf: {
                file: null,
                page: null
              },
              cgu: false
            }
        },
        computed: {
            startCardVisible: function () {
                return ['input', 'searching', 'select'].includes(this.state);
            },
        },
        methods: {
            search() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.state = 'searching';
                        this.$http.post(this.api.tickets.search, this.form)
                            .then(response => {

                                if (response.ok) {

                                    if (response.data.data.length == 1) {
                                        this.state = 'selling_details';
                                        this.tickets = response.data.data;
                                        this.tickets[0].user = this.user;
                                        this.tickets[0].id = 0;
                                        this.tickets[0].currency = this.tickets[0].bought_currency;
                                        this.tickets[0].price = Math.floor(this.tickets[0].bought_price);
                                        this.selectedTicket = this.tickets[0];
                                    } else {
                                        this.state = 'select';
                                        for (var i = 0; i < response.data.data.length; i++) {
                                            response.data.data[i].id = i;
                                            this.tickets.push(response.data.data[i]);
                                        }
                                    }
                                }
                            }, response => {

                                // Extra form of fields not present yet, we add them
                                if (! this.formExtraFields) {
                                    this.formExtraFields = true;
                                    this.form.email = this.user.email;
                                    this.$notify({
                                        title: this.trans('tickets.sell.manual.fail_retrieval.title'),
                                        message: this.trans('tickets.sell.manual.fail_retrieval.message_extra_fields'),
                                        type: 'warning',
                                    });
                                } else {
                                    this.$notify({
                                        title: this.trans('tickets.sell.manual.fail_retrieval.title'),
                                        message: this.trans('tickets.sell.manual.fail_retrieval.message'),
                                        type: 'warning',
                                    });
                                }

                                this.state = 'input';
                                return;
                            });

                    }
                }, response => {
                    this.$notify({
                        title: this.trans('tickets.sell.manual.fail_retrieval.title'),
                        message: this.trans('tickets.sell.manual.fail_retrieval.message'),
                        type: 'warning',
                    });
                    this.state = 'input';
                });
            },
            sell(id) {
                this.selectedTicket = this.tickets[id];
                this.selectedTicket.user = this.user;
                this.selectedTicket.currency = this.selectedTicket.bought_currency;
                this.selectedTicket.price = Math.floor(this.selectedTicket.bought_price);
                this.state = 'selling_details';
            },
          step3() {
              if(this.selectedTicket.price > this.selectedTicket.max_price) {
                let message = this.trans('tickets.pdf.price_too_high') + ' ' + this.selectedTicket.max_price + this.selectedTicket.currency;
                  this.$message({message: message, type: 'alert'})
              }
              if(this.cgu) {
                this.step = 3;
              }
          },
          getPdf(file) {
            this.base64(file.file)
            this.pdf.page = file.page
            let serialize = JSON.stringify(this.pdf)

            this.step = 4;
          },
          base64 (file)  {
            let reader = new FileReader();
            let baseString;
            reader.onloadend = () => {
              this.pdf.file = reader.result;
            };
            reader.readAsDataURL(file);
          },
          submitForm() {
            let checkBox = document.getElementById("unique-ticket");
            if (checkBox.checked === true){
              this.loaderSellTicket = true;
              document.forms["formSellTicket"].submit();
            }
          }
        }
    }
</script>