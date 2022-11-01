<?php /*a:5:{s:75:"/media/psf/qianmokeji/SaetAdmin/saet.io/app/admin/view/admin/group/auth.vue";i:1663567081;s:36:"../app/admin/view/public/layout.html";i:1666663026;s:36:"../app/admin/view/public/header.html";i:1666258581;s:36:"../app/admin/view/public/assgin.html";i:1666258650;s:36:"../app/admin/view/public/script.html";i:1667032728;}*/ ?>
<!DOCTYPE html>
<html lang="cn" class="<?php echo htmlentities($adminTheme['theme']); ?> <?php echo htmlentities($adminTheme['color']); ?> ">

<head>
    <script>
    // ST = {'xxxx':'yyyy'}
    const ST = <?php echo json_encode($vars); ?>; 
    const __CONFIG__ = ST.__CONFIG__;
    // 防止编辑器格式化出错 
    console.log(__CONFIG__);
    // script 可以通过 ST.XXXXX使用 系统默认vue中 js部分可通过this.ST.xxxx 视图部分 ST.xxxx
    console.info('ST', ST);
</script>
    <script>

        let THEME = ST.adminTheme.theme
        const htmlDom = document.getElementsByTagName('html')[0]

        if (ST.adminTheme.theme == 'system') {
            THEME = window.matchMedia("(prefers-color-scheme: dark)").matches ? 'dark' : 'light';
            htmlDom.setAttribute('class', `${THEME} ${ST.adminTheme.color}`)
        }



    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>Document</title>
    <link rel="stylesheet" href="/static/saet/css/common.min.css?v=<?php echo time(); ?>">

    <script src="/static/package/vue/index.min.js"></script>
    <script src=" https://unpkg.com/vuex@4.0.0/dist/vuex.global.js"></script>
    <script src="/static/package/vue/component.js"></script>

    <script src="/static/package/element-plus/index.min.js"></script>
    <link rel="stylesheet" href="/static/package/element-plus/index.min.css">
    <link rel="stylesheet" href="/static/package/remixicon/remixicon.css">
    <script src="/static/package/axios/axios.min.js"></script>
    <script src="/static/package/string/string.min.js"></script>
    <script src="/static/package/element-plus/icon.js"></script>
    <script src="/static/saet/js/common.js?v=<?php echo time(); ?>"></script>
    <script src="/static/package/nprogress.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
    <script src="/static/package/draggable/vuedraggable.umd.min.js"></script>
    <link rel="stylesheet" href="/static/package/nprogress.css">

    <style>
        * {
            margin: 0px;
            -webkit-text-size-adjust: none;
        }



        @keyframes twinkle {
            0% {
                transform: scale(.8)
            }

            50% {
                transform: scale(1.1)
            }

            to {
                transform: scale(1)
            }
        }

        .el-icon svg {
            animation: twinkle 400ms ease-in-out;
        }

        .el-icon svg,
        .el-button:hover .el-icon {
            animation: twinkle 400ms ease-in-out;
        }

        .el-icon.no-twinkle svg,
        .el-button:hover .no-twinkle.el-icon {
            animation: none;
        }
    </style>

</head>

