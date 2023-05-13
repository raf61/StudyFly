<template>
    <div class="markdown-body bootstrap-iso" v-html="markdown(content)"></div>
    
</template>

<script>
export default {
    name:'Markdown'
}
</script>

<script setup>
import '../../css/bootstrap-iso.css'
import '../../css/github-markdown.css'
import markdown from '../helpers/markdown';
let {content} = defineProps({
    content:String
})
</script>

<style scoped>
.bootstrap-iso{
    word-wrap: break-word;
}
</style>

