<template>
  <Modal>
      <LoginForm 
      @error="handleLoginError" 
      @success="handleLoginSuccess"
      :options="options"
      />
  </Modal>
</template>

<script>
export default {
    name:'AuthModal'
}
</script>
<script setup>
import Modal from './Modal.vue'
import LoginForm from './LoginForm.vue'
import { useToast } from 'vue-toastification'
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const toast = useToast()
const flash = computed(() => usePage().props.flash)

const options = {
  headers:{
      "X-Redirect-Back":"true"
  }
}
const emit = defineEmits(['loginError','loginSuccess','registerError','registerSuccess'])

function handleLoginError(errors){
  emit('loginError', errors)
}

function handleLoginSuccess(){
  emit('loginSuccess')
  if (flash.value['success']){
    toast.success(flash.value['success'])
  }
  
}
</script>

<style>

</style>