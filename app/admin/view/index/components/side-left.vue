<template  id="side-left">
    <div class="minimize-mask" @click="adminTheme.menu.minimize = true" v-if="adminTheme.menu.menu_float"
        :class="{ 'is-open': !adminTheme.menu.minimize }">
    </div>
    <aside
        :class="['side-left', { 'is-minimize': adminTheme.menu.minimize }, { 'menu-float': adminTheme.menu.menu_float }]">
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
                    <span class="nickname">{{ ST.admin.nickname }}</span>
                    <span class="username">{{ ST.admin.username }}</span>
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
                        <div class="st-flex" style="flex:1;"></div>
                        <el-button @click="" text class="design-btn">
                            <img src="/static/saet/img/theme.png" style="width: 20px;height: 20px;" alt="主题设置">
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
 
<script type="module">
import { store } from '/app_static/admin/js/store.js'
store.adminTheme.menu_type = 'main';

SaetComponent({
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
        const adminTheme = reactive(store.adminTheme);
        const isMainCollapse = Vue.computed(() => {
            let r = adminTheme.menu_type == 'main-sub' ? true : false
            return r
        })

        window.addEventListener('resize', () => {
            if (adminTheme.menu.minisize_auto) {
                if (window.innerWidth < 700) {
                    adminTheme.menu.menu_float = true
                    adminTheme.menu.minimize = true
                } else {
                    adminTheme.menu.menu_float = false
                    setTimeout(() => {
                        adminTheme.menu.minimize = false
                    }, 10);
                }
            }
        })

        // 一级菜单
        const mainMenuId = Vue.computed(() => { return store.mainMenuId });
        // 二级菜单
        const subMenuId = Vue.computed(() => { return store.subMenuId });
        // const subMenuList = ref(ST.menuListTree.find((item) => item.id == ST.openMenu.T_root_id));
        const subMenuList = ref();

        const setSubMenu = (e) => {
            if (!e.children) { openIfarm(e); store.subMenuId = e.id }
            store.mainMenuId = e.T_root_id
            subMenuList.value = e
        }


        // 监听子菜单变化
        Vue.watch(
            () => mainMenuId,
            (n, o) => {
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

        const openTabList = Vue.computed(() => { return store.openTabList });

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
                store.tabActiveId = e.id
                store.openTabList.push(e)
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
                store.tabActiveId = e.id
                context.emit('setActive', { menu: e, type: 'change' });
            }
        }
        const logout = () => {
            // 登出
            St.axios.post('index/logout', this.formData, { loadingToast: true, successToast: true }).then((res) => {
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
    border-right-width: 0px;
}

/* @media only screen and (max-width: 991px) { */

.side-left.menu-float {
    position: fixed;
    left: 0;
    height: 100vh;
    z-index: 10000 !important;
    transition: transform 400ms;
}

.side-left.menu-float.is-minimize {
    transform: translateX(calc(-100% - var(--layout-float-space)));
}

.side-left.menu-float.is-minimize>.side1,
.side-left.menu-float.is-minimize>.side2 {
    width: fit-content;
    min-width: auto;
}

.side-float .side-left.menu-float {
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
    z-index: 2999;
    opacity: .42;
    animation: minimizeMask 500ms;
}

/* } */
</style>
