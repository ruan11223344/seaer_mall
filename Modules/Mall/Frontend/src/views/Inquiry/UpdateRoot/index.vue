<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
    import Cookies from "@/utils/auth"

    export default {
        methods: {
            getSessionStorage: Cookies.getSessionStorage
        },
        beforeRouteEnter : (to, from, next) => {
            next(vm => {
                if(to.path == "/inquiryList/uploadroot/tips") {
                    return true
                }else {
                    const user = vm.getSessionStorage()
                    const bool = user.publish_product.status
                    if(bool == true) {
                        return true
                    }else {
                        return vm.$router.push('/inquiryList/uploadroot/tips')
                    }
                }
            })
        }
    }
</script>

<style lang="less" scoped>

</style>
