<template>
    <section>
            <div class="p-5 border border-gray-200 rounded-md mb-10 mt-0">
                <h3 class="font-bold mb-1">Confirm logout ?</h3>
                <div class="flex justify-center mt-6">
                    <button @click="logout" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Yes</button>
                    <Link :href="$route('account.show')" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 ">No</Link>
                </div>
            </div>
    </section>
</template>

<script>
export default {
    name:'AccountLogout',
    layout:Account
}
</script>

<script setup>
import {router} from '@inertiajs/vue3'
import Account from './Account.vue';

const logout = () => {
    router.visit(route('login.destroy'))
}


</script>

<style>

</style>