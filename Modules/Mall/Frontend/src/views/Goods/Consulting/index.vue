<template>
    <div style="backgroundColor: #f5f5f9; paddingBottom: 37px">
        <section class="container main-title">
            <!-- <Breadcrumb separator='<b style="color:#666666">></b>'>
                <BreadcrumbItem to="/">Home</BreadcrumbItem>
                <BreadcrumbItem style="color:#666666">{{ 'consulting' }}</BreadcrumbItem>
            </Breadcrumb> -->
            <v-Breadcrumb title="Supplier Homepage" :url="`/company/home?&company_id=${$route.query.company_id}`" :Breadcrumbs="[ 'consulting' ]"></v-Breadcrumb>
        </section>

        <main class="container consulting-main">
            <div class="consulting-main-body">
                <div class="consulting-main-body-title">From "{{ User_Info.user.email }}" <span>Edit</span></div>
                <!-- 目标 -->
                <div class="consulting-main-body-content">
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
                    <div class="consulting-main-body-content-subject">{{ $route.query.name}}</div>
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
                            <label class="label">Attach Files</label>
                        </Upload> 
                        <span>
                            <!-- 文件类型 -->
                            &nbsp;- Supports jpg, jpeg, png, gif, pdf, doc, docx, xls, xlsx, txt, rar and zip
                            <br>
                            &nbsp;- Max upload 3 files;Max. total size: 3MB
                        </span>
                    </div>
                </div>
                <div class="consulting-main-body-content">
                    <div class="consulting-main-body-content-label"></div>
                    <div class="consulting-main-body-content-fileName" v-show="fromItem.files" v-for="(file, index) in fromItem.files" :key="index">
                        <v-img width="13" height="13" :imgSrc="require('@/assets/img/fj.png')"></v-img>
                        <!-- <span>{{ fromItem.files.name }}</span> -->
                        <span>{{ file.name }}</span>
                        <span @click="onDelete(index)">
                            <v-img width="16" style="cursor: pointer" height="16" :imgSrc="require('@/assets/img/qx.png')" ></v-img>
                        </span>
                    </div>
                </div>
                <button class="consulting-main-body-content-btn" @click="onSend">Send Inquiry</button>
            </div>
        </main>

    </div>
</template>

<script>
    import Img from '@/components/Img'
    import { mapState, mapMutations } from "vuex"
    import Breadcrumb  from '@/components/Breadcrumb'

    export default {
        computed: {
            ...mapState([ 'User_Info', 'Company_Detail' ])
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
                }
            }
        },
        methods: {
            onRouter() {
                this.$router.push("/goods/success")
            },
            onbeforeUpload(files) {
                let type = (files.name.split('.'))[1]
                type = type.toLowerCase()

                if(files.size > 1048576 * 3 || !(['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'rar', 'and', 'zip'].includes(type))) { // 图片大于3M
                    // this.$Notice.error({
                    //     desc: '- Supports jpg, jpeg, png, gif, pdf, doc, docx, xls, xlsx, txt, rar and zip \n- Max upload 3 files;Max. total size: 3MB'
                    // })
                    this.$Message.warning('- Supports jpg, jpeg, png, gif, pdf, doc, docx, xls, xlsx, txt, rar and zip \n- Max upload 3 files;Max. total size: 3MB')
                }else {
                    if(this.fromItem.files.length < 3) {
                        this.fromItem.files.push(files)
                    }else {
                        // this.$Notice.error({
                        //     desc: '- Max upload 3 files;Max. total size: 3MB'
                        // })
                        this.$Message.warning('- Max upload 3 files;Max. total size: 3MB')
                    }
                }
                return false
            },
            onDelete(index) {
                this.$delete(this.fromItem.files, index)
            },
            // onUnit(value) {
            //     if(value == 'Other') {
            //         this.$set(this.fromItem, 'unit', '')
            //         this.is_select = true
            //     }else {
            //         this.$set(this.fromItem, 'unit', value)
            //         this.is_select = false
            //     }
            // },
            // 发送
            onSend() {
                if(this.fromItem.quantity.length <= 0) {
                    // this.$Notice.error({
                    //     desc: ''
                    // });
                    this.$Message.warning('Please fill out the purchase quantity')
                    return false
                }

                if(this.fromItem.content.length <= 0) {
                    // this.$Notice.error({
                    //     desc: 'Please fill out the content'
                    // });
                    this.$Message.warning('Please fill out the content')
                    return false
                }
                let data = new FormData()

                data.append('to_af_id', this.$route.query.af_id) //必填  发送给用户的唯一识别id
                for(let i = 0; i < this.fromItem.files.length; i++) { // 发送多个文件
                    data.append('attachment_list[]', this.fromItem.files[i])
                }
                data.append('subject', this.$route.query.name) //必填 询盘的主题 
                data.append('purchase_quantity', this.fromItem.quantity) //必填 需要的数量
                data.append('purchase_unit', this.fromItem.unit)  //必填 需要的数量的单位
                data.append('content', this.fromItem.content) //必填 发送的主体内容

                if(this.fromItem.social.length > 0) {
                    let extra_request = {}
                    for(let i = 0; i < this.fromItem.social.length; i++) {
                        extra_request[this.fromItem.social[i]] = true
                    }
                    data.append('extra_request[]', JSON.stringify(extra_request)) //非必填 额外要求 值要求:json字符串对象
                }

                this.$request({
                    url: '/message/create_message',
                    method: 'post',
                    data,
                    headers:{'Content-Type': 'multipart/form-data'}
                }).then(({code}) => {
                    if(code == 200) {
                        this.$router.push('/goods/success')
                    }
                }).catch(err => {
                    // console.log(err);
                })

                return true
            }
        },
        components: {
            "v-img": Img,
            "v-Breadcrumb": Breadcrumb 
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index');

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
                    .bg-color(light);
                    font-size: 16px;
                    line-height: 47px;
                    padding: 0px 14px;
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
                    height: 16px;

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
