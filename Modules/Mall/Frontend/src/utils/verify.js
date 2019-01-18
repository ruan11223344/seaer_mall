// 自定义验证
const myRules = {
    LoginUserId: {
        test(value) {
            const Rex = /^[\da-zA-Z]{6,20}$ || ^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/gi
            let bool = Rex.test(value)
            if(!bool) {
                return false
            }else {
                return true
            }
        },
        message: 'Please enter your Email Address or Member ID.',
        minLength: 6
    },
    LoginPassword: {
        test: function (value) { // 自定义正则
            const Rex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/g
            let bool = Rex.test(value)

            if(!bool){
                return false
            }else {
                return true
            }
        },
        message: 'Please fill in the correct password',
        minLength: 6
    }
}

export default myRules
