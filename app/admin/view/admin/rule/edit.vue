<template>
    <st-form :data="row" :fields="fields">
        <template #icon>
            <el-input v-model="row.icon" placeholder="">

                <template #prepend>
                    <el-button :icon="row.icon" style="color:var(--el-color-primary);font-weight: 700;"></el-button>
                </template>

                <template #append>
                    <el-button @click="iconListVisible = true">选择</el-button>
                </template>
            </el-input>
        </template>
    </st-form>

    <el-drawer v-model="iconListVisible" direction="btt" size="75%" :with-header="false" v-if="isMounted">
        <template #default>
            <el-tabs type="border-card" stretch>
                <el-tab-pane>
                    <template #label>
                        <div class="st-flex align-center justify-center">
                            <el-icon :size="20" class="st-m-r-4">
                                <element-plus />
                            </el-icon>
                            <span>ElementIcon</span>
                        </div>
                    </template>
                    <div style="height:calc(75vh - 114px);overflow: auto;" v-infinite-scroll="addElPage"
                        :infinite-scroll-distance="50" :infinite-scroll-disabled="elDisabled"
                        :infinite-scroll-immediate="false">
                   
                        <el-alert type="success">
                            <el-link type="primary"
                                href="https://element-plus.gitee.io/zh-CN/component/icon.html#%E5%9B%BE%E6%A0%87%E9%9B%86%E5%90%88"
                                target="_blank">点击前往来源｜element-plus</el-link>
                        </el-alert>
                        <el-row class="row-bg">
                            <template v-for="name in elIconsList" :key="name">
                                <el-col :span="4" class="st-m-t-10" @click="chooseIcon(name)">
                                    <el-icon :size="24">
                                        <component :is="name"></component>
                                    </el-icon>
                                </el-col>
                            </template>
                        </el-row>
                        <p v-if="elLoading">Loading...</p>
                        <p v-if="elNoMore">No more</p>
                    </div>
                </el-tab-pane>
                <el-tab-pane>
                    <template #label>
                        <div class="st-flex align-center justify-center">
                            <el-icon :size="20" class="st-m-r-4">
                                <ri-remixicon-line />
                            </el-icon>
                            <span>RemixIcon</span>
                        </div>
                    </template>
                    <div style="height:calc(75vh - 114px);overflow: auto;" v-infinite-scroll="addRePage"
                        :infinite-scroll-distance="50" :infinite-scroll-disabled="reDisabled"
                        :infinite-scroll-immediate="false">
                        <el-alert type="success">
                            <el-link type="primary" href="https://remixicon.cn/" target="_blank">点击前往来源｜remixicon.cn</el-link>
                        </el-alert>
                        <el-row class="row-bg">
                            <template v-for="name in reIconsList" :key="name">
                                <el-col :span="4" class="st-m-t-10" @click="chooseIcon(name)">
                                    <el-icon :size="24">
                                        <component :is="name"></component>
                                    </el-icon>
                                </el-col>
                            </template>
                        </el-row>
                        <p v-if="reLoading">Loading...</p>
                        <p v-if="reNoMore">No more</p>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </template>
    </el-drawer>

</template>

{component is="st-form"/}

<script>

new SaetApp({
    setup() {
        const isMounted = ref(false)
        Vue.onMounted(() => {
            isMounted.value = true
        })
        const row = ref(ST.row || {})

        const fields = ref([
            { name: 'pid', title: '上级分类' },
            { name: 'addons', title: '插件分组' },
            { name: 'title', title: '标题' },
            { name: 'desc', title: '描述' },
            { name: 'url', title: 'URL' },
            { name: 'weight', title: '排序权重' },
            { name: 'is_menu', title: '是否菜单' },
            { name: 'menu_type', title: '菜单类型' },
            { name: 'icon', case: 'slot', title: '菜单图标' },
        ])
        const iconListVisible = ref(true)
        const limit = 100;
        const elIcons = ref(Array.from(Object.entries(ElementPlusIconsVue), x => x[0]))
        const elIconsList = ref(elIcons.value.slice(0, 100))


        const elLoading = ref(false)
        const elNoMore = Vue.computed(() => elPageLast.value >= elIcons.length)
        const elDisabled = Vue.computed(() => elLoading.value || elNoMore.value)

        const elPageLast = ref(100)

        const addElPage = () => {
            elLoading.value = true
            setTimeout(() => {
                elIconsList.value.push(...elIcons.value.slice(elPageLast.value, elPageLast.value + limit))
                elPageLast.value = elPageLast.value + limit
                elLoading.value = false
            }, 100);
        }

        const reIcons = ref(RemixIcons)
        const reIconsList = ref(reIcons.value.slice(0, 100))
        const rePageLast = ref(100)
        const reLoading = ref(false)
        const reNoMore = Vue.computed(() => rePageLast.value >= reIcons.length)
        const reDisabled = Vue.computed(() => reLoading.value || reNoMore.value)
        const addRePage = () => {
            reLoading.value = true
            setTimeout(() => {
                reIconsList.value.push(...reIcons.value.slice(rePageLast.value, rePageLast.value + limit))
                rePageLast.value = rePageLast.value + limit
                reLoading.value = false
            }, 100);
        }

        const chooseIcon = (v) => {
            console.log(v);
            row.value.icon = v
            iconListVisible.value = false
        }

        return { row, fields, iconListVisible, elIconsList, reIconsList, addElPage, addRePage, isMounted, elLoading, elNoMore, elDisabled, reLoading, reNoMore, reDisabled, chooseIcon }
    }
})
</script>