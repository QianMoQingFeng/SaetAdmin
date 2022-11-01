
{layout name="../addons/edoc/view/public/layout.html" /}
<template>
    <div class="doc-main">
        <!-- 左侧菜单 -->
        <el-scrollbar class="menu" height="100vh" w always @scroll="scroll">
            <div style="height: 30px;"></div>
                <el-menu :default-active="id.toString()" :default-openeds="ST.openAllMenu" class="menu-body">
                    <menu-tree :list="ST.menuListTree" @choose="chooseMenu"></menu-tree>
                </el-menu>
            <div style="height: 30px;"></div>
        </el-scrollbar>
        <div style="width:200px"></div>
     <div class="main">
        <div id="content" >
                    <template v-for="(doc,index) in openDocList">
                        <div class="content-box" v-show="doc.visible">
                            <div class="doc-content">
                                <h1>{{doc.title}}</h1>
                                <div :id="'doc'+doc.id" v-html="doc.content"></div>
                            </div>
                            <div style="width:200px"></div>
                            <div style="width:200px;position: fixed;right: 0;padding-top: 40px;">
                                <span style="" class="nav-title">CONTENTS</span>
                                <el-tabs tab-position="right" :model-value="scrollIndex"
                                    :class="{'no':scrollIndex == -1}" @tab-click="(e)=>navClick(e,index)">
                                    <el-tab-pane v-for="(nav,index) in doc.navs" :label="nav.title" :name="index">
                                        <template #label>
                                            <el-link :href="'#'+nav.title">{{nav.title}}</el-link>
                                        </template>
                                    </el-tab-pane>
                                </el-tabs>
                            </div>
                        </div>
                    </template>
                </div>
                <el-backtop :right="100" :bottom="100" ></el-backtop>
     </div>
        <!-- </el-scrollbar> -->

    </div>
</template>

