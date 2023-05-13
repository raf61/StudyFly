<template>
  <Head title="Sign in" />  
  <div class='flex items-center justify-center h-screen'>
    <main class='mb-32'>
      <LoginForm :="$props"/>
      <p class="text-sm border rounded-sm p-4 w-72 mx-auto mt-4 text-center">
          New to StudyFly ?&nbsp;&nbsp;
          <Link class="text-blue-600" :href="$route('account.index')">Create an account</Link>.
        </p>
    </main>
  </div>

  

</template>
<script>
export default {name:'Login'}
</script>

<script setup>
import LoginForm from '../../Components/LoginForm.vue';
const props = defineProps({
  errors:Object
})


</script>
