<?php /*a:9:{s:70:"/media/psf/qianmokeji/SaetAdmin/saet.io/app/admin/view/index/index.vue";i:1666182151;s:36:"../app/admin/view/public/layout.html";i:1666663026;s:36:"../app/admin/view/public/header.html";i:1666258581;s:36:"../app/admin/view/public/assgin.html";i:1666258650;s:84:"/media/psf/qianmokeji/SaetAdmin/saet.io/app/admin/view/index/components/side-top.vue";i:1667222471;s:85:"/media/psf/qianmokeji/SaetAdmin/saet.io/app/admin/view/index/components/side-left.vue";i:1667208611;s:85:"/media/psf/qianmokeji/SaetAdmin/saet.io/app/admin/view/index/components/main-menu.vue";i:1663840560;s:84:"/media/psf/qianmokeji/SaetAdmin/saet.io/app/admin/view/index/components/sub-menu.vue";i:1663396342;s:36:"../app/admin/view/public/script.html";i:1667292335;}*/ ?>
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
    <div class="body" id="frame-entrance" :class="'side-' + adminTheme.side_type">
        <side-left ref="saetMenu"></side-left>
        <main style="display: flex;flex: 1;flex-direction: column;">
            <side-top ref="saetTop"> </side-top>
            <pages></pages>
        </main>
    </div>
</template>

    
    <template type="text/html" id="side-top">

    <div class="side-top">
        <div class="saet-top">
            <div class="tabs" style="width:100%;">
                <div class="tabs-box" @mousewheel="scrollChange" ref="tabRef">
                    <div class="item" v-for="(item, index) in openTabList" :key="index" :title="item.title"
                        :class="{ 'active': tabActiveId == item.id }" :name="item.id" @click="changeTab(item.id)">
                        <!-- :closable="index > 0 ? true : false" -->
                        <!-- removeTab  tabActiveId -->
                        <div class="line" v-if="index != 0"></div>
                        <div class="tab-content">
                            <div class="title">{{  item.title  }}</div>
                        </div>
                        <div class="tab-bg">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                style="display: block;width: 100%;height: 100%;">
                                <defs>
                                    <symbol id="tab-geometry-left" viewBox="0 0 214 36">
                                        <path d="M17 0h197v36H0v-2c4.5 0 9-3.5 9-8V8c0-4.5 3.5-8 8-8z">
                                        </path>
                                    </symbol>
                                    <symbol id="tab-geometry-right" viewBox="0 0 214 36">
                                        <use xlink:href="#tab-geometry-left"></use>
                                    </symbol>
                                    <clipPath id="crop">
                                        <rect class="mask" width="100%" height="100%" x="0"></rect>
                                    </clipPath>
                                </defs><svg width="52%" height="100%">
                                    <use xlink:href="#tab-geometry-left" width="214" height="36" class="tab-geometry">
                                    </use>
                                </svg>
                                <g transform="scale(-1, 1)"><svg width="52%" height="100%" x="-100%" y="0">
                                        <use xlink:href="#tab-geometry-right" width="214" height="36"
                                            class="tab-geometry"></use>
                                    </svg></g>
                            </svg>
                        </div>
                        <saet-icon name="close" class="is-icon-close" @click.stop="removeTab(item.id, index)"
                            v-if="openTabList.length > 1"></saet-icon>
                    </div>
                </div>
            </div>
            <!-- </el-scrollbar> -->
            <div class="navs">
                <div class="left" style="flex:1;display: flex;align-items: center;">
                    <el-link :underline="false" class="collapse-btn"
                        @click="() => { if (adminTheme.menu.minimize) return adminTheme.menu.minimize = false; adminTheme.menu_type == 'main' ? adminTheme.menu.collapse = !adminTheme.menu.collapse : adminTheme.submenu.collapse = !adminTheme.submenu.collapse }">
                        <saet-icon name="ri-menu-fold-fill"
                            :class="{ 'is-collapse': adminTheme.menu.minimize == true || (adminTheme.menu_type == 'main' ? adminTheme.menu.collapse : adminTheme.submenu.collapse) }">
                        </saet-icon>
                    </el-link>
                    <el-breadcrumb :separator-icon="ArrowRight" class="style-1 hidden-sm-and-down">
                        <title-tree :list="ST.menuListTree" :level="0" :id-tree="idTreeArr"></title-tree>
                    </el-breadcrumb>
                </div>
                <div class="right">
                    <el-tooltip class="box-item" effect="dark" content="如需跟随系统，点击右侧主题按钮设置" placement="bottom"
                        :disabled="'<?php echo htmlentities($adminTheme['theme']); ?>' == 'system' ? true : false">
                        <div @click="changeTheme(relTheme == 'dark' ? 'light' : 'dark', true)" class="theme-toggler">
                            <div class="switch">
                                <div class="switch__action">
                                    <div class="switch__icon">
                                        <saet-icon :size="13" name="DarkIcon"></saet-icon>
                                        <saet-icon :size="13" name="LightIcon"></saet-icon>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </el-tooltip>

                    <el-button @click="" text circle>
                        <saet-icon :size="20" name="ri-translate-2"></saet-icon>
                    </el-button>

                    <el-button @click="full_screen ? exitScreen() : fullScreen()" text circle>
                        <saet-icon :size="20" name="ri-fullscreen-exit-line" v-if="full_screen"></saet-icon>
                        <saet-icon :size="20" name="ri-fullscreen-line" v-else></saet-icon>
                    </el-button>

                    <el-button text bg class="avatar" ref="adminBtnRef">
                        <el-avatar :size="28" :src="ST.admin.avatar">
                        </el-avatar>
                        <div class="info">
                            <span class="nickname">{{  ST.admin.nick_name  }}</span>
                            <span class="username">{{  ST.admin.user_name  }}</span>
                        </div>
                    </el-button>

                    <el-button @click="drawer = !drawer" text circle>
                        <img src="/static/img/theme.png" style="width: 20px;height: 20px;" alt="主题设置">
                    </el-button>
                </div>
            </div>

            <!-- admin-info-popover -->
            <el-popover ref="adminInfoRef" :virtual-ref="adminBtnRef" trigger="hover" virtual-triggering width="240px"
                placement="bottom-end">
                <div class="st-flex-col admin-info">
                    <div class="st-flex info">
                        <el-avatar :size="50" :src="ST.admin.avatar" class="st-m-r-10">
                        </el-avatar>
                        <div class="st-flex-col justify-around st-p-y-4">
                            <div><span class="st-m-r-5">{{  ST.admin.nick_name  }}</span>
                                <el-tag size="small" type="info">Aid:{{  ST.admin.aid  }}</el-tag>
                            </div>
                            <div style="font-size: 12px;width: 160px;">
                                <span>{{  ST.admin.user_name  }}</span>
                                <span v-if="ST.admin.mobile || ST.admin.email">（{{  ST.admin.mobile || ST.admin.email 
                                    }}）</span>
                            </div>
                        </div>
                    </div>
                    <div class="st-m-t-8 st-m-l-2" style="color: var(--el-text-color-secondary);font-size: 12px;">
                        登录时间:2020-12-3
                        29:22:33</div>
                    <div class="st-flex justify-between st-m-t-10" style="width: 100%;">
                        <el-button type="primary" size="" plain @click="">个人资料</el-button>
                        <el-button type="danger" icon="SwitchButton" :loading="logouting" :disabled="logouting" plain
                            @click="logout()">
                            {{  logouting ? '正在登出...' : '注销'  }}</el-button>
                    </div>
                </div>
            </el-popover>

            <el-drawer v-model="drawer" title="外观设置" :size="300">
                <el-scrollbar style="padding:20px;">
                    <div class="st-style">
                        <div class="box">
                            <el-divider content-position="left"> 主题模式</el-divider>
                            <div class="theme">
                                <div class="item st-m-l-4" :class="{ 'active': adminTheme.theme == 'system' }"
                                    @click="changeTheme('system', true)">
                                    <div class="image">
                                        <el-image src="/static/img/system.png"></el-image>
                                    </div>
                                    <div class="desc">跟随系统</div>
                                </div>
                                <div class="item" :class="{ 'active': adminTheme.theme == 'dark' }"
                                    @click="changeTheme('dark', true)">
                                    <div class="image">
                                        <el-image src="/static/img/dark.png"></el-image>
                                    </div>
                                    <div class="desc">深色</div>
                                </div>
                                <div class="item" :class="{ 'active': adminTheme.theme == 'light' }"
                                    @click="changeTheme('light', true)">
                                    <div class="image">
                                        <el-image src="/static/img/light.png"></el-image>
                                    </div>
                                    <div class="desc">浅色</div>
                                </div>
                            </div>
                        </div>
                        <div class="box">

                            <el-divider content-position="left"> 主色调<span class="info st-m-l-10">{{  colorTitle  }}</span>
                            </el-divider>
                            <div class="color">
                                <template v-for="c in colorList">
                                    <div class="item theme-color"
                                        :class="[c.name, relTheme, c.name == adminTheme.color ? 'active' : '']"
                                        @click="changeColor(c.name)" v-if="!(relTheme == 'dark' && c.name == 'invert')">
                                        <!-- <span class="active" v-if="c.name == adminTheme.color"></span> -->
                                    </div>
                                </template>

                            </div>
                        </div>

                        <div class="box">
                            <el-divider content-position="left"> 布局</el-divider>
                            <div class="layout st-flex" style="justify-content: space-around;">
                                <el-switch v-model="adminTheme.side_type" active-value="float" inactive-value="fixed"
                                    active-text="悬浮" inactive-text="吸附"></el-switch>
                            </div>
                        </div>

                        <div class="box">
                            <el-divider content-position="left"> 菜单风格</el-divider>
                            <div class="nav st-flex">
                                <div class="item"
                                    :class="{ 'active': adminTheme.menu_type == 'main' && !adminTheme.menu.collapse }"
                                    @click="changeMenuType('main', false)">
                                    <div class="left" style="width: 20px;"> </div>
                                    <div class="right">
                                        <div class="head"> </div>
                                        <div class="body"></div>
                                    </div>
                                </div>
                                <div class="item"
                                    :class="{ 'active': adminTheme.menu_type == 'main' && adminTheme.menu.collapse }"
                                    @click="changeMenuType('main', true)">
                                    <div class="left" style="width: 10px;"></div>
                                    <div class="right">
                                        <div class="head"></div>
                                        <div class="body"></div>
                                    </div>
                                </div>
                                <div class="item"
                                    :class="{ 'active': adminTheme.menu_type == 'main-sub' && !adminTheme.submenu.collapse }"
                                    @click="changeMenuType('main-sub', false)">
                                    <div class="side">
                                        <div class="side-1"></div>
                                        <div class="side-2" style="width: 20px;"></div>
                                    </div>
                                    <div class="right">
                                        <div class="head"></div>
                                        <div class="body"></div>
                                    </div>
                                </div>
                                <div class="item"
                                    :class="{ 'active': adminTheme.menu_type == 'main-sub' && adminTheme.submenu.collapse }"
                                    @click="changeMenuType('main-sub', true)">
                                    <div class="side">
                                        <div class="side-1"></div>
                                        <div class="side-2" style="width: 10px;"></div>
                                    </div>
                                    <div class="right">
                                        <div class="head"></div>
                                        <div class="body"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="box">
                            <el-divider content-position="left"> 栏行风格</el-divider>
                            <div class="layout st-flex">
                                <el-button-group class="ml-4">
                                    <el-button type="primary">
                                        <span
                                            style="width: 12px;height:12px;border:2px solid var(--el-bg-color-page);"></span>
                                    </el-button>
                                    <el-button type="primary" plain>
                                        <span
                                            style="width: 12px;height:12px;border:2px solid var(--el-bg-color-page);border-radius: 4px;"></span>
                                    </el-button>
                                </el-button-group>
                            </div>
                        </div> -->

                        <div class="footer">
                            <el-button type="primary" @click="saveTheme(false)" :loading="saveThemeIng">确定
                            </el-button>
                            <el-button type="primary" plain @click="saveTheme(true)" :loading="saveSysThemeIng"
                                style="flex: 1;">
                                应用到全部用户默认
                            </el-button>
                        </div>
                    </div>
                </el-scrollbar>
            </el-drawer>

        </div>
    </div>
