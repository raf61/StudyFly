<template>
  <Head title="Welcome! Sign Up" />  
<div class='flex items-center justify-center h-screen'>
    <main class='mb-32'>
      <div id="login">
        <form action="#" method="post" @submit.prevent="submit">
            
          <div>
            <h1 class="text-2xl font-light text-center">Welcome to StudyFly</h1>
            <h3 class='text-center mt-2'>Create an account</h3>
          </div>
          <div v-if="errors.invalid" class="mt-3 p-3 flex max-w-md justify-between flex-row-reverse bg-red-600 shadow-lg mx-auto rounded text-sm pointer-events-auto bg-clip-padding mb-3" id="static-example" role="alert" aria-live="assertive" aria-atomic="true" data-mdb-autohide="false">
            <button class='pl-3 flex items-center' @click="errors.invalid = ''">
              <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="times-circle" class="w-4 h-4 mr-2 fill-current" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z"></path>
              </svg>
            </button>
            <div class="bg-red-600 pl-5 flex-1rounded break-words text-white">
              {{ errors.invalid }}
            </div>
            
          </div>
          <div class="text-sm border rounded-sm bg-white p-4 w-72 mx-auto mt-4">

            <label class="block font-medium tracking-wide" for="username">Username</label>
            <span v-if="errors.username" class='text-xs text-red-600'>{{ errors.username }}</span>
            <input placeholder="Only letters and numbers" required v-model="form.username" class="mb-3 border border-gray-300 p-2 rounded-sm bg-white mt-1 w-full block" type="text" name="username" id="username" tabindex="1" autocapitalize="off" autocorrect="off" autofocus="autofocus" />

            <label class="block font-medium tracking-wide" for="email">Email address</label>
            <span v-if="errors.email" class='text-xs text-red-600'>{{ errors.email }}</span>
            <input placeholder="email@example.com" required v-model="form.email" class="border border-gray-300 p-2 rounded-sm bg-white mt-1 w-full block" type="email" name="email" id="email" tabindex="2" autocapitalize="off" autocorrect="off" autofocus="autofocus" />

            <label class="mt-4 block font-medium tracking-wide relative" for="password">Password</label>
            <span v-if="errors.password" class="text-xs text-red-600">{{ errors.password }}</span>
            <input placeholder="**********" required v-model="form.password" class="border p-2 rounded-sm bg-white mt-1 w-full block" type="password" name="password" id="password" tabindex="2" />

            <button v-if="!form.processing" class="select-none disabled:opacity-70 block w-full bg-blue-500 text-white font-semibold py-2 rounded-sm mt-6 border-blue-700 hover:border-blue-900 cursor-pointer" name="commit" tabindex="3">
                Sign up
            </button>
              
            <div class='flex justify-center mt-3' v-else>
              <Loader :size="40" />
            </div>

          </div>
        </form>

        <p class="text-sm border rounded-sm p-4 w-72 mx-auto mt-4 text-center">
          Already have an account ?&nbsp;&nbsp;
          <Link class="text-blue-600" :href="$route('login.index')">Sign in</Link>.
        </p>
      </div>
      
  
    </main>
  </div>
</template>

<script>
export default {
    name:'Signup'
}
</script>

<script setup>
import { useForm } from '@inertiajs/vue3';
import Loader from '../../Components/Loader.vue';



defineProps({
    errors:Object
})

const form = useForm({
    username:'',
    email:'',
    password:''
})

const submit = () => {
  form.post(route('account.store'), {})
}


</script>

<style>

</style>