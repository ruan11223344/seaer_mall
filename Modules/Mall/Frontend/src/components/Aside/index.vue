<template>
    <div class="aside">
        <nav class="aside-item">
            <router-link
                to="/inquiryList/personalpenter"
                tag="div"
                class="aside-item-list"
                >
                <img
                    @mouseenter="imgItem1.state = imgItem1.active"
                    @mouseleave="imgItem1.state = imgItem1.default"
                    :src="imgItem1.state" alt="">
            </router-link>

            <div class="aside-item-list-hr"></div>

            <router-link
                to="/inquiryList/inbox"
                tag="div"
                class="aside-item-list"
                >
                <img
                    @mouseenter="imgItem2.state = imgItem2.active"
                    @mouseleave="imgItem2.state = imgItem2.default"
                    :src="imgItem2.state" alt="">
            </router-link>

            <div class="aside-item-list-hr"></div>

            <router-link
                tag="div"
                to="/inquiryList/collection"
                class="aside-item-list"
                >
                <img
                    @mouseenter="imgItem3.state = imgItem3.active"
                    @mouseleave="imgItem3.state = imgItem3.default"
                    :src="imgItem3.state" alt="">
            </router-link>
            <div class="aside-item-list-hr"></div>

            <div
                class="aside-item-list"
                @click="onClcik"
                >
                <img
                    @mouseleave="imgItem4.state = imgItem4.default"
                    @mouseenter="imgItem4.state = imgItem4.active"
                    :src="imgItem4.state" alt="">
            </div>
        </nav>

        <div class="aside-affix" @click="modal=true"></div>
        <Modal
            v-model="modal"
            width="800"
            :mask-closable="true"
            @on-ok="asyncOK">
                <div class="111" slot="header">
                    Need Help ?
                </div>
                <Form ref="formInline" :model="formData" :rules="ruleInline" label-position="top">
                    <FormItem prop="content">
                        <Input v-model="formData.content" type="textarea" :autosize="{minRows: 10,maxRows: 10}" placeholder="Such as: I want to find the parts of the car (within 500 words)" />
                    </FormItem>
                    <FormItem prop="email">
                        <Input v-model="formData.email" placeholder="Please enter your contact information (email, phone)" />
                    </FormItem>
                </Form>
        </Modal>
    </div>
</template>

<script>
    import upData from "@/utils/upData"
    import auth from "@/utils/auth"

    export default {
        data() {
            return {
                imgItem1 : {
                    default: require('@/assets/img/home/grzx.png'),
                    active: require('@/assets/img/home/grzx-active.png'),
                    state: require('@/assets/img/home/grzx.png')
                },
                imgItem2 : {
                    default: require('@/assets/img/home/youj.png'),
                    active: require('@/assets/img/home/youj-active.png'),
                    state: require('@/assets/img/home/youj.png')
                },
                imgItem3 : {
                    default: require('@/assets/img/home/sc.png'),
                    active: require('@/assets/img/home/sc-active.png'),
                    state: require('@/assets/img/home/sc.png')
                },
                imgItem4 : {
                    default: require('@/assets/img/home/top.png'),
                    active: require('@/assets/img/home/top-active.png'),
                    state: require('@/assets/img/home/top.png')
                },
                modal: false,
                formData: {
                    email: null,
                    content: null
                },
                ruleInline:{},
                user: null
            }
        },
        methods: {
            getSessionStorage: auth.getSessionStorage,
            onClcik() {
                let oTop = document.body.scrollTop || document.documentElement.scrollTop

                const clear = setInterval(() => {
                    oTop = oTop - 100
                    
                    oTop = oTop > 0 ? oTop : 0

                    window.scrollTo(0, oTop)
                    
                    if(oTop <= 0) {
                        clearInterval(clear)
                    } 
                }, 20)
            },
            UpSendFeedback: upData.UpSendFeedback,
            asyncOK() {
                this.UpSendFeedback({
                    "message": this.formData.email, //必填
                    "contact_way": this.formData.content, //必填
                    "user_id": this.user ? this.user.user.id : '' //非必填 但是用户登录时传入~ 
                }).then(res => {
                    this.formData = {
                        email: null,
                        content: null
                    }
                    this.modal = false
                }).catch(err => {
                    this.formData = {
                        email: null,
                        content: null
                    }
                    this.modal = false
                })
            }
        },
        created() {
            this.user = this.getSessionStorage()
        },
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');

    .aside {
        .width(50px, 100%);
        .bg-color(white);
        position: fixed;
        top: 0px;
        right: 0px;
	    border: solid 1px #eeeeee;
        display: block;
        z-index: 10000;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);

        &-item {
            .flex(center, center, column);
            height: 100%;

            &-list {
                .flex(center, center);
                .width(100%, 64px);
                cursor: pointer;

                img {
                    .width(33px, 33px);
                    display: block;
                }
            }

            &-list:hover {
                .bg-color(whiteLight);
            }

            &-list-hr {
                .width(12px, 1px);
                background-color: #e3e3e3;
            }
        }

        &-affix {
            position: absolute;
            right: 60px;
            bottom: 20px;
            width: 72px;
            height: 110px;
            background-image: url('../../assets/img/home/kf.png');
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }
    }
</style>
