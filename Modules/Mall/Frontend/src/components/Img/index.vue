<template>
    <div :style="{width: width + 'px', height: height + 'px'}" class="imgBox">
        <img v-lazy="filterImgs" lazy="loading"/>
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
        },
        data() {
            return {
                imgObj: {
                    src: '',
                    loading: require('@/assets/img/loading.gif')
                },
            }
        },
        computed: {
            filterImgs() { // 过滤
                this.$set(this.imgObj, 'src', this.imgSrc)
                return this.imgObj
            }
        },
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

    img[lazy=loading] {
        width: 20px;
        height: 20px;
    }
</style>
