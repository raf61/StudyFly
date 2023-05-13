<template>
    <div class='flex items-center justify-center h-screen'>
      <Head title="Reset Password" />  
  
        <main class='mb-32'>
          <div id="login">
            <form action="#" method="post" @submit.prevent="verifyAndSubmit">
                
              <div class="">
                <h1 class="text-2xl text-center">Reset password</h1>
                
                  
              </div>
              
              <div class="text-sm border rounded-sm bg-white p-4 w-72 mx-auto mt-4">
                
                <div>
                    <label class="block font-medium tracking-wide" for="email">New password</label>
                    <input minlength="8" maxlength="255" placeholder="**********" required v-model="form.password" class="border border-gray-300 p-2 rounded-sm bg-white mt-1 w-full block" type="password" name="password" id="password" tabindex="2" autocapitalize="off" autocorrect="off" autofocus="autofocus" />
                </div>

                <div class="pt-4">
                    <label class="block font-medium tracking-wide" for="email">Confirm password</label>
                    <input minlength="8" maxlength="255" placeholder="**********" required v-model="confirmPassword" class="border border-gray-300 p-2 rounded-sm bg-white mt-1 w-full block" type="password" name="password2" id="password2" tabindex="2" autocapitalize="off" autocorrect="off" autofocus="autofocus" />
                </div>
    
               
    
                <button v-if="!form.processing" class="select-none disabled:opacity-70 block w-full bg-blue-500 text-white font-semibold py-2 rounded-sm mt-6 border-blue-700 hover:border-blue-900 cursor-pointer" name="commit" tabindex="3">
                    Submit
                </button>
                  
                <div class='flex justify-center mt-3' v-else>
                  <Loader :size="40" />
                </div>
    
              </div>
            </form>
    
          </div>
  
        
          
      
        </main>
      </div>
    </template>
    
    <script>
    export default {
        name:'PasswordRestt'
    }
    </script>
    
<script setup>

  import { useForm, usePage } from '@inertiajs/vue3';
  import Loader from '../../Components/Loader.vue';
  import { ref } from 'vue';
  import { useToast } from 'vue-toastification';

  const token = usePage().props.token
  const confirmPassword = ref('')
  
  const form = useForm({
      token,
      password:'',
  })

  const toast = useToast()

  
  const submit = () => {
      form.post('/reset-password',
      {
          onError(error){
            toast.error(error?.invalid || 'Internal server error')
          }
      })
  }

  const verifyAndSubmit = () => {
    if (form.password != confirmPassword.value){
        return toast.error('Passwords should match')
    }
    submit()
  }

  
    
    
  
    
    
    </script>
    
    <style>
    
    </style>