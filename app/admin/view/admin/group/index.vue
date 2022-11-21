
<template>
    <div>
        <st-table :list="ST.list" :total="ST.total" :fields="fields">
            <template #auth_set="{ row, index }">
                <div v-if="row">
                    <span v-if="row.rule_ids == '*'">无限制</span>
                    <el-button v-else type="primary" plain @click="openSet(row)">设置权限</el-button>
                </div>
            </template>
        </st-table>
    </div>
</template>

{component is="st-table"/}

<script>
new SaetApp({
    setup() {
        const fields = [
            { case: 'selection' },
            { name: 'id', title: 'id' },
            { name: 'name', title: '名称' },
            { name: 'badge', title: '徽章', case: 'image' },
            { name: 'create_time', title: '创建时间', search: { type: 'datetimerange' } },
            { name: 'update_time', title: '更新时间', search: { type: 'datetimerange' } },
            { name: 'auth_set', title: '权限', case: 'slot' },
        ]
        const openSet = (e) => {
            St.window.open({
                title: '设置权限', 'custom-class': 'adadad', url: 'auth?_self=1&id=' + e.id
            })
        }
        return { fields, openSet }
    }
})
</script>