<template>
    
    <span class="loader" style="width:size" :style="{width:size+'px', height:size+'px', 'border-width':Math.trunc(size*0.1)+'px'}"></span>
</template>

<script>
export default {
    name:'Loader'
}
</script>

<script setup>
let {size} = defineProps({
    size: {type:Number, default:40, required:false }
})

</script>

<style scoped>
.loader {
    border: solid rgb(62, 144, 221);
    border-bottom-color: transparent;
    border-radius: 50%;
    display: inline-block;
    box-sizing: border-box;
    animation: rotation .8s linear infinite;
    }

    @keyframes rotation {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
    } 

</style>