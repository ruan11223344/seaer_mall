<template>
    <div class="bannerSet">
        <v-title title="Shop Settings"></v-title>
        
        <div style="marginTop: 20px;">
            <v-table-switch title="Banner Setting" :num="num" :tableSwitch="['Slide Setting']" @on-click="onTableSwitch"></v-table-switch>
        </div>
        
        <template>
            <!-- banner设置 -->
            <v-banner-template v-show="num == 0"></v-banner-template>
        </template>

        <template>
            <!-- 幻灯片广告位设置 -->
            <v-slide-template v-show="num == 1"></v-slide-template>
        </template>

        <!-- 导航列表设置 -->
        <!-- <template>
            <v-nav-list v-show="num == 2"></v-nav-list>
        </template> -->
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import TableSwitch from "../../components/TableSwitch"
    import BannerTemplate from "./Banner-template.vue"
    import SlideTemplate from "./Slide-template.vue"
    import NavList from "./NavList-template.vue"
    import getData from "@/utils/getData.js"

    export default {
        data() {
            return {
                num: 0
            }
        },
        methods: {
            // 切换
            onTableSwitch(num) {
                this.num = num

                switch (num) {
                    case 0:

                        break
                    case 1:
                        break
                    case 2:
                        break
                }
            }
        },
        mounted() {
           
        },
        components: {
            "v-title": Title,
            "v-table-switch": TableSwitch,
            "v-banner-template": BannerTemplate,
            "v-slide-template": SlideTemplate,
            "v-nav-list": NavList
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

</style>
