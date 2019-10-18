<template>
  <section class="follow-user-data">
    <n-link :to="{ name: 'users-name', params: {name: follower.name} }">
      <UserImage :user="follower" type="thumb" />
      <div class="user-info">
        <h1>{{ follower.name }}</h1>
        <p>{{ follower.description }}</p>
      </div>
    </n-link>
    <div class="dropdown-divider" />
  </section>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'
import UserImage from '@/components/front/UserImage.vue'

@Component({
  components: {
    UserImage
  }
})
export default class FollowerCard extends Vue {
  @Prop()
  follower!: Object
}
</script>

<style lang="sass" scoped>
.follow-user-data a
    color: #000
    display: flex
    .user-icon
        width: 80px
        padding-right: 10px
        img
            border-radius: 5px
    .user-info
        width: calc(100% - 90px)
    h1
        padding-top: 0
        padding-bottom: 10px
</style>
