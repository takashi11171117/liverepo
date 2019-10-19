<template>
  <p>Twitterへリダイレクトしています</p>
</template>

<script>
import { Component, Vue } from 'nuxt-property-decorator'
import { OauthStore } from '@/store'

@Component({})
export default class OauthTwitterRedirect extends Vue {
  get redirectUrl () {
    return OauthStore.getRedirectUrl
  }

  async asyncData () {
    await OauthStore.loadRedirectUrl()
  }

  mounted () {
    window.location.href = this.redirectUrl
  }
}
</script>
