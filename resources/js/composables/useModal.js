import { ref } from 'vue'

const activeModal = ref(null) // null, 'user', 'service', 'accounts', 'contacts'

export function useModal() {
  const showModal = (modalName) => {
    activeModal.value = modalName
  }

  const closeModal = () => {
    activeModal.value = null
  }

  return {
    activeModal,
    showModal,
    closeModal
  }
}