{component is="st-table"/}
<script>
console.log('Prism', Prism);
new SaetApp({
    setup() {
        const menuList = reactive(ST.menuList);
        const openDocList = ref([])
        const id = ref(ST.menuListTree[0]['children'][0].id ?? ST.menuList[0].id);
        const row = Vue.computed(() => menuList.find((item) => item.id == id.value) ?? {})
        if (ST.row) {
            id.value = ST.row.id
        }

        const hideAll = (exclude_id) => {
            for (let i = 0; i < openDocList.value.length; i++) {
                const e = openDocList.value[i];
                if (exclude_id != e.id) {
                    openDocList.value[i].visible = false
                }
            }
        }


        // 文档内切换
        const navClick = (e, index) => {
            let offsetTop = openDocList.value[index].navs[e.index].offsetTop
            window.scrollTo(0, offsetTop)
            // 动画 -- 已关闭
            // let nowTop = docScrollRef.value.wrap$.scrollTop;
            // const d = offsetTop - nowTop
            // if (d < 0) {
            //     console.log(d);
            // }
            // let scrolling = setInterval(() => {
            //     nowTop += d / 80
            //     window.scrollTo(0, nowTop)
            //     if (nowTop >= offsetTop) {
            //         window.scrollTo(0, offsetTop)
            //         clearInterval(scrolling)
            //     }
            // }, 1)

        }



        const getContent = (new_id) => {

            let isHave = openDocList.value.findIndex((e) => e.id == new_id);
            if (isHave > -1) {
                hideAll(openDocList.value[isHave].id)
                openDocList.value[isHave].visible = true
                window.scrollTo(0, 0)
                return
            }

            NProgress.start();
            St.axios.get('/addons/edoc/doc/item', { params: { id: new_id } }).then((e) => {
                let index = menuList.findIndex((e) => e.id == new_id);
                // console.log(e);
                //  e = marked.parse(e)
                menuList[index].content = e
                menuList[index].visible = true
                let length = openDocList.value.push(menuList[index])
                hideAll(menuList[index].id)
                window.scrollTo(0, 0)
                setTimeout(() => {
                    let tags = ['H2', 'H3', 'H4', 'H5']
                    let docBox = document.getElementById('doc' + menuList[index].id);
                    let level = 0;
                    let arr = [];
                    let offsetTop = [];
                    for (let i = 0; i < docBox.childNodes.length; i++) {
                        let c = docBox.childNodes[i];
                        if (tags.includes(c.tagName)) {
                            let newlevel = parseInt(c.tagName.split("").reverse().join(""))
                            if (level < newlevel) level -= 1;
                            if (level > newlevel) level += 1;
                            if (level = newlevel) level = newlevel;
                            arr.push({
                                title: c.innerText,
                                level: level - 2,
                                offsetTop: c.offsetTop
                            })
                            offsetTop.push(c.offsetTop)
                        }
                    }
                    openDocList.value[length - 1].navs = arr
                    openDocList.value[length - 1].offsetTop = offsetTop
                    let navTitle = decodeURIComponent(window.location.hash.slice(1));
                    if (navTitle) {
                        let row = arr.find((item) => item.title == navTitle)
                        console.log(row);
                        window.scrollTo(0, row.offsetTop)
                    }

                }, 0)
                setTimeout(() => {
                    Prism.highlightAll()
                    NProgress.done();
                }, 0);
            })
        }
        const scrollIndex = ref(-1);

        const scroll = (e) => {
            if (e.scrollTop < 1) {
                scrollIndex.value = -1
            }
            let index = openDocList.value.findIndex((item) => item.id == id.value)
            if (index > -1 && openDocList.value[index].navs.length > 0) {
                let offsetTops = openDocList.value[index].offsetTop;
                for (let i2 = 0; i2 < offsetTops.length; i2++) {
                    let offsetTop = offsetTops[i2];
                    if (offsetTop <= e.scrollTop) {
                        scrollIndex.value = i2
                    }
                }
            }
        }

        // 文档切换
        Vue.watch(
            () => id,
            (n, o) => {
                getContent(n.value)
                let row = ST.menuList.find((item) => item.id == n.value);
                console.log('row', row);
                // console.log(n.value);
                // var activeTab = openTabList.value[activeTabIndex];
                document.title = row.title;
                window.history.pushState({}, row.title, `/edoc/${row.group.name}/${row.diyname ?? row.id}`);

            }, { deep: true, immediate: true }
        )
        const chooseMenu = (row) => {
            id.value = row.id
        }

        return { chooseMenu, id, row, getContent, openDocList, navClick, scroll, scrollIndex }
    },

})
</script>

<template id="menu-tree">
    <template v-for="v in list">
        <el-sub-menu :index="v.id.toString()" v-if="v.children">
            <template #title>
                <span>{{v.title}}</span>
            </template>
            <menu-tree :list="v.children" @choose="chooseMenu"></menu-tree>
        </el-sub-menu>
        <el-menu-item :index="v.id.toString()" @click="choose(v)" v-else>
            <span>{{v.title}}</span>
        </el-menu-item>
    </template>
</template>

<script>


    new SaetComponent({
        name:'menu-tree',
        template:'#menu-tree',
        props:{
            list:Array
        },
        setup(props,context) {
            const choose = (row)=>{
                console.log('choose',row);
                console.log(context);
                context.emit('choose',row)
      
            }
            const chooseMenu = (row) => {
                context.emit('choose',row)
            }
            return {choose,chooseMenu}
        }
    })
</script>
<style>
html,
body {
    width: 100%;
    height: 100vh;
    font-size: 16px;
}

.doc-main {
    display: flex;
    flex-direction: row;
}

.doc-main .menu{
    width: 200px;
    position: fixed;
    top: 0;
    bottom: 0;
}

.doc-main .el-scrollbar.menu .el-scrollbar__view {
    width: 200px;
}

.doc-main .el-menu {
    --el-menu-base-level-padding: 10px;
    --el-menu-item-height: 40px;
    border-right: 0px;
    padding: 0 10px;
}

.doc-main .el-menu .el-sub-menu .el-menu-item {
    min-width: 0px;
}

.doc-main .menu-body>li {
    margin-bottom: 20px;
}

