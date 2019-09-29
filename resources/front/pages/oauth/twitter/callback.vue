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

    async mounted () {
      const callbackData = await this.$axios.$get(
          '/oauth/twitter/callback',
          { params: this.$route.query }
        ).catch(err => {
          this.failedMessage = err.message
        });

      this.$auth.setToken('local', `Bearer ${callbackData.token}`);
      this.$auth.setUser(callbackData.user);

      await this.$router.push('/', undefined, () => { location.href = '/' });
    }
  }
</script>