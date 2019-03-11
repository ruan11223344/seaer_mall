<template>
    <div class="main-footer">
        <h1 class="main-footer-title">Product Description</h1>
        <div class="ql-editor main-footer-content" v-html="product_details">

        </div>
        <!-- <div class="main-footer-table">
            <h1 class="main-footer-table-title">Specific Information</h1>
            <Table size="large" :columns="columns1" :data="data1" :show-header="false"></Table>
        </div>

        <div class="main-footer-box">
            <img src="" alt="">
        </div>
        <article class="main-footer-article">
            <h1>Seller’s Information</h1>
            <ol type="1" start="1">
                <li v-for="(item, index) in dataArticle" :key="index">
                    {{ (index + 1) + ('.' + item) }}
                </li>
            </ol>
        </article>
        <div>
            <img src="" alt="">
        </div> -->
    </div>
</template>

<script>
    import 'quill/dist/quill.bubble.css'
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'

    export default { 
        props: ['product_details'],
        data() {
            return {
                dataArticle: [
                    'Since 1998,with over 17 years exporting electronics &consumer electronic experience.',
                    'Expert in OEM&ODM order. Professional R&D department,provide one-stop service for customers from original design/idea to finished products.',
                    'Since 2002,we participate in Canton fair & HK global sources fair. ',
                    'Own design team,can help you custom your packaging.',
                    'Advanced production equipment &professional QC to esure 0% defective rate of the goods.  Every batch of goods are inspected strictly to make sure the goods our customer received are qualified.'
                ],
                columns1: [
                    {
                        title: 'Name',
                        key: 'name',
                        className: 'main-footer-table-name',
                        tooltip: true
                    },
                    {
                        title: 'Age',
                        key: 'age',
                        className: 'main-footer-table-value'
                    },
                    {
                        title: 'Address',
                        key: 'address',
                        className: 'main-footer-table-name'
                    },
                    {
                        title: 'date',
                        key: 'date',
                        className: 'main-footer-table-value'
                    },
                ],
                data1: [
                    {
                        name: 'VIN(vehicle Identification VIN(vehicle Identification ',
                        age: 18,
                        address: 'New York No. 1 Lake Park',
                        date: '2016-10-03'
                    },
                    {
                        name: 'Jim Green',
                        age: 24,
                        address: 'London No. 1 Lake Park',
                        date: '2016-10-01'
                    },
                    {
                        name: 'Joe Black',
                        age: 30,
                        address: 'Sydney No. 1 Lake Park',
                        date: '2016-10-02'
                    },
                    {
                        name: 'Jon Snow',
                        age: 26,
                        address: 'Ottawa No. 2 Lake Park',
                        date: '2016-10-04'
                    }
                ]
            }
        }
    }
</script>

<style lang="less">
    @import url('../../../../assets/css/index.less');

    .main-footer {
        width: 100%;

        &-title {
            .lineHeight(50px);
            width: 100%;
            padding-left: 20px;
            font-size: 16px;
            color: #333333;
            background-color: #f7f7fc;
            border-top: 2px solid #f0883a;
        }

        // &-box {
        //     .bg-color(whiteDark);
        //     width: 100%;
        //     height: 1186px;

        //     & > img {
        //         width: 100%;
        //         display: block;
        //     }
        // }

        // &-table {
        //     margin-top: 10px;
        //     margin-bottom: 20px;

        //     &-title {
        //         font-size: 16px;
        //         line-height: 3;
        //         color: #333333;
        //         padding-left: 20px;
        //     }

        //     .main-footer-table-name {
        //         width: 252px;
        //         height: 62px;
        //         background-color: #f5f5f8;
        //     }

        //     .main-footer-table-value {
        //         width: 358px;
        //         height: 62px;
        //         background-color: #ffffff;
        //     }
        // }

        // &-article {

        //     & > h1 {
        //         .color(blackDark);
        //         font-size: 18px;
        //         line-height: 37px;
        //         letter-spacing: 0px;
        //         margin-top: 10px;
        //         margin-bottom: 10px;
        //         font-weight: bold;
        //     }

        //     & > ol {
        //         & > li {
        //             .color(blackLight);
        //             width: 920px;
        //             font-size: 14px;
        //             line-height: 16px;
        //             letter-spacing: 0px;
        //             margin-bottom: 12px;
        //             word-wrap:break-word;
        //         }
        //     }
        // }

        // &-article + div {
        //     .bg-color(whiteDark);
        //     width: 100%;
        //     height: 607px;
        // }
        &-content {
            padding: 0px;
            img {
                width: 1220px;
                max-width: 1220px !important;
                height: auto;
                display: block;
            }

            * {
                word-wrap: break-word;
            }
        }
    }

    
</style>
