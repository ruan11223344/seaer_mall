<template>
    <div class="main">
        <div class="container">
            <footer>
                <div>
                    <span>Home</span>
                    <span>|</span>
                    <span>Marketplace</span>
                </div>
                <div>Copyright © 2018-2019  Afriby.com  All Rights Reserved.</div>
            </footer>
        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {

            }
        }
    }
</script>

<style lang="less" scoped>
    @import url("../../assets/css/index.less");

    .main {
        .bg-color(whiteLight);
        min-width: 1220px;
        height: 71px;
    }
    footer {
        height: 71px;
        .flex(center, center, column);
        
        & > div:first-child {
            .color(blackDark);

            & > span {
                cursor: pointer;
            }
        }

        & > div:first-child > span:nth-child(2) {
            padding: 0px 20px 0px 16px;
            position: relative;
            top: -3px;
        }

        & > div:last-child {
            .color(blackLight);
            cursor: pointer;
        }
    }
</style>
