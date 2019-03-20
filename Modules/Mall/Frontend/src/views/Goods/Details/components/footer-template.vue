<template>
    <div class="main-footer">
        <h1 class="main-footer-title">Product Description</h1>
        <div class="ql-editor main-footer-content" v-html="product_details"></div>
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
