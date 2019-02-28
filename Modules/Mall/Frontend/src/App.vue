<template>
    <div id="app">
        <router-view/>
    </div>
</template>

<script>
import getData from '@/utils/getData'
import { mapMutations, mapState  } from 'vuex'

export default {
    computed: {
        ...mapState(['Oss_Url_Config', 'User_Info'])
    },
    methods: {
        ...mapMutations([ 'SET_OSS_URL_CONFIG', 'SET_USER_INFO' ]),
        onGetUser: getData.onGetUser,
        onGetSysConfig: getData.onGetSysConfig,
        onGetConfig() {
            if(this.Oss_Url_Config == "") {
                this.onGetSysConfig().then(res => this.SET_OSS_URL_CONFIG(res))
            }

            if(this.User_Info == "") {
                this.onGetUser().then(res => this.SET_USER_INFO(res))
            }
        },
    },
    mounted() {
        this.onGetConfig()
    }
};
</script>

<style lang="less">
    * {
        letter-spacing: 0px;
        padding: 0px;
        margin: 0px;
        font-family: Arial;
    }
</style>