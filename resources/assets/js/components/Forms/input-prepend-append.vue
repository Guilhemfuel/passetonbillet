<template>
    <div  v-if="$slots.prepend || $slots.append">
        <div class="input-group">
            <div class="input-group-addon" v-if="$slots.prepend">
                <span class="input-group-text">
                    <slot name="prepend"></slot>
                </span>
            </div>
            <slot></slot>
            <div class="input-group-addon" v-if="$slots.append">
                <span class="input-group-text">
                    <slot name="apend"></slot>
                </span>
            </div>
        </div>
    </div>
    <div v-else>
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: {

        },
        computed: {

        },
        mounted(){
        },
        data() {
            return {
            }
        },
        methods: {

        },
    }
</script>
