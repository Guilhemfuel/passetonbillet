<template>
    <div class="col-12 discussion p-0">
        <div class="info-header">
            <div class="row">
                <div class="col-6  col-sm-6">
                    <img class="mx-auto rounded-circle" :src="correspondant.picture" alt="profile_picture"/>
                    <p class="text-center mt-2 d-none d-sm-block">
                        {{correspondant.full_name}}

                        <span class="fa-stack fa-lg label-verified d-none d-sm-inline-block"
                              v-if="correspondant.verified">
                                  <i class="fa fa-circle fa-stack-1x text-warning"></i>
                                  <i class="fa fa-check fa-inverse fa-stack-1x"></i>
                        </span>
                    </p>
                </div>
                <div class="col-6 col-md-6">
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
            </div>
        </div>
        <div :class="{'messages':true, 'row':true, 'shadow':topShadow}" v-on:scroll="onScroll" id="messages">
            <template v-for="message in discussion.messages">
                <div class="msg-container">
                    <el-tooltip class="item" effect="dark" :content="messageTooltip(message)" placement="right">
                        <div :class="{'msg':true, 'msg-sent':(message.sender_id == user.id), 'msg-received':!(message.sender_id == user.id)}">
                            {{message.message}}
                        </div>
                    </el-tooltip>
                </div>
            </template>

        </div>
        <div class="input">
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
            }
        },
        computed: {
            sendUrl: function () {
                return this.api.send.replace('ticket_id', this.discussion.ticket.id).replace('discussion_id', this.discussion.id);
            },
            refreshUrl: function () {
                var formatted_date = new moment(this.lastMessageReceived.created_at.date);
                var url = this.api.refresh.replace('ticket_id', this.discussion.ticket.id)
                    .replace('discussion_id', this.discussion.id);
                return url + '?date=' + encodeURI(formatted_date.format('YYYY-MM-DD HH:mm:ss'));
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
            }
        },
        mounted(){
            var myDiv = document.getElementById('messages');
            myDiv.scrollTop = myDiv.scrollHeight;

            this.checkMessages();

            setInterval(function () {
                this.checkMessages();
            }.bind(this), 30000);
        },
        methods: {
            sendMessage() {
                if (this.state == 'sending') return;

                this.state = 'sending';
                this.$http.post(this.sendUrl, {"message": this.inputMessage})
                    .then(response => {
                        if (response.ok) {
                            this.discussion.messages.push(response.body.data);
                            this.inputMessage = '';
                            this.state = 'default';

                            var myDiv = document.getElementById('messages');
                            myDiv.scrollTop = myDiv.scrollHeight*1000;
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
            },
            checkMessages(){
                this.$http.get(this.refreshUrl, {"message": this.inputMessage})
                .then(response => {
                    if (response.ok) {
                        for (let message of response.body.data){
                            this.discussion.messages.push(message);
                        }
                        var myDiv = document.getElementById('messages');
                        myDiv.scrollTop = myDiv.scrollHeight*1000;

//                      sort array of messages by date
                        this.discussion.messages = this.discussion.messages.sort((a, b) => (a.created_at.date > b.created_at.date));
                    }
                });
            }
        }
    }
</script>