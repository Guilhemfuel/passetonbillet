<template>
    <div class="vue-modal">
    <transition name="fade" v-on:afterEnter="transitionCallback">
        <div v-show="isOpen">
            <div class="modal" :class="modalClass">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" v-click-outside="outsideClick">
                        <div class="modal-header" v-if="title">
                            <h5 class="modal-title">{{title}}</h5>
                            <button type="button" class="close" @click="closeModal" v-if="buttonClose">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <button type="button" class="close"  @click="closeModal" v-if="!title">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <slot></slot>
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
        date(){
            return {
                fullyOpened: this.isOpen  // True when opening transition is over
            }
        },
        props: {
            isOpen: {type: Boolean, required: true},
            closeOnOutsideClick: {type: Boolean, default: true, required: false},
            buttonClose: {type: Boolean, default: true, required: false},
            title: {type: String, required: false},
            footer: {type: String, required: false},
            modalClass: {type: String, default: ''}
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
                bind: function(el, binding, vNode) {
                    // Provided expression must evaluate to a function.
                    if (typeof binding.value !== 'function') {
                        const compName = vNode.context.name
                        let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
                        if (compName) { warn += `Found in component '${compName}'` }

                        console.warn(warn)
                    }
                    // Define Handler and cache it on the element
                    const bubble = binding.modifiers.bubble
                    const handler = (e) => {
                        if (bubble || (!el.contains(e.target) && el !== e.target)) {
                            binding.value(e)
                        }
                    }
                    el.__vueClickOutside__ = handler

                    // add Event Listeners
                    document.addEventListener('click', handler)
                },

                unbind: function(el, binding) {
                    // Remove Event Listeners
                    document.removeEventListener('click', el.__vueClickOutside__)
                    el.__vueClickOutside__ = null

                }
            }
        }
    }

</script>