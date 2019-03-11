<template>
    <section class="container Registered-three">
        <v-head-template :img="require('@/assets/img/login/bg2.png')" />

        <div class="Registered-three-main" style="padding:50px 140px 50px 50px">
            <Form ref="RulesItem" :model="formItem" :rules="RulesItem" label-position="right" :label-width="240">
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
                <FormItem prop="company">
                    <label for="" slot="label" class="Registered-three-main-label">Company Name</label>
                    <Input type="text" v-model="formItem.company" placeholder="Must be a legally registered company" />
                </FormItem>
                <!-- 可选中国公司名称 -->
                <FormItem prop="companyChina" v-show="Countries == false">
                    <label for="" slot="label" class="Registered-three-main-label">Company Name In China</label>
                    <Input type="text" v-model="formItem.companyChina" placeholder="Must be a legally registered company" />
                </FormItem>
                <!-- 联系人名称 -->
                <FormItem prop="userName">
                    <label for="" slot="label" class="Registered-three-main-label">Contact Full Name</label>
                    <Row>
                        <Col span="6">
                            <Select v-model="formItem.gender">
                                <Option value="Mr">Mr.</Option>
                                <Option value="Miss">Miss.</Option>
                                <Option value="Mrs">Mrs.</Option>
                            </Select>
                        </Col>
                        <Col span="16" offset="2">
                            <Input v-model="formItem.userName" />
                        </Col>
                    </Row>
                </FormItem>
                <!-- 手机号 -->
                <FormItem prop="phone">
                    <label for="" slot="label" class="Registered-three-main-label">Mobilephone</label>
                    <Input v-model="formItem.phone">
                        <div slot="prepend" style="width:65px;fontSize: 18px;color: #333333;">+{{Countries == false ? 86 : 254}}</div>
                    </Input>
                </FormItem>
                <!-- 公司地址 -->
                <FormItem prop="Address1">
                    <label for="" slot="label" class="Registered-three-main-label">Company Address</label>
                    <Row>
                        <!-- 省份地址 -->
                        <Col span="14" class="Registered-three-main-address">
                            <div style="width:80px;fontSize: 18px;color: #333333;">{{ Countries == false ? 'China' : 'Kenya'}}</div>
                            <Select v-model="formItem.Address1" style="width: 187px" @on-change="changeProvince">
                                <Option :value="province_id" v-for="({ province_id, name }, index) in Province" :key="index">{{ name }}</Option>
                            </Select>
                        </Col>
                        <!-- 城市地址 -->
                        <Col span="9" offset="1"> 
                            <Select v-model="formItem.Address2" style="width: 185px;marginLeft: 10px;">
                                <Option v-for="({city_id, name}, index) in City" :value="city_id" :key="index">{{ name }}</Option>
                            </Select>
                        </Col>
                    </Row>
                </FormItem>
                 <!-- 营业执照编码 -->
                <FormItem  prop="coding" v-show="Countries == false">
                    <label for="" slot="label" class="Registered-three-main-label">Business License</label>
                    <Input type="text" v-model="formItem.coding" placeholder="填写营业执照上的统一社会信用代码" />
                </FormItem>
                <!-- 营业执照文件 -->
                <FormItem prop="file" v-show="Countries == false">
                    <label for="" slot="label" class="Registered-three-main-label">Business License Scan Upload</label>
                    <Row>
                        <Col span="24" class="registered-main-form-content">
                            <div @click="openGallery(0)" style="cursor:zoom-in;">
                                <!-- <v-img width="157" height="157" :imgSrc="`${imgSrc[0]}`" v-show="imgSrc[0]"></v-img> -->
                                <!-- <v-img width="157" height="157" :imgSrc="imgSrc" v-show="imgSrc"></v-img> -->
                                <img style="width: 157px; height: 157px; display: block" :src="imgSrc" v-show="imgSrc" alt="">
                            </div>
                            <!-- 图片预览 -->
                            <LightBox 
                                :images="imgSrc1" 
                                ref="lightbox"
                                :show-light-box="false"
                                :showThumbs="false"
                            ></LightBox>
                            <Upload
                                class="registered-main-form-upload"
                                action="//jsonplaceholder.typicode.com/posts/"
                                :format="['jpg','jpeg','png']"
                                :max-size="1024"
                                type="drag"
                                :before-upload="onBeforeUpload"
                                :show-upload-list="false"
                                >
                                <v-img width="157" height="157" :imgSrc="require('@/assets/img/uploadAdd.png')"></v-img>
                            </Upload>
                            <span>Upload png, jpg,jpeg within 1M</span>
                        </Col>
                    </Row>
                </FormItem>
            </Form>
            <!-- 提交 -->
            <button type="button" class="Registered-three-main-btn" @click="onSubmit('RulesItem')">Confirm</button>
        </div>
    </section>
