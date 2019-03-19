<template>
    <div id="list">
        <section class="title">
            <div class="title-left">
                <span>{{ $route.meta[$route.meta.length - 1] }}列表</span>
                <span>共{{ total.total }}条</span>
            </div>

            <div class="title-right" v-if="inputBool">
                <el-input
                    placeholder="请输入“会员ID”、“Email”搜索相关数据"
                    v-model="search"
                    class="title-right-input"
                    >
                    <el-button  type="primary" slot="append" icon="el-icon-search" class="title-right-search"></el-button>
                </el-input>
            </div>
        </section>
        <slot name="btn"></slot>
        <slot name="table"></slot>

        <section class="page">
            <el-pagination
                background
                layout="prev, pager, next"
                :total="total.total"
                :page-size="total.size"
                @current-change="onCurrentChange"
                >
            </el-pagination>
        </section>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                search: null,
                time: null
            }
        },
        props: {
            total: {
                type: Object,
                default: {
                    total: 0,
                    size: 10
                }
            },
            inputBool: false
        },
        methods: {
            // 分页
            onCurrentChange(num) {
                this.$emit('on-change-num', num)
            },
            // 搜索
            onChangeSearch(val) {
                clearTimeout(this.time)

                this.time = setTimeout(() => {
                    this.$emit('on-change-input', val)
                }, 500)
            }
        },
        watch: {
            search(newVal) {
                this.onChangeSearch(newVal)
            }
        },
    }
</script>

<style lang="scss" scoped>

    #list {
        width: 100%;

        .title {
            height: 40px;
            margin-bottom: 20px;
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
