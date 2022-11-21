<template>
    <div class="body" id="frame-entrance" :class="'side-' + adminTheme.side_type">
        <side-left ref="saetMenu"></side-left>
        <main style="display: flex;flex: 1;flex-direction: column;">
            <side-top ref="saetTop"> </side-top>
            <pages></pages>
        </main>
    </div>
</template>

    {include file="/index/components/side-top" /}
    {include file="/index/components/side-left" /}
    {include file="/index/components/main-menu" /}
    {include file="/index/components/sub-menu" /}

<script type="module">

import { store } from '/app_static/admin/js/store.js'

new SaetApp({
    setup() {
        const adminTheme = reactive(store.adminTheme);
        if (window.innerWidth < 700 && adminTheme.menu.minisize_auto) { adminTheme.menu.minimize = true; adminTheme.menu.menu_float = true; }
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
