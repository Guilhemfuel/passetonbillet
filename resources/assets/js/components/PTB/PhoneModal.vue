<template>
    <div class="call-component">
        <modal :is-open="trulyOpened"
               @close-modal="closeModal()"
               class="review-modal">

            <div v-if="state == 'phone_not_verified'">
                <div class="modal-body">
                    <p class="text-justify">
                        {{trans('tickets.sell.confirm_number.last_step')}}
                    </p>
                    <form method="post" :action="this.route('public.profile.phone.add')">
                        <div class="row">

                            <div class="col-md-12">

                                <div class="form-group">
                                    <phone :country-value="this.lang" @getData="getPhoneForm"></phone>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-ptb-blue btn-block" @click.prevent="addPhone">
                                        {{ trans('tickets.sell.confirm_number.CTA') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div v-else-if="state == 'phone_verification_sent'">
                <div class="modal-body">
                    <p class="card-text text-justify">
                        {{ trans('tickets.sell.confirm_number.last_step') }}
                    </p>
                    <form method="post" :action="this.route('public.profile.phone.verify')">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <cleave type="text"
                                            class="form-control"
                                            placeholder="XXXXXX"
                                            :options="{ numericOnly: true, blocks:[6] }"
                                            name="code"
                                            v-model="formConfirmPhone.code"></cleave>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-ptb-blue btn-block" @click.prevent="confirmPhone">
                                        {{ trans('tickets.sell.confirm_number.CTA') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p @click.prevent="noCodeReceive">{{ trans('tickets.sell.confirm_number.no_code_received') }}</p>
                </div>
            </div>

            <div v-else-if="state == 'phone_verified'">
                <div class="modal-body">
                    <p class="card-text text-justify">
                        Votre numéro est vérifié !
                    </p>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
  export default {
    props: {
      isOpen: {required: false, default: null}
    },
    data() {
      return {
        state: 'phone_not_verified',
        modalBuyOpened: this.isOpen == null ? false : null,
        form: {
          _token: window.csrf,
        },
        formPhone: {},
        formConfirmPhone: {
          code: null
        },
      }
    },
    computed: {
      trulyOpened() {
        if (this.isOpen == true || this.modalBuyOpened == true) {
          return true;
        }
        return false;
      },
    },
    methods: {
      closeModal() {
        // Only update that if modal not controlled externally
        if (this.isOpen == null) {
          this.modalBuyOpened = false;
        }
        this.$emit('close-modal');
      },
      handleResponse(response) {
        if(response.body.state) { this.state = response.body.state; }
        if(response.body.message) { this.$message({message: response.body.message, type: response.body.type}) }
      },
      getPhoneForm (data) {
        this.formPhone = data
      },
      noCodeReceive () {
        this.state = 'phone_not_verified'
      },
      addPhone() {
        this.$http.post(this.route('public.profile.phone.add'), this.formPhone)
          .then(response => {
            this.handleResponse(response)
          });
      },
      confirmPhone() {
        this.$http.post(this.route('public.profile.phone.verify'), this.formConfirmPhone)
          .then(response => {
            this.handleResponse(response)
          });
      }
    }
  }
</script>