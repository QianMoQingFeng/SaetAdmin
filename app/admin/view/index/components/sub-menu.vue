
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
<script type="module">
import {store} from '/app_static/admin/js/store.js';
console.log('store',store.adminTheme);
 SaetComponent({
    name: 'st-sub-menu',
    template: '#st-sub-menu',
    props: {
        menuList: Array
    }, setup(props, context) {

        const subMenuList = Vue.computed(() => {
            return props.menuList.children ? props.menuList.children : [props.menuList]
        })
        const adminTheme = reactive(store.adminTheme);

        const subMenuId = Vue.computed(() => {
            return store.subMenuId
        })

        function setMenu(e) {
            store.subMenuId = e.id
            store.mainMenuId = e.T_root_id
            context.emit('setMenu', e)
        }
        return { setMenu, subMenuId, subMenuList, adminTheme }
    }
})
</script>