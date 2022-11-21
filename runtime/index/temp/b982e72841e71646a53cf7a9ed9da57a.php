<?php /*a:3:{s:56:"/media/psf/qianmokeji/SaetAdmin/saet.io/saet/install.vue";i:1668433797;s:36:"../app/index/view/public/layout.html";i:1668431777;s:36:"../app/index/view/public/assgin.html";i:1668307619;}*/ ?>
<!DOCTYPE html>
<html lang="cn" class="  ">

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
  <script>const LANG = {}</script>
  <script src="<?php echo LANG_URL; ?>"></script>

  <script src="/static/package/axios/axios.min.js"></script><script src="/static/package/nprogress/nprogress.min.js"></script><link rel="stylesheet" href="/static/package/nprogress/nprogress.min.css"><script src="/static/package/sortable/sortable.min.js"></script><script src="/static/package/vue/vue.global.prod.js"></script><script src="/static/package/element-plus/index.full.min.js"></script><script src="/static/package/element-plus/icon.min.js"></script><link rel="stylesheet" href="/static/package/element-plus/index.min.css"><link rel="stylesheet" href="/static/package/element-plus/dark.min.css"><script src="/static/package/element-plus/locale/zh-cn.min.js"></script><script src="/static/package/string/string.min.js"></script><script src="/static/saet/js/common.min.js"></script><link rel="stylesheet" href="/static/saet/css/common.min.css"><link rel="stylesheet" href="/static/package/remixicon/remixicon.css">

  <script src="/static/package/draggable/vuedraggable.umd.min.js"></script>

</head>

<body>
  <div id="saetApp"></div>
  <div id="js-style"></div>
  <vue>
<template>
    <div style="margin: auto;padding:0 10px;">
        <el-space direction="vertical" style="width:100%;" fill>
            <el-image src=""></el-image>
            <el-alert title="欢迎使用SaetAdmin快速开发框架" description="请认真填写下方所需信息," type="info">
                <template #default>
                    请填写下方所需信息,如果是第一次使用可以点击 <el-link :underline="false" href="http://baidu.com">
                        <el-tag effect="dark" size="small">
                            传送门
                        </el-tag>
                    </el-link>查看文档 ^-^
                </template>
            </el-alert>

            <el-steps :active="stepCur" simple finish-status="success">
                <el-step title="检测" :icon="stepCur > 0 ? 'select' : stepCur == 0 ? 'edit' : 'none'"></el-step>
                <el-step title="安装" :icon="stepCur > 1 ? 'select' : stepCur == 1 ? 'edit' : 'none'"></el-step>
                <el-step title="完成" :icon="stepCur == 2 ? 'select' : 'none'"></el-step>
            </el-steps>

            <template v-if="stepCur == 0">
                <el-table :data="checkData" border style="width: 100%;border-radius:8px;overflow: hidden;">
                    <el-table-column prop="app" label="环境"></el-table-column>
                    <el-table-column prop="version_keep" label="版本需求"></el-table-column>
                    <el-table-column prop="version" label="目前版本"></el-table-column>
                    <el-table-column prop="status" label="状态" fixed="right" width="90px">
                        <template #default="{ row }">
                            <template v-if="row.status == 'yes'">
                                <saet-icon name="ri-checkbox-circle-fill" style="color:var(--el-color-success)"
                                    :size="16"> </saet-icon>
                                <span class="text"> 通过</span>
                            </template>

                            <template v-if="row.status == 'fail'">
                                <saet-icon name="ri-close-circle-fill" style="color:var(--el-color-error)" :size="16">
                                </saet-icon>
                                <span class="text"> 不匹配</span>
                            </template>
                            <template v-if="row.status == 'wait'">
                                <saet-icon name="ri-information-fill" style="color:var(--el-color-warning)" :size="16">
                                </saet-icon>
                                <span class="text"> 待验证</span>
                            </template>
                        </template>
                    </el-table-column>

                </el-table>

                <el-form ref="formRef" :model="form" label-width="90px" :label-position="position" :rules="rules">
                    <div class="title">数据库信息</div>
                    <el-form-item label="地址/端口" required prop="hostname">
                        <el-row :gutter="10">
                            <el-col :span="13">
                                <el-input v-model="form.hostname" placeholder="ip地址"
                                    @input="checkData[1].status = 'wait'"></el-input>
                            </el-col>
                            <el-col :span="11">
                                <el-form-item prop="hostport">
                                    <el-input v-model="form.hostport" placeholder="数据库端口"
                                        @input="checkData[1].status = 'wait'"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form-item>

                    <el-form-item label="账户/密码" required prop="username">
                        <el-row :gutter="10">
                            <el-col :span="13">
                                <el-input v-model="form.username" placeholder="数据库账号"
                                    @input="checkData[1].status = 'wait'"></el-input>
                            </el-col>
                            <el-col :span="11">
                                <el-form-item label="" required prop="password">
                                    <el-input v-model="form.password" placeholder="数据库密码"
                                        @input="checkData[1].status = 'wait'"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form-item>

                    <el-form-item label="库名/前缀" required prop="database">
                        <el-row :gutter="10">
                            <el-col :span="13">
                                <el-input v-model="form.database" placeholder="数据库名"
                                    @input="checkData[1].status = 'wait'"></el-input>
                            </el-col>
                            <el-col :span="11">
                                <el-form-item prop="prefix">
                                    <el-input v-model="form.prefix" placeholder="数据库前缀"></el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form-item>
                </el-form>
                <div class="st-flex">
                    <el-button type="warning" :loading="checkIng" @click="check(formRef)" style="flex:1;">
                        {{ checkIng ? '检验中...' : '核验数据库信息' }}</el-button>
                    <el-button type="primary" :disabled="checkStatus" @click="stepCur = 1" style="width: 100px;">下一步
                    </el-button>
                </div>

            </template>

            <template v-if="stepCur == 1">
                <el-form ref="formRef" :model="form" label-width="90px" :label-position="position" :rules="rules">

                    <div class="title">
                        站点信息
                    </div>

                    <el-form-item label="站点标题" prop="site_title">

                        <el-input v-model="form.site_title" placeholder="站点标题"></el-input>
                    </el-form-item>
                    <el-form-item label="超管账号" required prop="admin_username">
                        <el-input v-model="form.admin_username" placeholder="管理员账号"></el-input>
                    </el-form-item>
                    <el-form-item label="账号密码" required prop="admin_password">
                        <el-input v-model="form.admin_password" placeholder="管理员密码"></el-input>
                    </el-form-item>
                    <el-form-item label="重复密码" required prop="admin_password2">
                        <el-input v-model="form.admin_password2" placeholder="重复密码"></el-input>
                    </el-form-item>
                    <el-form-item label="定义入口">
                        <div class="st-flex" style="flex: 1;">
                            <el-input v-model="form.entry_file" placeholder="默认admin">
                                <template #append>.php</template>
                            </el-input>
                            <el-button class="st-m-l-10" type="primary" plain @click="buildRandom" icon="refresh">
                            </el-button>
                        </div>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" :loading="installIng" @click="install(formRef)">{{ installIng ?
                                '安装中....' :
                                '开始安装'
                        }}
                        </el-button>
                        <el-button type="info" plain @click="stepCur = 0">返回</el-button>
                    </el-form-item>
                </el-form>


            </template>
        </el-space>
    </div>