</template>

<script>
    import { mapState, mapMutations } from 'vuex'
    import Img from "@/components/Img"
    import HeadTemplate from "../components/Head/index"
    // 图片预览插件
    import LightBox from 'vue-image-lightbox'
    import 'vue-image-lightbox/dist/vue-image-lightbox.min.css'
    // 公共方法
    import getData from '@/utils/getData'

    export default {
        data() {
            const validatorPassword = (rule, value, callback) => {
                // const Rex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/g
                const Rex = /^[a-zA-Z]\w{6,20}$/g
                let bool = Rex.test(value)

                if (value === '') {
                    callback(new Error('password is required'));
                } else if(!(value.length >= 6 && value.length <= 20)) {
                    callback(new Error('password must be between 6 and 20 characters'))
                } else if(!bool){
                    callback(new Error('password is (A-Z,a-z,0-9)'));
                }else {
                    callback()
                }
            };

            const validatorPasswords = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('password is required'));
                }else if(!(this.formItem.password === value)) {
                    callback(new Error("The two passwords don't match"))
                }else {
                    callback()
                }
            }
            
            // 手机号
            const validatorPhone = (rule, value, callback) => {
                var Rex = null
                if(this.Countries) {
                    Rex = /^(07)\d{8}$/
                }else {
                    Rex = /^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/
                }
                let bool = Rex.test(value)

                if (value === '') {
                    callback(new Error('Phone is required'));
                } else if(!bool){
                    callback(new Error('Please fill in the correct phone number'));
                }else {
                    callback()
                }
            }

            // 营业执照
            const validatorCoding = (rule, value, callback) => {
                var Rex = /(^(?:(?![IOZSV])[\dA-Z]){2}\d{6}(?:(?![IOZSV])[\dA-Z]){10}$)|(^\d{15}$)/

                let bool = Rex.test(value)

                if (value === '') {
                    callback(new Error('The business license is required'));
                } else if(!bool){
                    callback(new Error('Please fill in the right business license'));
                }else {
                    callback()
                }
            }

            // 必填
            const validatorCheck = (rule, value, callback) => {
                if(!this.Countries) {
                    if (value === '') {
                        callback(new Error("Can't be empty"))
                    }else {
                        callback()
                    }
                }else {
                    callback()
                }
            }

            return {
                // 421002600458688
                formItem: {
                    id: 'wjcharles',
                    password: '', // 密码
                    passwdCheck: '', // 确认密码
                    company: '', // 公司
                    companyChina: '', // 中国公司
                    gender: 'Mr', // 性别
                    userName: '', // 姓名
                    phone: '', // 手机号
                    Address1: '',
                    Address2: '',
                    coding: '', // 营业执照编码
                    file: ''
                },
                Province: '',
                City: '',
                RulesItem: { // 校验
                    password: [ // 密码验证
                        { trigger: 'blur', validator: validatorPassword }
                    ],
                    passwdCheck: [ // 确认密码
                        { trigger: 'blur', validator: validatorPasswords }
                    ],
                    company: [
                        { trigger: 'blur', validator: validatorCheck }
                    ],
                    companyChina: [
                        { trigger: 'blur', validator: validatorCheck }
                    ],
                    userName: [
                        { trigger: 'blur', validator: validatorCheck }
                    ],
                    phone: [
                        { trigger: 'blur', validator: validatorPhone }
                    ],
                    Address1: [
                        { trigger: 'blur', validator: validatorCheck }
                    ],
                    coding: [
                        { trigger: 'blur', validator: validatorCheck }
                    ],
                    file: [
                        { trigger: 'blur', validator: validatorCheck }
                    ],
                },
                imgSrc: '',
                imgSrc1: [
                    {
                        thumb: '',
                        src: '',
                    }
                ],
            }
        },
        computed: {
            ...mapState([ 'Countries' ])
        },
        methods: {
            ...mapMutations(['SET_COUNTRIES']),
            // 地址
            getCityAddress: getData.getCityAddress,
            // 地址
            getProvinceAddress: getData.getProvinceAddress,
             // 获取图片本地地址
            getObjectURL: getData.getObjectURL,
            checkAllGroupChange(value) {
                
            },
            onBeforeUpload(files) {
                const type = (files.type.split('/'))[1]
                // 判断上传图片是否符合格式
                if(files.size > 1048576 || !(['jpg','jpeg','png'].includes(type))) { // 图片大于1M
                    this.$Message.warning('Upload png, jpg,jpeg within 1M')
                }else {
                    // 获取图片路径
                    // this.$set(this.imgSrc, 0, this.getObjectURL(files))
                    // this.$set(this.imgSrc, 0, this.getObjectURL(files))
                    this.imgSrc = this.getObjectURL(files)
                    this.$set(this.imgSrc1[0], 'thumb', this.getObjectURL(files))
                    this.$set(this.imgSrc1[0], 'src', this.getObjectURL(files))

                    this.$set(this.formItem, 'file', files)
                }
                // 阻止默认上传
                return false;
            },

            // 图片预览
            openGallery(index) {
                this.$refs.lightbox.showImage(index)
            },

            changeProvince(value) { // 地址
                const City = this.getCityAddress(value)

                City.then(res => {
                    const { code, data } = res
                    if(code == 200) {
                        this.City = data
                    }
                })
            },

            onSubmit(name) { // 提交
                this.$refs[name].validate((valid) => {
                    if(valid) {
                        this.upFrom()
                    }else {
                        this.$Message.warning('请全部填写')
                    }
                })
            },

            upFrom() {
                let formData = new FormData()
                formData.append('password', this.formItem.password)
                formData.append('password_confirmation', this.formItem.passwdCheck)
                formData.append('account_type', this.Countries ? 1 : 0)
                formData.append('sex', this.formItem.gender)
                formData.append('company_name', this.formItem.company)
                formData.append('company_name_in_china', this.formItem.companyChina)
                formData.append('china_business_license', this.formItem.coding)
                formData.append('business_license_img', this.formItem.file)
                formData.append('contact_full_name', this.formItem.userName)
                formData.append('mobile_phone',  this.Countries ? `+254${this.formItem.phone}` : `+86${this.formItem.phone}`)
                formData.append('city_id', this.formItem.Address2)
                formData.append('province_id', this.formItem.Address1)
                formData.append('uuid', this.$route.query.rg_id)

                // 注册
                this.$request({
                    url: '/auth/register',
                    method: 'post',
                    data: formData,
                    headers:{'Content-Type':'multipart/form-data'}
                }).then(res => {
                    const { code, data } = res
                    if(code == 200) {
                        this.$router.push('/registered/complete')
                    }else {
                        this.$Message.warning('Verify through please register')
                    }
                }).catch(err => {
                    return false
                })
            },

            getId() { // 获取参数
                this.$request({
                    url: '/auth/check_register_status',
                    method: 'post',
                    params: {
                        uuid: this.$route.query.rg_id
                    }
                }).then(res => {
                    const { code, data } = res
                    if(code == 200) {
                        this.SET_COUNTRIES(data.account_type == 1 ? true : false)
                        this.$set(this.formItem, 'id', data.member_id)
                    }else {
                        this.$Message.error(res.message)
                        // 此处 跳转过期提醒页面！
                        // this.$router.push('/registered/one')
                    }
                }).catch(err => {
                    return false
                })
            }
        },
        mounted() {
            if(this.$route.query.u_from) {
                if(this.$route.query.u_from == 'KE') {
                    this.SET_COUNTRIES(true)
                }else {
                    this.SET_COUNTRIES(false)
                }
                const Province = this.getProvinceAddress(this.$route.query.u_from)
                Province.then(res => { // 省份地址
                    this.Province = res.data
                })

                this.getId()
            }else {
                // this.$router.push('/registered/one')
            }
        },
        components: {
            'v-img': Img,
            'v-head-template': HeadTemplate,
            LightBox
        },
        watch: {
            Countries(val) {
                const Province = this.getProvinceAddress(val ? 'ke' : 'cn')
                Province.then(res => { // 省份地址
                    this.Province = res.data
                })
            }
        },
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
    .registered-main-form-content {
        .flex(flex-start, flex-end);

        & > span:last-child {
            .color(gray);
            font-size: 14px;
            line-height: 1;
            margin-left: 14px;
        }
    }
    .registered-main-form-upload {
        width: 157px;
        height: 157px;
    }
</style>
