<template>
    <div class="edit" v-if="formData != null">
        <v-title title="Edit Company Info"></v-title>
        
        <Form ref="formInline" :model="formData" :rules="ruleInline">
            <Row>
                <Col span="24">
                    <div class="edit-title">Basic Info</div>
                </Col>
            </Row>
            <Row class-name="edit-from">
                <!-- 公司业务类型 -->
                <Col span="24" style="marginBottom: 20px;">
                    <Row :gutter="10">
                        <Col span="6">
                            <div class="edit-from-title">Business Type</div>
                        </Col>
                        <Col span="15">
                            <Row class-name="edit-from-checkbox">
                                <Col span="24">
                                    <RadioGroup v-model="formData.basic_info.business_type_id">
                                        <Radio :label="`${id}`" v-for="({name, id}, index) in formData.other_info.business_type_list" :key="index" class="edit-from-checkbox-list">
                                            <span>{{ name + id }}</span>
                                        </Radio>
                                    </RadioGroup>
                                </Col>
                            </Row>
                        </Col>
                    </Row>
                </Col>
                <!-- 公司名称 -->
                <Col span="24" style="marginBottom: 20px;"> 
                    <Row :gutter="10">
                        <Col span="6">
                            <div class="edit-from-title" style="lineHeight: 36px;">Company Name</div>
                        </Col>
                        <Col span="15" class-name="edit-from-prompt">
                            <!-- <input type="text" v-model="formData.basic_info.company_name"  placeholder="Wuhan Sier International Co.,LTD." class="edit-from-input"> -->
                            <!-- <p class="edit-from-prompt-text">输入的信息有误</p> -->
                            <Input type="text" v-model="formData.basic_info.company_name" placeholder="Wuhan Sier International Co.,LTD." />
                        </Col>
                    </Row>
                </Col>
                <!-- 公司中文名称 -->
                <Col span="24">
                    <Row :gutter="10">
                        <Col span="6">
                            <div class="edit-from-title" style="lineHeight: 36px;">Company Name In China</div>
                        </Col>
                        <Col span="15" class-name="edit-from-prompt">
                            <!-- <input type="text" v-model="formData.basic_info.company_name_in_china" placeholder="武汉思迩电子商务有限公司" class="edit-from-input"> -->
                            <!-- <p class="edit-from-prompt-text">输入的信息有误</p> -->
                            <Input type="text" v-model="formData.basic_info.company_name_in_china" placeholder="武汉思迩电子商务有限公司" />
                        </Col>
                    </Row>
                </Col>
                <!-- 国家 -->
                <Col span="24">
                    <Row :gutter="10" style="margin: 10px 0px;">
                        <Col span="6">
                            <div class="edit-from-title" style="lineHeight: 36px;" >Country</div>
                        </Col>
                        <Col span="15" class-name="edit-from-prompt">
                            <div class="edit-from-title" style="lineHeight: 36px;textAlign: left;">{{ formData.basic_info.country_name }}</div>
                        </Col>
                    </Row>
                </Col>
                <!-- 省市 -->
                <Col span="24" style="marginBottom: 20px;">
                    <Row :gutter="10">
                        <Col span="6">
                            <div class="edit-from-title" style="lineHeight: 36px;">Province/City</div>
                        </Col>
                        <Col span="15" class-name="edit-from-prompt" style="display: flex;">
                            <Select v-model="formData.basic_info.company_province_id"  @on-change="onProvince" style="width:250px;marginRight: 50px;">
                                <Option v-for="item in ProvinceAddress" :value="item.value" :key="item.value">{{ item.label }}</Option>
                            </Select>
                            <Select v-model="formData.basic_info.company_city_id" style="width:250px">
                                <Option v-for="item in CityAddress" :value="item.value" :key="item.value">{{ item.label }}</Option>
                            </Select>
                        </Col>
                    </Row>
                </Col>
                <!-- 详细地址 -->
                <Col span="24" style="marginBottom: 20px;">
                    <Row :gutter="10">
                        <Col span="6">
                            <div class="edit-from-title" style="lineHeight: 36px;">Address</div>
                        </Col>
                        <Col span="15" class-name="edit-from-prompt edit-from-phone">
                            <Input v-model="formData.basic_info.address" type="textarea" :autosize="{minRows: 7,maxRows: 7}" placeholder="Enter something..." />
                        </Col>
                    </Row>
                </Col>
                <!-- 手机 -->
                <Col span="24" style="marginBottom: 20px;">
                    <Row :gutter="10">
                        <Col span="6">
                            <div class="edit-from-title" style="lineHeight: 36px;">Mobilephone</div>
                        </Col>
                        <Col span="15" class-name="edit-from-prompt edit-from-phone">
                            <Input type="text" v-model="formData.basic_info.telephone" placeholder="" /> 
                                <span slot="prepend">+86</span >
                            </Input>
                        </Col>
                    </Row>
                </Col>
                <!-- 网站 -->
                <Col span="24">
                    <Row :gutter="10">
                        <Col span="6">
                            <div class="edit-from-title" style="lineHeight: 36px;">Website</div>
                        </Col>
                        <Col span="15" class-name="edit-from-prompt">
                            <Input type="text" v-model="formData.basic_info.website" placeholder="" /> 
                            </Input>
                        </Col>
                    </Row>
                </Col>
            </Row>

            <Row>
                <Col span="24">
                    <div class="edit-title">Edit Business Info</div>
                </Col>
            </Row>

            <Row class-name="edit-from">
                <!-- 公司业务类型 -->
                <Col span="24" style="marginBottom: 20px;">
                    <Row :gutter="10">
                        <Col span="6">
                            <div class="edit-from-title">Business Range</div>
                        </Col>
                        <Col span="15">
                            <Row class-name="edit-from-checkbox">
                                <Col span="24">
                                    <CheckboxGroup v-model="formData.business_info.business_range_id_arr">
                                        <Checkbox :label="`${id}`" v-for="({name, id}, index) in formData.other_info.business_range_list" :key="index" class="edit-from-checkbox-list">
                                            <span>{{ name }}</span>
                                        </Checkbox>
                                    </CheckboxGroup>
                                </Col>
                            </Row>
                        </Col>
                    </Row>
                </Col>
                <!-- 主要产品 -->
                <Col span="24" style="marginBottom: 20px;">
                    <Row :gutter="10">
                        <Col span="6">
                            <div class="edit-from-title" style="lineHeight: 36px;">Main Products</div>
                        </Col>
                        <Col span="15" class="edit-from-add">
                            <Row>
                                <Col span="24" v-for="(item, index) in formData.business_info.main_products_arr" :key="index" style="marginBottom: 12px;">
                                    <!-- <input type="text" class="edit-from-add-input" v-model="Products[index]" /> -->
                                    <Input type="text" style="width: 500px;marginRight: 20px;" v-model="formData.business_info.main_products_arr[index]" placeholder="" /> 
                                    </Input>
                                    <button type="button" class="edit-from-add-remove" @click="onProductsRemove(index)">
                                        <div class="edit-from-add-remove-hr"></div>
                                    </button>
                                </Col>
                                <Col span="24">
                                    <button type="button" class="edit-from-add-btn" @click="onProductsAdd">+ Add more </button>
                                </Col>
                            </Row>
                        </Col>
                    </Row>
                </Col>
                <!-- 公司简介 -->
                <Col span="24" style="marginBottom: 20px;">
                    <Row :gutter="10">
                        <Col span="6">
                            <div class="edit-from-title">Company Profile</div>
                        </Col>
                        <Col span="15">
                            <!-- <textarea class="edit-from-textarea"></textarea> -->
                            <Input v-model="formData.business_info.company_profile" type="textarea" :autosize="{minRows: 7,maxRows: 7}" placeholder="" />
                            <div>- Tell us your company history, business scope, certification, future development and etc.</div>
                            <div>- 100 - 40,000 characters (Including spaces and other special characters).</div>
                        </Col>
                    </Row>
                </Col>
                <!-- 营业执照 -->
                <Col span="24" style="marginBottom: 20px;">
                    <Row :gutter="10">
                        <Col span="6">
                            <div class="edit-from-title" style="lineHeight: 36px;">Business License</div>
                        </Col>
                        <Col span="15" class-name="edit-from-prompt">
                            <Input type="text" v-model="formData.business_info.business_license" placeholder="" /> 
                            <!-- <p class="edit-from-prompt-text">输入的信息有误</p> -->
                        </Col>
                    </Row>
                </Col>
                <!-- 营业执照照片 -->
                <Col span="24" style="marginBottom: 20px;">
                    <Row :gutter="10">
                        <Col span="6">
                            <div class="edit-from-title">Attachment</div>
                        </Col>
                        <Col span="15">
                            <Row>
                                <Col span="24" class="registered-main-form-content">
                                    <div @click="openGallery(0)" style="cursor:zoom-in;">
                                        <img style="width: 157px; height: 157px; display: block" :src="formData.business_info.business_license_url" v-show="formData.business_info.business_license_path" alt="">
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
                        </Col>
                    </Row>
                </Col>
            </Row>
        </Form>
        <section class="edit-btn">
            <button type="button" @click="$router.back(-1)">Cancel</button>
            <button type="button" @click="onSave(formData)">Save</button>
        </section>
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import Img from "@/components/Img"
    import Select from "@/components/Select"
    // 图片预览插件
    import LightBox from 'vue-image-lightbox'
    import 'vue-image-lightbox/dist/vue-image-lightbox.min.css'
    
    // 公共方法
    import getData from '@/utils/getData'
    import upData from '@/utils/upData'

    export default {
        data() {
            return {
                formData: null,
                // 图片预览
                imgSrc1: [
                    {
                        thumb: '',
                        src: '',
                    }
                ],
                ProvinceAddress: [],
                CityAddress: [],
                ruleInline: {}
            }
        },
        methods: {
            UpBusinessLicense: upData.UpBusinessLicense,
            UpSetAccountInfo: upData.UpSetAccountInfo,
            onGetCompanyInfo: getData.onGetCompanyInfo,
            getProvinceAddress: getData.getProvinceAddress,
            getCityAddress: getData.getCityAddress,
            getObjectURL: getData.getObjectURL, // 获取图片本地地址
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
            onProductsAdd() { // 添加主要产品
                if(this.formData.business_info.main_products_arr.length < 5) {
                    this.formData.business_info.main_products_arr.push('')
                }
                return false
            },
            onProductsRemove(index) { // 删除主要产品
                if(this.formData.business_info.main_products_arr.length > 1) {
                    this.$delete(this.formData.business_info.main_products_arr, index)
                }
                return false
            },
            checkAllGroupChange(value) {
                
            },
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
            onBeforeUpload(files) {
                let type = (files.type.split('/'))[1]
                type = type.toLowerCase()

                // 判断上传图片是否符合格式
                if(files.size > 1048576 || !(['jpg','jpeg','png'].includes(type))) { // 图片大于1M
                    this.$Message.warning('Upload png, jpg,jpeg within 1M')
                }else {
                    const formData = new FormData()
                    formData.append('business_license_img', files)
                    this.UpBusinessLicense(formData).then(({ name, path, url }) => {
                        // name: "5a449a3004429.png"
                        // path: "mall/users/AF_CN_c1dce03043/private/155123859271619548.png"
                        // url: "https://afriby-oss.oss-cn-hongkong.aliyuncs.com/mall

                        // 获取图片路径
                        this.$set(this.formData.business_info, 'business_license_path', path)
                        this.$set(this.formData.business_info, 'business_license_url', url)
                        this.$set(this.imgSrc1[0], 'thumb', url)
                        this.$set(this.imgSrc1[0], 'src', url)
                    })

                }
                // 阻止默认上传
                return false;
            },
            // 图片预览
            openGallery(index) {
                this.$refs.lightbox.showImage(index)
            },
            // 设置公司信息
            onSave(formData) {
                
                const obj = {
                    company_business_type_id: this.type_id,
                    company_name: formData.basic_info.company_name,
                    company_name_in_china: formData.basic_info.company_name_in_china,
                    company_province_id: formData.basic_info.company_province_id, // 省份
                    company_city_id: formData.basic_info.company_city_id, //  城市
                    company_detailed_address: formData.basic_info.address,
                    company_mobile_phone: formData.basic_info.telephone,
                    company_website: formData.basic_info.website,
                    company_business_range_ids: formData.business_info.business_range_id_arr,
                    company_main_products: formData.business_info.main_products_arr,
                    company_business_license: formData.business_info.business_license,
                    company_business_license_pic_url: formData.business_info.business_license_path,
                    company_profile: formData.business_info.company_profile
                }

                this.UpSetAccountInfo(obj).then(res => {
                })
            }
        },
        mounted() {
            // const formData = this.$route.query.formData
            // this.formData = JSON.parse(formData)
            // console.log(this.formData);

            this.onGetCompanyInfo().then(res => {
                this.formData = res
                if(this.formData.business_info.main_products_arr.length == 0) {
                    this.$set(this.formData.business_info.main_products_arr, 0, '')
                }
                
                return res
            }).then(res => {
                this.getProvinceAddress(this.formData.country_name == 'China' ? 'cn' : 'ke ').then(res => {
                // this.getProvinceAddress('cn').then(res => {
                    res.data.forEach(element => {
                        this.ProvinceAddress.push({ value: element.province_id, label: element.name })
                    })
                })

                return res
            }).then(res => {
                this.getCityAddress(this.formData.basic_info.company_province_id).then(res => {
                    res.data.forEach(element => {
                        this.CityAddress.push({ value: element.city_id, label: element.name })
                    })
                })
            })
        },
        watch: {
            ['formData.business_info.business_range_id_arr'](val) {
                const len = val.length
                if(len > 5) {
                    this.$delete(this.formData.business_info.business_range_id_arr, len - 1)
                }
            }
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-select": Select,
            LightBox
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');
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

    .edit {
        align-self: flex-start;
        width: 945px;
        height: auto;
        background-color: #ffffff;
        padding: 21px 30px;

        &-title {
            width: 100%;
            height: 47px;
            line-height: 47px;
            font-size: 16px;
            color: #666666;
            background-color: #f5f5f9;
            padding-left: 20px;
            margin-top: 20px;
        }

        &-from {
            margin-top: 22px;
            
            &-title {
                text-align: right;
                font-size: 16px;
                color: #333333;
            }

            &-checkbox {
                &-list {
                    width: 45%;
                    margin-bottom: 24px;
                    .textHidden();
                }

                &-list:nth-child(2n) {
                    margin-left: 5%;
                }
            }

            &-prompt {
                position: relative;

                &-text {
                    position: absolute;
                    bottom: -25px;
                }
            }
            &-input {
                width: 561px;
                height: 52px;
                border: solid 2px #eeeeee;
                font-size: 16px;
                line-height: 1;
                color: #999999;
                text-indent: 1em;
            }

            &-phone {
                .flex();

                &-frs {
                    width: 95px;
                    height: 52px;
                    border: solid 2px #eeeeee;
                    text-align: center;
                    line-height: 52px;
                    font-size: 16px;
                    color: #333333;
                }

                &-frs + .edit-from-input {
                    width: 468px;
                    height: 52px;
                    border: solid 2px #eeeeee;
                }
            }

            &-add {

                &-input {
                    width: 500px;
                    height: 52px;
                    border: solid 2px #eeeeee;
                    font-size: 16px;
                    color: #999999;
                    text-indent: 1em;
                    margin-right: 16px;
                }

                &-remove {
                    width: 27px;
                    height: 27px;
                    border: solid 1px #f0883a;
                    font-size: 37px;
                    color: #f0883a;
                    background-color: #ffffff;

                    &-hr {
                        width: 11px;
                        height: 4px;
                        background-color: #f0883a;
                        margin: 0px auto;
                    }
                }

                &-btn {
                    width: 76px;
                    height: 25px;
                    background-color: #f0883a;
                    font-size: 12px;
                    color: #ffffff;
                    border: none;
                }
            }

            &-textarea {
                width: 564px;
                height: 122px;
                border: solid 1px #dddddd;
                resize: none;
            }

            &-textarea ~ div {
                font-size: 14px;
                line-height: 1.8;
                color: #999999;
            }
        }

        &-btn {
            text-align: center;
            margin-top: 61px;
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