<template>

    <div :class="{'col-12':true, 'discussion':true, 'p-0':true, 'sold':sold, 'sold-here':sold_here,
        'seller':(user.id == discussion.ticket.user.id),'buyer':(user.id != discussion.ticket.user.id)}">

        <!-- Modal confirm sold here  -->
        <modal :is-open="modalSellOpen" :title="trans('message.discussions.modal_sell.title')+correspondant.full_name"
               @close-modal="modalSellOpen=false;modalSellState='default'" v-if="!sold">

            <!-- First part is to check that payment was received-->
            <template v-if="modalSellState=='default'">
                <h3 class="emoji text-center">💸</h3>
                <p class="text-bold text-center">{{trans('message.discussions.modal_sell.money_received.question')}}</p>
                <div class="btn-rack">
                    <button class="btn btn-success" @click="modalSellState='pdf'">
                        {{trans('message.discussions.modal_sell.money_received.confirm')}}
                    </button>
                    <button class="btn btn-danger" @click="modalSellOpen=false">
                        {{trans('message.discussions.cancel')}}
                    </button>
                </div>
                <p class="text-center mt-3">{{trans('message.discussions.modal_sell.money_received.warning')}}</p>

            </template>

            <!-- Secund part it to deal with pdf -->
            <template v-else-if="modalSellState=='pdf'">

                <form class="hidden" method="post" ref="sellForm"
                      :action="this.route('public.message.discussion.sell',[discussion.ticket.id,discussion.id])">
                    <input type="hidden" name="_token" :value="csrf">
                </form>

                <!-- PDF not found -->
                <template v-if="!discussion.ticket.pdf_downloaded">
                    <h3 class="text-center text-primary">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    </h3>
                    <p class="text-center" v-html="trans('message.discussions.modal_sell.pdf.missing')"></p>
                    <div class="btn-rack">
                        <button class="btn btn-success" @click="$refs.sellForm.submit()">
                            {{trans('message.discussions.cta_sell_to')}} {{correspondant.full_name}}
                        </button>
                        <button class="btn btn-danger" @click="modalSellOpen=false">
                            {{trans('message.discussions.cancel')}}
                        </button>
                    </div>
                    <p class="text-center mt-3" v-html="trans('message.discussions.modal_sell.pdf.warning')"></p>

                </template>

                <!-- PDF not found -->
                <template v-else>
                    <h3 class="text-center text-success emoji">
                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                    </h3>
                    <p class="text-center" v-html="trans('message.discussions.modal_sell.pdf.found')"></p>
                    <div class="btn-rack">
                        <button class="btn btn-success" @click="$refs.sellForm.submit()">
                            {{trans('message.discussions.cta_sell_to')}} {{correspondant.full_name}}
                        </button>
                        <button class="btn btn-danger" @click="modalSellOpen=false">
                            {{trans('message.discussions.cancel')}}
                        </button>
                    </div>
                    <p class="text-center mt-3" v-html="trans('message.discussions.modal_sell.pdf.warning')"></p>

                </template>
            </template>


        </modal>

        <!-- Modal explanations -->
        <modal :is-open="modalInfo" :title="trans('message.discussions.modal_title')" @close-modal="closeInfoModal"
               v-if="modalInfo" :button-close="false">
            <div class="container-fluid">
                <div class="row">
                    <p class="text-justify" v-if="user.id == discussion.ticket.user.id">
                        <span v-html="trans('message.discussions.modal_explanation_buyer')"></span>
                    </p>
                    <p class="text-justify" v-else>
                        <span v-html="trans('message.discussions.modal_explanation_seller')"></span>
                    </p>
                    <p class="text-center mt-3" style="width: 100%;"><a :href="route('help.page')" target="_blank">
                        {{trans('message.discussions.modal_open_faq')}}
                    </a></p>
                    <button class="btn btn-primary btn-block mt-1" @click="closeInfoModal">
                        {{trans('message.discussions.modal_close_understand')}}
                    </button>
                </div>
            </div>
        </modal>

        <call-modal :ticket="discussion.ticket"
                    :is-open="modalCallOpen"
                    @close-modal="modalCallOpen=false;"
        ></call-modal>

        <div class="info-header">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-4 d-flex align-items-center justify-content-center flex-column">
                    <a :href="profileUrl">
                        <img class="mx-auto rounded-circle" :src="correspondant.picture" alt="profile_picture"/>
                        <p class="text-center mt-2 d-none d-sm-block full-name">
                            {{correspondant.full_name}}

                            <span class="fa-stack fa-lg label-verified d-none d-sm-inline-block"
                                  v-if="correspondant.verified">
                                  <i class="fa fa-circle fa-stack-1x text-warning"></i>
                                  <i class="fa fa-check fa-inverse fa-stack-1x"></i>
                        </span>
                        </p>
                    </a>
                </div>
                <div class="col-md-4 d-sm-none d-none d-md-flex align-items-center justify-content-center"
                     v-if="!sold && user.id == discussion.ticket.user.id">
                    <div>
                        <button class="btn btn-primary mx-auto" @click="openSellModal()">
                            {{trans('message.discussions.cta_sell_to')}} {{correspondant.full_name}}
                        </button>
                        <br>
                        <p class="text-center"><a href="#"
                                                  @click.prevent="modalInfo=true">{{trans('message.discussions.modal_title')}}</a>
                        </p>
                    </div>
                </div>
                <div class="col-md-4 d-sm-none d-none d-md-flex align-items-center justify-content-center"
                     v-if="!sold && user.id != discussion.ticket.user.id">
                    <p class="text-center">
                        <button class="btn btn-primary mx-auto mb-2" @click.prevent="openCallModal">
                            <i class="fa fa-phone" aria-hidden="true"></i> {{trans('message.discussions.call_seller')}}
                        </button>
                        <br>
                        <a href="#" @click.prevent="modalInfo=true">
                            {{trans('message.discussions.modal_title')}}
                        </a>
                    </p>
                </div>

                <template v-if="sold">
                    <div class="col-8 col-md-4 col-sm-6 d-flex align-items-center justify-content-center flex-column"
                         v-if="sold_here">
                        <h3 class="text-center">Deal!</h3>
                        <p class="text-center" v-if="user.id == discussion.ticket.user.id">
                            {{trans('message.discussions.sold_to')}} {{correspondant.first_name}}<br>
                        </p>
                        <p class="text-center" v-else>
                            {{trans('message.discussions.bought_from')}} {{correspondant.first_name}}<br>
                        </p>
                    </div>
                    <div class="col-8 col-md-4 col-sm-6 d-flex align-items-center justify-content-center flex-column"
                         v-else>
                        <p class="text-center">
                            {{trans('message.discussions.sold_to_so_else')}}
                        </p>
                    </div>
                </template>
                <div class="col-md-4 col-12 d-flex align-items-center justify-content-center flex-column py-3 py-sm-0 pb-sm-3"
                     v-if="sold">
                    <ticket-mini :discussion="discussion" :ticket="discussion.ticket"></ticket-mini>
                </div>
                <div class="col-md-4 col-sm-6 col-8 d-flex align-items-center justify-content-center flex-column py-3 py-sm-0 pb-sm-3"
                     v-else>
                    <ticket-mini :discussion="discussion" :ticket="discussion.ticket"></ticket-mini>
                </div>
                <div class="col-sm-12 d-md-none p-0" v-if="!sold && user.id == discussion.ticket.user.id">
                    <button @click="openSellModal()" class="btn btn-ptb-blue btn-block btn-header">
                        {{trans('message.discussions.cta_sell_to')}} {{correspondant.full_name}}
                    </button>
                </div>
                <div class="col-sm-12 d-md-none p-0" v-if="!sold && user.id != discussion.ticket.user.id">
                    <button @click="openCallModal()" class="btn btn-ptb btn-block btn-header">
                        <i class="fa fa-phone" aria-hidden="true"></i> {{trans('message.discussions.call_seller')}}
                    </button>
                </div>
            </div>
        </div>


        <div :class="{'messages':true, 'row':true, 'shadow':topShadow, 'archived':(sold && !sold_here)}"
             v-on:scroll="onScroll" id="messages">
            <p class="text-center px-4 reminder" v-if="discussion.ticket.provider == 'eurostar'">
                {{trans('message.discussions.disclaimer_eurostar')}}
            </p>
            <template v-for="message in discussion.messages">
                <div class="msg-container">
                    <el-tooltip class="item" effect="dark" :content="messageTooltip(message)" placement="right">
                        <div :class="{'msg':true, 'msg-sent':(message.sender_id == user.id), 'msg-received':!(message.sender_id == user.id)}">
                            {{message.message}}
                        </div>
                    </el-tooltip>
                </div>
            </template>
            <p class="text-center" v-if="(sold && !sold_here)">
                {{trans('message.discussions.sold_disc_ended')}}
            </p>
        </div>
        <div class="input" v-if="!(sold && !sold_here)">
        <textarea placeholder="Type a message..." v-model="inputMessage"
                  @keyup.enter.prevent="sendMessage"></textarea>
            <button class="btn btn-ptb-blue" @click="sendMessage">
                <template v-if="state!='sending'">
                    {{trans('message.discussions.send')}}
                </template>
                <template v-else>
                    <loader :class-name="'mx-auto white'"></loader>
                </template>
            </button>
        </div>
        <audio class="d-none" src="/audio/notification.mp3" id="notification-sound"></audio>
    </div>
