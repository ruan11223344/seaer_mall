<template>
    <div class="bannerSet">
        <v-title title="Shop Settings"></v-title>
        
        <div style="marginTop: 20px;">
            <v-table-switch title="Banner Setting" :tableSwitch="['Slide Setting', 'Shop Information Setting']"></v-table-switch>
        </div>
        
        <template>
            <!-- banner设置 -->
            <!-- <v-banner-template></v-banner-template> -->
        </template>

        <template>
            <!-- 幻灯片广告位设置 -->
        </template>
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import TableSwitch from "../../components/TableSwitch"
    import BannerTemplate from './Banner-template.vue'

    export default {
        components: {
            "v-title": Title,
            "v-table-switch": TableSwitch,
            "v-banner-template": BannerTemplate
            // "v-img": Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

</style>
