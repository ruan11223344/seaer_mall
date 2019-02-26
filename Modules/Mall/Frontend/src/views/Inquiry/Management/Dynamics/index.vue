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
                                <Checkbox v-model="single"></Checkbox>
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
                        <Row v-for="(item, index) in 5" :key="item">
                            <Col span="24" class-name="Dynamics-table-title">
                                <Checkbox v-model="single"></Checkbox>
                                <div class="Dynamics-table-title-text">Product ID:100001457 </div>
                            </Col>
                            <Col span="24" class-name="Dynamics-table-content">
                                <Row>
                                    <Col span="11" offset="1" class-name="Dynamics-table-content-title">
                                        <v-img width="74" height="74" imgSrc="" style="border: 1px solid #eeeeee;"></v-img>
                                        <section class="Dynamics-table-content-title-text">
                                            <p>Fresh Pure White Garlic in Double Corrugated Carton Medium Pure white garlic wholesale</p>
                                            <p>SKU:KE3587412</p>
                                        </section>
                                    </Col>
                                    <Col span="4" class-name="Dynamics-table-content-price">
                                        <p class="Dynamics-table-content-title-price-ksh">KSh 76000-84000</p>
                                        <p class="Dynamics-table-content-title-price-moq">MOQ 26 Tons</p>
                                    </Col>
                                    <Col span="4" class="Dynamics-table-content-date">
                                        <p>Dec,28 2018</p>
                                    </Col>
                                    <Col span="4" class="Dynamics-table-content-select">
                                        <button type="button" class="Dynamics-table-content-select-active" ref="refSelect" @click="onSelect($event, index)">Select</button>
                                        <!-- <Select v-model="model1" style="width:127px">
                                            <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                        </Select> -->
                                    </Col>
                                </Row>
                            </Col>
                        </Row>
                    </section>

                    <!-- 分页 -->
                    <section style="marginTop:20px;">
                        <template>
                            <Page :total="100" style="textAlign: center"/>
                        </template>
                    </section>
                </div>
            </transition>

            <div class="Dynamics-block">
                <div class="Dynamics-upload">
                    <img :src="require('@/assets/img/uploadAdd.png')" alt="" />
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import TableSwitch from "../../components/TableSwitch"
    import Img from "@/components/Img"
    import getData from "@/utils/getData"

    export default {
        data() {
            return {
                boolShow: false,
                single: false
            }
        },
        methods: {
            onGetRecommendList: getData.onGetRecommendList,
            onSelect(event, index) {
                // console.log(event);
                // const refSelect = this.$refs.refSelect[index]
                // console.log(refSelect);
            }
        },
        mounted() {
            this.onGetRecommendList().then(res => {
                console.log(res);
            })
            
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
            width: 210px;
            height: 322px;
            margin-top: 17px;
            margin-right: (885px - 210px * 4) / 3;
            border: solid 1px #eeeeee;
            background-color: #ffffff;
            .flex(center, center);
            cursor: pointer;
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
                }
            }
        }

        &-block {
            .flex(flex-start, center);
            flex-wrap: wrap;
            width: 885px;
            
        }
    }

    
</style>
