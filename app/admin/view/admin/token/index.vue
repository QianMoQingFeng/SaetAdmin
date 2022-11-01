<template>
    <div>
        <saet-table :list="ST.list ?? []" :total="ST.total ?? 0" :fields="fields"> </saet-table>
    </div>
</template>

{component is="st-table"/}

<script>
    new SaetApp({
        setup() {
            const fields = [
                { case: 'selection' },
                { name: 'id', title: 'ID' },
                { name: 'aid', title: '管理员ID' },
                { name: 'token', title: 'Token', case: 'copy' },
                { name: 'create_time', title: '创建时间', search: { type: 'datetimerange' } },
                { name: 'create_time', title: '生效时间', search: { type: 'datetimerange' } },
                { name: 'expire_time', title: '失效时间', search: { type: 'datetimerange' } },
                { name: 'is_temporary', title: '是否临时', case: 'switch', search: { type: 'radio' } },
                { case: 'operation' }
            ]
            return { fields }
        }
    })
</script>
