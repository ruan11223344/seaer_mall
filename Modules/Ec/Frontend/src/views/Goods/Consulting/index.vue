<template>
    <div style="backgroundColor: #f5f5f9; paddingBottom: 37px">
        <section class="container main-title">
            <Breadcrumb separator='<b style="color:#666666">></b>'>
                <BreadcrumbItem to="/">Home</BreadcrumbItem>
                <BreadcrumbItem style="color:#666666">{{ '$route.query.name' }}</BreadcrumbItem>
            </Breadcrumb>
        </section>
        <main class="container consulting-main">
            <div class="consulting-main-body">
                <div class="consulting-main-body-title">From "524155445@qq.com" <span>Edit</span></div>
                <div class="consulting-main-body-content">
                    <div class="consulting-main-body-content-label">To</div>
                    <div class="consulting-main-body-content-goods">
                        <span class="consulting-main-body-content-goods-title">wuhan sier international co., LTD</span>
                        <div>
                            <v-img width="61" height="50" imgSrc="1"></v-img>
                        </div>
                    </div>
                </div>
                <div class="consulting-main-body-content" style="marginTop: 24px;marginBottom: 32px;">
                    <div class="consulting-main-body-content-label">Subject</div>
                    <div class="consulting-main-body-content-subject">Inquiry about”Beidou GPS dual mode  vehicle navigation ”</div>
                </div>
                <div class="consulting-main-body-content">
                    <div class="consulting-main-body-content-label" style="lineHeight: 34px;">Purchase Quantity</div>
                    <div class="consulting-main-body-content-purchase">
                        <input type="text">
                         <Select v-model="model1" style="width:183px;">
                            <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                        </Select>
                    </div>
                </div>
                <div class="consulting-main-body-content" style="marginTop: 22px;marginBottom: 29px;">
                    <div class="consulting-main-body-content-label">Extra Request</div>
                    <div class="consulting-main-body-content-extra">
                        <CheckboxGroup v-model="social">
                            <Checkbox label="twitter" style="marginRight: 35px; fontSize: 16px;">
                                <span>Price</span>
                            </Checkbox>
                            <Checkbox label="github" style="marginRight: 35px; fontSize: 16px;">
                                <span>Product Spectfications</span>
                            </Checkbox>
                            <Checkbox label="snapchat" style="fontSize: 16px;">
                                <span>Company Proile</span>
                            </Checkbox>
                        </CheckboxGroup>
                    </div>
                </div>
                <div class="consulting-main-body-content">
                    <div class="consulting-main-body-content-label">Content</div>
                    <textarea class="consulting-main-body-content-content" name="" id="" cols="30" rows="10">

                    </textarea>
                </div>
                <div class="consulting-main-body-content" style="marginTop: 34px;marginBottom: 17px;">
                    <div class="consulting-main-body-content-label"></div>
                    <div class="consulting-main-body-content-upload">
                        <span><strong>Attach Files</strong> (ZIP/RAR/Word/Excel,Within20M)</span>
                    </div>
                </div>
                <div class="consulting-main-body-content">
                    <div class="consulting-main-body-content-label"></div>
                    <div>
                        <span></span>
                        <span>Pre-order document.rar</span>
                        <span></span>
                    </div>
                </div>
                <button class="consulting-main-body-content-btn">Send Inquiry</button>
            </div>
        </main>
    </div>
</template>

<script>
    import Img from '@/components/Img'

    export default {
        data() {
            return {
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
                social: ['facebook', 'github'],
                fruit: ['苹果']
            }
        },
        components: {
            "v-img": Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index');

    // 头部
    .main-title {
        .lineHeight(45px);
    }

    .consulting-main {
        .width(1220px, 762px);
        .bg-color(white);
        padding: 46px 0px;

        &-body {
            .width(611px, 668px);
            margin: 0px auto;

            &-title {
                font-size: 16px;
                line-height: 21px;
                letter-spacing: 0px;
                color: #333333;
                padding-left: 99px;
                margin-bottom: 24px;

                & > span {
                    text-decoration: underline;
                    line-height: 21px;
                    color: #f0883a;
                }
            }

            &-content {
                .flex(flex-start, flex-start);
                &-label {
                    .width(134px, 15px);
                    font-size: 16px;
                    line-height: 21px;
                    letter-spacing: 0px;
                    color: #333333;
                    margin-right: 10px;
                    text-align: right;
                }

                &-goods {
                    .width(449px, 144px);
                    background-color: #f5f5f9;
                    padding: 15px 19px;

                    &-title {
                        width: 449px - 19px * 2;
                        font-size: 16px;
                        line-height: 1;
                        color: #666666;
                        display: block;
                        .textHidden();
                        margin-bottom: 12px;
                    }
                    &-title + div {
                        .width(87px, 87px);
                        .bg-color(white);
                    }
                }

                &-subject {
                    .width(449px, 47px);
                    .textHidden();
                    background-color: #f5f5f9;
                    font-size: 16px;
                    line-height: 47px;
                    color: #666666;
                    padding: 0px 14px;
                    text-align: center;
                }

                &-purchase {
                    .flex(space-between, center);
                    .width(449px, 34px);
                    
                    & > input {
                        .width(258px, 34px);
                        border: solid 1px #dddddd;
                        padding-left: 10px;
                        margin-right: 8px;
                    }
                }

                &-extra {
                    height: 20px;

                    
                }

                &-content {
                    .width(449px, 111px);
                    border: solid 1px #dddddd;
                }

                &-upload {
                    font-size: 12px;
                    letter-spacing: 0px;
                    color: #999999;

                    & strong {
                        font-size: 16px;
                        font-weight: normal;
                        color: #333333;
                        cursor: pointer;
                        line-height: 1;
                    }
                    & strong:hover {
                        color: #f0883a;
                    }
                }

                &-btn {
                    .width(133px, 39px);
                    background-color: #f0883a;
                    border: none;
                    font-size: 18px;
                    color: #ffffff;
                    display: block;
                    margin: 0px auto;
                    margin-top: 48px;
                }
            }
        }
    }
    
</style>
