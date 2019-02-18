<template>
    <div class="products">
        <v-title title="Group & Sort Products"></v-title>
        <template>
            <section class="products-btns">
                <button type="button">Delete</button>
                <button type="button">New Category</button>
            </section>
        </template>

        <template>
            <section class="products-table">
                <div class="products-table-head">
                    <div class="products-table-head-checkbox">
                        <template>
                            <Checkbox v-model="single" size="large"></Checkbox>
                        </template>
                    </div>
                    <div class="products-table-head-text products-table-head-name">
                        <span>Name</span>
                    </div>
                    <div class="products-table-head-text products-table-head-sort">Sort</div>
                    <div class="products-table-head-text products-table-head-display">Display</div>
                    <div class="products-table-head-text products-table-head-operation">Operation</div>
                </div>
                <div class="products-table-body">
                    <!-- 最多有5个 -->
                    <template>
                        <dl class="products-table-body-dl">
                            <dd class="products-table-body-dl-checkbox">
                                <template>
                                    <Checkbox v-model="single" size="large"></Checkbox>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-name ">
                                <template>
                                    <div class="products-table-body-dl-name-open products-table-body-dl-name-open-add"></div>
                                    <span class="products-table-body-dl-name-text">Beauty and Hair </span>
                                    <button type="button" class="products-table-body-dl-name-btn">Add Sub-category</button>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-sort">
                                <template>
                                    <span>
                                        0
                                    </span>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-display">
                                <template>
                                    <span>
                                        Yes
                                    </span>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-operation">
                                <template>
                                    <section class="products-table-body-dl-operation-btns">
                                        <button type="button">Delete</button>
                                        <button type="button">Edit</button>
                                    </section>
                                </template>
                            </dd>
                        </dl>
                        <dl class="products-table-body-dl">
                            <dd class="products-table-body-dl-checkbox">
                                <!-- <template>
                                    <Checkbox v-model="single" size="large"></Checkbox>
                                </template> -->
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-name ">
                                <template>
                                    <div class="products-table-body-dl-name-seat"></div>
                                    <span class="products-table-body-dl-name-text products-table-body-dl-name-dot">Beauty and Hair </span>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-sort">
                                <template>
                                    <span>
                                        0
                                    </span>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-display">
                                <template>
                                    <span>
                                        Yes
                                    </span>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-operation">
                                <template>
                                    <section class="products-table-body-dl-operation-btns">
                                        <button type="button">Delete</button>
                                        <button type="button">Edit</button>
                                    </section>
                                </template>
                            </dd>
                        </dl>
                    </template>
                    <template>
                        <dl class="products-table-body-dl">
                            <dd class="products-table-body-dl-checkbox">
                                <template>
                                    <Checkbox v-model="single" size="large"></Checkbox>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-name ">
                                <template>
                                    <div class="products-table-body-dl-name-open products-table-body-dl-name-open-add"></div>
                                    <span class="products-table-body-dl-name-text">Beauty and Hair </span>
                                    <button type="button" class="products-table-body-dl-name-btn">Add Sub-category</button>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-sort">
                                <template>
                                    <span>
                                        0
                                    </span>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-display">
                                <template>
                                    <span>
                                        Yes
                                    </span>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-operation">
                                <template>
                                    <section class="products-table-body-dl-operation-btns">
                                        <button type="button">Delete</button>
                                        <button type="button">Edit</button>
                                    </section>
                                </template>
                            </dd>
                        </dl>
                        <dl class="products-table-body-dl" v-show="false">
                            <dd class="products-table-body-dl-checkbox">
                                <!-- <template>
                                    <Checkbox v-model="single" size="large"></Checkbox>
                                </template> -->
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-name ">
                                <template>
                                    <div class="products-table-body-dl-name-seat"></div>
                                    <span class="products-table-body-dl-name-text products-table-body-dl-name-dot">Beauty and Hair </span>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-sort">
                                <template>
                                    <span>
                                        0
                                    </span>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-display">
                                <template>
                                    <span>
                                        Yes
                                    </span>
                                </template>
                            </dd>
                            <dd class="products-table-body-dl-text products-table-body-dl-operation">
                                <template>
                                    <section class="products-table-body-dl-operation-btns">
                                        <button type="button">Delete</button>
                                        <button type="button">Edit</button>
                                    </section>
                                </template>
                            </dd>
                        </dl>
                    </template>
                </div>
            </section>
            
            <!-- 分页 -->
            <section style="marginTop:20px;">
                <template>
                    <Page :total="100" style="textAlign: center"/>
                </template>
            </section>

            <!-- 删除图片 -->
            <template>
                <v-deletealbum v-show="deletAlbum" @on-show="onDeleteShow"></v-deletealbum>
            </template>
        </template>
    </div>
