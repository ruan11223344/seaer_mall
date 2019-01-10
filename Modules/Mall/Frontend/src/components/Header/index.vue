<template>
    <div class="container">
        <nav class="nav">
            <div>Sign In</div>
            <div>Join Free</div>
            <div class="Customer">
                <!-- 下拉 -->
                <div>
                    <span>Customer Service</span>
                    <Icon type="ios-arrow-down" style="marginLeft:2px;"/>
                </div>
                <ul>
                    <li>Help Center</li>
                    <li>Service</li>
                </ul>
            </div>
            <div>Inquiry</div>
        </nav>
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style lang="less" scoped>
    @import url("../../assets/css/index.less");
    
    .nav {
        .flex(flex-end, center);
        .lineHeight(40px);
        .color(white);
        
        & > div {
            height: 40px;
            margin-left: 25px;
            cursor: pointer;
        }

        & > .Customer {
            position: relative;

            & > ul:last-child {
                .bg-color(white);
                .width(143px, 0px);
                position: absolute;
                top: 35px;
                z-index: 10000;
                overflow: hidden;
                transition: all .2s;
                
                & > li {
                    .color(blackLight);
                    height: 30px;
                    padding-left: 15px;
                    font-size: 14px;
                    line-height: 30px;
                }

                & > li:hover {
                    .color(white);
                    .bg-color(Orange);
                }
            }

            & > div:first-child:hover + ul:last-child {
                height: 80px;
                border: solid 1px #dddddd;
                padding: 10px 0px;
            }

            ul:last-child:hover {
                height: 80px;
                border: solid 1px #dddddd;
                padding: 10px 0px;
            }
        }
    }
</style>
