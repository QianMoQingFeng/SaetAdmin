
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
<script type="module">
import { store } from '/addons/admin/js/store.js'
 SaetComponent({
    name: 'st-main-menu',
    template: '#st-main-menu',
    props: {
        menuList: Array
    }, setup(props, context) {

        const adminTheme = reactive(store.adminTheme);

        const setMenu = (e) => {
            // if (adminTheme.menu_type == 'main-sub') return context.emit('setSubMenu', e);
            context.emit('setSubMenu', e)
        }
        const mainMenuId = Vue.computed(() => { return store.mainMenuId })
        const subMenuId = Vue.computed(() => { return store.subMenuId })

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
