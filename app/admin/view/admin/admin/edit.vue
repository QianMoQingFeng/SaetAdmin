<template>
    <st-form :data="row" :fields="fields">
        <!-- <template #address>
            <el-cascader :options="ST.area" v-model="row['area_id']"></el-cascader>
        </template> -->
    </st-form>
</template>

{component is="st-form"/}

<script>
new SaetApp({
    setup() {
        const row = ref(ST.row || {})

        const fields = ref([
            { case: 'remote-select', name: 'city', title: '城市', required: true, alwaysUpdatet: true, url: ST.apiContUrl + '/get_field_list?field=city', 'allow-create': true },
            { case: 'remote-select', name: 'district', title: '区/县', required: true, alwaysUpdatet: true, url: only(ST.apiContUrl + '/get_field_list?field=district'), 'allow-create': true  },
            { case: 'remote-select', name: 'street', title: '街道', required: true, alwaysUpdatet: true, url: only(ST.apiContUrl + '/get_field_list?field=street') , 'allow-create': true },
            { case: 'text', name: 'latitude', title: '维度' },
            { case: 'text', name: 'longitude', title: '经度' },

        ])

        Vue.watch(
            () => row.value.city,
            (n, o) => {
                if (n != o) {
                    row.value.district = ''
                    row.value.street = ''
                }
                fields.value[1].url = only(ST.apiContUrl + '/get_field_list?field=district', { city: row.value.city })
            }, { deep: true, immediate: false }
        )
        Vue.watch(
            () => row.value.district,
            (n, o) => {
                if (n != o) {
                    row.value.street = ''
                }
                fields.value[2].url = only(ST.apiContUrl + '/get_field_list?field=street', { city: row.value.city, district: row.value.district })
            }, { deep: true, immediate: false }
        )
        return { row, fields }
    }
})
</script>