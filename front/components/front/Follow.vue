<template>
  <div>
    <template v-if="isFollow">
      <template v-if="sending">
        <button class="button is-primary is-loading" />
      </template>
      <template v-else>
        <button class="button" @click="unFollow()">
          <slot name="follow">
            フォロー中 -
          </slot>
        </button>
      </template>
    </template>
    <template v-else>
      <template v-if="sending">
        <button class="button is-primary is-loading" />
      </template>
      <template v-else>
        <button class="button" @click="follow()">
          <slot name="unfollow">
            フォローする +
          </slot>
        </button>
      </template>
    </template>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'

@Component({})
export default class Tag extends Vue {
  @Prop() followType!: string
  @Prop() currentFollowing!: boolean
  @Prop() eachData!: {
    id: number
  }
  @Prop() text!: string

  sending: boolean = false
  following: boolean = this.currentFollowing

  async follow () {
    const _this = this as any
    if (!_this.$auth.$state.loggedIn) {
      _this.$router.replace({
        name: 'auth-login'
      })
      return
    }
    if (this.sending) {
      return
    }
    this.sending = true
    const data = { id: this.eachData.id }
    await _this.$axios.$post(`/${this.followType}`, data)
    this.following = true
    this.sending = false
  }

  async unFollow () {
    const _this = this as any
    if (!_this.$auth.$state.loggedIn) {
      _this.$router.replace({
        name: 'auth-login'
      })
      return
    }
    if (this.sending) {
      return
    }
    this.sending = true
    await _this.$axios.$delete(`/${this.followType}/${this.eachData.id}`)
    this.following = false
    this.sending = false
  }
}
</script>
