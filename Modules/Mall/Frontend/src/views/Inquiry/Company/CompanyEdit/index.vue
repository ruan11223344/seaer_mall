<template>
    <div class="edit">
        <v-title title="Edit Company Info"></v-title>

        <Row>
            <Col span="24">
                <div class="edit-title">Basic Info</div>
            </Col>
        </Row>
        <Row class-name="edit-from">
            <!-- 公司业务类型 -->
            <Col span="24">
                <Row :gutter="10">
                    <Col span="6">
                        <div class="edit-from-title">Business Type</div>
                    </Col>
                    <Col span="18">
                        <Row class-name="edit-from-checkbox">
                            <Col span="12" class-name="edit-from-checkbox-list" v-for="({name, active}, index) in Business" :key="index">
                                <template>
                                    <Checkbox v-model="active" @on-change="onRadio(active, index)" size="large">
                                        <span class="edit-from-checkbox-list-text" v-text="name"></span>
                                    </Checkbox>
                                </template>
                            </Col>
                        </Row>
                    </Col>
                </Row>
            </Col>
            <!-- 公司名称 -->
            <Col span="24" style="marginBottom: 20px;"> 
                <Row :gutter="10">
                    <Col span="6">
                        <div class="edit-from-title" style="lineHeight: 52px;">Company Name</div>
                    </Col>
                    <Col span="18" class-name="edit-from-prompt">
                        <input type="text" placeholder="Wuhan Sier International Co.,LTD." class="edit-from-input">
                        <!-- <p class="edit-from-prompt-text">输入的信息有误</p> -->
                    </Col>
                </Row>
            </Col>
            <!-- 公司中文名称 -->
            <Col span="24">
                <Row :gutter="10">
                    <Col span="6">
                        <div class="edit-from-title" style="lineHeight: 52px;">Company Name In China</div>
                    </Col>
                    <Col span="18" class-name="edit-from-prompt">
                        <input type="text" placeholder="武汉思迩电子商务有限公司" class="edit-from-input">
                        <!-- <p class="edit-from-prompt-text">输入的信息有误</p> -->
                    </Col>
                </Row>
            </Col>
            <!-- 国家 -->
            <Col span="24">
                <Row :gutter="10">
                    <Col span="6">
                        <div class="edit-from-title" style="lineHeight: 52px;">Country</div>
                    </Col>
                    <Col span="18" class-name="edit-from-prompt">
                        <div class="edit-from-title" style="lineHeight: 52px;textAlign: left;">China</div>
                    </Col>
                </Row>
            </Col>
            <!-- 省市 -->
            <Col span="24" style="marginBottom: 20px;">
                <Row :gutter="10">
                    <Col span="6">
                        <div class="edit-from-title" style="lineHeight: 52px;">Province/City</div>
                    </Col>
                    <Col span="18" class-name="edit-from-prompt" style="display: flex;">
                        <v-select :select="select"></v-select>
                        <v-select :select="select" style="marginLeft: 19px;"></v-select>
                    </Col>
                </Row>
            </Col>
            <!-- 详细地址 -->
            <Col span="24" style="marginBottom: 20px;">
                <Row :gutter="10">
                    <Col span="6">
                        <div class="edit-from-title" style="lineHeight: 52px;">Address</div>
                    </Col>
                    <Col span="18" class-name="edit-from-prompt edit-from-phone">
                        <textarea style="resize:none;width: 561px;height: 88px;border: solid 2px #eeeeee;"></textarea>
                    </Col>
                </Row>
            </Col>
            <!-- 手机 -->
            <Col span="24" style="marginBottom: 20px;">
                <Row :gutter="10">
                    <Col span="6">
                        <div class="edit-from-title" style="lineHeight: 52px;">Mobilephone</div>
                    </Col>
                    <Col span="18" class-name="edit-from-prompt edit-from-phone">
                        <div class="edit-from-phone-frs" style="borderRight: none;">+86</div>
                        <input type="text" placeholder="027-65520870" class="edit-from-input">
                    </Col>
                </Row>
            </Col>
            <!-- 网站 -->
            <Col span="24">
                <Row :gutter="10">
                    <Col span="6">
                        <div class="edit-from-title" style="lineHeight: 52px;">Website</div>
                    </Col>
                    <Col span="18" class-name="edit-from-prompt">
                        <input type="text" placeholder="https://www.seaer.com.cn" class="edit-from-input">
                        <!-- <p class="edit-from-prompt-text">输入的信息有误</p> -->
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
            <Col span="24">
                <Row :gutter="10">
                    <Col span="6">
                        <div class="edit-from-title">Business Range</div>
                    </Col>
                    <Col span="18">
                        <Row class-name="edit-from-checkbox">
                            <Col span="12" class-name="edit-from-checkbox-list" v-for="({name, active}, index) in Business" :key="index">
                                <template>
                                    <Checkbox v-model="active" @on-change="onRadio(active, index)" size="large">
                                        <span class="edit-from-checkbox-list-text" v-text="name"></span>
                                    </Checkbox>
                                </template>
                            </Col>
                        </Row>
                    </Col>
                </Row>
            </Col>
            <!-- 主要产品 -->
            <Col span="24" style="marginBottom: 20px;">
                <Row :gutter="10">
                    <Col span="6">
                        <div class="edit-from-title" style="lineHeight: 52px;">Main Products</div>
                    </Col>
                    <Col span="18" class="edit-from-add">
                        <Row>
                            <Col span="24" v-for="(item, index) in Products" :key="index" style="marginBottom: 12px;">
                                <input type="text" class="edit-from-add-input" v-model="Products[index]" />
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
                    <Col span="18">
                        <textarea class="edit-from-textarea"></textarea>
                        <div>- Tell us your company history, business scope, certification, future development and etc.</div>
                        <div>- 100 - 40,000 characters (Including spaces and other special characters).</div>
                    </Col>
                </Row>
            </Col>
            <!-- 营业执照 -->
            <Col span="24" style="marginBottom: 20px;">
                <Row :gutter="10">
                    <Col span="6">
                        <div class="edit-from-title" style="lineHeight: 52px;">Business License</div>
                    </Col>
                    <Col span="18" class-name="edit-from-prompt">
                        <input type="text" placeholder="武汉思迩电子商务有限公司" class="edit-from-input">
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
                    <Col span="18">
                        <Row>
                            <Col span="24" class="registered-main-form-content">
                                <div @click="openGallery(0)" style="cursor:zoom-in;">
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
                    </Col>
                </Row>
            </Col>
        </Row>

        <section class="edit-btn">
            <button type="button">Cancel</button>
            <button type="button">Save</button>
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


    export default {
        data() {
            return {
                Business: [
                    {   
                        name: 'Manufacturer / Factory',
                        active: true,
                    },
                    {   
                        name: 'Manufacturer / Factory',
                        active: false,
                    },
                    {   
                        name: 'Manufacturer / Factory',
                        active: false,
                    },
                    {   
                        name: 'Manufacturer / Factory',
                        active: false,
                    },
                    {   
                        name: 'Manufacturer / Factory',
                        active: false,
                    },
                ],
                select: [
                    {
                        address: 'a',
                        id: 0
                    },
                    {
                        address: 'b',
                        id: 1
                    },
                ],
                Products: [ '' ],
                // 图片预览
                imgSrc: '',
                imgSrc1: [
                    {
                        thumb: '',
                        src: '',
                    }
                ],
            }
        },
        methods: {
            onRadio(active, index) { // 单选
                if(active) {
                    this.Business.forEach((element, i) => {
                        if(i != index) {
                            this.$set(this.Business[i], 'active', false)
                        }else {
                            this.$set(this.Business[index], 'active', true)
                        }
                    })
                }
            },
            onProductsAdd() { // 添加主要产品
                if(this.Products.length < 5) {
                    this.Products.push('')
                }
                return false
            },
            onProductsRemove(index) { // 删除主要产品
                if(this.Products.length > 1) {
                    this.$delete(this.Products, index)
                }
                return false
            },
            getObjectURL: getData.getObjectURL, // 获取图片本地地址
            checkAllGroupChange(value) {
                
            },
            onBeforeUpload(files) {
                const type = (files.type.split('/'))[1]
                // 判断上传图片是否符合格式
                if(files.size > 1048576 || !(['jpg','jpeg','png'].includes(type))) { // 图片大于1M
                    this.$Message.warning('Upload png, jpg,jpeg within 1M')
                }else {
                    // 获取图片路径
                    this.imgSrc = this.getObjectURL(files)
                    this.$set(this.imgSrc1[0], 'thumb', this.getObjectURL(files))
                    this.$set(this.imgSrc1[0], 'src', this.getObjectURL(files))

                    // this.$set(this.formItem, 'file', files)
                }
                // 阻止默认上传
                return false;
            },

            // 图片预览
            openGallery(index) {
                this.$refs.lightbox.showImage(index)
            },
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
                line-height: 1;
                color: #333333;
            }

            &-checkbox {
                
                &-list {
                    margin-bottom: 24px;
                    &-text {
                        font-size: 16px;
                        line-height: 1;
                        color: #666666;
                        margin-left: 11px;
                    }
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