</template>
<script>

SaetApp({
    setup() {
        const stepCur = ref(0)
        const installIng = ref(false)
        const install = async (formEl) => {

            if (!formEl) return
            await formEl.validate((valid) => {
                if (valid) {
                    installIng.value = true
                    form.value.type = 'install'
                    St.axios.post('install.html', form.value, { successToast: true }).then((res) => {
                        installIng.value = false;

                    }).catch((err) => {
                        installIng.value = false;
                    });
                }
            })
        }

        const rules = reactive({
            hostname: { required: true, message: '请填写数据库IP', trigger: 'blur' },
            hostport: { required: true, message: '请填写数据库端口', trigger: 'blur' },
            database: { required: true, message: '请填写数据库名称', trigger: 'blur' },
            username: { required: true, message: '请填写数据库账号', trigger: 'blur' },
            password: { required: true, message: '请填写数据库密码', trigger: 'blur' },
            admin_username: { required: true, message: '请填写管理员账号', trigger: 'blur' },
            admin_password: { required: true, message: '请填写密码', trigger: 'blur' },
            admin_password2: { required: true, message: '两次输入密码不匹配', trigger: 'blur', validator: () => { return form.value.admin_password == form.value.admin_password2 } },
        })

        const formRef = ref();
        const checkIng = ref(false)

        const checkStatus = Vue.computed(() => {
            return checkData.value.find((item) => item.status != 'yes') ? true : false
        })

        const check = async (formEl) => {
            if (!formEl) return
            await formEl.validate((valid) => {
                if (valid) {
                    checkIng.value = true;
                    form.value.type = 'check'
                    St.axios.post('install.html', form.value, { successToast: true }).then((res) => {
                        checkIng.value = false;
                        checkData.value[1].version = res.version
                        checkData.value[1].status = 'yes'
                    }).catch((err) => {
                        if (err.data && err.data.version) {
                            checkData.value[1].version = err.data.version + '(过低)'
                            checkData.value[1].status = 'fail'
                        }
                        checkIng.value = false;
                    });
                }
            })
        }

        const form = ref({
            prefix: 'st_',
            hostport: '3306',
            hostname: 'localhost'
        })


        const position = ref('left')

        if (window.innerWidth < 500) position.value = 'top'

        const buildRandom = () => {
            form.value.entry_file = St.string('Letter+number').random(10, true)
        }

        const checkData = ref([{
            app: 'php',
            version_keep: '>= 7.4',
            version: '<?php echo htmlentities(PHP_VERSION); ?>',
            status: 'yes'
        },
        {
            app: 'mysql',
            version_keep: '>= 5.7',
            version: '待验证',
            status: 'wait'
        }
        ])
        return { stepCur, install, installIng, form, check, checkIng, position, formRef, rules, buildRandom, checkData, checkStatus }
    }
})

</script>
<style>
.title {
    padding: 20px 0;
    color: var(--el-text-color-secondary);
}

.el-form-item__content {
    max-width: 300px;
}

.cell {
    display: flex;
    align-items: center;
}

.cell .el-icon {
    margin-right: 5px;
}

.cell .text {
    font-size: 12px;
}

.el-steps--simple {
    background-color: var(--el-bg-color-page);
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

    useSaetVue();

    // if (self == top && ST.rule != 'index/index' && ST.rule != 'index/login') {
    //   let headDom = document.head || document.getElementsByTagName('head')[0]
    //   let style = document.createElement('style');
    //   style.appendChild(document.createTextNode('body{padding:15px;}'))
    //   headDom.appendChild(style)
    // }



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