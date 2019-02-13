<template>
    <div class="updateInfo">
        <v-head :imgSrc="require('@/assets/img/login/bg2.png')"></v-head>
        <v-title title="Selected Subcatalog: "  class="updateInfo-title">
            <template slot="content">
                <span class="updateInfo-title-text">{{ 'Garlic' }}</span>
                <button type="button" class="updateInfo-title-btn">Reselect</button>
            </template>
        </v-title>

        <section class="Send-main-screening" style="marginBottom: 20px;">
            <div class="Send-main-screening-text">Basic Info</div>
        </section>
        <!-- Basic Info内容 -->
        <template>
            <section>
                <Form ref="formInline" :model="formItem">
                    <FormItem prop="">
                        <Row :gutter="20">
                            <Col span="6" class-name="updateInfo-lable">
                                <span>Product Name</span>
                            </Col>
                            <Col span="15">
                                <Input placeholder="eg: Pure white garlic wholesale"></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <FormItem prop="">
                        <Row :gutter="20">
                            <Col span="6" class-name="updateInfo-lable">
                                <span>SKU No.</span>
                            </Col>
                            <Col span="15">
                                <Input placeholder="SKU refers to the number of business management products, it is not visible to buyer."></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <FormItem prop="">
                        <Row :gutter="20">
                            <Col span="6" class-name="updateInfo-lable">
                                <span>
                                    Keyword
                                    <span style="color: #999999;fontSize: 14px;">(Up to 3)</span>
                                </span>
                            </Col>
                            <Col span="15">
                                <Row>
                                    <Col span="24">
                                        <Input placeholder="The suggested length of keyword is 1-4 words."></Input>
                                    </Col>
                                </Row>
                            </Col>
                        </Row>
                    </FormItem>
                </Form>
            </section>
        </template>
    </div>
</template>

<script>
    import Title from "../components/Title"
    import Img from "@/components/Img"
    import Head from "../components/Head"
    
    export default {
        data() {
            return {
                formItem: {

                }
            }
        },
        methods: {
            
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-head": Head,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .updateInfo {
        width: 945px;
        height: 2246px;
        background-color: #ffffff;
        padding: 21px 30px;

        &-title {
            
            &-text {
                font-size: 16px;
                color: #999999;
            }

            &-btn {
                border: none;
                width: 76px;
                height: 25px;
                background-color: #f0883a;
                font-size: 12px;
                color: #ffffff;
                margin-left: 18px;
            }
        }

        &-lable {
            text-align: right;
            font-size: 16px;
            line-height: 36px;
            color: #333333;
        }
    }

    .Send-main-screening {
        width: 885px;
        height: 47px;
        background-color: #f5f5f9;
        margin-top: 19px;
        .flex(flex-start, center);
        padding-left: 20px;

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

</style>
