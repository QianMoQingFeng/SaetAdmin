<?php /*a:3:{s:70:"/media/psf/qianmokeji/SaetAdmin/saet.io/app/admin/view/index/login.vue";i:1667208611;s:36:"../app/admin/view/public/layout.html";i:1668688293;s:36:"../app/admin/view/public/assgin.html";i:1667877771;}*/ ?>
<!DOCTYPE html>
<html lang="cn" class="<?php echo htmlentities($adminTheme['theme']); ?> <?php echo htmlentities($adminTheme['color']); ?> ">

<head>

  <script>
    // ST = {'xxxx':'yyyy'}
    const ST = <?php echo json_encode($vars); ?>; 
    const CONFIG = ST.CONFIG;
    // 防止编辑器格式化出错 
    console.log('CONFIG',CONFIG);
    // script 可以通过 ST.XXXXX使用 系统默认vue中 js部分可通过this.ST.xxxx 视图部分 ST.xxxx
    console.info('ST', ST);
</script>

  <script>
    let THEME = ST.adminTheme.theme
    const htmlDom = document.getElementsByTagName('html')[0]


    // 主题是否通用
    if (ST.adminTheme.theme == 'system') {
      THEME = window.matchMedia("(prefers-color-scheme: dark)").matches ? 'dark' : 'light';
      htmlDom.setAttribute('class', `${THEME} ${ST.adminTheme.color}`)
    }

  </script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport"
    content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <title>SaetAdmin</title>

  <script>const LANG = {};</script>
  <script src="<?php echo LANG_URL; ?>"></script>

  <script src="/static/package/axios/axios.min.js"></script><script src="/static/package/nprogress/nprogress.min.js"></script><link rel="stylesheet" href="/static/package/nprogress/nprogress.min.css"><script src="/static/package/sortable/sortable.min.js"></script><script src="/static/package/vue/vue.global.prod.js"></script><script src="/static/package/element-plus/index.full.min.js"></script><script src="/static/package/element-plus/icon.min.js"></script><link rel="stylesheet" href="/static/package/element-plus/index.min.css"><link rel="stylesheet" href="/static/package/element-plus/dark.min.css"><script src="/static/package/element-plus/locale/zh-cn.min.js"></script><script src="/static/package/string/string.min.js"></script><script src="/static/saet/js/common.min.js"></script><link rel="stylesheet" href="/static/saet/css/common.min.css"><link rel="stylesheet" href="/static/package/remixicon/remixicon.css">

  <script src="/static/package/draggable/vuedraggable.umd.min.js"></script>




</head>

<body>
  <div id="saetApp"></div>
  <div id="js-style"></div>
  
  <vue><template>
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
</style></vue>

  
<template id="st-window">
    <div class="st-window">
        <div class="fixed-box" style="position: fixed;left:0px;bottom:0px;    z-index: 20000;">
            <el-tabs v-model="editableTabsValue" type="card" closable @tab-remove="close" @tab-click="tabRecovery">
                <template v-for="(e, key) in list">
                    <el-tab-pane :name="e.id" v-if="!e.visible && e.minimize">
                        <template #label>
                            <span class="">
                                <span class="st-m-r-10">{{ e.title }}</span>
                                <saet-icon name="ri-picture-in-picture-line"></saet-icon>
                            </span>
                        </template>
                    </el-tab-pane>
                </template>
            </el-tabs>
        </div>
        <template v-for="(e, key) in list">
            <div>
                
                
                <el-dialog v-model="e.visible" width="600px" v-bind="e" :show-close="false"
                    :custom-class="'window-box ' + (e.fullscreenAnimation ? 'fullscreen-animation ' : '') + e.customClass"
                    @closed="closed(key, e)" :style="{ color: '#333', fontSize: '14px' }" @opened="opened">
                    <template #header>
                        <div class="st-flex align-center">
                            <span class="window-title">{{ e.title }}</span>
                            <saet-icon class="is-loading" name="loading"
                                v-if="!e.loadEnd && (e.loadType == 'tip' || e.loadType == 'all') && e.url">
                            </saet-icon>
                            <div style=" flex: 1;">
                            </div>
                            <el-button icon="ArrowLeftBold" circle v-if="isLast(key, e)"></el-button>
                            <el-button icon="ArrowRightBold" circle v-if="isLast(key, e)" class="st-m-r-12"></el-button>

                            <div class="st-dots" v-if="e.showClose || e.showMinimize || e.showMaximize">
                                <div class="color-dot error" @click="close(key, true)" v-if="e.showClose">
                                    <saet-icon name="ri-close-line"></saet-icon>
                                </div>
                                <div class="color-dot warning" @click="minimize(key)" v-if="e.showMinimize">
                                    <saet-icon name="ri-subtract-fill"></saet-icon>
                                </div>
                                <div class="color-dot success" :class="{ 'is-fullscreen': e.fullscreen }"
                                    v-if="e.showMaximize" @click="changFullscreen(key, e.fullscreen)">
                                    <saet-icon class="left" name="ri-arrow-up-s-fill"></saet-icon>
                                    <saet-icon class="right" name="ri-arrow-up-s-fill"></saet-icon>
                                </div>
                            </div>
                        </div>
                    </template>

                    
                    <div :id="'iframe-box-' + e.id" class="iframe-box"></div>
                    
                </el-dialog>
            </div>
        </template>
    </div>
