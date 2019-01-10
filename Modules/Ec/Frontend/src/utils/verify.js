// 自定义验证
const myRules = {
    LoginUserId: {
        test: function (val) { // 自定义正则
            if (val.length > 6) {
                return false
            }
            return true;
        },
        message: 'Please enter your Email Address or Member ID.',
        minLength: 2
    },
    LoginPassword: {
        test: function (val) { // 自定义正则
            if (val.length > 6) {
                return false
            }
            return true;
        },
        message: 'Please enter your Email Address or Member ID.',
        minLength: 2
    }
}

export default myRules
