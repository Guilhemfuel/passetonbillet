<template>
    <div class="col-12">
        <div class="card">
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="card-body">
                        <transition enter-class="pre-animated"
                                    enter-active-class="animated fadeIn"
                                    leave-active-class="animated fadeOut">
                            <div v-if="state=='input'">
                                <h4 class="card-title" >{{lang.title}}</h4>

                                <p class="card-text text-justify">
                                    {{lang.description}}
                                </p>

                                <form>
                                    <div class="col-xs-12 form-group">
                                        <input id="last_name" type="text"
                                               :class="{'form-control': true, 'is-invalid': errors.has('last_name') }"
                                               name="last_name" required v-validate="'required'"
                                               :placeholder="lang.inputs.last_name" v-model="form.last_name">
                                        <span v-if="errors.has('last_name')" class="invalid-feedback">{{ errors.first('last_name')}}</span>

                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <input id="booking_code" type="text"
                                               :class="{'form-control': true, 'is-invalid': errors.has('booking_code') }"
                                               name="booking_code" required v-validate="'required|max:6|min:6'"
                                               :placeholder="lang.inputs.booking_code" v-model="form.booking_code">
                                        <span v-if="errors.has('booking_code')" class="invalid-feedback">{{ errors.first('booking_code')}}</span>

                                    </div>
                                    <button type="submit" class="btn btn-lastar-blue btn-block" @click.prevent="search">Search Ticket</button>
                                </form>
                            </div>

                        </transition>

                        <transition enter-class="pre-animated"
                                    enter-active-class="animated fadeIn"
                                    leave-active-class="animated fadeOut">
                            <div v-if="state=='searching'">
                                <h4 class="card-title">Searching for your ticket(s)</h4>
                                <div class="p-5">
                                    <loader :class-name="'mx-auto'"></loader>
                                </div>
                            </div>
                        </transition>

                        <transition enter-class="pre-animated"
                                    enter-active-class="animated fadeIn"
                                    leave-active-class="animated fadeOut">
                            <div v-if="state=='select'">
                                <h4 class="card-title">Your ticket(s)</h4>
                                <p class="card-text text-justify" v-if="tickets.length==1">
                                    Hooray ! We find your ticket. <br>
                                    Just click next if you wish to move on with the sale.
                                </p>
                                <p class="card-text text-justify" v-if="tickets.length>1">
                                    Hooray ! We find your tickets. <br>
                                    Click a ticket to select it and move on with the sale.
                                </p>
                            </div>
                        </transition>

                    </div>
                </div>
                <div class="d-none d-sm-none d-md-block col-md-4 bg-ticket-sell"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            api: {type: Object, required: true},
            lang: {type: Object, required: true},

        },
        data() {
            return {
                state: 'input',
                form: {},
                tickets: {},
                searchError: false
        }
        },
        methods: {
            search(){
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.state='searching';
                        setTimeout(() => {
                            this.$http.post(this.api.tickets.search,this.form)
                                .then(response => {
                                    this.tickets = response.data.data;
                                    if(!this.tickets.length>0) {
                                        this.searchError = true;
                                        this.state='input';
                                        return;
                                    }
                                    this.state='select';
                                    return;
                                })
                            this.loading = false;
                        }, 10000);
                    }
                }, response => {
                    this.searchError = true;
                    this.state='input';
                });
            }
        }
    }
</script>