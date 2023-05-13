<template>
  <div class='flex items-center justify-center h-screen'>
    <Head title="Forgot password" />  

      <main class='mb-32'>
        <div id="login" v-if="showForm">
          <form action="#" method="post" @submit.prevent="submit">
              
            <div class="">
              <h1 class="text-2xl text-center">Reset my password</h1>
              <div class="flex mt-5 justify-center">
                  <p class='text-center mt-2 text-[10pt] max-w-[20rem] text-center'>Enter your e-mail address. We will send you a message with instructions for reseting your password.</p>
              </div>
                
            </div>
            
            <div class="text-sm border rounded-sm bg-white p-4 w-72 mx-auto mt-4">
  
              <label class="block font-medium tracking-wide" for="email">Email address</label>
              <input placeholder="email@example.com" required v-model="form.email" class="border border-gray-300 p-2 rounded-sm bg-white mt-1 w-full block" type="email" name="email" id="email" tabindex="2" autocapitalize="off" autocorrect="off" autofocus="autofocus" />
  
             
  
              <button v-if="!form.processing" class="select-none disabled:opacity-70 block w-full bg-blue-500 text-white font-semibold py-2 rounded-sm mt-6 border-blue-700 hover:border-blue-900 cursor-pointer" name="commit" tabindex="3">
                  Submit
              </button>
                
              <div class='flex justify-center mt-3' v-else>
                <Loader :size="40" />
              </div>
  
            </div>
          </form>
  
        </div>

        <div v-else>
          <div class="">
            <div class="flex justify-center">
              <CheckIcon class="w-[10rem]"/>
            </div>
              <h1 class="text-2xl text-blue-600 text-center">All set.</h1>
              
              <div class="flex mt-5 justify-center">
                  <p class='text-center mt-2 text-[13pt] max-w-[25rem] text-center'>If you have an account with a confirmed email, you will have received an email with instructions for resetting your password.</p>
              </div>
                
            </div>
        </div>
        
    
      </main>
    </div>
  </template>
  
  <script>
  export default {
      name:'ForgotPassword'
  }
  </script>
  
  <script setup>
import { useForm } from '@inertiajs/vue3';
import Loader from '../../Components/Loader.vue';
import { ref } from 'vue';
import { useToast } from 'vue-toastification';
import { CheckIcon } from '@heroicons/vue/20/solid'
const showForm = ref(true)

const form = useForm({
    email:''
})
const toast = useToast()

const submit = () => {
    form.post('/forgot-password',
    {
        onError(errors){
          toast.error('Internal server error')
        },
        onSuccess(response){
          showForm.value = false
        }
    })
}

  
  

  
  
  </script>
  
  <style>
  
  </style>