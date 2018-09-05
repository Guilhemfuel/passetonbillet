<template>
    <vue-json-pretty
            :deep="deep"
            :data="data"
    >
    </vue-json-pretty>
</template>

<script>

    import VueJsonPretty from 'vue-json-pretty'

    export default {
        components: {
            VueJsonPretty
        },
        props: {
            data: {type: Object, required: true},
            deep: {required: false}
        },
    }

</script>