<style>
  html.dark {

    --el-bg-color: #161819;

    --el-text-color-primary: #dddddd;

    /* border */
    --el-border-color: #333333;

    /* input */

    --el-color-success: #62ba46;
    --el-color-success-light-3: #4e8e2f;
    --el-color-success-light-5: #3e6b27;
    --el-color-success-light-7: #2d481f;
    --el-color-success-light-8: #25371c;
    --el-color-success-light-9: #1c2518;
    --el-color-warning: #ffc726;
    --el-color-warning-light-3: #a77730;
    --el-color-warning-light-5: #7d5b28;
    --el-color-warning-light-7: #533f20;
    --el-color-warning-light-8: #3e301c;
    --el-color-warning-light-9: #292218;
    --el-color-danger: #f68219;
    --el-color-danger-light-3: #b25252;
    --el-color-danger-light-5: #854040;
    --el-color-danger-light-7: #582e2e;
    --el-color-danger-light-8: #412626;
    --el-color-danger-light-9: #2b1d1d;
    --el-color-error: #e0373e;
    --el-color-error-light-3: #b25252;
    --el-color-error-light-5: #854040;
    --el-color-error-light-7: #582e2e;
    --el-color-error-light-8: #412626;
    --el-color-error-light-9: #2b1d1d;
    --el-color-info: #909399;
    --el-color-info-light-3: #6b6d71;
    --el-color-info-light-5: #525457;
    --el-color-info-light-7: #393a3c;
    --el-color-info-light-8: #2d2d2f;
    --el-color-info-light-9: #202121;
    --el-color-info-dark-2: #a6a9ad;
    --el-box-shadow: 0px 12px 32px 4px rgba(0, 0, 0, .36), 0px 8px 20px rgba(0, 0, 0, .72);
    --el-box-shadow-light: 0px 0px 12px rgba(0, 0, 0, .72);
    --el-box-shadow-lighter: 0px 0px 6px rgba(0, 0, 0, .72);
    --el-box-shadow-dark: 0px 16px 48px 16px rgba(0, 0, 0, .72), 0px 12px 32px #000000, 0px 8px 16px -8px #000000;
    --el-bg-color-page: #202020;
    --el-bg-color: #161616;
    --el-bg-color-overlay: #1d1e1f;
    --el-text-color-primary: #E5EAF3;
    --el-text-color-regular: #CFD3DC;
    --el-text-color-secondary: #A3A6AD;
    --el-text-color-placeholder: #8D9095;
    --el-text-color-disabled: #6C6E72;
    --el-border-color-darker: #636466;
    --el-border-color-dark: #58585B;
    --el-border-color: #4C4D4F;
    --el-border-color-light: #414243;
    --el-border-color-lighter: #363637;
    --el-border-color-extra-light: #2B2B2C;
    --el-fill-color-darker: #424243;
    --el-fill-color-dark: #39393A;
    --el-fill-color: #303030;
    --el-fill-color-light: #262727;
    --el-fill-color-lighter: #1D1D1D;
    --el-fill-color-extra-light: #191919;
    --el-fill-color-blank: transparent;
    --el-mask-color: rgba(0, 0, 0, .8);
    --el-mask-color-extra-light: rgba(0, 0, 0, .3);

  }

  html,
  body {
    background-color: var(--el-bg-color-page);
    transition: background-color 300ms;
  }

  /* 兼容组件支持effect属性的夜间主题 */
  .is-dark.el-popover {
    --el-popover-title-text-color: var(--el-bg-color);
  }

  /* 兼容调试模式的夜晚模式 */
  html.dark .exception .source-code {
    background-color: var(--el-bg-color-page);
  }

  html.dark pre.prettyprint .pln {
    color: var(--el-color-info-light-3);
  }

  html.dark pre.prettyprint .kwd {
    color: var(--el-color-warning);
  }

  html.dark pre.prettyprint .line-error .pln {
    color: var(--el-bg-color);
  }

  html.dark body {
    color: var(--el-text-color-primary);
  }

  pages {
    display: flex;
    height: 100%;
  }


  @media only screen and (max-width: 767px) {
    .hidden-xs-only {
      display: none !important;
    }
  }

  @media only screen and (min-width: 768px) {
    .hidden-sm-and-up {
      display: none !important;
    }
  }

  @media only screen and (min-width: 768px) and (max-width: 991px) {
    .hidden-sm-only {
      display: none !important;
    }
  }

  @media only screen and (max-width: 991px) {
    .hidden-sm-and-down {
      display: none !important;
    }
  }

  @media only screen and (min-width: 992px) {
    .hidden-md-and-up {
      display: none !important;
    }
  }

  @media only screen and (min-width: 992px) and (max-width: 1199px) {
    .hidden-md-only {
      display: none !important;
    }
  }

  @media only screen and (max-width: 1199px) {
    .hidden-md-and-down {
      display: none !important;
    }
  }

  @media only screen and (min-width: 1200px) {
    .hidden-lg-and-up {
      display: none !important;
    }
  }

  @media only screen and (min-width: 1200px) and (max-width: 1919px) {
    .hidden-lg-only {
      display: none !important;
    }
  }

  @media only screen and (max-width: 1919px) {
    .hidden-lg-and-down {
      display: none !important;
    }
  }

  @media only screen and (min-width: 1920px) {
    .hidden-xl-only {
      display: none !important;
    }
  }


  ::-webkit-scrollbar {
    width: 8px;
    height: 8px;
  }

  ::-webkit-scrollbar-thumb {
    border-radius: 5px;
    background-color: var(--el-border-color-dark);
  }


</style>