.doc-main .el-menu>.el-sub-menu>.el-sub-menu__title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--el-text-color-primary);
    margin-bottom: 8px;
}

.doc-main .el-menu .el-menu-item {
    cursor: pointer;
    font-weight: 500;
    height: 40px;
    font-size: 13px;
    --el-menu-level: 0;
}

.doc-main .el-menu .el-menu-item:not(.is-active) {
    color: var(--el-text-color-regular);
}

.doc-main .el-sub-menu__title:hover {
    background-color: transparent;
}

.doc-main .el-menu-item:hover {
    background-color: transparent;
    color: var(--el-color-primary);
}

.doc-main .el-menu .el-menu-item.is-active {
    --el-menu-item-height: 40px;
    background-color: var(--el-color-primary-light-9);
    border-radius: 5px;
}

.doc-main .main {
    flex: 1;
}

.doc-main .main .el-scrollbar__wrap {
    flex: 1;
}

.doc-main .main #content {
    flex: 1;

}

.doc-main .main #content .content-box {
    flex: 1;
    display: flex;
    flex-direction: row;
}

.doc-main .main #content .content-box .doc-content {
    flex: 1;
    padding: 40px;
    width: 0;
}

.doc-main .nav-title {
    font-size: 12px;
    color: var(--el-text-color-regular);
    font-weight: 600;
    text-transform: uppercase;
    margin-top: 0;
    padding-left: 19px;
}


.doc-main table {
    border-collapse: collapse;
    width: 100%;
    background-color: var(--bg-color);
    font-size: 14px;
    line-height: 1.5em;
}

.doc-main table tr td:nth-child(2) {
    font-family: var(--font-family)
}

.doc-main table th,
.doc-main table td {
    white-space: nowrap;
    border-top: 1px solid var(--border-color);
    border-bottom: 1px solid var(--border-color);
    padding: .6em 1em;
    text-align: left;
    max-width: 250px;
    white-space: pre-wrap
}

.doc-main table thead tr:first-child th {
    border-top: none
}


@keyframes show {
    0% {
        transform: translateY(-20px);
    }

    100% {
        transform: translateY(0px);
    }
}

@keyframes remove {
    100% {
        margin-top: -20px;
    }
}

.el-tabs--right .el-tabs__active-bar.is-right {
    width: 5px !important;
}

.el-tabs .el-link {
    font-size: 12px;
    font-weight: 500;
    color: var(--el-text-color-secondary);
}

.el-tabs .is-active .el-link {
    color: var(--el-color-primary);
}

.el-tabs:not(.no) .el-tabs__active-bar {
    animation: show 300ms;
}

.el-tabs .el-tabs__active-bar {
    transition-property: width, opacity, transform;
}

.el-tabs.no .el-tabs__active-bar {
    opacity: 0;
    animation: remove 1000ms;
}

.el-tabs__header {
    width: 100%;
}

.el-tabs--right .el-tabs__nav-wrap.is-right::after {
    width: 0px;
}

.el-tabs--right .el-tabs__active-bar.is-right {
    width: 6px;
    border-radius: 6px;
    margin-left: 1px;
    height: 16px !important;
    margin-top: 4px;
}

.el-tabs__item {
    --el-font-size-base: 13px;
    --el-tabs-header-height: 24px;
}

body {
    font-size: 16px;
    color: var(--el-text-color-primary);
    font-family: Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB, Microsoft YaHei, \5fae\8f6f\96c5\9ed1, Arial, sans-serif;
}

h1 {
    font-size: 2.2rem;
    margin-bottom: 2rem;
}

h1,
h2,
h3,
h4,
h5,
h6 {
    color: var(--el-text-color-regular);
    font-weight: inherit;
}

h1,
h2,
h3,
h4,
h5,
h6,
strong,
b {
    font-weight: 600;
}

h2 {
    padding-top: 2.25rem;
    margin-bottom: 1.25rem;
    padding-bottom: 0.3rem;
    line-height: 1.25;
    font-size: 1.4rem;
}

p,
ol,
ul {
    margin: 1rem 0;
    line-height: 1.7;
}
</style>