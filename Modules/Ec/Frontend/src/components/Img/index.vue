<template>
    <div :style="{width: width + 'px', height: height + 'px'}">
        <img :src="imgSrc" alt="" class="img">
    </div>
</template>

<script>
    export default {
        props: {
            width: '',
            height: '',
            imgSrc: {
                type: String,
                required: true
            }
        }
    }
</script>

<style lang="less" scoped>
    .img {
        display: block;
        width: 100%;
        height: 100%;
    }
</style>
