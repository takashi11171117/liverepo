<template>
  <div>
    <p v-if="!$isset(failedMessage)">
      Twitterでログインしています。
    </p>
    <template v-else>
      <p>Twitterでのログインに失敗しました。</p>
      <p>{{ failedMessage }}</p>
    </template>
  </div>
</template>

<script>
import { Component, Vue } from 'nuxt-property-decorator'
import { OauthStore } from '@/store'

@Component({})
export default class OauthTwitterRedirect extends Vue {
   failedMessage = ''

   async mounted () {
     await OauthStore.loadCallbackData(this.$route.query)
       .catch((err) => {
         this.failedMessage = err.message
       })

     if (this.failedMessage) {
       return
     }

     const callbackData = OauthStore.getCallbackData

     this.$auth.setToken('local', `Bearer ${callbackData.token}`)
     this.$auth.setUser(callbackData.user)

     this.$router.push('/', undefined, () => { location.href = '/' })
   }
}
</script>
