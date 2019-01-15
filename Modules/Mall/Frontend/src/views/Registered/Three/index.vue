<template>
    <section class="container Registered-three">
        <v-head-template :img="require('@/assets/img/login/bg2.png')" />

        <div class="Registered-three-main">
            <Form ref="" :model="formItem" :rules="RulesItem" label-position="right" :label-width="150">
                <!-- id -->
                <FormItem>
                    <label for="" slot="label" class="Registered-three-main-label">Member ID</label>
                    <div class="Registered-three-main-id">{{ formItem.id }}</div>
                </FormItem>
                <!-- 密码 -->
                <FormItem prop="password">
                    <label for="" slot="label" class="Registered-three-main-label">Create Password</label>
                    <Input type="password" v-model="formItem.password" placeholder="Please enter your password" />
                </FormItem>
                <!-- 确认密码 -->
                <FormItem prop="passwdCheck">
                    <label for="" slot="label" class="Registered-three-main-label">Confirm Password</label>
                    <Input type="password" v-model="formItem.passwdCheck" placeholder="Please retype your password" />
                </FormItem>
                <!-- 公司名称 -->
                <FormItem>
                    <label for="" slot="label" class="Registered-three-main-label">Company Name</label>
                    <Input type="text" v-model="formItem.company" placeholder="Must be a legally registered company" />
                </FormItem>
                <!-- 联系人名称 -->
                <FormItem>
                    <label for="" slot="label" class="Registered-three-main-label">Contact Full Name</label>
                    <Row>
                        <Col span="6">
                            <Select v-model="formItem.gender">
                                <Option value="Mr.">Mr.</Option>
                                <Option value="shenzhen">Sydney</Option>
                            </Select>
                        </Col>
                        <Col span="16" offset="2">
                            <Input v-model="formItem.userName" />
                        </Col>
                    </Row>
                </FormItem>
                <!-- 手机号 -->
                <FormItem>
                    <label for="" slot="label" class="Registered-three-main-label">Mobilephone</label>
                    <Input v-model="formItem.phone">
                        <div slot="prepend" style="width:65px;fontSize: 18px;color: #333333;">+254</div>
                    </Input>
                </FormItem>
                <!-- 公司地址 -->
                <FormItem>
                    <label for="" slot="label" class="Registered-three-main-label">Company Address</label>
                    <Row>
                        <Col span="14" class="Registered-three-main-address">
                            <div style="width:80px;fontSize: 18px;color: #333333;">Kenya</div>
                            <Select v-model="formItem.Address1" style="width: 187px">
                                <Option value="beijing">New York</Option>
                                <Option value="shanghai">London</Option>
                                <Option value="shenzhen">Sydney</Option>
                            </Select>
                        </Col>
                        <Col span="9" offset="1">
                            <Select v-model="formItem.Address2" disabled style="width: 187px">
                                <!-- <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option> -->
                            </Select>
                        </Col>
                    </Row>
                </FormItem>
            </Form>
            <!-- 提交 -->
            <button type="button" class="Registered-three-main-btn">Confirm</button>
        </div>
    </section>
</template>

<script>
    import Img from "@/components/Img"
    import HeadTemplate from "../components/Head/index"

    export default {
        data() {
            return {
                formItem: {
                    id: 'wjcharles',
                    password: '',
                    passwdCheck: '',
                    company: '',
                    gender: 'Mr.', // 性别
                    userName: '', // 姓名
                    Address1: '',
                    Address2: '',
                },
                RulesItem: { // 校验
                    password: [
                        {}
                    ],
                    passwdCheck: [
                        {}
                    ],
                }
            }
        },
        methods: {
            
        },
        components: {
            'v-img': Img,
            'v-head-template': HeadTemplate
        }
    }
</script>

<style lang="less">
    @import url('../../../assets/css/index');

    .Registered-three {

        &-main {
            width: 950px;
            height: auto;
            background-color: #ffffff;
            border-radius: 4px;
            border: solid 1px #eeeeee;
            margin: 0px auto;
            padding: 50px 150px;

            &-id {
                font-size: 16.2px;
                color: #333333;
            }

            &-label {
                font-size: 16px;
                line-height: 1;
                color: #333333;
            }

            &-address {
                .flex();

                & > div:first-child {
                    width:80px;
                    font-size: 18px;
                    color: #333333;
                    background-color: #f8f8f9;
                    border: solid 2px #eeeeee;
                    border: 1px solid #dcdee2;
                    border-right: 0px;
                    text-align: center;
                }
            }

            .ivu-select-selection {
                border-radius: 0px;
            }

            &-btn {
                border: none;
                width: 198px;
                height: 50px;
                background-color: #f0883a;
                font-size: 18px;
                line-height: 1;
                color: #ffffff;
                margin: 0px auto;
                display: block;
            }
        }
    }
</style>
