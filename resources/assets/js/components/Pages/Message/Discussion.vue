<template>

    <div :class="{'col-12':true, 'discussion':true, 'p-0':true, 'sold':sold, 'sold-here':sold_here,
        'seller':(user.id == discussion.ticket.user.id),'buyer':(user.id != discussion.ticket.user.id)}">
        <modal :is-open="modalSellOpen"  :title="'Vendre ce billet à '+correspondant.full_name" @close-modal="modalSellOpen=false" v-if="!sold">
            <p>
                You are about to mark this ticket as sold to {{correspondant.full_name}}. Make sure to click there, only once you received the payment. {{correspondant.full_name}} will then automatically receive your ticket.
            </p>
            <form class="hidden" method="post" ref="sellForm" :action="routes.sell">
                <input type="hidden" name="_token" :value="csrf">
            </form>
            <div class="btn-rack">
                <button class="btn btn-success" @click="$refs.sellForm.submit()">Sell ticket to {{correspondant.full_name}}</button>
                <button class="btn btn-danger" @click="modalSellOpen=false">Cancel</button>
            </div>
        </modal>
        <div class="info-header">
            <div class="row">
                <div class="col-md-4 col-6">
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
                <div class="col-md-4 d-sm-none d-none d-md-flex" v-if="!sold && user.id == discussion.ticket.user.id">
                    <div class="pt-5 mx-auto">
                        <button class="btn btn-lastar-blue mx-auto" @click="modalSellOpen=true">Vendre ce billet à {{correspondant.full_name}}</button>
                    </div>
                </div>

                <template v-if="sold">
                    <div class="col-md-4 d-sm-none d-none d-md-block" v-if="sold_here">
                        <h3 class="text-center">Deal! </h3>
                        <p class="text-center" v-if="user.id == discussion.ticket.user.id">
                            You already sold this ticket to {{correspondant.full_name}}!<br> Congratulations!
                        </p>
                        <p class="text-center" v-else>
                            You already bought this ticket from {{correspondant.full_name}}!<br> Congratulations!
                        </p>
                    </div>
                    <div class="col-md-4 d-sm-none d-none d-md-block pt-5" v-else>
                        <p class="text-center" v-if="user.id == discussion.ticket.user.id">
                            Ticket already sold to someone else!
                        </p>
                        <p class="text-center" v-else>
                            Ticket already sold to someone else!
                        </p>
                    </div>
                </template>


                <div class="col-md-4 col-6">
                    <p class="text-center align-middle pt-3">
                        Ticket
                        <br>
                        {{discussion.ticket.train.departure_city.short_name.substring(2)}}
                        <i aria-hidden="true" class="fa fa-long-arrow-right text-primary"></i>
                        {{discussion.ticket.train.arrival_city.short_name.substring(2)}}
                        <br>
                        <span class="text-left">{{discussion.ticket.train.departure_time.substring(0,5)}}</span>
                        <span class="text-right">{{discussion.ticket.train.arrival_time.substring(0,5)}}</span>
                    </p>
                </div>
                <div class="col-sm-12 d-md-none p-0" v-if="!sold && user.id == discussion.ticket.user.id">
                    <button @click="modalSellOpen=true" class="btn btn-lastar-blue btn-block btn-header">Vendre ce billet à {{correspondant.full_name}}</button>
                </div>
                <div class="col-sm-12 d-md-none p-0" v-if="sold_here">
                    <h3 class="text-center">Deal! </h3>
                    <p class="text-center" v-if="user == discussion.ticket.user.id">
                        You already sold this ticket to {{correspondant.full_name}}!<br> Congratulations!
                    </p>
                    <p class="text-center" v-else>
                        You already bought this ticket from {{correspondant.full_name}}!<br> Congratulations!
                    </p>
                </div>
            </div>
        </div>
        <div :class="{'messages':true, 'row':true, 'shadow':topShadow, 'archived':(sold && !sold_here)}" v-on:scroll="onScroll" id="messages">
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
                Ticket was sold to someone else. The discussion ended.
            </p>
        </div>
        <div class="input" v-if="!(sold && !sold_here)">
        <textarea placeholder="Type a message..." v-model="inputMessage"
        @keyup.enter.prevent="sendMessage"></textarea>
        <button class="btn btn-lastar-blue" @click="sendMessage">
        <template v-if="state!='sending'">
        Send
        </template>
        <template v-else>
        <loader :class-name="'mx-auto white'"></loader>
        </template>
        </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            api: {type: Object, required: true},
            routes: {type: Object, required: true},
            lang: {type: Object, required: true},
            ticketLang: {type: Object, required: true},
            user: {type: Object, required: true},
            csrf: {type: String, required: true},
            discussionDefault: {type: Object, required: true},

        },
        data() {
            return {
                state: 'default',
                discussion: this.discussionDefault,
                inputMessage: '',
                topShadow: false,
                modalSellOpen: false,
            }
        },
        computed: {
            sendUrl: function () {
                return this.api.send.replace('ticket_id', this.discussion.ticket.id).replace('discussion_id', this.discussion.id);
            },
            profileUrl: function () {
                return this.routes.profile.replace('user_id', this.correspondant.hashid);
            },
            readUrl: function () {
                return this.api.read.replace('ticket_id', this.discussion.ticket.id)
                    .replace('discussion_id', this.discussion.id);
            },
            correspondant: function () {
                if (this.user.id == this.discussion.buyer.id) {
                    return this.discussion.seller;
                }
                return this.discussion.buyer;

            },
            lastMessageReceived: function () {
                var last = null;
                for (let message of this.discussion.messages){
                    if (last == null || (message.sender_id != this.user.id
                        && new moment(message.created_at.date).isAfter(new moment(last.created_at.date)))){
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
            messages: function() {
                // Simply to be able to put a watcher on this
                return this.discussion.messages;
            }
        },
        methods: {
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
            messageTooltip(message){
                return new moment(message.created_at.date).format('dddd HH:mm')
            },
            onScroll(){
                if (document.getElementById('messages').scrollTop == 0){
                    this.topShadow = false;
                } else {
                    this.topShadow = true;
                }
            }
        },
        mounted() {
            // Init window with max scroll
            var div = document.getElementById('messages');
            div.scrollTop = div.scrollHeight;

            Echo.private('discussion.'+this.discussion.id)
                .listen('MessageSent', (data) => {
                    this.discussion.messages.push(data.message);
                    // Marj as read
                    this.$http.post(this.readUrl);
            });
        },
        watch: {
            // whenever question changes, this function will run
            messages: function (newMessages, oldMessages) {
                this.$lodash.delay(function(){
                    var div = document.getElementById('messages');
                    div.scrollTop = div.scrollHeight;
                },50);
            }
        },
    }
</script>