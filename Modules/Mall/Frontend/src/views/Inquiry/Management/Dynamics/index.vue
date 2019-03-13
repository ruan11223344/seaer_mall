<template>
    <div class="Dynamics">
        <v-title title="Store Dynamics"></v-title>
        
        <div style="marginTop: 20px;">
            <v-table-switch title="Recommended Settings"></v-table-switch>
        </div>
        <div class="Dynamics-block">
            <div class="Dynamics-upload" @click="boolShow=true"  v-show="!boolShow">
                <img :src="require('@/assets/img/uploadAdd.png')" alt="" />
            </div>
        </div>
        
        <template v-if="boolShow">
                    
            <!-- 表格 -->
            <transition name="fade">
                <div>
                    <section class="Dynamics-table">
                        <Row class-name="Dynamics-header">
                            <Col span="1" class-name="Dynamics-table-checkboxs">
                                <Checkbox v-model="single" @on-change="onChange"></Checkbox>
                            </Col>
                            <Col span="11" class-name="Dynamics-table-head">
                                Product Title
                            </Col>
                            <Col span="4" class-name="Dynamics-table-head">
                                Price
                            </Col>
                            <Col span="4" class-name="Dynamics-table-head">
                                Publish time
                            </Col>
                            <Col span="4" class-name="Dynamics-table-head">
                                Operation
                            </Col>
                        </Row>
                        <Row v-for="(item, index) in activeData" :key="index">
                            <Col span="24" class-name="Dynamics-table-title">
                                <Checkbox v-model="item.single" @on-change="onChanges"></Checkbox>
                                <div class="Dynamics-table-title-text">Product ID:100001457 </div>
                            </Col>
                            <Col span="24" class-name="Dynamics-table-content">
                                <Row>
                                    <Col span="11" offset="1" class-name="Dynamics-table-content-title">
                                        <img style="width: 74px; height: 74px; border: 1px solid #eeeeee;" :src="item.product_main_pic_url" alt="">
                                        <section class="Dynamics-table-content-title-text">
                                            <p>{{ item.product_name }}</p>
                                            <p>SKU:{{ item.product_sku }}</p>
                                        </section>
                                    </Col>
                                    <Col span="4" class-name="Dynamics-table-content-price">
                                        <p class="Dynamics-table-content-title-price-ksh">{{ item.product_price }}</p>
                                        <p class="Dynamics-table-content-title-price-moq">{{ item.product_moq }}</p>
                                    </Col>
                                    <Col span="4" class="Dynamics-table-content-date">
                                        <p>{{ dayjs( item.publish_time ).format('MMM DD,YYYY HH:mm') }}</p>
                                    </Col>
                                    <Col span="4" class="Dynamics-table-content-select">
                                        <button
                                            v-show="!edit"
                                            :disabled="recommend_product_id_list.includes(item.product_id)"
                                            :style=" recommend_product_id_list.includes(item.product_id) ? 'backgroundColor: #dddddd' : '' "
                                            type="button"
                                            class="Dynamics-table-content-select-active"
                                            ref="refSelect"
                                            @click="onSelect(item, item.product_id)">
                                                Select
                                        </button>

                                        <button
                                            v-show="edit"
                                            type="button"
                                            class="Dynamics-table-content-select-active Dynamics-table-content-select-ani"
                                            ref="refSelect"
                                            @click="onEdit(item, item.product_id)">
                                                Select
                                        </button>
                                    </Col>
                                </Row>
                            </Col>
                        </Row>
                    </section>

                    <!-- 分页 -->
                    <section style="marginTop:20px;">
                        <template>
                            <Page :total="total.total" :page-size="total.size" style="textAlign: center" @on-change="onPages"/>
                        </template>
                    </section>
                </div>
            </transition>

            <div class="Dynamics-block">
                <div class="Dynamics-upload" v-for="(item, index) in 8" :key="index">
                    <template v-if="product_info_list.length > index">
                        <img :src="product_info_list[index].product_main_pic_url" alt="" class="Dynamics-upload-img">
                        <div class="Dynamics-upload-footer">
                            <p class="Dynamics-upload-footer-title">{{ product_info_list[index].product_name }}</p>
                            <p class="Dynamics-upload-footer-price">{{ product_info_list[index].product_price }}</p>
                            <p class="Dynamics-upload-footer-moq">{{ product_info_list[index].product_moq }}</p>
                            <div class="Dynamics-upload-footer-btns">
                                <button type="button" @click="onDel(product_info_list[index].product_id)">Delete</button>
                                <button type="button" @click="edit=true,replace = product_info_list[index].product_id">Edit</button>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <img :src="require('@/assets/img/uploadAdd.png')" @click="onSroll" alt="" />
                    </template>
                </div>
            </div>
            <button class="Dynamics-sub" @click="onSub">Submit</button>
        </template>
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import TableSwitch from "../../components/TableSwitch"
    import Img from "@/components/Img"
    import getData from "@/utils/getData"
    import upData from "@/utils/upData"
    import dayjs from "dayjs"

    export default {
        data() {
            return {
                edit: false,
                replace: -1,
                total: {
                    size: 5,
                    total: 0,
                    num: 1
                },
                boolShow: false,
                single: false,
                formData: [],
                activeData: [],
                activeProductId: [],
                product_info_list: [],
                recommend_product_id_list: []
            }
        },
        methods: {
            dayjs: dayjs,
            onGetRecommendList: getData.onGetRecommendList,
            onGetReleaseProductList: getData.onGetReleaseProductList,
            onSetRecommendProductList: upData.onSetRecommendProductList,
            filterAll: getData.filterAll,
            onSelect(item, index) {
                // 设置商品
                this.recommend_product_id_list.push(index)
                this.product_info_list.push(item)
            },
            // 分页
            onPages(index) {
                this.$set(this.total, 'num', index)
                this.filterAll(this.formData, this.total).then(res => this.activeData = res)
            },
            // 添加全选key
            onSelectKey(data) {
                const arr = []
                data.forEach((element) => {
                    const obj = element
                    obj.single = false
                    arr.push(obj)
                })
                this.formData = arr
            },
            onChange(bool) {
                this.activeProductId = []
                this.activeData.forEach((element, index )=> {
                    this.$set(this.activeData[index], 'single', bool)
                    if(element.single) {
                        this.activeProductId.push(element.product_id)
                    }
                })
            },
            onChanges(bool) {
                this.activeProductId = []
                const arr = []
                this.activeData.forEach((element, index )=> {
                    arr.push(element.single)
                    if(element.single) {
                        this.activeProductId.push(element.product_id)
                    }
                })
                arr.includes(false) ? this.single = false : this.single = true
            },
            onDel(id) {
                const index = this.recommend_product_id_list.indexOf(id)

                this.recommend_product_id_list.splice(index, 1)
                this.product_info_list.splice(index, 1)
            },
            onEdit(item, id) {
                const index = this.recommend_product_id_list.indexOf(this.replace)

                if(this.recommend_product_id_list.includes(id)) {
                    this.$Message.error('No duplicate goods allowed')
                }else {
                    this.$set(this.recommend_product_id_list, index, id)
                    this.$set(this.product_info_list, index, item)
                }

                this.replace = -1
                this.edit = false
                this.onSroll()
            },
            onSroll() {
                window.scrollTo(0,0)
            },
            onSub() {
                this.onSetRecommendProductList(this.recommend_product_id_list)
            }
        },
        mounted() {
            this.onGetReleaseProductList({ "status" :"selling" }).then(res => {
                this.formData = res.data_list
                this.onSelectKey(res.data_list)

                this.total.total = res.total
                this.filterAll(this.formData, this.total).then(res => this.activeData = res)
            })

            this.onGetRecommendList().then(res => {
                this.product_info_list = res.product_info_list
                this.recommend_product_id_list = res.recommend_product_id_list
            })
            
        },
        watch: {
            recommend_product_id_list(val) {
                const len = val.length

                if(len > 8) {
                    this.recommend_product_id_list.splice(len - 1, 1)
                    this.product_info_list.splice(len - 1, 1)
                }
            }
        },
        components: {
            "v-title": Title,
            "v-table-switch": TableSwitch,
            "v-img": Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .Dynamics {

        &-upload {
            width: 212px;
            height: 210px + 147px + 2px;
            margin-top: 17px;
            margin-right: (885px - 212px * 4) / 3;
            border: solid 1px #eeeeee;
            background-color: #ffffff;
            .flex(center, center);
            flex-direction: column;
            cursor: pointer;

            &-img {
                width: 210px;
                height: 210px;
                display: block;
                align-self: flex-start;
            }

            &-footer {
                width: 212px;
                height: 147px;
                text-align: center;
                .flex(center, center);
                flex-direction: column;

                &-title {
                    width: 168px;
                    height: auto;
                    font-size: 16px;
                    line-height: 1.2;
                    color: #000000;
                    overflow: hidden;
                    .textHiddens(2);
                }

                &-price {
                    margin-top: 14px;
                    font-size: 16px;
                    line-height: 1;
                    color: #de2727;
                }

                &-moq {
                    margin-top: 12px;
                    font-size: 12px;
                    line-height: 1;
                    color: #999999;
                }

                &-btns {
                    margin-top: 12px;

                    & > button {
                        width: 54px;
                        height: 21px;
                        font-size: 12px;
                        line-height: 1;
                        border: none;
                    }

                    & > button:first-child {
                        border: solid 1px #f0883a;
                        background-color: #ffffff;
                        color: #f0883a;
                    }

                    & > button:last-child {
                        background-color: #f0883a;
                        color: #ffffff;
                        margin-left: 20px;
                    }
                }
            }
        }

        &-upload:nth-child(4n) {
            margin-right: 0px;
        }

        &-table {
            border-top: solid 1px #eeeeee;
            border-bottom: solid 1px #eeeeee;
            margin-top: 20px;
            
            &-header {
                height: 36px;
            }

            &-checkboxs {
                .flex(flex-start, center);
                height: 36px;
                padding-left: 10px;
            }

            &-head {
                .flex(center, center);
                height: 36px;
                font-size: 14px;
                color: #666666;
                text-align: center;
            }

            &-title {
                .flex(flex-start, center);
                width: 882px;
                height: 47px;
                padding-left: 10px;
                padding-right: 15px;
                background-color: #f5f5f9;

                &-text {
                    font-size: 14px;
                    color: #666666;
                }
            }

            &-content {
                padding: 12px 0px;
                cursor: pointer;

                &-price, &-date, &-select {
                    .flex(center, center, column);
                    height: 74px;
                }

                &-title {
                    .flex(space-between, center);
                    height: 74px;
                    
                    &-text {
                        width: 320px;
                        display: inline-block;
                        font-size: 14px;
                        line-height: 1.2;
                        color: #666666;

                        & > p:last-child {
                            font-size: 12px;
                            color: #999999;
                            margin-top: 10px;
                        }
                    }
                }

                &-price {
                    & > p:first-of-type {
                        font-size: 14px;
                        color: #de2727;
                    }

                    & > p:last-of-type {
                        font-size: 12px;
                    	color: #999999;
                    }
                }

                &-date {
                    font-size: 14px;
                    color: #666666;
                }

                &-select {
                    & > button {
                        width: 70px;
                        height: 26px;
                        // background-color: #f0883a;
                        background-color: #dddddd;
                        font-size: 16px;
                        line-height: 1;
                        color: #ffffff;
                        border: none;
                    }

                    & > &-active {
                        background-color: #f0883a;
                    }

                    &-ani {
                        animation: ani .5s;
                        animation-iteration-count: infinite;
                        transition: .5s;
                    }

                    &-ani:hover {
                        transform: rotate(0deg);
                        animation-play-state: paused;
                    }

                    @keyframes ani {
                        0% {
                            transform: rotate(5deg)
                        }
                        50% {
                            transform: rotate(0deg)
                        }
                        100% {
                            transform: rotate(-5deg)
                        }
                    }
                }
            }
        }

        &-block {
            .flex(flex-start, center);
            flex-wrap: wrap;
            width: 885px;
            
        }

        &-sub {
            width: 107px;
            height: 40px;
            background-color: #f0883a;
            font-size: 18px;
            line-height: 1;
            color: #ffffff;
            border: none;
            margin: 0px auto;
            margin-top: 35px;
            display: block;
        }
    }

    
</style>
