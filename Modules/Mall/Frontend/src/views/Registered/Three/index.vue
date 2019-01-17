<template>
    <section class="container Registered-three">
        <v-head-template :img="require('@/assets/img/login/bg2.png')" />

        <div class="Registered-three-main" style="padding:50px 140px 50px 50px">
            <Form ref="" :model="formItem" :rules="RulesItem" label-position="right" :label-width="240">
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
                <!-- 可选中国公司名称 -->
                <FormItem v-show="Countries == false">
                    <label for="" slot="label" class="Registered-three-main-label">Company Name In China</label>
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
                        <div slot="prepend" style="width:65px;fontSize: 18px;color: #333333;">+{{Countries == false ? 86 : 254}}</div>
                    </Input>
                </FormItem>
                <!-- 公司地址 -->
                <FormItem>
                    <label for="" slot="label" class="Registered-three-main-label">Company Address</label>
                    <Row>
                        <Col span="14" class="Registered-three-main-address">
                            <div style="width:80px;fontSize: 18px;color: #333333;">{{ Countries == false ? 'China' : 'Kenya'}}</div>
                            <Select v-model="formItem.Address1" style="width: 187px">
                                <Option value="beijing">New York</Option>
                                <Option value="shanghai">London</Option>
                                <Option value="shenzhen">Sydney</Option>
                            </Select>
                        </Col>
                        <Col span="9" offset="1">
                            <Select v-model="formItem.Address2" disabled style="width: 187px;float:right">
                                <!-- <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option> -->
                            </Select>
                        </Col>
                    </Row>
                </FormItem>
                 <!-- 营业执照编码 -->
                <FormItem v-show="Countries == false">
                    <label for="" slot="label" class="Registered-three-main-label">Business License</label>
                    <Input type="text" v-model="formItem.company" placeholder="填写营业执照上的统一社会信用代码" />
                </FormItem>
                <!-- 营业执照编码 -->
                <FormItem v-show="Countries == false">
                    <label for="" slot="label" class="Registered-three-main-label">Business License Scan Upload</label>
                    <Row>
                        <Col span="24" class="registered-main-form-content">
                            <div @click="openGallery(0)" style="cursor:zoom-in;">
                                <v-img width="157" height="157" :imgSrc="`${imgSrc[0]}`" v-show="imgSrc[0]"></v-img>
                            </div>
                            <!-- 图片预览 -->
                            <LightBox 
                                :images="imgSrc1" 
                                ref="lightbox"
                                :show-light-box="false"
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
            <button type="button" class="Registered-three-main-btn">Confirm</button>
        </div>
    </section>
</template>

<script>
    import { mapState } from 'vuex'
    import Img from "@/components/Img"
    import HeadTemplate from "../components/Head/index"
    // 图片预览插件
    import LightBox from 'vue-image-lightbox'
    import 'vue-image-lightbox/dist/vue-image-lightbox.min.css'

    export default {
        data() {
            const validatorPassword = (rule, value, callback) => {
                const Rex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/g
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
            
            return {
                formItem: {
                    id: 'wjcharles',
                    password: '', // 密码
                    passwdCheck: '', // 确认密码
                    company: '', // 公司
                    gender: 'Mr.', // 性别
                    userName: '', // 姓名
                    Address1: '',
                    Address2: '',
                },
                RulesItem: { // 校验
                    password: [ // 密码验证
                        { trigger: 'blur', validator: validatorPassword }
                    ],
                    passwdCheck: [ // 确认密码
                        { trigger: 'blur', validator: validatorPasswords }
                    ],
                },
                imgSrc: [],
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
            getObjectURL(file) {  
                let url = null;  
                if (window.createObjcectURL != undefined) {  
                url = window.createOjcectURL(file);  
                } else if (window.URL != undefined) {  
                url = window.URL.createObjectURL(file);  
                } else if (window.webkitURL != undefined) {  
                url = window.webkitURL.createObjectURL(file);  
                }  
                return url;  
            },
            checkAllGroupChange(value) {
                
            },
            businessChange(value) {
                if(value.length < 4) {
                    this.formItem.business = value
                }else {
                    this.$delete(this.formItem.business, 3)
                }
            },
            onBeforeUpload(files) {
                const type = (files.type.split('/'))[1]
                // 判断上传图片是否符合格式
                if(files.size > 1048576 || !(['jpg','jpeg','png'].includes(type))) { // 图片大于1M
                    this.$Message.warning('Upload png, jpg,jpeg within 1M')
                }else {
                    // 获取图片路径
                    this.$set(this.imgSrc, 0, this.getObjectURL(files))
                    this.$set(this.imgSrc1[0], 'thumb', this.getObjectURL(files))
                    this.$set(this.imgSrc1[0], 'src', this.getObjectURL(files))
                }
                // 阻止默认上传
                return false;
            },
            // 图片预览
            openGallery(index) {
                this.$refs.lightbox.showImage(index)
            },
            onSubmit(name) {

            }
        },
        components: {
            'v-img': Img,
            'v-head-template': HeadTemplate,
            LightBox
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
