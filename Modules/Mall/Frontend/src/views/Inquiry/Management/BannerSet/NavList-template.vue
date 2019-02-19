<template>
    <div class="navList">
        <div class="navList-title">
            <button type="button">Add Navigation</button>
        </div>
        <div class="navList-table">
            <div class="navList-table-head">
                <div>Sort</div>
                <div>Navigation Name</div>
                <div>Whether to show</div>
                <div>Operation</div>
            </div>
            <div class="navList-table-body">
                <div class="navList-table-body-list" :style=" index == 0 ? 'borderTopWidth: 1px' : '' " v-for="(item, index) in 6" :key="index">
                    <div>{{ index + 1 }}</div>
                    <div>Products</div>
                    <div>YES</div>
                    <div class="navList-table-body-list-btns">
                        <template v-if="index != 0">
                            <button type="button">Edit</button>
                            <button type="button">Delete</button>
                        </template>
                        <template v-else>
                            -
                        </template>
                    </div>
                </div>
            </div>
        </div>
        
        <section style="marginTop:20px;">
            <template>
                <Page :total="100" :page-size="8" style="textAlign: center" />
            </template>
        </section>
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .navList {

        &-title {
            & > button {
                width: 113px;
                height: 25px;
                background-color: #f0883a;
                font-size: 14px;
                color: #ffffff;
                border: none;
                margin-top: 20px;
                margin-bottom: 10px;
            }
        }

        &-table {

            &-head {
                width: 100%;
                height: 47px;
                background-color: #f5f5f9;
                .flex(space-between, center);

                & > div {
                    width: 25%;
                    text-align: center;
                    font-size: 14px;
                    color: #666666;
                }
            }

            &-body {

                &-list {
                    width: 100%;
                    height: 60px;
                    border: solid 1px #e0e0e0;
                    border-top-width: 0px;
                    .flex(space-between, center);

                    & > div {
                        width: 25%;
                        text-align: center;
                        font-size: 14px;
                        color: #666666;
                    }

                    &-btns {
                        
                        & > button {
                            font-size: 12px;
                            height: 21px;
                            border: none;
                        }

                        & > button:first-child {
                            width: 53px;
                            border: solid 1px #f0883a;
                            color: #f0883a;
                            background-color: #ffffff;
                        }

                        & > button:last-child {
                            width: 53px;
                            background-color: #f0883a;
                            color: #ffffff;
                            margin-left: 20px;
                        }
                    }
                }
            }
        }
    }
</style>
