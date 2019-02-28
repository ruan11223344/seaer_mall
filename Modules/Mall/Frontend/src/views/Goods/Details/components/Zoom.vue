<template>
    <div class="box">
        <!-- 放大镜功能 -->
        <img-magnifier
            :smallSrc="imgSrc"
            :magnifierSrc="imgSrc"
            :maskStyle="maskStyle"
            :maskTransEnter="maskTransEnter"
            :maskTransLeave="maskTransLeave"
            :configs="configs"
            >
        </img-magnifier>
    </div>
</template>

<script>
    export default {
        props: [ 'imgSrc' ],
        data() {
            return {
                // smallImgSrc: require('@/assets/img/details/demo.jpg'), // 小图片地址
                // magnifierSrc: require('@/assets/img/details/demo.jpg'), // 放大镜图片地址
                // 设置遮罩样式
                // 这里可以根据需要设置，但至少宽高是需要设置的
                maskStyle: {
                    width: '150px',
                    height: '150px',
                    background: '#000000',
                    opacity: 0.4,
                    // 如果有多个过渡效果，可以设置 transition: 'opacity 2s,background 2s' ，请勿设置为：transition: 'all .8s' ，这将会影响组件的实现。
                    transition: 'opacity 1s'
                },
                // 设置遮罩进入的过渡效果，选填，要实现动画效果请在 maskStyle 中设置 transition
                // 注意此处是在js中设置样式，如果使用了CSS3的属性，请自行按需添加私有前缀
                maskTransEnter: {
                    opacity: 0
                // 这里仅为举例如何添加私有前缀，请勿真的使用transform为过渡，否则会影响组件的功能
                // webkitTransform:translate3d(0,0,0)`,
                // transform:translate3d(0,0,0)`
                },
                // 设置遮罩离开的过渡效果，选填，要实现动画效果请在 maskStyle 中设置 transition
                // 同样请自行按需添加私有前缀
                maskTransLeave: {
                    opacity: 0
                },
                configs: {
                    // 小图片的宽高
                    smallImgWidth: 348,
                    smallImgHeight: 348,
                    // 放大镜图片的宽高，注意是这里是图片的尺寸而不是
                    magnifierWidth: 1044,
                    magnifierHeight: 1044,
                    magnifierPosWay: 'absolute',
                    magnifierPosLeft: '350px',
                    magnifierPosTop: 0,
                }
            };
        },
        methods: {
        },
        mounted() {
        },
        components: {
        }
    }
</script>

<style lang="less" scoped>
    .box {
        position: relative;
        width: 100%;
        height: 100%;
        cursor: move;
        z-index: 10000;
    }
</style>
