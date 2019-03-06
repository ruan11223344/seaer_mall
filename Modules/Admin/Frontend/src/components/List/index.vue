<template>
    <div id="list">
        <section class="title">
            <div class="title-left">
                <span>用户列表</span>
                <span>共2000条</span>
            </div>

            <div class="title-right">
                <el-input placeholder="请输入“会员ID”、“Email”搜索相关数据" v-model="search" class="title-right-input">
                    <el-button type="primary" slot="append" icon="el-icon-search" class="title-right-search"></el-button>
                </el-input>
            </div>
        </section>
        <slot name="btn"></slot>
        <slot name="table"></slot>

        <section class="page">
            <el-pagination
                background
                layout="prev, pager, next"
                :total="1000"
                >
            </el-pagination>
        </section>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                search: null
            }
        },
        methods: {
            
        }
    }
</script>

<style lang="scss" scoped>

    #list {
        width: 100%;

        .title {
            @include mixin-flex(space-between, center);

            &-left {
                font-size: 16px;
                @include mixin-color(grey);

                & > span:last-of-type {
                    font-size: 12px;
                    margin-left: 11px;
                    @include mixin-color(dark);
                }
            }

            &-right {

                &-input {
                    width: 331px + 71px;
                }
            }
        }

        .page {
            margin-top: 16px;
            @include mixin-flex(center, center);
        }
    }
</style>