</template>


<script >



new SaetComponent({
    name: 'title-tree',
    props: { list: Array, level: Number, idTree: Array },
    template: `<template v-for="(v, index) in list"><template v-if="idTree[level] == v.id"><el-breadcrumb-item class=""> {{  v.title  }}  </el-breadcrumb-item></template><title-tree :list="v.children" v-if="v.children" :level="level+1" :id-tree="idTree"></title-tree></template>`,
})

new SaetComponent({
    template: '#side-top',
    name: 'side-top',
    setup(props, context) {
        const adminBtnRef = ref()
        const adminInfoRef = ref()
        const drawer = ref(false)
        const store = Vuex.useStore();
        const openTabList = Vue.computed(() => { return store.state.openTabList });
        const adminTheme = reactive(store.state.adminTheme);
        const relTheme = ref(THEME);
        const colorList = [
            { title: '紫色', name: 'purple' },
            { title: '蓝色', name: 'blue' },
            { title: '粉色', name: 'pink' },
            { title: '红色', name: 'error' },
            { title: '橙色', name: 'orange' },
            { title: '黄色', name: 'yellow' },
            { title: '绿色', name: 'green' }, { title: '简洁素雅', name: 'invert' }]

        // 监听主题切换,外框架动态，再次监听
        window.matchMedia('(prefers-color-scheme: dark)')
            .addEventListener('change', event => {
                if (adminTheme.theme == 'system') {
                    if (event.matches) {
                        changeTheme('dark')
                    } else {
                        changeTheme('light')
                    }
                }
            })

        // 监听主题变化 保存配置
        // Vue.watch(
        //     () => adminTheme,
        //     (n, o) => {
        //         if (o != undefined) St.cookie.set('admin_theme', JSON.stringify(n))
        //     }, { deep: true, immediate: true }
        // )

        // const store = Vuex.useStore();
        const tabActiveId = Vue.computed(() => { return store.state.tabActiveId });

        // 一级菜单
        const mainMenuId = Vue.computed(() => { return store.state.mainMenuId });
        // 二级菜单
        const subMenuId = Vue.computed(() => { return store.state.subMenuId });
        const changeTab = (id) => {
            let menu = openTabList.value.find((item) => item.id == id);
            store.state.subMenuId = menu.id
            store.state.mainMenuId = menu.T_root_id
            store.state.tabActiveId = menu.id
        }
        // 监听子菜单变化
        Vue.watch(
            () => subMenuId,
            (n, o) => {
                let activeTabIndex = openTabList.value.findIndex((item) => item.id == n.value);
                if (activeTabIndex > -1) {
                    var activeTab = openTabList.value[activeTabIndex];
                    document.title = activeTab.title;
                    window.history.pushState({ id: activeTab.id, rule_url: activeTab.url }, activeTab.title, activeTab.nav_url);
                }
            }, { deep: true, immediate: true }
        )



        const changeTheme = (theme, b) => {
            if (b === true) adminTheme.theme = theme
            if (theme == 'system') {
                const isDarktheme = window.matchMedia("(prefers-color-scheme: dark)").matches
                theme = isDarktheme ? 'dark' : 'light'
            }
            relTheme.value = theme;
            changeDomTheme()
        }
        const changeColor = (color) => {
            adminTheme.color = color
            changeDomTheme()
        }

        const changeSideType = (e) => {
            adminTheme.side_type = e
            // changeDomTheme()
        }
        const changeMenuType = (e, c) => {
            console.log(adminTheme);
            adminTheme.menu_type = e
            if (e == 'main') {
                adminTheme.menu.collapse = c
            }
            if (e == 'main-sub') {
                adminTheme.submenu.collapse = c
            }
        }

        function changeDomTheme() {
            htmlDom.setAttribute('class', `${relTheme.value} ${adminTheme.color} ${adminTheme.layout} layouting`)
            openTabList.value.forEach(e => {
                let ifarmeWindow = document.getElementById("saet_page_ifarme_" + e.id).contentWindow;
                ifarmeWindow.postMessage({ theme: relTheme.value, color: adminTheme.color, layout: adminTheme.layout }, "*")
            });
        }
        const saveThemeIng = ref(false);
        const saveSysThemeIng = ref(false);

        const saveTheme = (e) => {
            if (e) {
                // 全部
                saveSysThemeIng.value = true
                St.axios.post('config/setAdminTheme', {data:adminTheme}, { successToast: true }).then((res) => {
                    saveSysThemeIng.value = false
                }).catch((err) => {
                    saveSysThemeIng.value = false
                });
            } else {
                // 个人
                saveThemeIng.value = true
                St.cookie.set('admin_theme', JSON.stringify(adminTheme))
                setTimeout(() => {
                    saveThemeIng.value = false
                    St.message.success('保存成功')
                }, 300);
            }

        }

        // 移除选项卡
        const removeTab = (id, index) => {
            // 首先移除删除的dom
            let dom = document.getElementById("saet_page_" + id);
            if (dom) dom.remove()
            // 如果删除的是当前项就重新赋予新的tab_id
            if (id == tabActiveId.value) {
                changeTab(openTabList.value[index - 1].id)
            }
            // 最后移除数组中对应的json数据 ，先移除为报错
            store.state.openTabList.splice(index, 1);
        }

        const tabRef = ref()
        const scrollChange = (e) => {
            let eventDelta = 40;
            if (e.deltaY < 0) {
                eventDelta *= -1;
            }
            tabRef.value.scrollLeft += eventDelta
        }
        const idTreeArr = ref([])
        //  监听菜单栏目变化 
        Vue.watch(
            () => tabActiveId,
            (n, o) => {
                if (!n.value) return false;
                let i = openTabList.value.findIndex((item) => item.id == n.value)
                let e = openTabList.value[i]

                idTreeArr.value = e.T_id_tree;
                var page_list = document.getElementsByClassName("saet-page-box");
                for (let i = 0; i < page_list.length; i++) {
                    if (page_list[i].dataset.id == e.id) {
                        page_list[i].style.display = "block";
                    } else {
                        page_list[i].style.display = "none";
                    }
                }
                tabRef.value.scrollLeft = i * 150 + 50;
            }, { deep: true, immediate: true }
        )

        return { idTreeArr, tabRef, scrollChange, adminBtnRef, adminInfoRef, drawer, adminTheme, changeTheme, changeColor, changeSideType, saveTheme, relTheme, colorList, saveThemeIng, saveSysThemeIng, changeMenuType, changeTab, removeTab, tabActiveId, openTabList }
    },
    computed: {
        colorTitle() {
            let c = this.colorList.find((item) => item.name == this.adminTheme.color)
            return c.title
        }
    },
    data() {
        return {
            full_screen: false, logouting: false
        }
    }, methods: {
        fullScreen() {
            var el = document.documentElement;
            var rfs = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullScreen;
            //typeof rfs != "undefined" && rfs
            if (rfs) {
                rfs.call(el);
            }
            else if (typeof window.ActiveXObject !== "undefined") {
                //for IE，这里其实就是模拟了按下键盘的F11，使浏览器全屏
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript != null) {
                    wscript.SendKeys("{F11}");
                }
            }
        },
        exitScreen() {
            var el = document;
            var cfs = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el.exitFullScreen;
            //typeof cfs != "undefined" && cfs
            if (cfs) {
                cfs.call(el);
            }
            else if (typeof window.ActiveXObject !== "undefined") {
                //for IE，这里和fullScreen相同，模拟按下F11键退出全屏
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript != null) {
                    wscript.SendKeys("{F11}");
                }
            }
        },
        // changeTab(id) {
        //     if (this.activeTabId == id) {
        //         return false;
        //     }
        //     let menu = this.openTabList.find((item) => item.id == id);
        //     this.$emit('setActive', { menu: menu, type: 'change' });
        // },

        // 登出
        logout() {
            this.logouting = true;
            St.axios.post('admin/logout', this.formData, { loadingToast: false, successToast: true }).then((res) => {
                this.logouting = false;
                setTimeout(() => {
                    window.location.reload();
                }, 400);
            }).catch((err) => {
                this.logouting = false;
            });
        }
    },
    created() {
        // 监听地址变化内容跟随
        window.addEventListener('popstate', event => {
            if (event.state.id) {
                this.changeTab(event.state.id)
            }
        });

        // 监听全屏切换
        window.onresize = () => {
            var isFull = !!(document.webkitIsFullScr90een || document.mozFullScreen ||
                document.msFullscreenElement || document.fullscreenElement
            );
            if (isFull == false) {
                this.full_screen = false
            } else {
                this.full_screen = true
            }
        }
    },
})
</script>
    <style>
    .el-drawer__body {
        padding: 0px;
    }
    
    .side-top {
        --top-right-width: 320px;
        display: flex;
    }
    
    .side-top .el-button {
        border-radius: var(--box-radius);
    }
    
    .saet-top {
        display: flex;
        flex-direction: column;
        position: relative;
        align-items: center;
        flex: 1;
        width: 0;
    }
    
    /* navs */
    .saet-top .navs {
        width: 100%;
        display: flex;
        flex-direction: row;
        height: 48px;
        background-color: var(--el-bg-color);
        border-radius: var(--layout-float-radius);
    }
    
    .saet-top .navs .left .collapse-btn {
        height: 100%;
    }
    
    .saet-top .navs .left .collapse-btn {
        padding: 0 15px;
        font-size: 18px;
    }
    
    .saet-top .navs .left .collapse-btn .is-collapse {
        transform: rotate(-180deg);
    }
    
    .saet-top .navs .right {
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
        align-items: center;
    }
    
    .saet-top .navs .right .info {
        margin-left: 5px;
        display: flex;
        flex-direction: column;
    }
    
    .saet-top .navs .right .el-button.avatar {
        padding: 4px 6px;
        height: auto;
    }
    
    .saet-top .navs .right .el-button:last-child {
        margin-right: 8px;
    }
    
    .saet-top .navs .right .info .nickname {
        font-size: 12px;
        max-width: 60px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        transform: scale(.94);
    }
    
    .saet-top .navs .right .info .username {
        font-size: 12px;
        margin-top: 1px;
        transform: scale(.88);
        color: var(--el-text-color-secondary);
    
    }
    
    .saet-top .navs .right .el-button+.el-button {
        margin-left: 8px;
    }
    
    
    .side-top .el-drawer__header {
        margin-bottom: 0px;
    }
    
    
    /* tabs */
    .saet-top .el-tabs {
        --el-tabs-header-height: 28px;
        padding: 0 12px !important;
    }
    
    .saet-top .tabs-box {
        display: flex;
        padding-left: 10px;
        display: flex;
        overflow-y: hidden;
        scrollbar-width: none;
    }
    
    .saet-top .tabs-box::-webkit-scrollbar {
        display: none;
    }
    
    .saet-top .tabs-box .item {
        width: 150px;
        min-width: 150px;
        height: 34px;
        position: relative;
        margin-right: -20px;
        cursor: pointer;
        animation: tt 200ms;
    }
    
    @keyframes tt {
        0% {
            transform: translateY(100%);
            opacity: 0;
        }
    
        100% {
            opacity: 1;
            transform: translateY(0%);
    
        }
    }
    
    .saet-top .tabs-box .item .tab-content {
        position: absolute;
        top: 0px;
        width: 150px;
        height: 34px;
        line-height: 32px;
        right: -21px;
        font-size: 14px;
        z-index: 3;
    }
    
    .saet-top .tabs-box .item .tab-content .title {
        mask-image: linear-gradient(90deg, #000 0%, #000 calc(100% - 55px), transparent);
        -webkit-mask-image: linear-gradient(90deg, #000 0%, #000 calc(100% - 55px), transparent);
        white-space: nowrap;
        width: 100px;
        color: var(--el-text-color-placeholder);
    }
    
    .saet-top .tabs-box .item.active .tab-content .title {
        color: var(--el-text-color-primary);
    }
    
    .saet-top .tabs-box .item .line {
        display: block;
        position: absolute;
        top: 0;
        left: 11px;
        bottom: 0;
        width: 1px;
        opacity: 1;
        background-color: var(--el-text-color-placeholder);
        height: 14px;
        margin: auto;
    }
    
    .saet-top .tabs-box .active+.item .line,
    .saet-top .tabs-box .item:hover .line {
        opacity: 0;
    }
    
    .saet-top .tabs-box .item .tab-bg {
        display: flex;
        position: absolute;
        z-index: 1;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        pointer-events: none;
    }
    
    .saet-top .tabs-box .item.active .tab-bg {
        z-index: 2;
    }
    
    
    .saet-top .tabs-box .item .tab-bg svg {
        fill: var(--el-bg-color);
        opacity: 0;
        transition: opacity 100ms;
    }
    
    
    .saet-top .tabs-box .item.active .tab-bg svg {
        /* fill: var(--el-bg-color); */
        opacity: 1;
    }
    
    
    .saet-top .tabs-box .item:not(.active):hover .tab-bg svg {
        opacity: 0.7;
    }
    
    .saet-top .tabs-box .item .is-icon-close {
        position: absolute;
        right: 16px;
        z-index: 4;
        line-height: 34px;
        font-size: 10px;
        width: 18px;
        height: 18px;
        border-radius: 18px;
        top: 0;
        bottom: 0;
        margin: auto;
    }
    
    .saet-top .tabs-box .item .is-icon-close:hover {
        background-color: var(--el-color-info-light-8);
    }
    
    .saet-top .el-tabs__item:last-child {
        margin-right: 0;
    }
    
    .saet-top .el-tabs__active-bar {
        height: 35px;
        z-index: -1;
        border-radius: 6px;
    }
    
    .saet-top .el-tabs__nav-wrap::after {
        height: 0;
    }
    
    .saet-top .el-tabs__header {
        margin: 0;
    }
    
    .saet-top .el-tabs__item.is-active {
        color: var(--el-color-white);
        transition: color .5s;
    }
    
    
    .saet-top .theme-toggler {
        height: 20px;
        margin-right: 12px;
    }
    
    .saet-top .switch {
        margin: 0;
        display: inline-block;
        position: relative;
        width: 40px;
        height: 20px;
        border: 1px solid var(--el-border-color);
        outline: none;
        border-radius: 10px;
        box-sizing: border-box;
        background: var(--el-border-color);
        cursor: pointer;
        transition: border-color var(--el-transition-duration), background-color var(--el-transition-duration);
    }
    
    html.dark .saet-top .switch__action {
        transform: translate(20px);
    }
    
    .saet-top .switch__action,
    .saet-top .switch__icon {
        width: 16px;
        height: 16px;
    }
    
    .saet-top .switch__action {
        position: absolute;
        top: 1px;
        left: 1px;
        border-radius: 50%;
        background-color: var(--el-bg-color);
        transform: translate(0);
        transition: border-color var(--el-transition-duration), background-color var(--el-transition-duration), transform var(--el-transition-duration);
    }
    
    .saet-top .switch__icon {
        position: relative;
    }
    
    .saet-top .switch__icon .el-icon {
        position: absolute;
        left: 1px;
        bottom: 1px;
    }
    
    .saet-top .dark-icon {
        opacity: 0;
    }
    
    .saet-top .light-icon {
        opacity: 1;
    }
    
    html.dark .saet-top .dark-icon {
        opacity: 1;
    }
    
    html.dark .saet-top .light-icon {
        opacity: 0;
    }
    
    .saet-top .dark-icon,
    .saet-top .light-icon {
        transition: color var(--el-transition-duration), opacity var(--el-transition-duration);
        position: absolute;
        top: 0;
        left: 0;
    }
    
    
    
    .admin-info .info {
        width: 220px;
        background-color: var(--el-fill-color-light);
        border-radius: 5px;
        padding: 10px;
    }
    
    .st-style {
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .st-style .box {
        margin-bottom: 26px;
    }
    
    .st-style .title {
        font-size: 14px;
    }
    
    .st-style .info {
        font-size: 13px;
        color: var(--el-color-info);
    }
    
    /* 主题 */
    .st-style .theme {
        display: flex;
    }
    
    .st-style .box .theme .el-image {
        width: 66px;
        height: 42px;
        border-radius: 7px;
        border: 1px solid var(--el-border-color-light);
    }
    
    .st-style .box .theme .item .image {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 4px;
    }
    
    .st-style .box .theme .item .desc {
        font-size: 12px;
        text-align: center;
        color: var(--el-text-color-primary);
        margin-top: 6px;
    }
    
    .st-style .box .theme .item.active .image:after {
        content: '';
        border: 2.5px solid var(--el-color-primary);
        position: absolute;
        height: 100%;
        width: 100%;
        border-radius: 8px;
    }
    
    .st-style .box .theme .item+.item {
        margin-left: 12px;
    }
    
    .st-style .box .color .item+.item {
        margin-left: 10px;
    }
    
    
    .st-style .footer {
        position: sticky;
        display: flex;
        bottom: 0;
        background: var(--el-bg-color);
        padding-top: 20px;
    }
    
    /* 颜色风格 */
    .st-style .box .color {
        display: flex;
        flex-direction: row;
    }
    
    .st-style .box .color .item {
        width: 16px;
        height: 16px;
        border-radius: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: var(--el-color-primary);
        border: 3px solid var(--el-color-primary-light-7);
        transition: width .3s;
    }
    
    .st-style .box .color .item.active {
        width: 24px;
    }
    
    .st-style .box .color .active::after {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 20px;
        background-color: #ffffff;
    }
    
    /* 布局 */
    .st-style .box .layout .item {
        position: relative;
    }
    
    .st-style .box .layout .active .item {
        --el-border-color: var(--el-color-primary);
    }
    
    .st-style .box .layout .title {
        width: 100%;
        margin-top: 5px;
        text-align: center;
        color: var(--el-text-color-secondary);
        font-size: 13px;
    }
    
    .st-style .box .layout .active .title {
        color: var(--el-color-primary) !important;
    }
    
    /* 菜单风格 */
    .st-style .box .nav {
        justify-content: space-around;
        flex-wrap: wrap;
    }
    
    .st-style .box .nav .item {
        width: 90px;
        height: 56px;
        padding: 8px;
        display: flex;
        border-radius: 6px;
        box-shadow: 0 0 5px 1px var(--el-border-color-lighter);
        margin-bottom: 20px;
    }
    
    .st-style .box .nav .item:not(.active):hover {
        box-shadow: 0 0 5px 1px var(--el-border-color-darker) !important;
    }
    
    .st-style .box .nav .item.active {
        /* box-shadow: 0 0 5px 1px var(--el-color-primary); */
        border: 2px solid var(--el-color-primary);
        padding: 6px;
    }
    
    .st-style .box .nav .item .left {
        height: 100%;
        background-color: var(--el-color-primary);
        border-radius: 2px;
        margin-right: 5px;
    }
    
    .st-style .box .nav .item .side {
        display: flex;
    }
    
    .st-style .box .nav .item .side .side-1 {
        width: 10px;
        height: 100%;
        background-color: var(--el-color-primary);
        margin-right: 5px;
        border-radius: 2px;
    
    }
    
    .st-style .box .nav .item .side .side-2 {
        height: 100%;
        background-color: var(--el-color-primary-light-3);
        margin-right: 5px;
        border-radius: 2px;
    
    }
    
    .st-style .box .nav .item .right {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .st-style .box .nav .item .head {
        background-color: var(--el-color-primary-light-3);
        width: 100%;
        height: 12px;
        /* border-bottom: 1px solid var(--el-border-color); */
        border-radius: 2px;
        margin-bottom: 5px;
    
    }
    
    .st-style .box .nav .item .body {
        background-color: var(--el-color-primary-light-7);
        width: 100%;
        flex: 1;
        border-radius: 2px;
        border: 1px dashed var(--el-color-primary);
    }
    
    /* 面包屑 */
    .el-breadcrumb.style-1 .el-breadcrumb__item:first-child:not(:last-child) .el-breadcrumb__inner {
        padding-left: 12px;
        border-radius: 6px 0 0 6px;
        clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 50%, calc(100% - 8px) 100%, 0 100%);
    }
    
    .el-breadcrumb.style-1 .el-breadcrumb__item .el-breadcrumb__inner {
        cursor: pointer;
        display: inline-block;
        background-color: var(--el-fill-color);
        transition: background-color .3s, var(--el-transition-color);
        padding: 8px 16px;
        clip-path: polygon(0 0, calc(100% - 8px) 0, 100% 50%, calc(100% - 8px) 100%, 0 100%, 8px 50%);
    }
    
    .el-breadcrumb.style-1 .el-breadcrumb__item .el-breadcrumb__separator {
        display: none;
    }
    
    .el-breadcrumb {
        flex: 1;
        display: flex;
        flex-direction: row;
        align-items: center;
        overflow: hidden;
        white-space: nowrap;
    }
    </style>

    <template  id="side-left">
    <div class="minimize-mask" @click="adminTheme.menu.minimize = true"
        :class="{ 'is-open': !adminTheme.menu.minimize }">
    </div>
    <aside :class="['side-left', adminTheme.menu_type, { 'is-minimize': adminTheme.menu.minimize }]">
        <div class="side1"
            :class="[{ 'is-collapse': (adminTheme.menu_type == 'main-sub' ? true : adminTheme.menu.collapse) }]">
            <div style="margin-top: 20px;"></div>
            <div class="opear-dot st-dots">
                <el-popconfirm confirm-button-text="确定" cancel-button-text="No, Thanks" icon="InfoFilled"
                    @confirm="logout" placement="right" icon-color="hsl(353, 80%, 60%)" title="确定离开并退出登录吗?">
                    <template #reference>
                        <div class="color-dot error">
                            <saet-icon name="ri-close-line"></saet-icon>
                        </div>
                    </template>
                </el-popconfirm>
                <div class="color-dot warning" @click="adminTheme.menu.minimize = !adminTheme.menu.minimize">
                    <saet-icon name="ri-subtract-fill"></saet-icon>
                </div>
                <div class="color-dot success"
                    @click="adminTheme.menu_type == 'main' ? adminTheme.menu.collapse = !adminTheme.menu.collapse : adminTheme.submenu.collapse = !adminTheme.submenu.collapse">
                    <saet-icon name="ri-arrow-left-right-line" :size="12" style="transform: scale(0.85);"></saet-icon>
                </div>
            </div>
            <div class="info-box">
                <div class="avatar">
                    <span class="tag"></span>
                    <el-avatar
                        src="https://img2.baidu.com/it/u=3768902040,1772619951&fm=253&fmt=auto&app=138&f=JPEG?w=500&h=500"
                        fit="fill"></el-avatar>
                </div>
                <div class="info">
                    <span class="nickname">{{ ST.admin.nick_name }}</span>
                    <span class="username">{{ ST.admin.user_name }}</span>
                </div>
            </div>
            <!-- 菜单搜索 -->
            <div class="search-box pd-lr" @click="clickSearch">
                <el-autocomplete v-model="searchValue" ref="searchRef" size="large" placeholder="Please Input"
                    :trigger-on-focus="false" clearable :fetch-suggestions="querySearch" prefix-icon="search">
                    <template #suffix v-if="!isMainCollapse">
                        <el-button class="collect-btn" type="warning" link v-popover="collectRef">
                            <saet-icon name="StarFilled"></saet-icon>
                        </el-button>
                    </template>
                </el-autocomplete>
            </div>
            <!-- 收集列表&overview -->
            <el-popover ref="collectRef" title="" :width="200" trigger="hover" placement="right-start"
                content="this is content, this is content, this is content">
            </el-popover>
            <div class="saet-second pd-lr">
                <div class="saet-title"><span>OVERVIEW</span></div>
                <el-button class="collect-btn" type="warning" text>
                    <saet-icon name="StarFilled"></saet-icon>
                </el-button>
            </div>
            <!-- 菜单组 -->
            <el-scrollbar>
                <div class="menu-scroll">
                    <st-main-menu :is-collapse="isMainCollapse" :menu-list="ST.menuListTree" @setMenu="setMenu"
                        @set-sub-menu="setSubMenu"></st-main-menu>

                </div>
                <div class="pd-lr" style="position: sticky;bottom: 0; background-color: var(--el-bg-color);">
                    <el-divider></el-divider>
                    <div class="saet-title system">
                        <span>ONBOARDING</span>
                    </div>
                    <div class="system-box" :class="{ 'is-system-collapse': isSystemCollapse }">
                        <el-link :underline="false" target="_blank"
                            href="http://wpa.qq.com/msgrd?v=3&uin=85347325&site=qq&menu=yes">
                            <el-button @click="" text bg>
                                <saet-icon :size="15" name="QmkjIcon"></saet-icon>
                            </el-button>
                        </el-link>
                        <el-link :underline="false" target="_blank"
                            href="http://wpa.qq.com/msgrd?v=3&uin=85347325&site=qq&menu=yes">
                            <el-button text>
                                <saet-icon name="ri-qq-fill" :size="18"></saet-icon>
                            </el-button>
                        </el-link>
                        <div>
                            <el-button @click="" text>
                                <saet-icon name="ri-wechat-fill" :size="18"></saet-icon>
                            </el-button>
                        </div>
                        <div>
                            <el-button @click="" text>
                                <saet-icon name="ri-arrow-up-circle-line" :size="18"></saet-icon>
                            </el-button>
                        </div>
                        <!-- ri-refresh-line -->
                        <div class="st-flex" style="flex:1;"></div>
                        <el-button @click="" text class="design-btn">
                            <img src="/static/img/theme.png" style="width: 20px;height: 20px;" alt="主题设置">
                        </el-button>
                        <div class="arrow">
                            <el-button @click="isSystemCollapse = !isSystemCollapse" link>
                                <saet-icon name="ArrowDown" v-if="isSystemCollapse"></saet-icon>
                                <saet-icon name="ArrowUp" v-else></saet-icon>
                            </el-button>
                        </div>
                    </div>
                    <div style="height:12px;"></div>
                </div>
            </el-scrollbar>


        </div>

        <div v-show="adminTheme.menu_type == 'main-sub'" class="side2">
            <st-sub-menu :menu-list="subMenuList" @set-menu="setMenu"> </st-sub-menu>
        </div>
    </aside>
</template>

<script>
new SaetComponent({
    name: 'side-left',
    template: '#side-left',

    setup(props, context) {
        const searchValue = ref()
        const isSystemCollapse = ref(true)
        const progress = ref(false)
        const progressValue = ref(0)
        const progressDuration = ref(0)
        const progressAnimation = ref(false)
        const searchRef = ref()
        const collectRef = ref()
        const store = Vuex.useStore();
        const adminTheme = reactive(store.state.adminTheme);
        const isMainCollapse = Vue.computed(() => {
            let r = adminTheme.menu_type == 'main-sub' ? true : false
            return r
        })


        window.addEventListener('resize', () => {
            if (window.innerWidth < 990) {
                adminTheme.menu.minimize = true
            } else {
                adminTheme.menu.minimize = false
            }
        })

        // 一级菜单
        const mainMenuId = Vue.computed(() => { return store.state.mainMenuId });
        // 二级菜单
        const subMenuId = Vue.computed(() => { return store.state.subMenuId });
        // const subMenuList = ref(ST.menuListTree.find((item) => item.id == ST.openMenu.T_root_id));
        const subMenuList = ref();

        const setSubMenu = (e) => {
            if (!e.children) { openIfarm(e); store.state.subMenuId = e.id }
            store.state.mainMenuId = e.T_root_id
            subMenuList.value = e
        }


        // 监听子菜单变化
        Vue.watch(
            () => mainMenuId,
            (n, o) => {
                console.log(n);
                let row = ST.menuListTree.find((item) => item.id == n.value)
                subMenuList.value = row
            }, { deep: true, immediate: true }
        )


        // 监听菜单变化
        const clickSearch = () => {
            console.log('search', props.isMainCollapse);
            if (props.isMainCollapse) {
                context.emit('change', 'collapse');
                setTimeout(() => {
                    searchRef.value.focus()
                }, 350);
            }
        }
        const setMenu = (item) => {
            item.type = 'tab';
            switch (item.type) {
                case 'tab':
                    openIfarm(item)
                    break;
                default:
                    openIfarm(item)
                    break;
            }
        }

        const openTabList = Vue.computed(() => { return store.state.openTabList });

        const openIfarm = (e) => {
            // 判断是否已经打开了页面
            var is_have = openTabList.value.some((item) => item.id == e.id);

            if (!is_have) {
                if (openTabList.value.length == 15) {
                    this.$message({
                        message: "最多只能打开15个窗口哦 ! ^-^",
                        duration: 1500,
                        type: "warning",
                    });
                    return false;
                }

                NProgress.start();
                store.state.tabActiveId = e.id
                store.state.openTabList.push(e)
                var container = document.createElement("section");
                container.className = "el-container saet-page-box";
                container.id = "saet_page_" + e.id;
                container.dataset.id = e.id;
                var ifarme = document.createElement("iframe");
                ifarme.src = e.page_url;
                ifarme.width = "100%";
                ifarme.height = "100%";
                ifarme.id = "saet_page_ifarme_" + e.id;
                ifarme.style.border = "none";
                const pagesDom = document.getElementsByTagName('pages')[0];
                var dom = pagesDom.appendChild(container).appendChild(ifarme);
                dom.onload = () => {
                    loading.close();
                    NProgress.done();
                };
                // target: '#main'时，是统一loading
                const loading = St.loading.service({
                    target: "#saet_page_" + e.id,
                    lock: true,
                });
                // 十秒超时关闭loading
                setTimeout(() => {
                    if (loading.visible) loading.close();
                    NProgress.done();
                }, 10000);
            } else {
                // 只切换
                store.state.tabActiveId = e.id
                context.emit('setActive', { menu: e, type: 'change' });
            }
        }
        const logout = () => {
            // 登出
            St.axios.post('admin/logout', this.formData, { loadingToast: true, successToast: true }).then((res) => {
                setTimeout(() => {
                    window.location.reload();
                }, 400);
            });
        }

        const createFilter = (queryString) => {
            return (restaurant) => {
                return (
                    restaurant.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0
                )
            }
        }
        const restaurants = ref([{ value: 'vue', link: 'https://github.com/vuejs/vue' },
        { value: 'element', link: 'https://github.com/ElemeFE/element' },
        { value: 'cooking', link: 'https://github.com/ElemeFE/cooking' },
        { value: 'mint-ui', link: 'https://github.com/ElemeFE/mint-ui' },
        { value: 'vuex', link: 'https://github.com/vuejs/vuex' },
        { value: 'vue-router', link: 'https://github.com/vuejs/vue-router' },
        { value: 'babel', link: 'https://github.com/babel/babel' }])
        const querySearch = (queryString, cb) => {
            const results = queryString
                ? restaurants.value.filter(createFilter(queryString))
                : restaurants.value
            // call callback function to return suggestions
            cb(results)
        }
        return { subMenuId, searchValue, isSystemCollapse, mainMenuId, progress, progressValue, progressDuration, progressAnimation, searchRef, clickSearch, setMenu, openIfarm, querySearch, logout, adminTheme, isMainCollapse, subMenuList, setSubMenu }
    }
})
</script>
<style>
.side-left {
    display: flex;
    margin-right: var(--layout-float-space);
    border-radius: var(--layout-float-radius);
    overflow: hidden;
    background-color: var(--el-bg-color);
}

.side-left.main-sub>.side1 {
    border-right: solid 1px var(--el-color-info-light-9);
}




.side1 .el-menu:not(.el-menu--collapse) {
    width: var(--aside-menu-max-width);
}

.side1 .pd-lr {
    padding: 0 var(--aside-menu-x-space);
}

.side1 {
    --el-menu-level-padding: 0px;
    --el-menu-base-level-padding: 15px;
    --avatar-radius: 22px;
    --avatar-box-width: 56px;
    --aside-menu-max-width: 200px;
    --aside-menu-x-space: 16px;
    --aside-menu-box-size: 36px;
    --aside-min-width: calc(var(--aside-menu-x-space) * 2 + var(--aside-menu-box-size));
    --aside-max-width: calc(var(--aside-menu-x-space) * 2 + var(--aside-menu-max-width));
    --el-menu-item-font-size: 13px;
    height: 100%;
    display: inline-block;
    display: flex;
    flex-direction: column;
    max-width: var(--aside-max-width);
    min-width: var(--aside-min-width);
    transition: all 320ms;
    width: var(--aside-max-width);
}

.side1 .info-box {
    display: flex;
    flex-direction: row;
    position: relative;
    align-items: center;
    padding: var(--aside-menu-x-space);
    transition: padding 300ms;
}

.side1.is-collapse .info-box {
    padding-left: calc((var(--aside-min-width) - calc(var(--avatar-box-width) + 2px))/2);
}

.side1.is-collapse {
    width: var(--aside-min-width);
}

.side1 .el-divider--horizontal {
    --el-border-color: #ebebeb;
}

html.dark .side1 .el-divider--horizontal {
    --el-border-color: #2c2c2c;
}



.side1 .avatar {
    border: 1px solid var(--el-border-color-lighter);
}

.side1 .avatar {
    position: relative;
    min-width: var(--avatar-box-width);
    height: var(--avatar-box-width);
    border-radius: var(--avatar-radius);
    display: flex;
    justify-content: center;
    align-items: center;
}




.side1 .info {
    width: 0px;
    transition: width 300ms;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
    white-space: nowrap;
    height: calc(var(--avatar-box-width) - 8px);
    margin-left: 6px;
}

.side1 .info {
    width: 120px;
}

.side1 .info span {
    width: 120px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}

.side1 .info .username {
    font-size: 12px;
    color: var(--el-text-color-secondary);
}

/* 菜单搜索框 */

.side1 .search-box {
    --el-border-color: none;
    margin-bottom: 10px;
}

.side1 .search-box>.el-autocomplete {
    --el-input-bg-color: var(--el-color-info-light-8);
    --el-input-border-radius: var(--box-radius);
    width: 100%;
    height: var(--aside-menu-box-size);
    border-radius: var(--box-radius);
    padding-bottom: 2px;
}

.side1 .search-box>.el-autocomplete .el-input__prefix {
    width: var(--aside-menu-box-size);
    justify-content: center;
}

.side1 .search-box>.el-autocomplete .el-input__wrapper {
    padding: 0;
    overflow: hidden;
    display: flex;
    flex-direction: row;
    justify-content: start;
}

.side1 .search-box>.el-autocomplete .el-input__prefix .el-icon {
    margin-right: 0;
}

.side1 .search-box>.el-autocomplete .el-input__clear {
    margin-left: 0;
    margin-right: 8px;
}



.side1 .saet-title {
    display: flex;
    align-items: flex-end;
    height: var(--aside-menu-box-size);
    line-height: var(--aside-menu-box-size);
    color: var(--el-color-info-light-3);
}


.side1 .saet-title span {
    font-size: 12px;
    transform: scale(0.88);
    display: inline-block;
}


/*  收藏按钮&title */
.side1 .saet-second {
    height: var(--aside-menu-box-size);
    min-height: var(--aside-menu-box-size);
    overflow: hidden;
}

.side1 .saet-second .saet-title {
    transition: margin 300ms;
}

.side1.is-collapse .saet-second .saet-title {
    margin-top: calc(var(--aside-menu-box-size) * -1);
}

.side1 .collect-btn {
    padding: 0;
    width: var(--aside-menu-box-size);
    height: var(--aside-menu-box-size);
}

.side1 .collect-btn .el-icon svg,
.side1 .collect-btn .el-icon {
    width: 24px;
    height: 24px;
}


.side1 .avatar .tag {
    width: 3.5px;
    height: 16px;
    background-color: var(--el-color-primary);
    position: absolute;
    left: 0;
    border-radius: 16px;
}

.side1 .avatar .el-avatar {
    --el-avatar-size: var(--aside-menu-box-size);
    border-radius: 16px;
}

.side1.is-open .avatar {
    margin-left: var(--aside-menu-x-space);
}

.side1 .el-menu>.el-divider--horizontal {
    margin-bottom: 0px;
}

.side1 .el-menu .el-sub-menu .el-divider--horizontal {
    margin: 2px 0;
    width: calc(100% - calc(var(--el-menu-base-level-padding) + var(--el-menu-level) * var(--el-menu-level-padding))*1);
    float: right;
}

.menu-scroll {
    width: auto;
    flex: 1;
    /* overflow-y: scroll; */
}

.el-sub-menu.is-active.is-opened .el-menu--inline {
    /* background-color: var(--el-color-primary-light-9); */
    border-radius: 6px;
    /* overflow: hidden; */
}

.el-menu-item {
    position: relative;
}

.el-menu-item.is-active::before {
    content: '';
    width: 5px;
    height: 20px;
    background-color: var(--el-color-primary);
    position: absolute;
    left: 0;
    border-radius: 5px;
}


.main-menu.el-menu--collapse>.el-sub-menu.is-active>.el-sub-menu__title {
    background: var(--el-color-primary);
    color: var(--el-bg-color);
}

.side-left .el-menu {
    border-right: none;
    margin: auto;
}

.menu-scroll>ul>li {
    margin-top: 10px;
}

.menu-scroll>.el-menu>.el-menu-item>.el-icon svg,
.menu-scroll>.el-menu>.el-sub-menu>.el-sub-menu__title>.el-icon svg {
    height: 18px;
    width: 18px;
}


.menu-scroll .el-menu-item.is-active {
    /* background-color: var(--el-color-primary); */
    color: var(--el-color-primary);
    font-weight: 700;
}

.menu-scroll .el-menu-item .title {
    margin-left: calc((var(--aside-menu-box-size) - 24px) / 2);
}

.menu-scroll .el-menu--collapse {
    width: var(--aside-menu-box-size);
}


.menu-scroll .el-menu-item,
.menu-scroll .el-sub-menu__title {
    height: 40px;
    line-height: 40px;
    border-radius: var(--box-radius);
    overflow: hidden;
}

.menu-scroll .el-menu--collapse .el-menu-item,
.menu-scroll .el-menu--collapse .el-sub-menu__title {
    height: var(--aside-menu-box-size);
    line-height: var(--aside-menu-box-size);
}


.menu-scroll>.el-menu>.el-menu-item,
.menu-scroll>.el-menu>.el-sub-menu>.el-sub-menu__title {
    padding: 0 calc((var(--aside-menu-box-size) - 24px) / 2) !important;
}



.menu-scroll .el-menu-item [class^=el-icon] {
    margin-right: 0px;
}


.menu-scroll .el-menu-item .el-menu-tooltip__trigger {
    margin-left: 10px;
}


/* 系统拓展栏 */
.side1 .saet-title.system {
    height: var(--aside-menu-box-size);
    transition: height 300ms;
}

.side1.is-collapse .saet-title.system {
    height: 0px;
    overflow: hidden;
}

.side1 .system-box {
    background-color: var(--el-color-info-light-7);
    border-radius: var(--box-radius);
    display: flex;
    align-items: center;
    padding-left: 4.5px;
    overflow: hidden;
    transition: all 300ms;
    height: var(--aside-menu-box-size);
    margin-top: 12px;
}

.side1 .system-box .design-btn {
    display: flex;
    flex-direction: row;
    margin-right: 6px;
}

.side1 .system-box .el-button {
    width: 27px;
    height: 27px;
    padding: 0;
    margin-right: 6px;
    border-radius: var(--box-radius);
}

.side1 .system-box .arrow {
    display: none;
}

.side1.is-collapse .system-box {
    height: var(--aside-menu-max-width);
    flex-direction: column;
    padding-left: 0px;
    padding-top: 5px;
    padding-bottom: 20px;
    position: relative;
}

.side1.is-collapse .system-box.is-system-collapse {
    height: var(--aside-menu-box-size);
}

.side1.is-collapse .system-box .design-btn {
    margin-right: 0px;
    margin-bottom: 10px;
}

.side1.is-collapse .system-box .el-button {
    margin-right: 0;
}

.side1.is-collapse .system-box .arrow .el-button {
    background-color: var(--el-color-info-light-7);
}

.side1.is-collapse .system-box .arrow {
    opacity: 1;
    position: absolute;
    bottom: 0px;
    display: block;
}

/* 系统盒子结束 */


/* 指示点 */

.side1 .opear-dot {
    display: flex;
    flex-direction: row;
    margin-left: calc((var(--aside-min-width) - var(--avatar-box-width))/2);
    margin-bottom: 20px;
}

/* light模式 */
html.light .side1 .el-input__wrapper {
    --el-input-bg-color: var(--el-color-info-light-8);
}

/* dark模式 */
html.dark .side1 .el-input {
    --el-input-bg-color: #333333;
    --el-input-text-color: #ffffff;
    --el-input-hover-border-color: #424242;
}

html.dark .side1 .saet-title {
    color: var(--el-text-color-placeholder);
}

html.dark .side1 .avatar {
    border-color: var(--el-bg-color-page);
    background-color: var(--el-color-info-light-9);
}

/* 副菜单 */
.side-left>.side2 .el-menu--vertical:not(.el-menu--collapse) {
    width: 200px;
}

.side-left>.side2 .sub-menu-title {
    height: 40px;
    transition: height 300ms;
    line-height: 40px;
    font-size: 12px;
    padding-left: 12px;
    color: var(--el-color-info);
    margin-top: 10px;
}

.side-left>.side2 .sub-menu-title.title-collapse {
    height: 0px;
    overflow: hidden;
}

/* 菜单最小化 */
.side-left.is-minimize {
    margin-right: 0px;
}

.side-left.is-minimize>.side1,
.side-left.is-minimize>.side2 {
    width: 0px;
    min-width: 0;
}

@media only screen and (max-width: 991px) {
    .side-left {
        position: fixed;
        left: 0;
        height: 100vh;
        z-index: 10000 !important;
        transition: transform 400ms;
    }

    .side-left.is-minimize {
        transform: translateX(calc(-100% - var(--layout-float-space)));
    }

    .side-left.is-minimize>.side1,
    .side-left.is-minimize>.side2 {
        width: fit-content;
        min-width: auto;
    }

    .side-float .side-left {
        /* border-radius: 0px; */
        height: calc(100% - var(--layout-float-space) * 2);
        left: var(--layout-float-space);
    }

    .minimize-mask.is-open {
        display: block;
    }

    @keyframes minimizeMask {
        from {
            opacity: 0;
        }

        to {
            opacity: .42;
        }
    }

    /* 做一个动画 */
    .minimize-mask {
        position: fixed;
        background: #000;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        display: none;
        z-index: 9999;
        opacity: .42;
        animation: minimizeMask 500ms;
    }

}
</style>

    
<template id="st-main-menu">
    <el-menu class="main-menu"
        :default-active="adminTheme.menu_type == 'main' ? subMenuId.toString() : mainMenuId.toString()"
        :collapse="adminTheme.menu_type == 'main-sub' ? true : adminTheme.menu.collapse" @close="handleClose"
        unique-opened>

        <template v-for="(m, index) in menuList">
            <el-sub-menu :index="m.id.toString()" :popper-offset="30" @click="setMenu(m)"
                v-if="m.children && adminTheme.menu_type == 'main'">
                <template #title>
                    <saet-icon :name="m.icon"></saet-icon>
                    <span>{{ m.title }}</span>
                </template>
                <template v-for="(m2, m2Index) in m.children">
                    <el-sub-menu :index="m2.id.toString()" v-if="m2.children" @click="setMenu(m2)">
                        <template #title>
                            <saet-icon :name="m2.icon"></saet-icon>
                            <div class="title">{{ m2.title }}</div>
                        </template>
                        <template v-for="m3 in m2.children">
                            <el-sub-menu :index="m3.id.toString()" v-if="m3.children" @click="setMenu(m3)">
                                <template #title>
                                    <saet-icon :name="m3.icon"></saet-icon>
                                    <div class="title">{{ m3.title }}</div>
                                </template>
                                <template v-for="m4 in m3.children">
                                    <el-menu-item :index="m4.id.toString()" @click="setMenu(m4)" :id="'menu_' + m4.id">
                                        <saet-icon :name="m4.icon"></saet-icon>
                                        <div class="title">{{ m4.title }}</div>
                                    </el-menu-item>
                                </template>
                            </el-sub-menu>
                            <el-menu-item :index="m3.id.toString()" v-else @click="setMenu(m3)" :id="'menu_' + m3.id">
                                <saet-icon :name="m3.icon"></saet-icon>
                                <div class="title">{{ m3.title }}</div>
                            </el-menu-item>
                        </template>
                    </el-sub-menu>
                    <el-menu-item :index="m2.id.toString()" v-else @click="setMenu(m2)" :id="'menu_' + m2.id">
                        <saet-icon :name="m2.icon"></saet-icon>
                        <div class="title">{{ m2.title }}</div>
                    </el-menu-item>
                </template>
            </el-sub-menu>
            <el-menu-item :index="m.id.toString()" @click="setMenu(m)" :id="'menu_' + m.id"
                @mouseover="(e) => (mouseover(e, m.title))" v-if="adminTheme.menu_type == 'main-sub' || !m.children">
                <saet-icon :name="m.icon"></saet-icon>
                <div class="title">{{ m.title }}</div>
            </el-menu-item>
        </template>

        <el-tooltip v-if="adminTheme.menu_type == 'main-sub' ? true : adminTheme.menu.collapse" ref="titleRef"
            placement="right-start" offset="30" :virtual-ref="titleTargetRef" virtual-triggering trigger="hover"
            :content="popoverTitle">
        </el-tooltip>

    </el-menu>


</template>
<script >
new SaetComponent({
    name: 'st-main-menu',
    template: '#st-main-menu',
    props: {
        menuList: Array
    }, setup(props, context) {

        const store = Vuex.useStore();
        const adminTheme = reactive(store.state.adminTheme);

        const setMenu = (e) => {
            // if (adminTheme.menu_type == 'main-sub') return context.emit('setSubMenu', e);
            context.emit('setSubMenu', e)
        }
        const mainMenuId = Vue.computed(() => { return store.state.mainMenuId })
        const subMenuId = Vue.computed(() => { return store.state.subMenuId })

        const isCollapse = Vue.computed(() => {
            let r = adminTheme.menu_type == 'main-sub' ? true : false
            return r
        })


        const popoverTitle = ref()
        const titleTargetRef = ref()
        const titleRef = ref()
        const mouseover = (e, t) => {
            titleTargetRef.value = e.currentTarget
            popoverTitle.value = t
        }
        return { setMenu, adminTheme, mainMenuId, subMenuId, mouseover, popoverTitle, titleRef, titleTargetRef }
    }
})
</script>

    
<template id="st-sub-menu">
    <el-scrollbar v-if="menuList">
        <div class="sub-menu-title" :class="{ 'title-collapse': adminTheme.submenu.collapse }">{{ menuList.title }}</div>
        <el-menu :default-active="subMenuId.toString()" :collapse="adminTheme.submenu.collapse" @close="handleClose"
            unique-opened>
            <template v-for="(m, index) in subMenuList">
                <el-sub-menu :index="m.id.toString()" :popper-offset="30" v-if="m.children">
                    <template #title>
                        <saet-icon :name="m.icon"></saet-icon>
                        <span>{{ m.title }}</span>
                    </template>
                    <template v-for="(m2, m2Index) in m.children">
                        <el-sub-menu :index="m2.id.toString()" v-if="m2.children">
                            <template #title>
                                <saet-icon :name="m2.icon"></saet-icon>
                                <div class="title">{{ m2.title }}</div>
                            </template>
                            <template v-for="m3 in m2.children">
                                <el-sub-menu :index="m3.id.toString()" v-if="m3.children">
                                    <template #title>
                                        <saet-icon :name="m3.icon"></saet-icon>
                                        <div class="title">{{ m3.title }}</div>
                                    </template>
                                    <template v-for="m4 in m3.children">
                                        <el-menu-item :index="m4.id.toString()" @click="setMenu(m4)">
                                            <saet-icon :name="m4.icon"></saet-icon>
                                            <div class="title">{{ m4.title }}</div>
                                        </el-menu-item>
                                    </template>
                                </el-sub-menu>
                                <el-menu-item :index="m3.id.toString()" v-else @click="setMenu(m3)">
                                    <saet-icon :name="m3.icon"></saet-icon>
                                    <div class="title">{{ m3.title }}</div>
                                </el-menu-item>
                            </template>
                        </el-sub-menu>
                        <el-menu-item :index="m2.id.toString()" v-else @click="setMenu(m2)">
                            <saet-icon :name="m2.icon"></saet-icon>
                            <div class="title">{{ m2.title }}</div>
                        </el-menu-item>
                    </template>
                </el-sub-menu>

                <el-menu-item :index="m.id.toString()" @click="setMenu(m)" :id="'menu_' + m.id">
                    <saet-icon :name="m.icon"></saet-icon>
                    <template #title>{{ m.title }}</template>
                </el-menu-item>
            </template>
        </el-menu>
    </el-scrollbar>
</template>
<script >
new SaetComponent({
    name: 'st-sub-menu',
    template: '#st-sub-menu',
    props: {
        menuList: Array
    }, setup(props, context) {

        const store = Vuex.useStore();
        const subMenuList = Vue.computed(() => {
            return props.menuList.children ? props.menuList.children : [props.menuList]
        })
        const adminTheme = reactive(store.state.adminTheme);

        const subMenuId = Vue.computed(() => {
            return store.state.subMenuId
        })

        function setMenu(e) {
            store.state.subMenuId = e.id
            store.state.mainMenuId = e.T_root_id
            context.emit('setMenu', e)
        }
        return { setMenu, subMenuId, subMenuList, adminTheme }
    }
})
</script>

<script>
new SaetApp({
    data() {
        return {
            isCollapse: false,
            isMinimize: false,
            loadEnd: false,
        };
    },
    created() {
        setTimeout(() => {
            this.loadEnd = true;
        }, 500);
        setTimeout(() => {
            // loading.close()
        }, 1000);
    },
    setup(props) {
        const store = Vuex.useStore();
        const adminTheme = reactive(store.state.adminTheme);
        return { adminTheme }
    },
    mounted() {
        for (let index = 0; index < ST.openMenuIds.length; index++) {
            const id = ST.openMenuIds[index];
            document.getElementById('menu_' + id).click();
        }
    },
    methods: {
        setActive(e) {
            switch (e.type) {
                case 'change':
                    this.activeTabId = e.menu.id
                    break;
                case 'push':
                    this.activeTabId = e.menu.id
                    this.openTabList.push(e.menu)
                    break;
            }
            var page_list = document.getElementsByClassName("saet-page-box");
            // 为了重新修改显示dom for循环无差别操作 循环过多可能有性能问题  赶时间 有更好解决此问题 请告知
            for (let i = 0; i < page_list.length; i++) {
                if (page_list[i].dataset.id == e.menu.id) {
                    page_list[i].style.display = "block";
                } else {
                    page_list[i].style.display = "none";
                }
            }
        }
    }
})
</script>
<style>
[v-cloak] {
    display: none;
}

:root {
    --layout-float-space: 12px;
    --layout-float-radius: 6px;
    --box-radius: 6px;
}

html,
#saetApp {
    height: 100%;
}

body {
    height: 100%;
    width: 100%;
}

html.layouting body {
    transition: all 300ms;
}

#saetApp>.body {
    width: calc(100% - var(--layout-float-space)*2);
    height: calc(100% - var(--layout-float-space) * 2);
    padding: var(--layout-float-space);
    transition: all 300ms;

}

#saetApp>.side-fixed {
    --layout-float-space: 0px;
    --layout-float-radius: 0px;
}

