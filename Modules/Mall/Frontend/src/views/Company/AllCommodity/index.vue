<template>
    <div>
        <v-main></v-main>
    </div>
</template>

<script>
    import Main from './Main.vue'

    export default {
        data () {
            return {
            }
        },
        components: {
           "v-main": Main
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');
</style>
