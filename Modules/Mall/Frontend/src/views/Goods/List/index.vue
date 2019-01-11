<template>
    <div>
        <main class="main">
            <section class="container main-title">
                <Breadcrumb separator='<b style="color:#666666">></b>'>
                    <BreadcrumbItem to="/">Home</BreadcrumbItem>
                    <BreadcrumbItem style="color:#666666">{{ $route.query.name }}</BreadcrumbItem>
                </Breadcrumb>
            </section>
            <section class="container main-content">
                <!-- 渲染商品列表mock -->
                <v-card class="main-content-list" :title="title" :price="price" :img-src="imgSrc" v-for="({title, price, imgSrc}, index) in record" :key="index"></v-card>
            </section>
            <!-- 分页 -->
            <section class="container main-page">
                <template>
                    <Page :total="1000" :page-size="20" next-text="Next"  prev-text="Up" show-elevator />
                    <div class="main-page-pg">page</div>
                    <div class="main-page-bt">Go</div>
                </template>
            </section>
        </main>
    </div>
</template>

<script>
    import Card from "@/components/Card"

    export default {
        data() {
            return {
                // 商品列表mock
                record: [
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "1.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "2.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "3.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "4.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "5.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "6.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "7.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "8.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "9.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "10.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "11.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "12.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "13.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "14.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "15.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    }
                ]
            }
        },
        mounted() {
            
        },
        components: {
            'v-card': Card,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .main {
        .bg-color(light);
            
        // 头部
        &-title {
            height: 45px;
            line-height: 45px;
        }

        // 商品列表
        &-content {
            .flex(flex-start, center, row);
            flex-wrap: wrap;

            // 商品
            &-list:first-child {
                margin-left: 0px;
            }
            &-list:nth-child(6n) {
                margin-left: 0px;
            }
            &-list {
                margin-left: 20px;
                margin-bottom: 20px;
                cursor: pointer;
            }
        }

        &-page {
            height: 48px + 26px + 34px;
            padding-top: 26px;
            .flex(center);

            &-pg {
                .lineHeight(32px);
                .color(gray);
                position: relative;
                left: 3px;
            }

            &-bt {
                .lineHeight(32px);
                .bg-color(orange2);
                .color(white);
                width: 45px;
                margin-left: 19px;
                text-align: center;
                cursor: pointer;
            }
        }

    }
</style>