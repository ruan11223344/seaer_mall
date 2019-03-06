<template>
    <el-header height="80px" id="header">
        <section>
            <el-breadcrumb separator-class="el-icon-arrow-right">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <!-- <el-breadcrumb-item>活动管理</el-breadcrumb-item>
                <el-breadcrumb-item>活动列表</el-breadcrumb-item>
                <el-breadcrumb-item>活动详情</el-breadcrumb-item> -->
            </el-breadcrumb>
        </section>

        <section class="right">
            <el-badge :value="100" :max="1">
                <!-- <img :src="require('@/assets/xiaox.png')" alt=""> -->
                <div class="right-email"></div>
            </el-badge>
            <div class="right-avatar">
                <img :src="require('@/assets/mrtx.png')" alt="">
            </div>
        </section>
    </el-header>
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss" scoped>
    #header {
        background-color: #f5f5f9;

        @include mixin-flex(space-between, center);

        .right {
            width: 170px;
            height: 80px;
            @include mixin-flex(space-between, center);

            &-email {
                width: 29px;
                height: 21px;
                background-image: url('../../assets/xiaox.png');
                cursor: pointer;
            }

            &-email:hover {
                background-image: url('../../assets/xzxx.png');
            }

            &-avatar {
                width: 53px;
                height: 53px;
                border-radius: 50%;
                @include mixin-bg-color(white);
            }
        }
    }
</style>
