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
                            <Input type="email" placeholder="wjcharles@163.com" v-model="formData.email_address" style="width: 563px" />
                        </Col>
                    </Row>
                </FormItem>
                <FormItem>
                    <Row :gutter="20">
                        <Col span="6" class-name="edit-from-title">
                            Contact Full Name
                        </Col>
                        <Col span="18" class-name="edit-from-text">
                            <Select v-model="formData.sex" style="width:187px">
                                <Option value="Mr">Mr.</Option>
                                <Option value="Miss">Miss.</Option>
                                <Option value="Mrs">Mrs.</Option>
                            </Select>
                            <Input type="text" style="width:355px;marginLeft: 20px;" v-model="formData.contact_full_name" />
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
                            <Select v-model="formData.province" style="width: 271px" @on-change="onProvince">
                                <Option v-for="item in ProvinceAddress" :value="item.value" :key="item.value">{{ item.label }}</Option>
                            </Select>
                            <Select v-model="formData.city" style="width: 271px;marginLeft: 20px;">
                                <Option v-for="item in CityAddress" :value="item.value" :key="item.value">{{ item.label }}</Option>
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
                            <Input v-model="formData.address" style="width: 563px" type="textarea" :autosize="{minRows: 3,maxRows: 3}" placeholder="Please fill in the detailed address" />
                        </Col>
                    </Row>
                </FormItem>
            </Form>
        </template>
        <section class="edit-btn">
            <button type="button" @click="$router.back(-1)">Cancel</button>
            <button type="button" @click="onSave">Save</button>
        </section>
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import getData from "@/utils/getData.js"
    import upData from "@/utils/upData.js"

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
                formData: {

                },
                ProvinceAddress: [],
                CityAddress: [],
                province: '',
                city: ''
            }
        },
        methods: {
            getProvinceAddress: getData.getProvinceAddress,
            getCityAddress: getData.getCityAddress,
            UpSetAccountInfo: upData.UpSetAccountInfo,
            onProvince(value) {
                // 获取城市列表
                this.getCityAddress(value).then(res => {
                    res.data.forEach(element => {
                        this.CityAddress.push({ value: element.city_id, label: element.name })
                        if(element.name == this.city) {
                            this.$set(this.formData, 'city', element.city_id)
                        }
                    })
                })
            },
            // 设置账户信息
            onSave() {
                // {
                // "sex":"Miss", //非必填
                // "contact_full_name":"王飞飞", //非必填
                // "mobile_phone":"+8613672009476", //非必填
                // "province_id":23, //非必填
                // "city_id":323,   //非必填
                // }
                const formData = this.formData
                this.UpSetAccountInfo({
                    sex: formData.sex,
                    contact_full_name: formData.contact_full_name,
                    mobile_phone: formData.mobile_phone,
                    province_id: formData.province,
                    city_id: formData.city,
                    detailed_address: formData.address
                }).then(res => {
                    // console.log(res);
                })
            }
        },
        mounted() {
            this.formData = JSON.parse(this.$route.query.formData)
            console.log(this.formData['province/city'])
            const name = this.formData['province/city'].split(' ')

            this.province = name[0]
            this.city = name[1]


            this.getProvinceAddress(this.formData.country == 'China' ? 'cn' : 'ke ').then(res => {
                res.data.forEach(element => {
                    this.ProvinceAddress.push({ value: element.province_id, label: element.name })
                    if(element.name == this.province) {
                        this.$set(this.formData, 'province', element.province_id)
                    }
                })

                this.getCityAddress(this.formData.province).then(res => {
                    res.data.forEach(element => {
                        this.CityAddress.push({ value: element.city_id, label: element.name })
                        if(element.name == this.city) {
                            this.$set(this.formData, 'city', element.city_id)
                        }
                    })
                })
            })
            
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
