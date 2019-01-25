<template>
    <div class="updateInfo">
        <v-head :imgSrc="require('@/assets/img/login/bg2.png')"></v-head>
        <v-title title="Selected Subcatalog: "  class="updateInfo-title">
            <template slot="content">
                <span class="updateInfo-title-text">Garlic</span>
                <button type="button" class="updateInfo-title-btn">Reselect</button>
            </template>
        </v-title>

        <section class="Send-main-screening" style="marginBottom: 20px;">
            <div class="Send-main-screening-text">Basic Info</div>
        </section>

      
    </div>
</template>

<script>
    import Title from "../components/Title"
    import Img from "@/components/Img"
    import Head from "../components/Head"
    // import Select from "@/components/Select"
    // // 图片预览插件
    // import LightBox from 'vue-image-lightbox'
    // import 'vue-image-lightbox/dist/vue-image-lightbox.min.css'
    
    // // 公共方法
    // import getData from '@/utils/getData'
    
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
            // "v-select": Select,
            "v-head": Head,
            // LightBox
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .updateInfo {
        width: 945px;
        height: 2246px;
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

</style>
