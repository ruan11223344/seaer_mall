<template>
    <div>
        <header>
            <router-link to="/home" tag="div" class="login-head">
                <img :src="require('@/assets/img/home/logo.png')" alt="" style="cursor: pointer;">
            </router-link>
        </header>
        <div style="backgroundColor: #f5f5f9; paddingBottom: 37px">
            <section class="container main-title"></section>

            <main class="container consulting-main">
                <div class="consulting-main-body">
                    <div class="consulting-main-body-title" v-if="user">From "{{ user.user.email }}" 
                        <!-- <span>Edit</span> -->
                    </div>
                    <!-- 目标 -->
                    <div class="consulting-main-body-content" v-if="this.$route.query.contactCompany == 'false'">
                        <div class="consulting-main-body-content-label">To</div>
                        <div class="consulting-main-body-content-goods">
                            <span class="consulting-main-body-content-goods-title">{{ Company_Detail.basic_info.company_name }}</span>
                            <div>
                                <!-- <v-img width="61" height="50" imgSrc=""></v-img> -->
                                <img :src="$route.query.url" style="width: 87px; height: 87px;" alt="">
                            </div>
                        </div>
                    </div>
                    <!-- 主题 -->
                    <div class="consulting-main-body-content" style="marginTop: 24px;marginBottom: 32px;">
                        <div class="consulting-main-body-content-label" style="marginTop: 12px;">Subject</div>
                        <!-- <div class="consulting-main-body-content-subject">{{ fromItem.subject}}</div> -->
                        <Input class="consulting-main-body-content-subject" type="text" v-model="fromItem.subject"></Input>

                    </div>
                    <!-- 采购 -->
                    <div class="consulting-main-body-content">
                        <div class="consulting-main-body-content-label" style="lineHeight: 34px;">Purchase Quantity</div>
                        <div class="consulting-main-body-content-purchase">
                            <InputNumber size="small" :step="100" class="consulting-main-body-content-purchase-input" :max="9999999999" :min="1" v-model="fromItem.quantity"></InputNumber>
                            <!-- <Select style="width:183px;" v-model="fromItem.unit" @on-change="onUnit" value="Pieces" size="small"> -->
                            <Select style="width:183px;" v-model="fromItem.unit" value="Pieces" size="small">
                                <Option v-for="item in cityList" :value="item.value" :key="item.value">{{ item.label }}</Option>
                            </Select>
                            <!-- <Input size="small" type="" style="marginLeft: 8px;" v-show="is_select" v-model="fromItem.unit"></Input> -->
                            <!-- <input  type="text" "> -->
                        </div>
                    </div>
                    <!-- 额外了解 -->
                    <div class="consulting-main-body-content" style="marginTop: 22px;marginBottom: 29px;">
                        <div class="consulting-main-body-content-label">Extra Request</div>
                        <div class="consulting-main-body-content-extra">
                            <CheckboxGroup v-model="fromItem.social">
                                <Checkbox label="Price" style="marginRight: 35px; fontSize: 16px;">
                                    <span>Price</span>
                                </Checkbox>
                                <Checkbox label="Product" style="marginRight: 35px; fontSize: 16px;">
                                    <span>Product Spectfications</span>
                                </Checkbox>
                                <Checkbox label="Proile" style="fontSize: 16px;">
                                    <span>Company Proile</span>
                                </Checkbox>
                            </CheckboxGroup>
                        </div>
                    </div>
                    <!-- 内容 -->
                    <div class="consulting-main-body-content">
                        <div class="consulting-main-body-content-label">Content</div>
                        <!-- <textarea class="consulting-main-body-content-content" name="" id="" cols="30" rows="10" v-model="fromItem.content"></textarea> -->
                        <Input
                            class="consulting-main-body-content-content"
                            type="textarea"
                            :autosize="{ minRows: 5, maxRows: 5 }"
                            v-model="fromItem.content"
                        />
                        <div class="consulting-main-body-content-prompt">please enter the content for your inquiry</div>
                    </div>
                    <!-- 上传文件 -->
                    <div class="consulting-main-body-content" style="marginTop: 34px;">
                        <div class="consulting-main-body-content-label"></div>
                        <div class="consulting-main-body-content-upload">
                            <Upload
                                multiple
                                action="//jsonplaceholder.typicode.com/posts/"
                                :before-upload="onbeforeUpload"
                                style="width:85px">
                                <label class="label" style="color: #f0883a;">Attach Files</label>
                            </Upload> 
                            <span>
                                <!-- 文件类型 -->
                                &nbsp;- Supports jpg, jpeg, png, gif, pdf, doc, docx, xls, xlsx, txt, rar and zip
                                <br>
                                &nbsp;- Max upload 3 files;Max. total size: 3MB
                            </span>
                        </div>
                    </div>
                    <div class="consulting-main-body-content" style="flex-direction: column">
                        <div class="consulting-main-body-content-label"></div>
                        <div class="consulting-main-body-content-fileName" v-show="fromItem.files" v-for="(file, index) in fromItem.files" :key="index">
                            <v-img width="13" height="13" :imgSrc="require('@/assets/img/fj.png')"></v-img>
                            <!-- <span>{{ fromItem.files.name }}</span> -->
                            <span class="consulting-main-body-content-fileName-span">{{ file.name }}</span>
                            <span @click="onDelete(index)">
                                <v-img width="16" style="cursor: pointer" height="16" :imgSrc="require('@/assets/img/qx.png')" ></v-img>
                            </span>
                        </div>
                    </div>
                    <button class="consulting-main-body-content-btn" @click="onSend">Send Inquiry</button>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
    import Img from '@/components/Img'
    import { mapState, mapMutations } from "vuex"
    import Breadcrumb  from '@/components/Breadcrumb'
    import Cookies from "@/utils/auth"

    export default {
        computed: {
            ...mapState([ 'Company_Detail' ])
        },
        data() {
            return {
                cityList: [
                    {
                        value: 'Pieces',
                        label: 'Pieces'
                    },
                    {
                        value: 'Bags',
                        label: 'Bags'
                    },
                    {
                        value: 'Boxes',
                        label: 'Boxes'
                    },
                    {
                        value: 'Foot',
                        label: 'Foot'
                    },
                    {
                        value: 'Meter',
                        label: 'Meter'
                    },
                    {
                        value: 'Kg',
                        label: 'Kg'
                    },
                    {
                        value: 'Ton',
                        label: 'Ton'
                    },
                    {
                        value: '㎡',
                        label: '㎡'
                    },
                    {
                        value: 'm³',
                        label: 'm³'
                    },
                    {
                        value: 'Other',
                        label: 'Other'
                    },
                ],
                is_select: false,
                fromItem: {
                    files: [],
                    unit: 'Pieces',
                    quantity: 0,
                    subject: 'Inquiry about”Beidou GPS dual mode  vehicle navigation ”',
                    content: '',
                    social: []
                },
                user: null
            }
        },
        methods: {
            getSessionStorage: Cookies.getSessionStorage,
            onRouter() {
                this.$router.push("/goods/success")
            },
            onbeforeUpload(files) {
                let type = (files.name.split('.'))[1]
                type = type.toLowerCase()

                if(files.size > 1048576 * 3 || !(['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'rar', 'and', 'zip'].includes(type))) { // 图片大于3M
                    this.$Message.warning('- Supports jpg, jpeg, png, gif, pdf, doc, docx, xls, xlsx, txt, rar and zip \n- Max upload 3 files;Max. total size: 3MB')
                }else {
                    if(this.fromItem.files.length < 3) {
                        this.fromItem.files.push(files)
                    }else {
                        this.$Message.warning('- Max upload 3 files;Max. total size: 3MB')
                    }
                }
                return false
            },
            onDelete(index) {
                this.$delete(this.fromItem.files, index)
            },
            // 发送
            onSend() {
                if(this.fromItem.quantity.length <= 0) {
                   
                    this.$Message.warning('Please fill out the purchase quantity')
                    return false
                }

                if(this.fromItem.content.length <= 0) {
                    this.$Message.warning('Please fill out the content')
                    return false
                }
                let data = new FormData()

                data.append('to_af_id', this.$route.query.af_id) //必填  发送给用户的唯一识别id
                for(let i = 0; i < this.fromItem.files.length; i++) { // 发送多个文件
                    data.append('attachment_list[]', this.fromItem.files[i])
                }
                data.append('subject', this.fromItem.subject) //必填 询盘的主题 
                data.append('purchase_quantity', this.fromItem.quantity) //必填 需要的数量
                data.append('purchase_unit', this.fromItem.unit)  //必填 需要的数量的单位
                data.append('content', this.fromItem.content) //必填 发送的主体内容
                data.append('product_id', this.$route.query.product_id ? this.$route.query.product_id : '')

                if(this.fromItem.social.length > 0) {
                    let extra_request = {}
                    for(let i = 0; i < this.fromItem.social.length; i++) {
                        extra_request[this.fromItem.social[i]] = true
                    }
                    data.append('extra_request[]', JSON.stringify(extra_request)) //非必填 额外要求 值要求:json字符串对象
                }

                this.$Spin.show()
                this.$request({
                    url: '/message/create_message',
                    method: 'post',
                    data,
                    headers:{'Content-Type': 'multipart/form-data'}
                }).then(({ code, message }) => {
                    if(code == 200) {
                        this.$router.push('/goods/success')
                    }else {
                        this.$Message.error(message)
                    }
                    this.$Spin.hide()
                }).catch(err => {
                    this.$Spin.hide()
                })

                return true
            }
        },
        created() {
            this.$set(this.fromItem, 'subject', this.$route.query.name)
            this.user = this.getSessionStorage()
                console.log(this.$route.query.a)

        },
        components: {
            "v-img": Img,
            // "v-Breadcrumb": Breadcrumb 
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index');

    .login {
        .bg-color(white);
        &-head {
            .flex(flex-start, center);
            height: 88px;
            margin-left: 18.2%;
            & > img {
                .width(181px, 53px);
            }
        }
    }

    // 头部
    .main-title {
        .lineHeight(45px);
    }

    .consulting-main {
        // .width(1220px, 762px);
        .width(1220px, auto);
        .bg-color(white);
        padding: 46px 0px;

        &-body {
            .width(611px, auto);
            margin: 0px auto;

            &-title {
                .color(blackDark);
                font-size: 16px;
                line-height: 21px;
                letter-spacing: 0px;
                padding-left: 99px;
                margin-bottom: 24px;

                & > span {
                    text-decoration: underline;
                    line-height: 21px;
                    .color(Orange);
                }
            }

            &-content {
                .flex(flex-start, flex-start);
                position: relative;

                &-label {
                    .width(134px, 15px);
                    .color(blackDark);
                    font-size: 16px;
                    line-height: 21px;
                    margin-right: 10px;
                    text-align: right;
                }

                &-goods {
                    .width(449px, 144px);
                    .bg-color(light);
                    padding: 15px 19px;

                    &-title {
                        .color(blackLight);
                        width: 449px - 19px * 2;
                        font-size: 16px;
                        line-height: 1;
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
                    .color(blackLight);
                    // .bg-color(light);
                    font-size: 16px;
                    line-height: 47px;
                    // padding: 0px 14px;
                    text-align: left;
                }

                &-purchase {
                    .flex(space-between, center);
                    .width(449px, 34px);
                    
                    &-input {
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
                    .width(449px, auto);
                    resize: none;
                }
                
                &-prompt {
                    .color(red);
                    position: absolute;
                    bottom: -16px;
                    left: 144px;
                    height: 13px;
                    font-size: 13px;
                }

                &-upload {
                    .flex();
                    .color(gray);
                    font-size: 12px;
                    letter-spacing: 0px;
                    & .label {
                        .color(blackDark);
                        font-size: 16px;
                        cursor: pointer;
                        line-height: 1;
                    }
                    & .label:hover {
                        .color(Orange);
                    }
                }

                &-fileName {
                    .flex(flex-start, center);
                    width: 449px;
                    height: 16px;
                    margin-left: 144px;
                    margin-top: 20px;

                    &-span {
                        width: 449px;
                        display: block;
                        .textHidden();
                    }

                    & > span:nth-child(2) {
                        margin-left: 9px;
                        margin-right: 4px;
                    }
                }

                &-btn {
                    .width(133px, 39px);
                    .color(white);
                    .bg-color(Orange);
                    border: none;
                    font-size: 18px;
                    display: block;
                    margin: 0px auto;
                    margin-top: 45px;
                }
            }
        }
    }
    
</style>
