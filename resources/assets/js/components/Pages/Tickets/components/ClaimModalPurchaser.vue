<template>
    <modal id="modal-claim"
            class="ticket-modal-share"
           :is-open="openModal"
           @close-modal="closeModal"
    >

        <div class="timeLeft" v-if="timeLeft">{{ timeLeft }} {{ trans('tickets.claim.hours_left') }}</div>

        <div v-if="state === 'start'" class="col-10 text-center mx-auto">
            <h1>
                {{ trans('tickets.claim.start') }}
            </h1>

            <p class="mt-2">
                {{ trans('tickets.claim.start_more') }}
            </p>

            <div class="button-my-ticket-update mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="state = 'faq'">
                    {{ trans('tickets.claim.i_have_question') }}
                </button>
            </div>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="state = 'question-1'">
                    {{ trans('tickets.component.yes') }}
                </button>
            </div>
        </div>

        <div v-if="state === 'faq'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.we_answers') }}</h1>

            <p class="mt-2">{{ trans('tickets.claim.read_our_faq') }}</p>

            <div class="button-my-ticket-update mt-2 mx-auto">
                <a :href="this.route('help.page')" class="btn btn-ptb btn-upper text-uppercase w-100">
                    {{ trans('tickets.claim.read_faq') }}
                </a>
            </div>
        </div>

        <div v-if="state === 'question-1'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.question_1') }}</h1>

            <p class="mt-2">{{ trans('tickets.claim.question_1_more') }}</p>

            <div class="button-my-ticket-update mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(false)">
                    {{ trans('tickets.component.no') }}
                </button>
            </div>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(true)">
                    {{ trans('tickets.component.yes') }}
                </button>
            </div>
        </div>

        <div v-if="state === 'question-2'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.question_2') }}</h1>

            <p class="mt-2">{{ trans('tickets.claim.question_2_more') }}</p>

            <div class="col-10 text-center mx-auto timepicker">
                <input type="time" id="timeAnswer" name="timeAnswer" value="12:00:00" v-model="timeScan" required>
            </div>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(timeScan)">
                    {{ trans('tickets.component.validate') }}
                </button>
            </div>
        </div>

        <div v-if="state === 'question-3'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.question_3') }}</h1>

            <p class="mt-2">{{ trans('tickets.claim.question_3_more') }}</p>

            <div class="button-my-ticket-update mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(false)">
                    {{ trans('tickets.component.no') }}
                </button>
            </div>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(true)">
                    {{ trans('tickets.component.yes') }}
                </button>
            </div>
        </div>

        <div v-if="state === 'question-4'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.question_4') }}</h1>

            <p class="mt-2">{{ trans('tickets.claim.question_4_more') }}</p>

            <div class="button-my-ticket-update mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(false)">
                    {{ trans('tickets.component.no') }}
                </button>
            </div>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(true)">
                    {{ trans('tickets.component.yes') }}
                </button>
            </div>
        </div>

        <div v-if="state === 'question-5'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.question_5') }}</h1>

            <p class="mt-2">
                <textarea id="moreInformation" name="moreInformation" :placeholder="trans('tickets.claim.more_info')" v-model="moreInformation"></textarea>
            </p>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="answerQuestion(moreInformation)">
                    {{ trans('tickets.component.submit') }}
                </button>
            </div>
        </div>

        <div v-if="state === 'end'" class="col-10 text-center mx-auto">
            <h1>{{ trans('tickets.claim.end') }}</h1>

            <p class="mt-2">{{ trans('tickets.claim.end_more') }}</p>

            <div class="paper-plane-success mx-auto"><i class="fa fa-check" aria-hidden="true"></i></div>

            <div class="button-my-ticket-delete mt-3 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="closeModal">
                    {{ trans('tickets.component.finish') }}
                </button>
            </div>
        </div>
    </modal>
</template>

<script>
  export default {
    props: {
      openModal: {required: true},
      ticket: {required: true},
    },
    data() {
      return {
        state: 'faq',
        currentQuestion: 1,
        timeLimit: 24,
        timeLeft: null,
        timeScan: '12:00:00',
        moreInformation: null,
        answers: []
      }
    },
    methods: {
      closeModal() {
        this.resetComponent();
        this.$emit("close-modal", false);
      },
      resetComponent() {
        this.state = 'faq';
        this.currentQuestion = 1;
        this.timeLeft = null;
        this.timeScan = '12:00:00';
        this.moreInformation = null;
        this.answers = [];
      },
      handleResponse(response) {
        if(response.body.message) { this.$message({message: response.body.message, type: response.body.status}) }
      },
      formatedDate(date) {
        return new moment(date, 'YYYY-MM-DD').format('L');
      },
      answerQuestion(answer) {
        this.answers.push(answer)
        this.currentQuestion++;
        if (this.currentQuestion <= 5) {
          this.state = 'question-' + this.currentQuestion;
        } else {
          this.submitClaim();
          this.state = 'end';
        }
      },
      calculTimeLeft() {
        let dateDeparture = this.ticket.train.full_departure_date;
        let claimLimitPurchaser = this.ticket.claim_limit_purchaser;
        let dateNow = moment().format('YYYY-MM-DD HH:mm:ss');

        //If departure has started, we display the claim modal
        //If not we display only FAQ modal
        if(dateDeparture <= dateNow) {
          //If the limit time for claim is not reached
          if(dateNow < claimLimitPurchaser) {
            this.state = 'start';

            let diff = new moment(claimLimitPurchaser,"YYYY-MM-DD HH:mm:ss").diff(moment(dateNow,"YYYY-MM-DD HH:mm:ss"));
            this.timeLeft = Math.round(new moment.duration(diff).asHours());
          }
        }
      },
      submitClaim() {
        let data = JSON.stringify({'answers': this.answers, 'ticket': this.ticket})

        this.$http.post(this.route('api.add.claim.buyer'), data)
          .then(response => {
            if(response.body.status === 'error') {
              this.handleResponse(response)
            }
          });
      },
    },
    computed: {
    },
    watch: {
      openModal: function () {
        if(this.openModal) {
          this.calculTimeLeft();
        }
      }
    }
  }
</script>