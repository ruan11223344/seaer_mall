<template>
    <div :style="{width: width + 'px', height: height + 'px'}" class="imgBox" v-loading="imgSrc == ''">
        <img :src="imgSrc" class="img" />
    </div>
</template>

<script>
    export default {
        props: {
            width: '',
            height: '',
            imgSrc: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
            }
        },
        computed: {
            
        }
    }
</script>

<style lang="less" scoped>

    .imgBox {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .img {
        display: block;
        width: 100%;
        height: 100%;
    }
</style>