</template>

<script>
    import Img from "@/components/Img"
    import Title from "../components/Title/index.vue"
    // 删除功能
    import DeletAlbum from "./DeleteAlbum/index.vue"

    export default {
        data() {
            return {
                single: false,
                deletAlbum: true,
            }
        },
        methods: {
            onDeleteShow() {
                this.deletAlbum = false
            },
            onMoveAlbum() {
                this.moveAlbum = false
            }
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-deletealbum": DeletAlbum,

        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .products {
        .width(945px, auto);
        min-height: 772px;
        .bg-color(white);
        padding: 21px 30px;

        &-btns {
            margin-top: 20px;

            & > button {
                background-color: #f0883a;
                height: 25px;
                padding: 0px 13px;
                font-size: 14px;
                color: #ffffff;
                border: none;
            }

            & > button:last-child {
                margin-left: 10px;
            }
        }

        &-table {
            margin-top: 12px;

            &-head {
                width: 885px;
                height: 47px;
                background-color: #f5f5f9;
                .flex(flex-start, center);
                // margin-bottom: 16px;

                &-text {
                    font-size: 14px;
                    color: #666666;
                    text-align: center;
                }
               

                &-checkbox {
                    width: 62px;
                    text-align: center;
                }

                &-name {
                    width: 350px;
                    text-align: left;
                    & > span {
                        padding-left: 138px - 62px;
                    }
                }

                &-sort {
                    width: 135px;
                }
                &-display {
                    width: 170px;
                }

                &-operation {
                    width: 180px;
                }
            }

            &-body {

                &-dl {
                    margin-top: 12px;
                    .flex(flex-start, center);
                    padding-bottom: 12px;
                    border-bottom: 1px solid #f5f5f9;

                    &-text {
                        font-size: 14px;
                        color: #666666;
                        text-align: center;
                    }

                    &-checkbox {
                        width: 62px;
                        text-align: center;

                    }

                    &-name {
                        width: 350px;
                        text-align: left;
                        .flex(flex-start, center);

                        &-open {
                            width: 20px;
                            height: 20px;
                            background-color: #f5f5f9;
                            margin-right: 20px;

                            &-add {
                                position: relative;
                                cursor: pointer;

                                &::before, &::after {
                                    content: '';
                                    position: absolute;
                                    top: 50%;
                                    left: 50%;
                                    transform: translate(-50%, -50%);
                                    background-color: #666666;
                                }

                                &::before {
                                    width: 12px;
                                    height: 2px;
                                }

                                &::after {
                                    width: 2px;
                                    height: 12px;
                                }
                            }
                        }

                        &-seat {
                            width: 20px;
                            height: 20px;
                            margin-right: 20px;
                        }

                        &-text {
                            font-size: 14px;
                            color: #666666;
                        }

                        // 装饰点
                        &-dot {
                            &::before {
                                content: '';
                                width: 4px;
                                height: 4px;
                                background-color: #bfbfbf;
                                display: inline-block;
                                border-radius: 50%;
                                margin-right: 10px;
                                margin-bottom: 4px;
                            }
                        }

                        &-btn {
                            width: 110px;
                            height: 23px;
                            font-size: 12px;
                            color: #f0883a;
                            margin-left: 10px;
                            background: transparent;
                            border: solid 1px #f0883a;
                        }
                    }

                    &-sort {
                        width: 135px;
                    }
                    &-display {
                        width: 170px;
                    }

                    &-operation {
                        width: 180px;

                        &-btns {
                            button {
                                height: 25px;
                                padding: 0px 13px;
                                font-size: 14px;
                                color: #ffffff;
                                border: none;
                            }

                            & > button:first-child {
                                background-color: #cfcfcf;
                            }

                            & > button:last-child {
                                background-color: #f0883a;
                                margin-left: 10px;
                            }
                        } 
                    }
                }
            }
        }
    }
</style>