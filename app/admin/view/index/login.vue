<template>
    <div class="login-page">
        <div class="login-box">
                <el-carousel height="540px" class="carousel hidden-xs-only" autoplay="false">
                    <el-carousel-item v-for="item in 4" :key="item">
                        <el-image :key="item" style="width: 400px;height:540px;"
                            src="https://img1.baidu.com/it/u=1499001738,37769528&fm=253&fmt=auto&app=120&f=JPEG?w=889&h=500"
                            fit="fill"></el-image>
                    </el-carousel-item>
                </el-carousel>
          

                <el-form class="form" :model="formData" ref="form" :rules="rules" label-width="80px" :inline="false"
                    size="normal">
                    <el-avatar :size="68" :src="lastAdmin.avatar" class="st-m-b-20"
                        style="border: 1px solid var(--el-border-color);"></el-avatar>
                    <div class="welcome">{{ lastAdmin.nick_name }}，欢迎回来！</div>
                    <div class="desc">列表形式展示多个字段，列表形式展示多个字段展示多个字段展示多个字段展示多个字段</div>

                    <el-form-item :class="{ 'is-focus': accountFocus || formData.account }" class="st-m-t-30"
                        prop="account">
                        <el-input v-model="formData.account" class="w-50 m-2" size="large" @focus="accountFocus = true"
                            @blur="accountFocus = false" ref="account" clearable :disabled="loging"
                            prefix-icon="UserFilled">
                        </el-input>
                        <div class="embed-title" @click="$refs['account'].focus()">用户名/邮箱/手机号</div>
                    </el-form-item>

                    <el-form-item :class="{ 'is-focus': passwordFocus || formData.password }" class="st-m-t-25"
                        prop="password">
                        <el-input v-model="formData.password" class="w-50 m-2" type="password" size="large"
                            @focus="passwordFocus = true" @blur="passwordFocus = false" ref="password" show-password
                            clearable :disabled="loging" prefix-icon="Unlock">
                        </el-input>
                        <div class="embed-title" @click="$refs['password'].focus()">密码/登录码</div>
                    </el-form-item>

                    <div style="display: flex;justify-content: space-between;" class="st-m-b-30 st-m-t-6">
                        <el-checkbox v-model="rememberAdmin" label="记住我" size="small" :disabled="loging"></el-checkbox>
                        <el-link type="primary" class="forget">忘记密码？</el-link>
                    </div>
                    <div class="btn">
                        <el-button type="primary" size="large" @click="login" :loading="loging">{{ loging ? '正在登录' :
                                '登录'
                        }}
                        </el-button>
                    </div>
                    <div class="btn st-m-t-15">
                        <el-button size="large">
                            <saet-icon name="ri-wechat-fill" color="#07c160" :size="18"></saet-icon>
                            <span style="font-size:12px;">Sgin in with Wechat</span>
                        </el-button>
                    </div>
                </el-form>


        </div>
        <div class="copyright">
            ©2022 SaetAdmin by QianMoQingFeng, Inc.
        </div>
    </div>
</template>

<script>
const lastAdmin = St.cookie.get('lastAdmin')
new SaetApp(
    {
        data() {
            return {
                lastAdmin: lastAdmin ? JSON.parse(lastAdmin) : { avatar: '', nick_name: '' },
                rememberAdmin: false,
                accountFocus: false,
                passwordFocus: false,
                formData: {
                    account: '',
                    password: '',
                },
                rules: {
                    account: [
                        { required: true, message: '请输入用户名/邮箱/手机号', trigger: 'blur' },
                        { min: 4, max: 20, message: '长度应为 4 ～ 20', trigger: 'blur' },
                    ],
                    password: [
                        { required: true, message: '请输入密码/登录码', trigger: 'blur' },
                        { min: 8, max: 64, message: '长度应大于8位', trigger: ['blur', 'change'] },
                    ]
                },
                loging: false
            }
        },
        methods: {
            login() {
                this.$refs.form.validate((valid, fields) => {
                    if (valid) {
                        this.loging = true;
                        St.axios.post('index/login', this.formData, { successToast: true }).then((res) => {
                            this.loging = false;
                            setTimeout(() => {
                                window.location.href = ST.refererUrl;
                            }, 300);
                        }).catch((err) => {
                            this.loging = false;
                        });
                        //    提交登录api
                    } else {
                        St.message.error('请填写正确登录信息');
                    }
                })
            }
        },
    }
)
</script>
<style>
@media only screen and (max-width: 767px) {
    .login-box {
        margin: 0 !important;
        border-radius: 0 !important;
        flex: 1;
        box-shadow: none !important;
    }

    .login-box .form {
        width: auto !important;
        padding: 30px !important;
        margin-top: 50px;
    }

    body {
        background-color: var(--el-bg-color);
    }
}

.login-page {
    display: flex;
    justify-content: center;
    min-height: 100vh;
    flex-direction: column;
}

.login-box {
    background-color: var(--el-bg-color);
    height: 540px;
    margin: auto;
    border-radius: 8px;
    display: flex;
    flex-direction: row;
    overflow: hidden;
    box-shadow: var(--el-box-shadow);
}

.login-box .carousel {
    width: 400px;
    background-color: var(--el-color-primary);
}

.login-box .form {
    width: 360px;
    padding: 40px 70px 0 70px;
    text-align: center;
}

.login-box .form .btn {
    display: flex;
    flex: 1;
    flex-direction: column;
}

.login-box .form .el-form-item__content {
    margin-left: 0px !important;

}

.login-box .form .welcome {
    text-align: center;
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 10px;
}

.login-box .form .desc {
    text-align: center;
    font-size: 12px;
    color: var(--el-text-color-secondary);
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    text-indent: 20px;
}

.login-box .form .el-input__wrapper {
    background-color: var(--el-fill-color-light);
}

.login-box .form .is-focus .el-input__wrapper {
    background: var(--el-bg-color);
}

.login-box .form .el-link.forget {
    --el-link-font-size: 12px;
}

.login-page .copyright {

    color: var(--el-text-color-secondary);
    font-size: 14px;
    text-align: center;
    height: 60px;
    line-height: 60px;
}

.embed-title {
    top: 50%;
    position: absolute;
    bottom: 0;
    left: 26px;
    transform: translateY(-50%);
    padding: 2px 4px;
    margin-left: 9px;
    font-size: 13px;
    display: flex;
    align-items: center;
    transition: all 300ms;
    color: var(--el-disabled-text-color);
    border-radius: 20px;
}

.is-focus .embed-title {
    font-size: 12px;
    transform: translateY(-150%) translateX(-10px);
    background: var(--el-bg-color);
}
</style>