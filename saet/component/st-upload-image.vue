<template id="st-image-upload">
    <el-upload v-drag="dragOptions" v-model:file-list="fileList"
        action="/admin.php/index/upload?_self=1" list-type="picture-card"
        :on-preview="handlePictureCardPreview" :on-exceed="handleExceed" multiple drag v-bind="config">
        <el-icon>
            <Plus />
        </el-icon>
    </el-upload>
    <el-image :initial-index="previewList.findIndex((item) => item == previewUrl)"
        style="width:0px;height:0px;display: block;" :src="previewUrl" id="st-image-upload-preview"
        :preview-src-list="previewList" preview-teleported></el-image>
</template>
<script>
 SaetComponent({
    name: 'st-image-upload',
    template: '#st-image-upload',
    props: { modelValue: [Array, String], resType: { type: String, default: 'string' }, config: { type: Object, default: {} } },
    setup(props, context) {
        let dom = '<style>.el-upload-list,.el-upload--picture-card{--el-upload-list-picture-card-size:80px !important;--el-upload-picture-card-size:80px !important;}</style>'
        document.getElementById('js-style').innerHTML += dom;

        Vue.defineEmits(['update:modelValue'])

        const dragOptions = [
            {
                selector: ".el-upload-list", // add drag support for row
                option: {
                    handle: '.el-upload-list__item',
                    animation: 150,
                    onEnd: (e) => {
                        let old = previewList.value[e.oldIndex].concat()
                        let new1 = previewList.value[e.newIndex].concat()
                        previewList.value[e.oldIndex] = new1
                        previewList.value[e.newIndex] = old
                    },
                },
            },
        ];

        const fileList = ref([])


        Vue.watch(
            () => props.modelValue,
            (n, o) => {
                if (props.modelValue && typeof (props.modelValue) == 'string') {
                    let list = St.string(props.modelValue).parseCSV(',', null)
                    let c = []
                    for (const url of list) {
                        c.push({ url: url })
                    }
                    fileList.value = c
                }
                if (!props.modelValue) {
                    fileList.value = []
                }
            }, { deep: true, immediate: true }
        )


        const handlePictureCardPreview = (e) => {
            previewUrl.value = e.response ? e.response.data : e.url
            setTimeout(() => {
                document.getElementById('st-image-upload-preview').click();
            }, 0);
        }
        const previewUrl = ref('')
        const previewList = ref([])
        Vue.watch(
            () => fileList.value,
            (n, o) => {
                let r = []
                for (let index = 0; index < fileList.value.length; index++) {
                    let e = fileList.value[index];
                    if (e.response) {
                        r.push(e.response.data)
                    } else {
                        r.push(e.url)
                    }
                }
                previewList.value = r
            }, { deep: true, immediate: true }
        )

        Vue.watch(
            () => previewList.value,
            (n, o) => {
                context.emit('update:modelValue', n.length > 0 ? (props.resType == 'string' ? St.string(n).toCSV(',', null).s : n) : '')
            }, { deep: true, immediate: false }
        )

        const handleExceed = (files, uploadFiles) => {
            St.message.warning(
                ` 最多只能上传 ${props.config.limit} 张`
            )
        }
        return { dragOptions, handlePictureCardPreview, previewUrl, previewList, fileList, handleExceed }
    }
})
</script>
<style>
.el-upload-dragger {
    width: calc(var(--el-upload-picture-card-size)-2px);
    height: 100%;
    padding: 0px !important;
    border: none !important;
    background-color: transparent;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>