<body>

  <div id="saetApp"></div>
  <div id="js-style"></div>
  <template>
    <div class="st-m-b-40  st-flex justify-between" >
        <div>
            <el-button type="primary" plain @click="setCheckedNodes()">全选</el-button>
            <el-button @click="resetChecked()">清空</el-button>
        </div>
        <el-button @click="save()" :loading="saving" icon="select" type="primary">保存</el-button>
    </div>
    
    <el-tree ref="treeRef" :data="ST.rules" node-key="id" :props="{ label: 'title', class: 'is-penultimate' }"
        show-checkbox :default-checked-keys="defaultCheckedKeys" default-expand-all :expand-on-click-node="false"
        check-on-click-node>
    </el-tree>

</template>
<!-- current-node-key -->
<script>
new SaetApp({
    setup() {
        const treeRef = ref(null)
        const getCheckedKeys = () => {
            let ruleArr = treeRef.value.getCheckedKeys(false);
            return ruleArr.length > 0 ? St.string(ruleArr).toCSV(',', null).s : null;
        }

        const resetChecked = () => {
            treeRef.value.setCheckedKeys([], false)
        }

        const setCheckedNodes = () => {
            treeRef.value.setCheckedNodes(ST.rules, false)
        }

        const save = () => {
            console.log(getCheckedKeys());
            saving.value = true
            St.axios.post('', { rules: getCheckedKeys() }, { successToast: 1 }).then((e) => {
                saving.value = false
            })
        }
        const saving = ref(false)

        const defaultCheckedKeys = St.string(ST.group.rule_ids).parseCSV(',', null)

        return { defaultCheckedKeys, treeRef, getCheckedKeys, resetChecked, setCheckedNodes, save, saving }
    }
})
</script>
<style>
html,
body {
    background-color: white;
}

.el-tree-node.is-expanded>.el-tree-node__children {
    display: flex !important;
    flex-direction: row;
    flex-wrap: wrap;
}
</style>

  
<template id="st-window">
    <div class="st-window">
        <div class="fixed-box" style="position: fixed;left:0px;bottom:0px;    z-index: 20000;">
            <el-tabs v-model="editableTabsValue" type="card" closable @tab-remove="close" @tab-click="tabRecovery">
                <template v-for="(e, key) in list">
                    <el-tab-pane :name="e.id" v-if="!e.visible && e.minimize">
                        <template #label>
                            <span class="">
                                <span class="st-m-r-10">{{  e.title  }}</span>
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
                            <span class="window-title">{{  e.title  }}</span>
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
<script>

