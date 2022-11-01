<template>
    <saet-table :list="ST.list" :total="ST.total" :fields="fields">
       
    </saet-table>
</template>

{component is="st-table"/}

<script>
new SaetApp({
    data() {
        return {
            fields: [
                { case: 'selection' },
                { name: 'id', title: 'id' },
                {
                    name: 'title', title: '名称'
                },
                {
                    name: 'diyname', title: '地址', case: 'copy', customValue(value, row) {
                        if (row.group) return `/edoc/${row.group.name}/${value ?? row.id}`;
                    }
                },
                { name: 'weight', title: '权重' },
                { case: 'operation' },
            ]
        }
    }
})
</script>