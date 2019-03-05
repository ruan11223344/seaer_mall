<template>
    <div style="backgroundColor: #f5f5f9; paddingBottom: 37px">
        <section class="container main-title">
            <!-- <Breadcrumb separator='<b style="color:#666666">></b>'>
                <BreadcrumbItem to="/">Home</BreadcrumbItem>
                <BreadcrumbItem style="color:#666666">{{ 'success' }}</BreadcrumbItem>
            </Breadcrumb> -->
            <!-- <v-Breadcrumb title="Supplier Homepage" :url="`/company/home?&company_id=${$route.query.company_id}`" :Breadcrumbs="[ 'consulting' ]"></v-Breadcrumb> -->
        </section>

        <section class="container success-main">
            <v-img width="129" height="131" :imgSrc="require('@/assets/img/success.png')"></v-img>
            <div class="success-main-title">Thank You!</div>
            <div class="success-main-content">
                <span>Inquiry has been sent to the seller successfully.</span>
                <span>Please wait for the seller's reply</span>
            </div>
            <button class="success-main-btn" @click="onReturn">Return</button>
        </section>
    </div>
</template>

<script>
    import Img from '@/components/Img'
    // import Breadcrumb  from '@/components/Breadcrumb'

    export default {
        methods: {
            onReturn() {
                this.$router.go(-1)
            }
        },
        components: {
            "v-img": Img,
            // "v-Breadcrumb": Breadcrumb 
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index');

    // 头部
    .main-title {
        .lineHeight(45px);
    }

    .success-main {
        .flex(center, center, column);
        .bg-color(white);
        height: 749px;

        &-title {
            .color(blackLight);
            font-size: 28px;
            line-height: 1;
            margin-top: 32px;
            margin-bottom: 17px;
        }

        &-content {
            .flex(flex-start, center, column);
            .color(gray);
            font-size: 19px;
            font-weight: normal;
            font-stretch: normal;
            line-height: 1;
            letter-spacing: 0px;

            & > span:first-child {
                margin-bottom: 10px;
            }
        }

        &-btn {
            .width(112px, 37px);
            .color(white);
            .bg-color(Orange);
            margin-top: 22px;
            font-size: 18px;
            line-height: 1;
            border: none;
        }
    }
</style>