</template>

<script>
    export default {
        props: {
            discussionDefault: {type: Object, required: true},
        },
        data() {
            return {
                csrf: window.csrf,
                state: 'default',
                discussion: this.discussionDefault,
                inputMessage: '',
                topShadow: false,
                modalSellOpen: false,
                modalSellState: 'default',
                modalTicketOpened: false,
                modalInfo: false,
                user: this.$root.user,

                modalCallOpen: false,
            }
        },
        computed: {
            sendUrl: function () {
                return this.route('api.discussion.send', [this.discussion.ticket.id, this.discussion.id]);
            },
            profileUrl: function () {
                return this.route('public.profile.stanger', this.correspondant.hashid);
            },
            readUrl: function () {
                return this.route('api.discussion.read', [this.discussion.ticket.id, this.discussion.id]);
            },
            correspondant: function () {
                if (this.user.id == this.discussion.buyer.id) {
                    return this.discussion.seller;
                }
                return this.discussion.buyer;

            },
            lastMessageReceived: function () {
                var last = null;
                for (let message of this.discussion.messages) {
                    if (last == null || (message.sender_id != this.user.id
                            && new moment(message.created_at.date).isAfter(new moment(last.created_at.date)))) {
                        last = message;
                    }
                }
                return last;
            },
            sold: function () {
                return this.discussion.ticket.buyer != null;
            },
            sold_here: function () {
                return this.sold && this.discussion.status == 2;
            },
            messages: function () {
                // Simply to be able to put a watcher on this
                return this.discussion.messages;
            }
        },
        methods: {
            openSellModal() {
                this.modalSellState = 'default';
                this.modalSellOpen = true;
            },
            sendMessage() {
                if (this.state == 'sending' || (this.sold && !this.sold_here)) return;

                this.state = 'sending';
                this.$http.post(this.sendUrl, {"message": this.inputMessage})
                    .then(response => {
                        if (response.ok) {

                            this.discussion.messages.push(response.body.data);
                            this.inputMessage = '';
                            this.state = 'default';

                        }
                    }, response => {
                        this.state = 'failed_sending';
                        return;
                    });
            },
            messageTooltip(message) {
                return new moment(message.created_at.date).format('dddd HH:mm')
            },
            onScroll() {
                if (document.getElementById('messages').scrollTop == 0) {
                    this.topShadow = false;
                } else {
                    this.topShadow = true;
                }
            },
            closeInfoModal() {
                this.modalInfo = false;
                $crisp.push(['do', 'chat:hide']);
            },
            openCallModal() {
                if (this.user.id == this.discussion.ticket.user.id) return;
                this.modalCallOpen=true;
            },
        },
        mounted() {
            // Init window with max scroll
            var div = document.getElementById('messages');
            div.scrollTop = div.scrollHeight;

            // Pusher
            Echo.private('discussion.' + this.discussion.id)
                .listen('MessageSent', (data) => {
                    // Add to list of messages
                    this.discussion.messages.push(data.message);
                    // Play sound
                    document.getElementById('notification-sound').play();
                    // Marj as read
                    this.$http.post(this.readUrl);
                });

            // Check if modal info should be opened for user (at least one message sent)
            let countMessages = this.messages.filter((msg) => msg.sender_id === this.user.id).length;
            if (countMessages == 0) {
                this.modalInfo = true;
                // Hide it automatically after 15 sec
                setTimeout(() => {
                    this.modalInfo = false;
                }, 15000);
            }

        },
        watch: {
            // whenever question changes, this function will run
            messages: function (newMessages, oldMessages) {
                this.$lodash.delay(function () {
                    var div = document.getElementById('messages');
                    div.scrollTop = div.scrollHeight;
                }, 50);
            }
        },
    }
</script>