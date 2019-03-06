<template>
    <div id="app">
        <el-container>
            <v-aside></v-aside>
                <el-container>
                    <v-header></v-header>

                    <router-view/>

                    <el-footer height="0px"></el-footer>
                </el-container>
        </el-container>
    </div>
</template>

<script>
    import Aside from '@/components/Aside'
    import Header from '@/components/Header'

    export default {
        methods: {
            handleSelect(key, keyPath) {
            }
        },
        components: {
            'v-aside': Aside,
            'v-header': Header
        }
    }
</script>

<style lang="scss">

</style>