new SaetComponent({
    name: 'st-window',
    template: '#st-window',
    created() {

    },
    setup() {

        const assign = {};
        const store = Vuex.useStore();

        assign.list = Vue.computed(() => {
            return store.state.W_LIST;
        });

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
    color:var(--el-text-color-regular);
}

.st-window .fixed-box .el-tabs__header {
    margin: 0;
}

/* .st-window .el-scrollbar__view{
    height: inherit;
}
.st-window .el-scrollbar__view>div{
    height: inherit; 
}*/
</style>
<script>


    // ceeat view
    const templatetDom = document.getElementsByTagName('template')
    const appDom = document.getElementById('saetApp')
    appDom.append(templatetDom[0].content.cloneNode(true))
    appDom.innerHTML += ' <st-window> </st-window>'

    if (self == top && ST.rule != 'index/index' && ST.rule != 'index/login') {
        let headDom = document.head || document.getElementsByTagName('head')[0]
        let style = document.createElement('style');
        style.appendChild(document.createTextNode('body{padding:15px;}'))
        headDom.appendChild(style)
    }


    /** 根地址模式
     * false-无根地址
     * admin-截止到admin.php/
     * addon-截止到admin.php/more_module@admin/访问非插件url时等效于root
     */
    St.axios.defaults.baseUrlType = 'addon';
    St.axios.interceptors.request.use((config) => {
        if (config.url == '') return config;
        if (config.baseUrlType == 'addon' && typeof (ST.apiBaseUrl) != 'undefined') {
            config.baseURL = ST.apiBaseUrl;
        }
        if (config.baseUrlType == 'root' && typeof (ST.apiRootUrl) != 'undefined') {
            config.baseURL = ST.apiRootUrl;
        }
        return config;
    });

    const only = (url, param) => {
        console.log(param);
        let i = St.string(url).contains('?');
        if (i) { url += '&self=1' } else { url += '?self=1' }
        if (param) {
            for (const key in param) {
                let value = param[key]
                url += `&${key}=${value}`
            }
        }
        return url;
    }

    if (typeof (Vue) != 'undefined') {
        const AppNo = {
            template: `<center style="margin-top:35vh;"></el-button><el-button type="error">{{message}}</el-button></center>`,
            data() {
                return {
                    message: "你引入了Vue，快开始创作你的页面吧！",
                };
            },
        };

        // directives: {
        //     drag: {
        //         mounted(el, binding) {
        //             console.log('自定义', el);
        //             console.log('自定义', binding);
        //             const options = binding.value;
        //             for (let oi = 0; oi < options.length; oi++) {
        //                 const o = options[oi];
        //                 new Sortable(el.querySelector(o.selector), o.option);
        //             }
        //         }
        //     }
        // },

        new SaetComponent(vuedraggable)

        const app = Vue.createApp(typeof (this.SaetPage) == 'undefined' ? AppNo : this.SaetPage);
        typeof (ElementPlus) != 'undefined' ? app.use(ElementPlus, { locale: ElementPlusLocaleZhCn }) : console.log('element-plus为必要拓展，请务必引入');
        if (typeof (this.SaetComponentList) != 'undefined') {
            for (const [key, component] of Object.entries(this.SaetComponentList)) {
                if (component.name) app.component(component.name, component)
            }
        }

        app.directive('drag', {
            mounted(el, binding) {
                const options = binding.value;
                for (let oi = 0; oi < options.length; oi++) {
                    const o = options[oi];
                    new Sortable(el.querySelector(o.selector), o.option);
                }
            }
        })

        for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
            app.component(key, component)
        }
        // created(){
        //     document.getElementById("saet-table").remove();
        // },
        for (const [key, component] of Object.entries(SaetAdminComponentVue)) {
            app.component(key, component)
        }

        // console.log(ST.defaultMenu.id);


        // ST.adminTheme
        if (window.innerWidth < 991) ST.adminTheme.menu.minimize = true
        const store = Vuex.createStore({
            state() {
                return {
                    adminTheme: reactive(ST.adminTheme),
                    W_LIST: [],
                    mainMenuId: ST.openMenu ? ST.openMenu.id : 0,
                    subMenuId: ST.openMenu ? ST.openMenu.id : 0,
                    tabActiveId: 0, openTabList: []
                }
            },
            mutations: {
                setStore(state, provider) {
                    let key = provider.key;
                    let data = provider.data;
                    let noStorage = provider.noStorage ? true : false;
                    state[key] = data;
                    if (noStorage == false) {
                        uni.setStorageSync(key, data);
                    } else {
                        console.log(key, '不缓存');
                    }
                },
            }
        })
        app.use(store)


        app.mixin({ data() { return { ST: ST } } })


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
                e = mergeProps(windowDefault, e);
                if (!e.id) e.id = store.state.W_LIST.length + 1
                if (!e.top) e.top = 'calc(15vh + ' + store.state.W_LIST.length * 40 + 'px)'
                let length = store.state.W_LIST.push(e);
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
                // html,body{background-color:unset;}
                // iframe.scrolling = 'no';



                iframe.onload = () => {
                    //去掉内容背景色
                    let iframeDoc = iframe.contentWindow.document;
                    let style = document.createElement('style');
                    style.appendChild(document.createTextNode('html,body{background-color:unset;}'))
                    iframeDoc.head.appendChild(style)

                    // // 监听高度变化
                    // let reizeHeight = new ResizeObserver(() => {
                    //     iframe.height = iframeBody.scrollHeight;
                    //     if (e.height < iframeBody.scrollHeight) {
                    //         iframe.height = iframeBody.scrollHeight;
                    //     }
                    // });
                    // reizeHeight.observe(iframeBody)

                    // iframe.height = iframeBody.scrollHeight;
                    // console.log('addddd', iframeBody);
                    // if (iframe.height > parseInt(e.height)) {
                    //     iframe.style = "width:calc(100% - 12px);"
                    // }
                    let d = e.delayTime - (new Date().getTime() - startTime)
                    if (d > 0) {
                        setTimeout(() => {
                            store.state.W_LIST[length - 1].loadEnd = true
                        }, d)
                    } else {
                        store.state.W_LIST[length - 1].loadEnd = true
                    }
                }
                console.log(store.state.W_LIST);
            }, edit(k, e) {
                store.state.W_LIST[k] = mergeProps(store.state.W_LIST[k], e);
            }, close(k) {
                store.state.W_LIST.splice(k, 1);
            }
        }

        St.window = windowTool


        app.mount("#saetApp");

        var templates = document.getElementsByTagName('template');
        for (let index = 0; index < templates.length; index++) {
            const element = templates[index];
            element.remove();
        }
    }
</script>
</body>

</html>