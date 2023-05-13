import { ref } from 'vue'

const authModalVisible = ref(false)

export function showAuthModal(){
    authModalVisible.value = true
}

export function hideAuthModal(){
    authModalVisible.value = false
}

export function getAuthModalStatus(){
    return authModalVisible.value
}