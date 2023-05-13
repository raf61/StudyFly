<template>
  <Head title="Account" />  
  <Navbar />
  <main>
    <section class="title flex justify-center mt-12 mb-10">
      <div class="text-center">
        <h1 class="text-4xl font-bold mb-3">Account</h1>
        <p class="text-gray-500">
          View & edit your account.
        </p>
      </div>
    </section>
    <section class="flex justify-center">
      <div class="w-full flex max-w-3xl">
        <div class="w-[30%]">
          <div class="bg-gray-100 py-4 rounded-sm">
            <ul>
              <li>
                <Link :href="$route('account.show')" :class="{'text-white bg-blue-500':getUrlPath($page.url) == getUrlPath($route('account.show'))}" class="block transition duration-300 text-sm hover:text-white hover:bg-blue-500 py-1 px-3 cursor-pointer">
                  <span>General</span>
                </Link>
              </li>
              <li>
                <Link :href="$route('account.questions')" :class="{'text-white bg-blue-500':getUrlPath($page.url) == getUrlPath($route('account.questions'))}" class="block transition duration-300 text-sm hover:text-white hover:bg-blue-500 py-1 px-3 cursor-pointer">
                  <span>Questions</span>
                </Link>
              </li>
              <li>
                <Link :href="$route('account.showLogout')" :class="{'text-white bg-blue-500':getUrlPath($page.url) == getUrlPath($route('account.showLogout'))}" class="block transition duration-300 text-sm hover:text-white hover:bg-blue-500 py-1 px-3 cursor-pointer">
                  <span>Logout</span>
                </Link>
              </li>
              <li>
                <Link :href="$route('account.showDelete')" :class="{'text-white bg-blue-500':getUrlPath($page.url) == getUrlPath($route('account.showDelete'))}" class="block transition duration-300 text-sm hover:text-white hover:bg-blue-500 py-1 px-3 cursor-pointer">
                  <span>Delete account</span>
                </Link>
              </li>
            </ul>
          </div>
        </div>
        <div class="w-[70%] pl-8">
          <slot></slot>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
export default {
    name:'Account'
}
</script>

<script setup>
import Navbar from '../../Components/Navbar.vue'

const {flash} = defineProps({
  auth:Object,
  errors:Object,
  flash:Object
})

const getUrlPath = x => {
  if (!x.startsWith('http'))
    return x
  return new URL(x).pathname
}





</script>

<style scoped>
</style>