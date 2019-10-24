<template>
  <div />
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { AdminAuthStore } from '@/store'

@Component({
  layout: 'admin'
})
export default class Logout extends Vue {
  mounted () {
    AdminAuthStore.logout()
  }
}
</script>
