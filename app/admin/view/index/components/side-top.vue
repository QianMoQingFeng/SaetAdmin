
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
                        :disabled="'{$adminTheme[\'theme\']}' == 'system' ? true : false">
                        <div @click="changeTheme(relTheme == 'dark' ? 'light' : 'dark', true,true)" class="theme-toggler">
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
                        <img src="/static/saet/img/theme.png" style="width: 20px;height: 20px;" alt="主题设置">
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
                                        <el-image src="/static/saet/img/system.png"></el-image>
                                    </div>
                                    <div class="desc">跟随系统</div>
                                </div>
                                <div class="item" :class="{ 'active': adminTheme.theme == 'dark' }"
                                    @click="changeTheme('dark', true)">
                                    <div class="image">
                                        <el-image src="/static/saet/img/dark.png"></el-image>
                                    </div>
                                    <div class="desc">深色</div>
                                </div>
                                <div class="item" :class="{ 'active': adminTheme.theme == 'light' }"
                                    @click="changeTheme('light', true)">
                                    <div class="image">
                                        <el-image src="/static/saet/img/light.png"></el-image>
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


<script type="module">

import {store} from '/addons/admin/js/store.js'
 
 SaetComponent({
    name: 'title-tree',
    props: { list: Array, level: Number, idTree: Array },
    template: `<template v-for="(v, index) in list"><template v-if="idTree[level] == v.id"><el-breadcrumb-item class=""> {{  v.title  }}  </el-breadcrumb-item></template><title-tree :list="v.children" v-if="v.children" :level="level+1" :id-tree="idTree"></title-tree></template>`,
})

 SaetComponent({
    template: '#side-top',
    name: 'side-top',
    setup(props, context) {
        const adminBtnRef = ref()
        const adminInfoRef = ref()
        const drawer = ref(false)
        const openTabList = Vue.computed(() => { return store.openTabList });
        const adminTheme = reactive(store.adminTheme);
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
        const tabActiveId = Vue.computed(() => { return store.tabActiveId });

        // 一级菜单
        const mainMenuId = Vue.computed(() => { return store.mainMenuId });
        // 二级菜单
        const subMenuId = Vue.computed(() => { return store.subMenuId });
        const changeTab = (id) => {
            let menu = openTabList.value.find((item) => item.id == id);
            store.subMenuId = menu.id
            store.mainMenuId = menu.T_root_id
            store.tabActiveId = menu.id
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



        const changeTheme = (theme, b,c) => {
            if (b === true) adminTheme.theme = theme
            if (theme == 'system') {
                const isDarktheme = window.matchMedia("(prefers-color-scheme: dark)").matches
                theme = isDarktheme ? 'dark' : 'light'
            }
            relTheme.value = theme;
            changeDomTheme()
            // 改变并保存
            if(c === true){
                St.cookie.set('admin_theme', JSON.stringify(adminTheme))
            }
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
            store.openTabList.splice(index, 1);
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
