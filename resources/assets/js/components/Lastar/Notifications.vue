<template>
    <div class="nav-notifications">
        <i class="fa fa-bell text-neon" @click="toggleDropdown()" aria-hidden="true"></i>
        <transition enter-active-class="animated fadeInDown"
                    leave-active-class="animated fadeOutUp"
                    v-on:afterEnter="transitionCallback">
            <div class="dropdown" v-show="dropdownOpened" v-click-outside="clickOutside">
                <div class="dropdown-body">
                    <div class="item">
                        Test
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: {

        },
        data() {
            return {
                dropdownOpened: false,
                fullyOpened: false
            }
        },
        computed: {},
        methods: {
            toggleDropdown() {
                if (this.fullyOpened == false && this.dropdownOpened == false) {
                    this.openDropdown()
                }
                if (this.fullyOpened && this.dropdownOpened) {
                   this.closeDropdown
                }
            },
            openDropdown() {
                this.dropdownOpened = true;
                this.fullyOpened = false;
            },
            closeDropdown() {
                if (this.fullyOpened && this.dropdownOpened) {
                    this.dropdownOpened = false;
                    this.fullyOpened = false;
                }
            },
            clickOutside() {
                this.closeDropdown()
            },
            transitionCallback() {
                if (this.dropdownOpened) this.fullyOpened = true;
            }
        },
        directives: {
            'click-outside': {
                bind: function (el, binding, vNode) {
                    // Provided expression must evaluate to a function.
                    if (typeof binding.value !== 'function') {
                        const compName = vNode.context.name
                        let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
                        if (compName) {
                            warn += `Found in component '${compName}'`
                        }

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

                unbind: function (el, binding) {
                    // Remove Event Listeners
                    document.removeEventListener('click', el.__vueClickOutside__)
                    el.__vueClickOutside__ = null

                }
            }
        }
    }
</script>