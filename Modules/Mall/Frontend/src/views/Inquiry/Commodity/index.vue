<template>
    <div class="commodity">
        <v-title title="Manage Products"></v-title>
        <!-- 切换 -->
        <section class="Send-main-screening">
            <div :class="actives[0] ? 'Send-main-screening-text Send-main-screening-text-active' : 'Send-main-screening-text'" @click="onClick(0)">Selling</div>
            <div class="Send-main-screening-hr"></div>
            <div :class="actives[1] ? 'Send-main-screening-text Send-main-screening-text-active' : 'Send-main-screening-text'" @click="onClick(1)">Check Pending</div>
            <div class="Send-main-screening-hr"></div>
            <div :class="actives[2] ? 'Send-main-screening-text Send-main-screening-text-active' : 'Send-main-screening-text'" @click="onClick(2)">Unapprove</div>
            <div class="Send-main-screening-hr"></div>
            <div :class="actives[3] ? 'Send-main-screening-text Send-main-screening-text-active' : 'Send-main-screening-text'" @click="onClick(3)">In the warehouse</div>
        </section>
        <!-- 点击功能 -->
        <div class="Send-main-btn">
            <button type="button" v-show="actives[3]">Resume</button> 
            <button type="button">Delete</button> 
            <button type="button" v-show="actives[0]">Pause</button>
            <span>Total 4</span>
        </div>

        <!-- 表格 -->
        <section class="commodity-table">
            <Row class-name="commodity-header">
                <Col span="1" class-name="commodity-table-checkboxs">
                    <Checkbox v-model="single"></Checkbox>
                </Col>
                <Col span="11" class-name="commodity-table-head">
                    Product Title
                </Col>
                <Col span="4" class-name="commodity-table-head">
                    Price
                </Col>
                <Col span="4" class-name="commodity-table-head">
                    Publish time
                </Col>
                <Col span="4" class-name="commodity-table-head">
                    Operation
                </Col>
            </Row>
            <Row>
                <Col span="24" class-name="commodity-table-title">
                    <Checkbox v-model="single"></Checkbox>
                    <div class="commodity-table-title-text">Product ID:100001457 </div>
                </Col>
                <Col span="24" class-name="commodity-table-content">
                    <Row>
                        <Col span="11" offset="1" class-name="commodity-table-content-title">
                            <v-img width="74" height="74" imgSrc="" style="border: 1px solid #eeeeee;"></v-img>
                            <section class="commodity-table-content-title-text">
                                <p>Fresh Pure White Garlic in Double Corrugated Carton Medium Pure white garlic wholesale</p>
                                <p>SKU:KE3587412</p>
                            </section>
                        </Col>
                        <Col span="4" class-name="commodity-table-content-price">
                            <p class="commodity-table-content-title-price-ksh">KSh 76000-84000</p>
                            <p class="commodity-table-content-title-price-moq">MOQ 26 Tons</p>
                        </Col>
                        <Col span="4" class="commodity-table-content-date">
                            <p>Dec,28 2018</p>
                        </Col>
                        <Col span="4" class="commodity-table-content-select">
                            <Select v-model="model1" style="width:127px">
                                <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                            </Select>
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
</template>

<script>
    import Title from "../components/Title"
    import Img from "@/components/Img"

    export default {
        data() {
            return {
                actives: [ true, false, false, false ],
                cityList: [
                    {
                        value: 'New York',
                        label: 'New York'
                    },
                    {
                        value: 'London',
                        label: 'London'
                    },
                    {
                        value: 'Sydney',
                        label: 'Sydney'
                    },
                    {
                        value: 'Ottawa',
                        label: 'Ottawa'
                    },
                    {
                        value: 'Paris',
                        label: 'Paris'
                    },
                    {
                        value: 'Canberra',
                        label: 'Canberra'
                    }
                ],
                model1: '',
                single: false
            }
        },
        methods: {
            onClick(i) {
                for (let index = 0; index < this.actives.length; index++) {
                    if(index == i) {
                        this.$set(this.actives, index, true)
                    }else {
                        this.$set(this.actives, index, false)
                    }
                }
            }
        },
        components: {
            "v-title": Title,
            "v-img": Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .commodity {
        width: 944px;
        height: auto;
        min-height: 772px;
        .bg-color(white);
        padding: 21px 30px;
        border: solid 1px #eeeeee;

        &-table {
            border-top: solid 1px #eeeeee;
            border-bottom: solid 1px #eeeeee;
            
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
            }
        }
    }

    .Send-main-screening {
        width: 882px;
        height: 47px;
        background-color: #f5f5f9;
        margin-top: 19px;
        .flex(flex-start, center);
        padding-left: 27px;

        &-text {
            .lineHeight(47px);
            font-size: 14px;
            color: #666666;

            & > span {
                color: #d72b2b;
            }
            cursor: pointer;
        }
        &-text-active {
            border-bottom: 2px solid #f0883a;
        }

        &-hr {
            width: 1px;
            height: 11px;
            background-color: #cccccc;
            margin: 0px 18px;
        }
    }

    .Send-main-btn {
            .flex();
            margin-top: 15px;
            margin-bottom: 12px;
            & > button {
                .color(white);
                .lineHeight(25px);
                .bg-color(Orange);
                width: 66px;
                font-size: 14px;
                border: none;
                margin-right: 10px;
            }
            & > span {
                .lineHeight(25px);
                font-size: 14px;
                color: #f0883a;
                display: inline-block;
                cursor: pointer;
            }
        }
</style>
