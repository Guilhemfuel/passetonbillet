<template>
    <div class="nav-settings">
        <i class="fa fa-cog text-neon" @click="toggleDropdown()" aria-hidden="true"></i>
        <transition enter-active-class="animated fadeInDown"
                    leave-active-class="animated fadeOutUp"
                    v-on:afterEnter="transitionCallback">
            <div class="dropdown" v-show="dropdownOpened" v-click-outside="clickOutside">
                <div class="dropdown-header">
                    {{trans('nav.dropdowns.settings.title')}}
                </div>
                <div class="dropdown-body">
                    <div class="item">
                        <a :href="routes.profile">{{trans('nav.dropdowns.settings.items.profile')}}</a>
                    </div>
                    <div class="item" v-if="user.admin">
                        <a :href="routes.admin">{{trans('nav.dropdowns.settings.items.admin')}}</a>
                    </div>
                    <div class="item">
                        <a :href="routes.logout">{{trans('nav.dropdowns.settings.items.logout')}}</a>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: {
            routes: {type: Object, required: true},
            activeLang: {type: String, required: true},
            user: {type:Object, required: true}
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