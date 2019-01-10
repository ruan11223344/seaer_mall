<template>
    <div class="container inquirySend">
        <section class="inquirySend-title">
            <Breadcrumb separator='<b style="color:#666666">></b>'>
                <BreadcrumbItem to="/">Home</BreadcrumbItem>
                <BreadcrumbItem style="color:#666666">{{" $route.query.name" }}</BreadcrumbItem>
            </Breadcrumb>
        </section>
        <section class="inquirySend-main">
            <!-- 侧边栏 -->
            <v-inquiry-aside></v-inquiry-aside>

            <v-inquiry-main></v-inquiry-main>
        </section>
    </div>
</template>

<script>
    import inquiryAside from "../components/Aside/index"
    import Main from "./Main.vue"

    export default {
        components: {
            "v-inquiry-aside": inquiryAside,
            "v-inquiry-main": Main
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .inquirySend {

        &-title {
            margin-bottom: 8px;
        }

        &-main {
            .flex(space-between, center);
        }
    }
</style>
