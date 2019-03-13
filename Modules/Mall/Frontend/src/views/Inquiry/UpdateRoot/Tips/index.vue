<template>
    <div class="tips-main">
        <div>
            <v-img width="112" height="112" :imgSrc="require('@/assets/img/tips.png')"></v-img>
        </div>
        <div class="tips-main-text">Your company information is under review and cannot be published </div>
        <div>
            <button type="button" class="tips-main-btn" @click="$router.push('/inquiryList/company/companyedit')">Click here</button>
        </div>
    </div>
</template>

<script>
    import Img from "@/components/Img"

    export default {
        components: {
            "v-img": Img,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .tips-main {
        .flex(center, center);
        width: 944px;
        height: 772px;
        background-color: #ffffff;
        padding: 21px 30px;
        flex-direction: column;

        &-text {
            font-size: 20px;
            color: #666666;
            margin: 40px 0px;
        }

        &-btn {
            width: 127px;
	        height: 39px;
            background-color: #f0883a;
            font-size: 16px;
            color: #ffffff;
            border: none;
        }
    }
</style>
