<template>
    <div>
        <el-tabs type="border-card" v-model="defaultName">
            <el-tab-pane label="刷新" name="refresh" disabled>
                <template #label>
                    <el-button icon="refresh" size="small" circle @click="refresh" :loading="refreshIng"></el-button>
                </template>
            </el-tab-pane>
            <el-tab-pane :label="title" :name="name" v-for="(title, name) in groupList">
                <el-alert title="⚠️ 注意，请谨慎修改" type="warning" :closable="false" v-if="name == 'admin_theme'">
                    <template #default>
                        主题相关设置请点击，右上角 <img src="/static/saet/img/theme.png" style="width: 20px;height: 20px;"
                            alt="主题设置" />
                        图标设置，下方仅用于开发者调试全局默认配置
                    </template>
                </el-alert>
                <st-config :list="configList[name]" :url="ST.apiContUrl + '/edit_value'" @edit="edit"
                    :is-operation="true" @success="refresh()"></st-config>
            </el-tab-pane>
            <el-tab-pane label="添加" name="addConfig">
                <template #label>
                    <el-tag type="info" size="normal" effect="plain" @close="">
                        <saet-icon name="plus"></saet-icon>
                    </el-tag>
                </template>
                <st-config :list="addConfig" :url="ST.apiContUrl + '/add'" @success="addConfigSuccess()"
                    ref="addConfigRef" :is-Back="false"></st-config>
            </el-tab-pane>
        </el-tabs>
    </div>

    <el-dialog v-model="editShow" :title="'修改`' + editRow.title + '`配置项'">
        <st-config :list="editConfig" :url="ST.apiContUrl + '/edit'" @success="addConfigSuccess()" ref="editConfigRef"
            :is-Back="false"></st-config>
    </el-dialog>
</template>


{component is="st-config"/}

<script type="module">
new SaetApp({
    setup() {
        const groupList = ref(ST.groupList);
        const configList = ref(ST.configList);
        const defaultName = ref(Object.keys(groupList.value)[0])

        const typeList = {
            'text': '文本',
            'long-text': '长文本',
            'image': '图片',
            'array': '一维数组',
            'json': '键值对',
            'select': '下拉单选',
            'radio': '单选框'
        }

        const addConfig = ref([
            { name: 'group', title: '分组', type: 'select', option: groupList.value },
            { name: 'name', title: '键名', type: 'text' },
            { name: 'title', title: '名称', type: 'text' },
            { name: 'type', title: '类型', type: 'select', option: typeList, value: Object.keys(typeList)[0] },
            { name: 'option', title: '预选值', type: 'json', visible: false },
            { name: 'value', title: '默认值', type: 'text' },
        ])


        const valueType = Vue.computed(() => {
            return addConfig.value.find((item) => item.name == 'type')['value']
        })


        Vue.watch(
            () => valueType,
            (n, o) => {
                let i = addConfig.value.findIndex((item) => item.name == 'value')
                if (n.value != o.value) addConfig.value[i].value = null;
                addConfig.value[i].type = n.value
                let i2 = addConfig.value.findIndex((item) => item.name == 'option')
                if (n.value == 'select' || n.value == 'radio') {
                    addConfig.value[i2].visible = true
                } else {
                    addConfig.value[i2].visible = false
                }
            }, { deep: true, immediate: false }
        )


        const optionValue = Vue.computed(() => {
            return addConfig.value.find((item) => item.name == 'option')['value']
        })

        Vue.watch(
            () => optionValue,
            (n, o) => {
                let i = addConfig.value.findIndex((item) => item.name == 'value')
                addConfig.value[i].option = n.value ? JSON.parse(n.value) : ''
            }, { deep: true, immediate: true }
        )

        const refreshIng = ref(false)
        const refresh = () => {
            refreshIng.value = true
            St.axios.get('').then((res) => {
                refreshIng.value = false
                groupList.value = res.groupList
                configList.value = res.configList
                addConfig.value = addConfig.value
                let groupIndex = addConfig.value.findIndex((item) => item.name == 'group')
                addConfig.value[groupIndex].option = groupList.value
            }).catch(() => {
                refreshIng.value = false
            })
        }

        const addConfigRef = ref()
        const addConfigSuccess = () => {
            refresh()
            addConfigRef.value.reset()
        }

        const editShow = ref(false)
        const editRow = ref([])
        const editConfig = ref(St.copy(addConfig.value))
        const edit = (row) => {
            editConfig.value.forEach((e, i) => {
                editConfig.value[i].value = row[e.name]
            });
            editShow.value = true
            editRow.value = row
        }


        return { defaultName, addConfig, refresh, refreshIng, groupList, configList, addConfigRef, edit, editRow, editShow, addConfigSuccess, editConfig }
    }
})


</script>
<style>
.el-tabs--border-card {
    border-radius: 5px;
}

.el-tabs--border-card>.el-tabs__header {
    border-radius: 5px 5px 0 0;
}


.config-item {
    display: flex;
    padding: 10px 0;
    border-bottom: 1px solid var(--el-fill-color-light);
}

.config-item .title {
    width: 120px;
    padding-left: 10px;
    color: var(--el-text-color-secondary);
    font-size: 14px;
    font-weight: 500;
}

.config-item .content {
    display: flex;
    width: 500px;
}
</style>




