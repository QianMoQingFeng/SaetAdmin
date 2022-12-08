
<template>
    <div>
        <st-table :list="ST.list" :total="ST.total" :fields="fields" :config="config"
            :table-default-config="tableConfig">
        </st-table>
    </div>
</template>

{component is="st-table"/}
<script src="//cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
<script>
    new SaetApp({
        setup() {
            const fields = ref([
                { case: 'selection' },
                { name: 'id', title: 'ID' },
                {
                    name: 'title', title: '名称', align: 'left', customValue(v, row, i) {
                        let nbsp = '', t = '';
                        for (let i = 0; i < row.T_level; i++) nbsp += '&nbsp;';
                        if (row.T_level > 0) t = row.T_index + 1 == row.T_last_total ? '└' : '├';
                        return nbsp + t + ' ' + v
                    },
                },
                { name: 'icon', title: '图标', case: 'icon' },
                { name: 'url', title: '规则', case: 'copy' },
                { case: 'tree' },
                { name: 'is_menu', title: '菜单', case: 'switch', search: { type: 'radio' } },
                { name: 'create_time', title: '创建时间', search: [ { type: 'datetimerange' },{ type: 'datetimerange' }] },
                { case: 'operation' },
            ])
            const config = ref({page: { pageSize: 1000 } })
            const tableConfig = {
                'row-key': "id", border: true, 'row-class-name'(e) {
                    return [ e.row.isDelSuccess == true ? 'del-animation' : '', e.row.is_menu_nav == 0 ? 'is-no-menu' : '']
                }
            }
            return {fields,config,tableConfig}
        }
    })
</script>
<style>
.el-table__row.is-no-menu {
    color: var(--el-color-info-light-3);
}
</style>