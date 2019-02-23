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
                    <!-- Product Name -->
                    <FormItem>
                        <Row :gutter="20">
                            <Col span="6" class-name="updateInfo-lable">
                                <span>Product Name</span>
                            </Col>
                            <Col span="15">
                                <Input v-model="formItem.name" placeholder="eg: Pure white garlic wholesale"></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <!-- SKU No. -->
                    <FormItem prop="">
                        <Row :gutter="20">
                            <Col span="6" class-name="updateInfo-lable">
                                <span>SKU No</span>
                            </Col>
                            <Col span="15">
                                <Input v-model="formItem.sku" placeholder="SKU refers to the number of business management products, it is not visible to buyer."></Input>
                            </Col>
                        </Row>
                    </FormItem>
                    <!-- Keyword (Up to 3) -->
                    <FormItem prop="">
                        <Row :gutter="20">
                            <Col span="6" class-name="updateInfo-lable">
                                <span>
                                    Keyword
                                    <span style="color: #999999;fontSize: 14px;">(Up to 3)</span>
                                </span>
                            </Col>
                            <Col span="15" class-name="updateInfo-main">
                                <Row>
                                    <Col span="24" v-for="(item, index) in formItem.keyword" :key="index" style="marginBottom: 20px;">
                                        <Row>
                                            <Col :span="formItem.keyword.length > 1 ? 22 : 24">
                                                <Input placeholder="The suggested length of keyword is 1-4 words." v-model="formItem.keyword[index]"></Input>
                                            </Col>
                                            <Col span="2" style="textAlign: right;" v-show="formItem.keyword.length != 1">
                                                <button type="button" class="updateInfo-main-del" @click="$delete(formItem.keyword, index)">
                                                </button>
                                            </Col>
                                        </Row>
                                    </Col>
                                    <Col span="24">
                                        <button type="button" class="updateInfo-main-add" @click=" formItem.keyword.length < 3 ? formItem.keyword.push('') : ''">+ Add a keyword</button>
                                    </Col>
                                </Row>
                            </Col>
                        </Row>
                    </FormItem>
                    <!-- Product Photo -->
                    <FormItem prop="">
                        <Row :gutter="20">
                            <Col span="6" class-name="updateInfo-lable" style="lineHeight: 1;">
                                Product Photo
                            </Col>
                            <Col span="15" class-name="updateInfo-main">
                                <Row>
                                    <Col span="24">
                                        <template>
                                            <div class="demo-upload-list" v-for="(item, index) in uploadList" :key="index" :title="'item.status'">
                                                <template v-if="item.status === 'finished'">
                                                    <img :src="item.path">
                                                    <div class="demo-upload-list-cover">
                                                        <!-- 传入图像name -->
                                                        <Icon type="ios-eye-outline" @click.native="handleView(item.path)"></Icon>
                                                        <Icon type="ios-trash-outline" @click.native="handleRemove(index)"></Icon>
                                                    </div>
                                                </template>
                                            </div>
                                            
                                            <Upload
                                                ref="upload"
                                                :show-upload-list="false"
                                                :before-upload="handleBeforeUpload"
                                                multiple
                                                type="drag"
                                                action="//jsonplaceholder.typicode.com/posts/"
                                                :style="'display: inline-block;width:102px;'+ (uploadList.length != 5 ? 'display: inline-block;' : 'display: none;')">
                                                
                                                <div style="width: 102px;height:102px;line-height: 102px;" v-show="uploadList.length != 5">
                                                    <Icon type="ios-camera" size="20"></Icon>
                                                </div>
                                            </Upload>
                                            <!-- 查看图片视图 -->
                                            <Modal v-model="visible">
                                                <img :src="imgName" v-if="visible" style="width: 100%">
                                            </Modal>
                                        </template>
                                    </Col>
                                    <Col span="24" class-name="updateInfo-main-font">
                                        - Format : Jpeg、Jpg、Png; Maximum: 1M;
                                    </Col>
                                </Row>
                            </Col>
                        </Row>
                    </FormItem>
                    <!-- Product Attributes -->
                    <FormItem prop="">
                        <Row :gutter="20">
                            <Col span="6" class-name="updateInfo-lable">
                                <span>
                                    Product Attributes
                                    <span style="color: #999999;fontSize: 14px;">(Up to 3)</span>
                                </span>
                            </Col>
                            <Col span="15" class-name="updateInfo-main">
                                <Row>
                                    <Col span="24" v-for="(item, index) in formItem.Custom" :key="index" style="marginBottom: 20px;">
                                        <Row type="flex" justify="space-between">
                                            <Col span="10">
                                                <Input placeholder="Color" v-model="item.color"></Input>
                                            </Col>

                                            <Col span="10">
                                                <Input placeholder="Attribute Name" v-model="item.value"></Input>
                                            </Col>
                                            <Col span="2" style="textAlign: right;" v-show="formItem.Custom.length != 1">
                                                <button type="button" class="updateInfo-main-del" @click="$delete(formItem.Custom, index)">
                                                </button>
                                            </Col>
                                        </Row>
                                    </Col>
                                    <Col span="24">
                                        <button type="button" class="updateInfo-main-add" @click=" formItem.Custom.length < 3 ? formItem.Custom.push({ value: '', color: '' }) : ''">+ Add a new price </button>
                                    </Col>
                                </Row>
                            </Col>
                        </Row>
                    </FormItem>
                </Form>
            </section>
        </template>
        
        <section class="Send-main-screening" style="marginBottom: 20px;">
            <div class="Send-main-screening-text">Trade Infomation</div>
        </section>

        <!-- Trade Infomation内容 -->
        <template>
            <section>
                <Form ref="formInline" :model="formItem">
                    <!-- FOB Price -->
                    <FormItem prop="">
                        <Row :gutter="20">
                            <Col span="6" class-name="updateInfo-lable">
                                <span>FOB Price</span>
                            </Col>
                            <Col span="15" class-name="updateInfo-main">
                                <Row>
                                    <Col span="24">
                                        <RadioGroup v-model="formItem.Price.animal">
                                            <Radio label="Ladder">Ladder Price</Radio>
                                            <Radio label="Base">Base Price</Radio>
                                        </RadioGroup>
                                    </Col>
                                    <Col span="24">
                                        <!-- Ladder Price -->
                                        <Row v-show="formItem.Price.animal != 'Base'">
                                            <Col span="24" class-name="updateInfo-main-Price"  style="marginBottom: 20px;">
                                                <div class="updateInfo-main-Price-display"  v-for="(item, index) in formItem.Price.Ladder" :key="index" :style="index != 0 ? 'marginTop: 12px;' : ''">
                                                    <div>
                                                        <span class="updateInfo-main-Price-text" style="marginLeft: 0px;">≥</span>
                                                        <!-- 数字输入框 -->
                                                        <template>
                                                            <InputNumber class="updateInfo-main-Price-input" :min="1" v-model="item.number"></InputNumber>
                                                        </template>
                                                        <!--下拉 -->
                                                        <template>
                                                            <Select v-model="item.cityList" size="large" style="width:100px">
                                                                <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                                            </Select>
                                                        </template>
                                                    </div>
                                                    <div>
                                                        <span class="updateInfo-main-Price-text">KSh</span>
                                                        <!-- 数字输入框 -->
                                                        <template>
                                                            <InputNumber :max="10" :min="1" v-model="item.number"></InputNumber>
                                                        </template>
                                                        <span class="updateInfo-main-Price-text">-</span>
                                                        <!-- 数字输入框 -->
                                                        <template>
                                                            <InputNumber :max="10" :min="1" v-model="item.number"></InputNumber>
                                                        </template>
                                                    </div>
                                                    <div v-show="formItem.Price.Ladder.length != 1">
                                                        <button type="button" class="updateInfo-main-del" @click="$delete(formItem.Price.Ladder, index)">
                                                        </button>
                                                    </div>
                                                </div>
                                            </Col>
                                            <Col span="24">
                                                <button type="button" class="updateInfo-main-add" @click="formItem.Price.Ladder.length < 4 ? formItem.Price.Ladder.push({ value: '', color: '' }) : ''">+ Add Custom Attributes</button>
                                                <span style="color: #999999;fontSize: 14px;">&nbsp;&nbsp;(Maximum 4)</span>
                                            </Col>
                                        </Row>
                                        <!-- Base Price -->
                                        <Row  v-show="formItem.Price.animal == 'Base'">
                                            <Col span="24" class-name="updateInfo-main-Price"  style="marginBottom: 20px;">
                                                <div class="updateInfo-main-Price-display">
                                                    <div>
                                                        <span class="updateInfo-main-Price-text" style="marginLeft: 0px;">≥</span>
                                                        <!-- 数字输入框 -->
                                                        <template>
                                                            <InputNumber class="updateInfo-main-Price-input" :min="1" v-model="formItem.Price.Base.number"></InputNumber>
                                                        </template>
                                                        <!--下拉 -->
                                                        <template>
                                                            <Select v-model="formItem.Price.Base.cityList" size="large" style="width:100px">
                                                                <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                                            </Select>
                                                        </template>
                                                    </div>
                                                    <div>
                                                        <span class="updateInfo-main-Price-text">KSh</span>
                                                        <!-- 数字输入框 -->
                                                        <template>
                                                            <InputNumber :max="10" :min="1" v-model="formItem.Price.Base.number"></InputNumber>
                                                        </template>
                                                        <span class="updateInfo-main-Price-text">-</span>
                                                        <!-- 数字输入框 -->
                                                        <template>
                                                            <InputNumber :max="10" :min="1" v-model="formItem.Price.Base.number"></InputNumber>
                                                        </template>
                                                    </div>
                                                </div>
                                            </Col>
                                        </Row>
                                    </Col>
                                </Row>
                            </Col>
                        </Row>
                    </FormItem>
                </Form>
            </section>
        </template>

        <section class="Send-main-screening" style="marginBottom: 20px;">
            <div class="Send-main-screening-text">Product Details</div>
        </section>

        <!-- Product Details内容 -->
        <template>
            <section>
                <!-- Description -->
                <Row :gutter="20">
                    <Col span="6" class-name="updateInfo-lable">
                        <span>Description</span>
                    </Col>
                    <Col span="15" class-name="updateInfo-main">
                        <Row>
                            <Col span="24" style="height: 367px;marginBottom: 15px;">
                                    <!-- <quill-editor ref="myTextEditor"
                                        class="updateInfo-main-editor"
                                        theme="Snow"
                                        v-model="content"
                                        :options="editorOption"
                                        @blur="onEditorBlur($event)"
                                        @focus="onEditorFocus($event)"
                                        @ready="onEditorReady($event)"> -->
                                    <quill-editor ref="myTextEditor"
                                        class="updateInfo-main-editor"
                                        theme="Snow"
                                        v-model="formItem.editor"
                                        :options="editorOption"
                                        @blur="onEditorBlur($event)"
                                        @focus="onEditorFocus($event)"
                                        >
                                    </quill-editor>
                            </Col>
                            <Col span="24">
                                <button type="button" class="updateInfo-main-add" style="marginRight: 10px;">Upload Picture</button>
                                <button type="button" class="updateInfo-main-add">Select from album</button>
                            </Col>
                        </Row>
                        <Row>
                            <Col span="24" class-name="updateInfo-main-Album">
                                <div class="updateInfo-main-Album-title">
                                    {{ 'Album Uuser' }} > {{ 'Pictures All' }}
                                </div>
                                <template>
                                    <Select v-model="model3" style="width:135px">
                                        <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                    </Select>
                                </template>
                            </Col>
                            <Col span="24" style="fontSize: 0px;">
                                <figure class="updateInfo-main-figure">
                                    <!-- img -->
                                </figure>
                                <figure class="updateInfo-main-figure">
                                    <!-- img -->
                                </figure>
                                <figure class="updateInfo-main-figure">
                                    <!-- img -->
                                </figure>
                                <figure class="updateInfo-main-figure">
                                    <!-- img -->
                                </figure>
                                <figure class="updateInfo-main-figure">
                                    <!-- img -->
                                </figure>
                                <figure class="updateInfo-main-figure">
                                    <!-- img -->
                                </figure>
                                <figure class="updateInfo-main-figure">
                                    <!-- img -->
                                </figure>
                                <figure class="updateInfo-main-figure">
                                    <!-- img -->
                                </figure>
                            </Col>
                            <Col span="24" style="borderBottom: 1px solid #eeeeee;paddingBottom: 15px;">
                                <section style="marginTop:20px;">
                                    <template>
                                        <Page :total="100" :page-size="8" style="textAlign: center"/>
                                    </template>
                                </section>
                            </Col>
                        </Row>
                    </Col>
                </Row>
            </section>
        </template>

        <section class="Send-main-screening" style="marginBottom: 20px;">
            <div class="Send-main-screening-text">Other Information</div>
        </section>

        <!-- Other Information内容 -->
        <template>
            <section>
                <!-- Shop Category -->
                <Row :gutter="20">
                    <Col span="6" class-name="updateInfo-lable">
                        <span>Shop Category</span>
                    </Col>
                    <Col span="15">
                        <Row>
                            <Col span="24" class-name="updateInfo-main-Category">
                                <Select v-model="model3" style="width:170px">
                                    <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                </Select>
                                <Select v-model="model3" style="width:170px">
                                    <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                </Select>
                                <Select v-model="model3" style="width:170px">
                                    <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                                </Select>
                            </Col>
                            <Col span="24">
                                <button type="button" class="updateInfo-main-add" style="margin: 10px 0px;">New Category</button>
                            </Col>
                            <Col span="24">
                                <div class="updateInfo-main-Category-text">
                                    Products can be subordinated to multiple categories of stores, and store categories can be customized by <span class="updateInfo-main-Category-text-span">Products > Group & Sort Products</span>
                                </div>
                            </Col>
                        </Row>
                    </Col>
                </Row>
                <!-- Release -->
                <Row :gutter="20" style="marginTop: 20px;" type="flex" align="middle">
                    <Col span="6" class-name="updateInfo-lable">
                        <span>Release</span>
                    </Col>
                    <Col span="15">
                        <RadioGroup v-model="disabledGroup" class="updateInfo-main-Release">
                            <Radio label="Release">Release</Radio>
                            <Radio label="Time">
                                <span style="marginRight: 10px;">Time</span>
                                <template>
                                    <span>
                                        <DatePicker type="datetime" format="yyyy-MM-dd HH:mm" placeholder="Select date and time(Excluding seconds)" style="width: 200px"></DatePicker>
                                    </span>
                                </template>
                            </Radio>
                            <Radio label="Put in Warehouse">Put in Warehouse</Radio>
                        </RadioGroup>
                    </Col>
                </Row>
            </section>
        </template>

        <Row style="marginTop: 40px;">
            <Col span="24" class-name="updateInfo-Agreement">
                <Checkbox v-model="single"></Checkbox>
                <div class="updateInfo-Agreement-text">
                    Please follow <span class="updateInfo-Agreement-text-pre">the Information Publishing Rules</span>, and ensure that your information is accurate,
