<template>
  <header>
    <div class="min-h-screen fixed z-50 flex flex-col flex-auto flex-shrink-0 antialiased bg-gray-50 text-gray-800">
      <div ref="sidebar" :class="{'sidebar-hidden':sideBarHidden}" v-click-outside="()=>{sideBarHidden=true}" class="fixed sidebar flex flex-col top-0 left-0 w-64 bg-white h-full border-r">
        <div class="flex items-center justify-center h-14 border-b">
            <div class="logo flex items-center">
                            <Logo :width="25" class="relative bottom-1" />
                            <span class='select-none text-logo-blue text-md pl-2'>StudyFly</span>
            </div>
        </div>
        <nav class="overflow-y-auto overflow-x-hidden flex-grow">
          <ul class="flex flex-col py-4 space-y-1">
            <div>
              
              <li>
                <div class="relative">
                  <Link :href="$route('question.index')"  class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-gray-50 text-gray-600 hover:text-gray-800 border-l-4 border-transparent hover:border-cyan-500 pr-6">
                    <span class="inline-flex justify-center items-center ml-4">
                      <QuestionMarkCircleIcon class="w-5" />
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">Questions</span>
                  </Link>
                  <Link v-if="user" :href="$route('question.indexAsk')" type="button" class="z-10 top-[50%] translate-y-[-50%] absolute right-2 inline-block px-6 py-1 border-2 border-blue-600 bg-blue-600 text-white font-medium text-xs leading-tight rounded hover:bg-opacity-5 focus:outline-none hover:text-blue-600 transition duration-150 ease-in-out">Ask</Link>
                </div>
              </li>
            </div>
          </ul>
        </nav>
      </div>
    </div>
    <div class="border-b shadow-md">
        <div class="flex justify-center">
            <div class="max-w-screen-lg	w-full justify-center flex items-center p-1 pt-2">
                <button class="burguer mr-3" @click.prevent="handleBurger($event)">
                    <Bars3Icon v-if="sideBarHidden" class='w-6 text-stone-500' />
                    <XMarkIcon v-else class='w-6 mr-3 text-stone-500' />
                </button>
                <Link href="/">
                    <div class="logo flex items-center select-none" :class="{'hidden':!sideBarHidden}">
                        <Logo :width="25" class="relative bottom-1" />
                        <span class='select-none text-logo-blue text-sm pl-2'>StudyFly</span>
                    </div>
                </Link>
                <div class="search max-w-[32rem] flex items-center flex-1 px-2">
                    <form @submit.prevent="search" action="" method=GET class="w-full">
                        <div class="flex p-1 justify-between items-center rounded-[2px] border border-gray-400">
                            <span><svg aria-hidden="true" class="fill-gray-400 s-input-icon s-input-icon__search svg-icon iconSearch" width="15" height="15" viewBox="0 0 18 18"><path d="m18 16.5-5.14-5.18h-.35a7 7 0 1 0-1.19 1.19v.35L16.5 18l1.5-1.5ZM12 7A5 5 0 1 1 2 7a5 5 0 0 1 10 0Z"></path></svg></span>
                            <input v-model="searchString" class="pl-2 text-[8pt] w-full block outline-none"
                            type="text" name="search" id="search" placeholder="Search...">
                        </div>
                    </form>
                </div>
                <div v-if="user" class="rounded-full border-2 border-transparent hover:border-cyan-600 cursor-pointer">
                    <Link :href="$route('account.show')">
                        <UserLogo  class="rounded-full" width="30"  />
                    </Link>
                </div>
                <div v-else>
                  <Link :href="$route('login.index')">
                      <button type="button" class="inline-block px-6 py-1 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight rounded hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">Log In</button>
                  </Link>
                </div>
            </div>
        </div>
      </div>
      </header>
</template>

<script>
export default {
    name:'Navbar'
}
</script>

<script setup>
import {XMarkIcon,Bars3Icon, ArrowRightOnRectangleIcon, QuestionMarkCircleIcon, DocumentTextIcon, PencilSquareIcon} from '@heroicons/vue/20/solid'
import Logo from "./Logo.vue"
import UserLogo from './UserLogo.vue'
import { ref, reactive, computed } from 'vue'
import { usePage, router } from '@inertiajs/vue3';


const { searchPath } = defineProps({
  searchPath:{
    type:String,
    default: '/questions'
  }
})
const searchString = ref('')
const showPageDropDown = ref(false)
const sideBarHidden = ref(true);
const sidebar = ref()
const user = computed(() => usePage().props.auth.user)

const handleBurger = (event) => {
  if (sideBarHidden.value == true){
    event.stopPropagation();
    sideBarHidden.value = false;
    return
  }
  sideBarHidden.value = true;
}

const search = () => {
  const parsedParams = new URLSearchParams(location.search)
  let params = {}
  parsedParams.forEach((value, key) => {
    params[key] = value
  })

  router.get(searchPath, {
    search:searchString.value
  },{
    replace:true
  })
}

</script>

<style scoped>
.text-logo-blue{
    color:#079FAF;
}
.sidebar-hidden{
    left:-20rem;
}
.sidebar{
  transition:.1s;
  box-shadow: 0 4px 6px 3px rgb(0 0 0 / 0.1);

}
</style>