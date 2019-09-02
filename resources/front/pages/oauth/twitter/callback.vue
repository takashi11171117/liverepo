<template>
    <div>
        <p v-if="attempting">Twitterでログインしています。</p>

        <template v-else>
            <p>Twitterでのログインに失敗しました。</p>
            <p>{{ failedMessage }}</p>
        </template>
    </div>
</template>

<script>
  import { mapActions } from 'vuex'

  export default {
    data () {
      return {
        failedMessage: null
      }
    },

    computed: {
      attempting () {
        return !this.failedMessage
      }
    },

    methods: mapActions('oauth', ['setOauthInfo']),

    async mounted () {
      try {
        const callbackData = await this.$axios.$get(
            '/oauth/twitter/callback',
            { params: this.$route.query }
          );

        this.setOauthInfo(callbackData.access_token, callbackData.user);

        this.$router.replace('/')
      } catch (error) {
        this.failedMessage = error.message
      }
    }
  }
</script>