legitimate, and does not infringe legitimate the rights and interests of third parties.
                </div>
            </Col>
        </Row>

        <button type="button" class="updateInfo-sub">Submit</button>
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import Img from "@/components/Img"
    import Head from "../../components/Head"
    import getData from "@/utils/getData"
    
    // 富文本编辑器
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'

    import { quillEditor } from 'vue-quill-editor'
    // 高亮
    // import hljs from 'highlight.js'
    import { mapState } from 'vuex'

    export default {
        data() {
            return {
                formItem: {
                    name: '', // Product Name
                    sku: '', // SKU No
                    keyword: [ '' ], // keyword
                    Custom: [
                        {
                            color: '',
                            value: ''
                        }
                    ],
                    Price: {
                        animal: 'Base',
                        Ladder: [
                            {
                                number: 1,
                                cityList: null
                            }
                        ],
                        Base: {
                            number: 1,
                            cityList: null
                        }
                    },
                    editor: null
                },
                uploadList: [], // Product Photo
                // 下拉
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
                model3: null,
                imgName: '',
                visible: false,
                // 编辑器
                editorOption: {
                    modules: {
                        toolbar: [
                            [
                                // 'bold', 'italic', 'underline', 'strike'
                                'bold', 'italic', 'underline'
                            ],
                            [
                                // 'blockquote', 'code-block'
                                'blockquote'
                            ],
                            [
                                { 'header': 1 }, { 'header': 2 }
                            ],
                            [
                                { 'list': 'ordered' }, { 'list': 'bullet' }
                            ],
                            // [
                            //     { 'script': 'sub' }, { 'script': 'super' }
                            // ],
                            [
                                { 'indent': '-1' }, { 'indent': '+1' }
                            ],
                            // [
                            //     { 'direction': 'rtl' }
                            // ],
                            [
                                { 'size': ['small', false, 'large', 'huge'] }
                            ],
                            [
                                { 'header': [1, 2, 3, 4, 5, 6, false] }
                            ],
                            [
                                { 'font': [] }
                            ],
                            // [
                            //     { 'color': [] }, { 'background': [] }
                            // ],
                            [
                                { 'color': [] }
                            ],
                            [
                                { 'align': [] }
                            ],
                            // ['clean'],
                            // ['link', 'image', 'video']
                        ],
                        // syntax: {
                        //     // highlight: text => hljs.highlightAuto(text).value
                        // }
                    }
                },
                disabledGroup: null,
                single: false
            }
        },
        computed: {
            ...mapState(['Classification'])
        },
        methods: {
            // // 获取图片路径
            // getObjectURL: getData.getObjectURL,
            handleView (name) {
                this.imgName = name;
                this.visible = true;
            },
            // 删除上传的某个图片
            handleRemove (index) {
                this.$delete(this.uploadList, index)
            },
            // 上传事件
            handleBeforeUpload (file) {
                let { name, size } = file

                if(size > 1024 * 1024) {
                    return false
                }

                const arr = name.split('.')
                const type = arr[ arr.length - 1 ]
                const types = ['jpg', 'jpeg', 'png']
                const bool = types.includes(type.toLowerCase())

                if(!bool) {
                    console.log(false);
                    return false
                }
                const len = this.uploadList.length

                this.UpProductImg(file, len == 0 ? 'main' : len).then(res => {
                    const path = res.img_url

                    this.uploadList.push({ path,  status: 'finished', file: res})
                }).catch(err => {
                    this.$Message.error('Failed to add pictures')
                })

                return false;
            },
            // 失去焦点
            onEditorBlur(editor) {
                // console.log('editor blur!', editor)
            },
            // 获取焦点
            onEditorFocus(editor) {
                // console.log('editor focus!', editor)
            },
            UpProductImg(file, id) {
                const fromData = new FormData()

                fromData.append('product_img', file)
                fromData.append('where', id)

                return new Promise((resolve, reject) => {
                    this.$request({
                        url: '/shop/product/upload_product_img',
                        method: 'post',
                        data: fromData,
                        headers:{'Content-Type':'multipart/form-data'}
                    }).then(res => {
                        if(res.code == 200) {
                            resolve(res.data)
                        }else {
                            reject(res.message)
                        }
                    }).catch(err => {
                        return false
                    })
                })
            }
        },
        mounted () {
            
        },
        // 跳转拦截
        // beforeRouteEnter (to, from, next) {
        //     next(vm => {
        //         if(vm.Classification) {
        //             return true
        //         }
        //         vm.$router.push('/inquiryList/uploadroot/uploadproduct')
        //     })
        // },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-head": Head,
            quillEditor
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .updateInfo {
        width: 945px;
        height: auto;
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

        &-main {
            
            &-del {
                width: 27px;
                height: 27px;
                border: solid 1.5px #f0883a;
                background: rgba(0, 0, 0, 0);
                

                &::before {
                    content: '';
                    width: 15px;
                    height: 1.5px;
                    background: #f0883a;
                    display: block;
                    margin: 0px auto;
                }
            }

            &-add {
                padding: 7px 14px;
                background-color: #f0883a;
                border: none;
                font-size: 12px;
                line-height: 1;
                color: #ffffff;
            }

            &-photo {
                width: 104px;
                height: 104px;
                background-color: #f0f1f5;
            }

            &-font {
                font-size: 14px;
                color: #999999;
            }

            &-Price {
                margin-top: 15px;
                padding: 20px 0px;
                background-color: #f5f5f9;
                border: solid 1px #eeeeee;

                &-display {
                    .flex(space-around);
                }

                &-text {
                    font-size: 14px;
                    color: #666666;
                    margin: 0px 16px;
                }

                &-input {
                    margin-right: 10px;
                }
            }

            &-editor {
                height: 300px;
            }

            &-Album {
                .flex(space-between, center);
                margin-top: 15px;
                padding: 0px 15px;
                height: 50px;
                background-color: #f5f5f8;
                border-bottom: solid 1px #eeeeee;

                &-title {
                    font-size: 14px;
                    color: #666666;
                }
            }

            &-figure {
                width: 545px / 6;
                height: 545px / 6;
                background-color: #ffffff;
                border: solid 1px #eeeeee;
                border-top: 0px;
                border-left: 0px;
                display: inline-block;
            }
            &-figure:nth-child(1) {
                border-left: solid 1px #eeeeee;
            }
            &-figure:nth-child(7n) {
                border-left: solid 1px #eeeeee;
            }

            &-Category {
                .flex(space-between);
            }

            &-Category-text {
                font-size: 14px;
                color: #999999;

                &-span {
                    color: #666666;
                }
            }

            &-Release {
                .flex(space-between, center);
            }
        }

        &-Agreement {
            .flex(center);

            &-text {
                width: 573px;
                font-size: 14px;
                color: #999999;

                &-pre {
                    color: #f0883a;
                }
            }
        }

        &-sub {
            width: 107px;
            height: 40px;
            background-color: #f0883a;
            font-size: 18px;
            color: #ffffff;
            border: none;
            margin: 35px auto;
            display: block;
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

    .demo-upload-list{
        display: inline-block;
        width: 104px;
        height: 104px;
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 100%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }

</style>
