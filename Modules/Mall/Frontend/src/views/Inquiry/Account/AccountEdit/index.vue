<template>
    <div class="edit">
        <v-title title="Edit Company Info"></v-title>
        <template>
            <Form ref="formInline" class="edit-from">
                <FormItem>
                    <Row :gutter="20">
                        <Col span="6" class-name="edit-from-title">
                            Member ID
                        </Col>
                        <Col span="18" class-name="edit-from-text">
                            {{ formData.member_id }}
                        </Col>
                    </Row>
                </FormItem>
                <FormItem>
                    <Row :gutter="20">
                        <Col span="6" class-name="edit-from-title">
                            Emali Address
                        </Col>
                        <Col span="18" class-name="edit-from-text">
                            <Input type="email" placeholder="wjcharles@163.com" style="width: 563px" />
                        </Col>
                    </Row>
                </FormItem>
                <FormItem>
                    <Row :gutter="20">
                        <Col span="6" class-name="edit-from-title">
                            Contact Full Name
                        </Col>
                        <Col span="18" class-name="edit-from-text">
                            <Select v-model="formData.gender" style="width:187px">
                                <Option value="Mr">Mr.</Option>
                                <Option value="Miss">Miss.</Option>
                                <Option value="Mrs">Mrs.</Option>
                            </Select>
                            <Select v-model="model1" style="width:355px;marginLeft: 20px;">
                                <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                            </Select>
                        </Col>
                    </Row>
                </FormItem>
                <FormItem>
                    <Row :gutter="20">
                        <Col span="6" class-name="edit-from-title">
                            Mobilephone
                        </Col>
                        <Col span="18" class-name="edit-from-text">
                            <Input type="text" style="width: 563px" v-model="formData.mobile_phone">
                                <span slot="prepend" style="display: inline-block;font-size: 18px;color: #333333;width: 95px;">+86</span>
                            </Input>
                        </Col>
                    </Row>
                </FormItem>
                <FormItem>
                    <Row :gutter="20">
                        <Col span="6" class-name="edit-from-title">
                            Country
                        </Col>
                        <Col span="18" class-name="edit-from-text">
                            {{ formData.country }}
                        </Col>
                    </Row>
                </FormItem>
                <FormItem>
                    <Row :gutter="20">
                        <Col span="6" class-name="edit-from-title">
                            Province/City
                        </Col>
                        <Col span="18" class-name="edit-from-text">
                            <Select v-model="model1" style="width: 271px">
                                <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                            </Select>
                            <Select v-model="model1" style="width: 271px;marginLeft: 20px;">
                                <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                            </Select>
                        </Col>
                    </Row>
                </FormItem>
                <FormItem>
                    <Row :gutter="20">
                        <Col span="6" class-name="edit-from-title">
                            Address
                        </Col>
                        <Col span="18">
                            <Input style="width: 563px" type="textarea" :autosize="{minRows: 3,maxRows: 3}" placeholder="Please fill in the detailed address" />
                        </Col>
                    </Row>
                </FormItem>
            </Form>
        </template>
        <section class="edit-btn">
            <button type="button">Cancel</button>
            <button type="button">Save</button>
        </section>
    </div>
</template>

<script>
    import Title from "../../components/Title"

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
                formData: {

                }
            }
        },
        methods: {
        },
        mounted() {
            this.formData = JSON.parse(this.$route.query.formData)

            console.log(this.formData);
            
        },
        components: {
            "v-title": Title,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .edit {
        align-self: flex-start;
        width: 945px;
        height: 772px;
        background-color: #ffffff;
        padding: 21px 30px;

        &-from {
            margin-top: 22px;

            &-title {
                height: 32px;
                text-align: right;
                font-size: 16px;
                line-height: 32px;
                color: #333333;
            }

            &-text {
                height: 32px;
                font-size: 16px;
                line-height: 32px;
                color: #333333;
            }
        }

        &-btn {
            text-align: center;
            margin-top: 50px;
            & > button {
                border: none;
                width: 118px;
                height: 44px;
                font-size: 18px;
                color: #ffffff;
            }

            & > button:first-child {
                background-color: #bfbfbf;
            }

            & > button:last-child {
                background-color: #f0883a;
                margin-left: 96px;
            }
        }
    }
</style>
