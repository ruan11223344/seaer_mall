<template>
    <div>
        <!-- 头部导航 -->
        <header class="header">
            <v-nav></v-nav>
        </header>

        <main class="main">
            <!-- 搜索 -->
            <section class="container main-search">
                <v-search></v-search>
            </section>
        </main>
        
        <section class="Notice-block">
            <div class="Notice-block-box" v-loading="content == null">
                <template v-if="content != null">
                    <div class="Notice-block-box-title">{{ content.article_title }}</div>
                    <time class="Notice-block-box-time">{{ content.publish_time }}</time>
                    <div class="ql-editor Notice-block-box-content" v-html="content.content"></div>
                </template>
            </div>
        </section>
        
        <v-footer-nav></v-footer-nav>
        <v-footer></v-footer>

        <!-- 右侧栏 -->
        <section>
            <v-aside></v-aside>
        </section>
    </div>
</template>

<script>
    import Header from "@/components/Header"
    import FooterNav from "@/components/Footer-nav"
    import Footer from "@/components/Footer"
    import Search from "@/components/Search"
    import getData from "@/utils/getData"
    import 'quill/dist/quill.bubble.css'
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import Aside from "@/components/Aside"

    export default {
        data() {
            return {
                content: null
            }
        },
        methods: {
            onGetArticleDetail: getData.onGetArticleDetail,
            onGetUserAgreement: getData.onGetUserAgreement,
            onGetTitleArticle: getData.onGetTitleArticle,
            GetData() {
                this.content = null
                switch (this.$route.query.key) {
                    case 'Notice':
                        this.onGetArticleDetail(this.$route.query.article_id).then(res => {
                            this.content = res
                        }).catch(err => {
                            this.content = ''
                            this.$Message.error(err.message)
                        })
                        break
                    case 'buyers':
                        this.onGetUserAgreement('buyers').then(res => {
                            this.content = res
                        }).catch(err => {
                            this.content = ''
                            this.$Message.error(err.message)
                        })
                        break
                    case 'merchants':
                        this.onGetUserAgreement('merchants').then(res => {
                            this.content = res
                        }).catch(err => {
                            this.content = ''
                            this.$Message.error(err.message)
                        })
                        break
                    default:
                        this.onGetTitleArticle(this.$route.query.key).then(res => {
                            this.content = res
                        }).catch(err => {
                            this.content = ''
                            this.$Message.error(err.message)
                        })
                        break
                }
            }
        },
        created() {
            this.GetData()
        },
        watch: {
            '$route': function () {
                this.GetData()
            }
        },
        components: {
            'v-nav': Header,
            'v-search': Search,
            'v-footer-nav': FooterNav,
            'v-footer': Footer,
            'v-aside': Aside
        }
    }
</script>

<style lang="less">
    @import url('../../assets/css/index.less');

    .header {
        background-color: #000;
    }
    .main {
        background-color: #ffffff;
    }
    .Notice-block {
        width: 100%;
        margin: 0px auto;
        padding: 20px 0px;
        background-color: #f5f5f9;

        &-box {
            width: 1220px;
            min-height: 100px;
            height: auto;
            background-color: #ffffff;
            margin: 0px auto;
            padding: 50px 25px;
            line-height: 2;

            &-title {
                font-size: 20px;
                color: #666666;
                text-align: center;
            }

            &-time {
                text-align: center;
                display: block;
            }

            &-content {
                padding: 0px;

                & > p > img {
                    width: 1170px !important;
                    max-width: 1170px !important;
                    height: auto;
                    display: block;
                }

                * {
                    word-wrap: break-word;
                }
            }
        }
    }

 
</style>