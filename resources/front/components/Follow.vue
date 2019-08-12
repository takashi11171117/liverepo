<template>
    <div>
        <template v-if="following">
            <template v-if="sending">
                <button class="button is-primary is-loading"></button>
            </template>
            <template v-else>
                <button @click="unFollow()" class="button">
                    <slot name="follow">フォロー中 -</slot>
                </button>
            </template>
        </template>
        <template v-else>
            <template v-if="sending">
                <button class="button is-primary is-loading"></button>
            </template>
            <template v-else>
                <button @click="follow()" class="button">
                    <slot name="unfollow">フォローする +</slot>
                </button>
            </template>
        </template>
    </div>
</template>

<script>
  export default {
    props: {
      followType: {
        required: true,
        type: String
      },
      currentFollowing: {
        required: true,
        type: Boolean
      },
      eachData: {
        required: true,
        type: Object
      },
      text: {
        type: String
      }
    },

    data() {
      return {
        sending: false,
        following: this.currentFollowing,
      }
    },

    methods: {
      async follow () {
        if (!this.$auth.$state.loggedIn) {
          this.$router.replace({
            name: 'auth-login'
          });
          return
        }
        if (this.sending) {
          return
        }
        this.sending = true;
        const data = { id: this.eachData.id };
        await this.$axios.$post(`/${this.followType}`, data);
        this.following = true;
        this.sending = false;
      },
      async unFollow() {
        if (!this.$auth.$state.loggedIn) {
          this.$router.replace({
            name: 'auth-login'
          });
          return
        }
        if (this.sending) {
          return
        }
        this.sending = true;
        await this.$axios.$delete(`/${this.followType}/${this.eachData.id}`);
        this.following = false;
        this.sending = false;
      }
    }
  }
</script>