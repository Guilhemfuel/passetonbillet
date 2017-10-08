<template>
    <div :class="{'sandwich-menu':true,'opened':opened}" @click="toggledSandwich()" >
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</template>

<script>
    export default {
        props: {
            opened: false
        },
        methods: {
            toggledSandwich() {
                this.$emit('toggled');
            }
        }
    }
</script>