#saetApp>.side-fixed>aside {
    box-shadow: 10px 0 10px -10px rgb(0 0 0 / 8%);
    z-index: 1;
}

#saetApp>.side-float .saet-page-box {
    transition: all 300ms;
    margin: 0;
}

#saetApp>.side-fixed .saet-page-box {
    margin: 12px;
}

#saetApp>.side-fixed .saet-aside {
    border-right: 1px solid var(--el-border-color-lighter);
}

#saetApp>.side-fixed .saet-top {
    border-bottom: 1px solid var(--el-border-color-lighter);
}


.body {
    display: flex;
    flex-direction: row;
    height: 100%;
    flex: 1;
}


#saetApp {
    display: flex;
    flex-direction: row;
}

pages {
    /* margin-left: var(--layout-float-space); */
    padding-top: var(--layout-float-space);
}

/* .saet-page-box {
                                                            border-radius: var(--box-radius);
                                                            overflow: hidden;
                                                        } */

#nprogress .bar {
    background: var(--el-color-primary) !important;
}

#nprogress .peg {
    box-shadow: 0 0 10px var(--el-color-primary), 0 0 5px var(--el-color-primary) !important;
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

        app.mixin({ data() { return { ST: ST, St: St } } })

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
            setTimeout(() => {
                element.remove();
            }, 0);
        }
    }
</script>
</body>

</html>