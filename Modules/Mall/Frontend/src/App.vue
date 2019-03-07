<template>
    <div id="app">
        <router-view/>
    </div>
</template>

<script>
import getData from '@/utils/getData'
import { mapMutations, mapState  } from 'vuex'
import auth from "@/utils/auth"

export default {
    data() {
        return {
            user: null
        }
    },
    computed: {
        ...mapState([ 'Oss_Url_Config' ])
    },
    methods: {
        ...mapMutations([ 'SET_OSS_URL_CONFIG' ]),
        onGetUser: getData.onGetUser,
        onGetSysConfig: getData.onGetSysConfig,
        getSessionStorage: auth.getSessionStorage,
        setSessionStorage: auth.setSessionStorage,
        removeSessionStorage: auth.removeSessionStorage,

        onGetConfig() {
            if(this.Oss_Url_Config == "") {
                this.onGetSysConfig().then(res => this.SET_OSS_URL_CONFIG(res))
            }
        },
    },
    mounted() {
        const TokenKey = auth.getCookies()

        if(TokenKey) {
            this.onGetConfig()
        }
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