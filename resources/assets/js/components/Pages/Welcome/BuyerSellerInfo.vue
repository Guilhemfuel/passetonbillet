<template>
    <div class="section-howitworks">
        <h2 class="text-center text-warning title">{{trans('welcome.howitworks.title')}}</h2>
        <div class="selector">
            <button id="btn-buyer"
                    :class="{'text-uppercase':true,'selected':state=='buyer'}"
                    @click.prevent="state='buyer';buttonClicked=true">
                {{trans('welcome.howitworks.buttons.buyer')}}
            </button>
            <button id="btn-seller"
                    :class="{'text-uppercase':true,'selected':state=='seller'}"
                    @click.prevent="state='seller';buttonClicked=true">
                {{trans('welcome.howitworks.buttons.seller')}}
            </button>
        </div>
        <transition name="el-fade-in">
            <div class="container" v-show="state=='buyer'">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                        <img class="svg-icon"
                             src="img/icon_search.svg"
                             alt="Icon Search"
                        />
                        <h3 class="howitworks-title  pt-1">{{trans('welcome.howitworks.search.title')}}</h3>
                        <p class="howitworks-text" v-html="trans('welcome.howitworks.search.text')"></p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                        <img class="svg-icon"
                             src="img/icon_auction.svg"
                             alt="Icon Auction"
                        />
                        <h3 class="howitworks-title  pt-1">{{trans('welcome.howitworks.auction.title')}}</h3>
                        <p class="howitworks-text" v-html="trans('welcome.howitworks.auction.text')"></p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                        <img class="svg-icon"
                             src="img/icon_chat.svg"
                             alt="Icon Chat"
                        />
                        <h3 class="howitworks-title  pt-1">{{trans('welcome.howitworks.chat.title')}}</h3>
                        <p class="howitworks-text" v-html="trans('welcome.howitworks.chat.text')"></p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                        <img class="svg-icon"
                             src="img/icon_send.svg"
                             alt="Icon Send"
                        />
                        <h3 class="howitworks-title  pt-1">{{trans('welcome.howitworks.send.title')}}</h3>
                        <p class="howitworks-text" v-html="trans('welcome.howitworks.send.text')"></p>
                    </div>
                </div>
            </div>
        </transition>
        <transition name="el-fade-in">
            <div class="container" v-show="state=='seller'" v-cloak>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                        <img class="svg-icon"
                             src="img/icon_sell.svg"
                             alt="Icon Sell"
                        />
                        <h3 class="howitworks-title  pt-1">{{trans('welcome.howitworks.sell.title')}}</h3>
                        <p class="howitworks-text" v-html="trans('welcome.howitworks.sell.text')"></p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                        <img class="svg-icon"
                             src="img/icon_accept.svg"
                             alt="Icon Accept"
                        />
                        <h3 class="howitworks-title  pt-1">{{trans('welcome.howitworks.accept.title')}}</h3>
                        <p class="howitworks-text" v-html="trans('welcome.howitworks.accept.text')"></p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                        <img class="svg-icon"
                             src="img/icon_chat2.svg"
                             alt="Icon Chat"
                        />
                        <h3 class="howitworks-title  pt-1">{{trans('welcome.howitworks.chat2.title')}}</h3>
                        <p class="howitworks-text" v-html="trans('welcome.howitworks.chat2.text')"></p>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 col-sm-6 mt-3">
                        <img class="svg-icon"
                             src="img/icon_send2.svg"
                             alt="Icon Send"
                        />
                        <h3 class="howitworks-title  pt-1">{{trans('welcome.howitworks.send2.title')}}</h3>
                        <p class="howitworks-text" v-html="trans('welcome.howitworks.send2.text')"></p>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: {},
        data() {
            return {
                state: 'buyer',
                buttonClicked: false
            }
        },
        mounted() {
            let switchState = () => {
                if (!this.buttonClicked) {
                    if (this.state == 'buyer') {
                        this.state = 'seller';
                    } else {
                        this.state = 'buyer';
                    }
                }
            }

            setInterval(function () {
                switchState();
            }, 5000);
        },
        computed: {},
        methods: {}
    }
</script>