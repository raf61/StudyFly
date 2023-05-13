<template>
    <section>
        <form action="" method="post" @submit.prevent="submit">
            <div class="p-5 border border-gray-200 rounded-md mb-10 mt-0">
                <h3 class="font-bold mb-1">Delete account</h3>
                <p class="text-[9pt] text-gray-500">Delete your account and all data associated permanently.</p>
                <div class="mt-2">
                    <span class="text-[8pt]">Account password</span>
                    <div>
                        <span v-if="errors.password" class='w-full text-xs text-red-600'>{{ errors.password }}</span>
                    </div>
                    <input type="password" v-model="form.password" class="form-control
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
                    placeholder="**********"
                    >
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Delete</button>
                </div>
            </div>
        </form>
    </section>
</template>

<script>
export default {
    name:'AccountDelete',
    layout:Account
}
</script>

<script setup>
import { useForm } from '@inertiajs/vue3';
import Account from './Account.vue';

defineProps({
    errors:Object
})

const form = useForm({
    password:''

})

const submit = () => {
    form.delete(route('account.destroy'))
}

</script>

<style>

</style>