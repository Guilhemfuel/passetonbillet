<template>
    <div class="vue-modal">
    <transition name="fade" v-on:afterEnter="transitionCallback">
        <div v-show="isOpen">
            <div class="modal" :class="modalClass">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" v-click-outside="outsideClick">
                        <div class="modal-header" v-if="title">
                            <h5 :class="['modal-title',titleClass]" v-html="title"></h5>
                            <button type="button" class="close" @click="closeModal" v-if="buttonClose">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <button type="button" class="close"  @click="closeModal" v-if="!title">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <template v-if="isOpen">
                                <slot></slot>
                            </template>
                        </div>
                        <div class="modal-footer" v-if="footer">
                            {{footer}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-backdrop show"></div>
        </div>
    </transition>
    </div>
</template>

<script>

    import _ from 'lodash';

    export default {
        props: {
            isOpen: {type: Boolean, required: true, default: false},
            closeOnOutsideClick: {type: Boolean, default: true, required: false},
            buttonClose: {type: Boolean, default: true, required: false},
            title: {type: String, required: false},
            footer: {type: String, required: false},
            modalClass: {type: String, default: ''},
            titleClass: {type: String, default: ''},
        },
        date(){
            return {
                fullyOpened: this.isOpen != undefined ? this.isOpen : false // True when opening transition is over
            }
        },
        methods: {
            outsideClick(){
                if(this.closeOnOutsideClick && this.fullyOpened && this.isOpen){
                    this.closeModal();
                }
            },
            closeModal(){
                this.$emit('close-modal');
                this.fullyOpened = false;
            },
            transitionCallback(){
                this.$emit('modal-opened');
                this.fullyOpened = true;
            }
        },
        directives: {
            'click-outside': {
                bind: function (el, binding, vnode) {
                    el.clickOutsideEvent = function (event) {
                        // here I check that click was outside the el and his childrens
                        if (!(el == event.target || el.contains(event.target))) {
                            // and if it did, call method provided in attribute value
                            vnode.context[binding.expression](event);
                        }
                    };
                    document.body.addEventListener('click', el.clickOutsideEvent)
                },
                unbind: function (el) {
                    document.body.removeEventListener('click', el.clickOutsideEvent)
                },
            }
        }
    }

</script>