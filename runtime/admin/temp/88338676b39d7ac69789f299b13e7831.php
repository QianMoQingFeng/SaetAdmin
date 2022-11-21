<?php /*a:3:{s:73:"/media/psf/qianmokeji/SaetAdmin/saet.io/app/admin/view/home/dashboard.vue";i:1666182129;s:36:"../app/admin/view/public/layout.html";i:1668688293;s:36:"../app/admin/view/public/assgin.html";i:1667877771;}*/ ?>
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
    <div>
        {{title}}
    </div>
</template>
<script>
const App = {
    data() {
        return {
            title: 'hello world'
        }
    },
}
</script></vue>

  
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