</template>
<script type="module">
import { store } from '/app_static/admin/js/store.js'

const windowDefault = {
    title: 'Saet',
    fullscreen: false,
    visible: true,
    draggable: true,
    customClass: '',
    fullscreenAnimation: true,
    delayTime: 600,
    loadEnd: false,
    loadType: 'all',//full tip
    height: '400px',
    width: '50%',
    top: '12vh',
    modal: false,
    showClose: true,
    showMinimize: true,
    showMaximize: true,
    closeOnClickModal: false, closeOnPressEscape: false
}

const windowTool = {
    open: (e) => {
        e = Vue.mergeProps(windowDefault, e);
        if (!e.id) e.id = store.W_LIST.length + 1
        if (!e.top) e.top = 'calc(15vh + ' + store.W_LIST.length * 40 + 'px)'
        let length = store.W_LIST.push(e);
        var startTime = new Date().getTime();
        setTimeout(() => {
            let iframeBox = document.getElementById('iframe-box-' + e.id);
            iframeBox.appendChild(iframe)
        }, 10);

        let iframe = document.createElement('iframe');
        iframe.src = e.url;
        iframe.width = '100%';
        iframe.id = 'iframe-' + e.id;
        iframe.height = e.height;
        iframe.onload = () => {
            //去掉内容背景色
            let iframeDoc = iframe.contentWindow.document;
            let style = document.createElement('style');
            style.appendChild(document.createTextNode('html,body{background-color:unset;}'))
            iframeDoc.head.appendChild(style)
            let d = e.delayTime - (new Date().getTime() - startTime)
            if (d > 0) {
                setTimeout(() => {
                    store.W_LIST[length - 1].loadEnd = true
                }, d)
            } else {
                store.W_LIST[length - 1].loadEnd = true
            }
        }
    }, edit(k, e) {
        store.W_LIST[k] = Vue.mergeProps(store.W_LIST[k], e);
    }, close(k) {
        store.W_LIST.splice(k, 1);
    }
}

St.window = windowTool
 SaetComponent({
    name: 'st-window',
    template: '#st-window',
    setup() {
        const assign = {};
        assign.list = ref(store.W_LIST);
        assign.changFullscreen = (k, s) => {
            St.window.edit(k, { fullscreen: !s })
        }
        assign.close = (k, is_key) => {
            if (is_key !== true) k = assign.list.value.findIndex((item) => item.id == k);
            if (assign.list.value[k].visible == false) return St.window.close(k);
            St.window.edit(k, { visible: false })
        }
        assign.minimize = (k) => {
            St.window.edit(k, { visible: false, minimize: true })
        }
        assign.recovery = (k) => {
            St.window.edit(k, { visible: true, minimize: false })
        }
        assign.tabRecovery = (e) => {
            let k = assign.list.value.findIndex((item) => item.id == e.props.name)
            St.window.edit(k, { visible: true, minimize: false })
        }

        assign.closed = (k, e) => {
            if (!e.minimize) {
                St.window.close(k)
            }
        }
        assign.dialogVisible = true
        assign.isLast = (k, e) => {
            return false
        }
        assign.opened = (e) => {
            return false
        }
        return assign
    },
})

</script>
<style>
.st-window {}

.st-window .window-box .el-dialog__header {
    margin-right: 0px !important;
}

.st-window .window-box {
    border-radius: 5px;
}

.st-window .window-box.is-fullscreen {
    border-radius: 0px;
    height: 100vh;
    display: flex;
    flex-direction: column;
}

.st-window .window-box.fullscreen-animation {
    transition-property: width, margin;
    transition-duration: 150ms;
}

.st-window .window-box .el-dialog__body {
    --el-dialog-padding-primary: 12px;
    padding: var(--el-dialog-padding-primary);
}

.st-window .window-box.is-fullscreen .el-dialog__body {
    height: calc(100vh - 86.5px);
}

.st-window .iframe-box {
    display: flex;
}

.st-window .iframe-box>iframe {
    border: none;
    transition: all 300ms;
}

.st-window .window-title {
    margin-right: 10px;
    color: var(--el-text-color-regular);
}

.st-window .fixed-box .el-tabs__header {
    margin: 0;
}

</style>

  <script type="module">

    useSaetVue()

    if (self == top && ST.rule != 'index/index' && ST.rule != 'index/login' && ST.rule != '') {
      let headDom = document.head || document.getElementsByTagName('head')[0]
      let style = document.createElement('style');
      style.appendChild(document.createTextNode('body{padding:15px;}'))
      headDom.appendChild(style)
    }

    // iframe 父级 主题切换
    window.addEventListener('message', function (e) {  // 监听 message 事件
      htmlDom.setAttribute('class', `${e.data.theme} ${e.data.color}`)
    });

    // 单窗口主动切换
    if (ST.adminTheme.theme == 'system') {
      window.matchMedia('(prefers-color-scheme: dark)')
        .addEventListener('change', event => {
          if (event.matches) {
            htmlDom.setAttribute('class', `dark ${ST.adminTheme.color}`)
          } else {
            htmlDom.setAttribute('class', `light ${ST.adminTheme.color}`)
          }
        })
    }


  </script>



</body>

</html>