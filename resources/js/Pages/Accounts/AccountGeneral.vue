<template>

  <section class='mb-52'>
    <form action="" @submit.prevent>
    <div class="p-5 border border-gray-200 rounded-md mb-10 mt-0">
      <h3 class="font-bold mb-1">Username</h3>
      <p class="text-[9pt] text-gray-500">Can`t be changed</p>
      <div class="mt-2">
        <span class="text-[8pt]">Username</span>
        <input type="text" readonly class="form-control
        block
        w-full
        px-3
        py-1.5
        text-[9pt]
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded-lg
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
        :value="user.username"
        >
      </div>
    </div>

    <div class="p-5 border border-gray-200 rounded-md mb-10">
      <h3 class="font-bold mb-1">Email</h3>
      <p class="text-[9pt] text-gray-500">Can`t be changed</p>
      <div class="mt-2">
        <span class="text-[8pt]">Email</span>
        <input type="email" class="form-control
        block
        w-full
        px-3
        py-1.5
        text-[9pt]
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded-lg
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
        :value="user.email"
        readonly
        >
      </div>
    </div>

    <div class="p-5 border border-gray-200 rounded-md mb-10">
      <h3 class="font-bold mb-1">Change Password</h3>
      <div class="mt-2">
        <div>
          <span class="text-[8pt]">Current password</span>
          <div>
            <span v-if="errors.current_password" class='w-full text-xs text-red-600'>{{ errors.current_password}}</span>
          </div>
          <input v-model="updatePasswordForm.current_password" type="password" class="form-control
          block
          w-full
          px-3
          py-1.5
          text-[9pt]
          font-normal
          text-gray-700
          bg-white bg-clip-padding
          border border-solid border-gray-300
          rounded-lg
          transition
          ease-in-out
          m-0
          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
          >
      </div>
      <div class="mt-2">
        <div>
          <span class="text-[8pt]">New password</span>
          <div>
            <span v-if="errors.new_password" class='w-full text-xs text-red-600'>{{ errors.new_password }}</span>
          </div>
          <input v-model="updatePasswordForm.new_password" type="password" placeholder="Min 8 characters" class="form-control
          block
          w-full
          px-3
          py-1.5
          text-[9pt]
          font-normal
          text-gray-700
          bg-white bg-clip-padding
          border border-solid border-gray-300
          rounded-lg
          transition
          ease-in-out
          m-0
          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
          >
        </div>
      </div>
      <div class="mt-2">
        <div>
          <span class="text-[8pt]">Confirm new password</span>
          <div>
            <span v-if="errors.confirm_new_password" class='w-full text-xs text-red-600'>{{ errors.confirm_new_password }}</span>
          </div>
          <input v-model="updatePasswordForm.confirm_new_password" type="password" class="form-control
          block
          w-full
          px-3
          py-1.5
          text-[9pt]
          font-normal
          text-gray-700
          bg-white bg-clip-padding
          border border-solid border-gray-300
          rounded-lg
          transition
          ease-in-out
          m-0
          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
          >
        </div>
      </div>
        
      <div class="flex justify-end mt-6">
        <button @click="updatePassword" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
      </div>
      </div>
    </div>
  </form>
  </section>

</template>

<script>
export default {
    name:'AccountGeneral',
    layout:Account
}
</script>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import Account from './Account.vue';

const toast = useToast()

const { auth } = defineProps({
  auth:Object,
  errors:Object
})

const user = ref(auth.user)

const updatePasswordForm = useForm({
  current_password:'',
  new_password:'',
  confirm_new_password:''
})

const updatePassword = () => {
  updatePasswordForm.post(route('account.updatePassword'),{
    preserveScroll:true,
    onSuccess: () => {
      updatePasswordForm.reset();
      toast.success('Your password has been changed')
    },
  });
}


</script>

<style scoped>

</style>