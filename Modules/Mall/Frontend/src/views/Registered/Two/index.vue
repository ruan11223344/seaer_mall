<template>
    <div class="registered-main">
        <h1 class="registered-main-title">Enter Your Business Information</h1>
        <div class="registered-main-license">
            <!-- 营业执照 -->
            <Checkbox v-model="formItem.checkRadio" size="large"></Checkbox>
            <span>I'm a person <strong>(No business license to choose an individual)</strong></span>
        </div>

        <Form :model="formItem" label-position="left" :rules="ruleCustom" ref="ruleCustom" class="registered-main-form">
            <!-- 公司名称 -->
            <FormItem>
                <label for="" slot="label" class="label">Company Name：</label>
                <Input v-model="formItem.companyName" />
            </FormItem>
            <!-- 中国公司名称 -->
            <FormItem>
                <label for="" slot="label" class="label">Company Name in China:</label>
                <Input v-model="formItem.chinaCompanyName" />
            </FormItem>
            <!-- 联系人姓名 -->
            <FormItem>
                <label for="" slot="label" class="label">Contact Full Name:</label>
                <Row>
                    <Col span="24">
                        <Row :gutter="20">
                            <Col span="8">
                                <Select v-model="formItem.gender" style="width:200px">
                                    <Option value="beijing">New York</Option>
                                    <Option value="shenzhen">Sydney</Option>
                                </Select>
                            </Col>
                            <Col span="16">
                                <Input v-model="formItem.userName" />
                            </Col>
                        </Row>
                    </Col>
                </Row>
            </FormItem>
            <!-- 中文名 -->
            <FormItem>
                <label for="" slot="label" class="label">Chinese Name:</label>
                <Input v-model="formItem.chinaUserName" />
            </FormItem>
            <!-- 手机号码 -->
            <FormItem>
                <label for="" slot="label" class="label">Mobile Phone:</label>
                <Input v-model="formItem.phone">
                    <div slot="prepend" style="width:95px;fontSize: 18px;color: #333333;">+254</div>
                </Input>
            </FormItem>
            <!-- 公司地点 -->
            <FormItem>
                <label for="" slot="label" class="label">Company Location:</label>
                <Row>
                    <Col span="24">
                        <Row :gutter="20">
                            <Col span="12">
                                <Select v-model="formItem.gender">
                                    <Option value="beijing">New York</Option>
                                    <Option value="shenzhen">Sydney</Option>
                                </Select>
                            </Col>
                            <Col span="12">
                                <Select v-model="formItem.gender">
                                    <Option value="beijing">New York</Option>
                                    <Option value="shenzhen">Sydney</Option>
                                </Select>
                            </Col>
                        </Row>
                    </Col>
                    <Col span="24" style="marginTop:20px">
                        <Input v-model="formItem.location" />
                    </Col>
                </Row>
            </FormItem>
            <!-- 业务类型 -->
            <FormItem>
                <label for="" slot="label" class="label">Business Type:</label>
                <!-- <Input v-model="formItem.passwords" /> -->
                <Row>
                    <Col span="24">
                        <CheckboxGroup v-model="formItem.checkAllGroupChange" @on-change="checkAllGroupChange" style="display:flex;justify-content: space-between;alignItems:center">
                            <Checkbox label="Manufacturer/Factory"></Checkbox>
                            <Checkbox label="Trading Company"></Checkbox>
                            <Checkbox label="Individuals/SOHO"></Checkbox>
                            <Checkbox label="Other"></Checkbox>
                        </CheckboxGroup>
                    </Col>
                </Row>
            </FormItem>
            <!-- 业务范围 -->
            <FormItem>
                <label for="" slot="label" class="label">Business Range:</label>
                <Row>
                    <Col span="24">
                        <CheckboxGroup v-model="formItem.business" @on-change="businessChange" class="registered-main-form-AllGroup">
                            <Checkbox class="registered-main-form-AllGroup-list" v-for="(itemText, index) in formItem.businessAll" :key="index" :title="itemText" :label="itemText"></Checkbox>
                        </CheckboxGroup>
                    </Col>  
                </Row>
            </FormItem>
            <!-- 营业执照编号 -->
            <FormItem>
                <label for="" slot="label" class="label">Business License:</label>
                <Input v-model="formItem.passwords" />
            </FormItem>
            <!-- 上传营业执照 -->
            <FormItem>
                <label for="" slot="label" class="label">Business License Scan Upload:</label>
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
            <!-- 提交 -->
            <FormItem style="marginTop:46px;">
                <Button type="primary" @click="onSubmit('ruleCustom')" class="subBtn">Submit</Button>
            </FormItem>
        </Form>
    </div>
</template>

<script>
    import Img from "@/components/Img"
    import LightBox from 'vue-image-lightbox'
    import 'vue-image-lightbox/dist/vue-image-lightbox.min.css'

    export default {
        data() {
            return {
                imgSrc: [],
                imgSrc1: [
                    {
                        thumb: '',
                        src: '',
                    }
                ],
                formItem: {
                    companyName: '', // 公司名称
                    chinaCompanyName: '', // 中国公司名称
                    gender: '', // 性别
                    userName: '', // 姓名
                    chinaUserName: '', // 中文名
                    phone: '', // 手机号
                    location: '', // 公司地点
                    checkAllGroupChange: [], // 业务
                    business: [],
                    businessAll: [ 
                        'Agriculture & Food', 
                        'Apparel & Accessories', 
                        'Manufacturing & Processing Machinery',
                        'Office Supplies',
                    ],// 业务

                    MenberId: '', // 会员身份
                    password: '', // 创建密码
                    passwords: '', // 确认密码
                    checkRadio: false,
                },
                ruleCustom: {
                    
                },
            }
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
            "v-img": Img,
            LightBox
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index');

    .registered-main {
        .width(768px, auto);
        .bg-color(white);
        padding: 0px 54px 44px 54px;

        &-title {
            .color(blackDark);
            height: 24px;
            font-size: 24px;
            line-height: 1;
            margin-top: 50px;
            text-align: center;
            font-weight: bold;
        }

        &-license {
            .flex(flex-start, center);
            margin-top: 37px;
            margin-bottom: 22px;
            font-size: 18px;

            & > span:last-child {
                .color(blackDark);
                line-height: 1;

                & > strong {
                    .color(Orange);
                    font-family: AdobeHeitiStd-Regular;
                    font-weight: normal;
                }
            }
        }

        & > &-form {
            .label {
                .color(blackDark);
                width: 660px;
                height: 15px;
                font-size: 16px;
                line-height: 1;
            }
            .subBtn {
                .color(white);
                .bg-color(Orange);
                .width(100%, 61px);
                font-size: 21px;
                border-color: transparent;
            }

            .registered-main-form-AllGroup {
                .flex(space-between, center);
                flex-wrap: wrap;
            }
            .registered-main-form-AllGroup-list {
                width: 49%;
                margin-right: 0px;
                .textHidden();
            }
            .registered-main-form-AllGroup-list:nth-child(2n) {
                margin-left: 1%;
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
        }
    }
</style>
