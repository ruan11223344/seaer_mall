<template>
    <div class="home">
        <el-container>
            <v-aside></v-aside>
            <el-container>
                <v-header></v-header>
                
                <v-home-main></v-home-main>

                <el-footer height="0px"></el-footer>
            </el-container>
        </el-container>
    </div>
</template>

<script>
    import Aside from '@/components/Aside'
    import Header from '@/components/Header'
    import HomeMain from '@/components/Home'

    export default {
        name: "home",
        data() {
            return {

            }
        },
        methods: {
            handleSelect(key, keyPath) {
            }
        },
        components: {
            'v-aside': Aside,
            'v-header': Header,
            'v-home-main': HomeMain
        }
    }
</script>

<style lang="scss" scoped>

</style>

