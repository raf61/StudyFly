<template>
  <img :src="$asset('/images/logo'+ (full ? '-full' : '')+'.png')" :width="width" alt="" />
</template>

<script>
export default {
    name:'Logo',
    props:{
        width:{type:Number, default:70},
        full:{type:Boolean, default:false}
    }
}
</script>
