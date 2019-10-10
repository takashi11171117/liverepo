<template>
  <div v-if="user !== null" class="user-data">
    <n-link id="user-data" :to="{ name: 'users-name', params: {name: user.name} }">
      <div class="user-icon">
        <template v-if="user.thumb !== null && user.thumb !== undefined">
          <img :src="user.thumb">
        </template>
        <template v-else>
          <img src="~assets/none_image.jpg">
        </template>
      </div>
      <div class="user-name">
        By {{ user.name }}
      </div>
      <div class="user-profile">
        {{ $calcAge(user.birth) }} / {{ $data.genderOption[user.gender] }} / {{ $data.prefsOption[user.pref] }}
      </div>
    </n-link>
  </div>
</template>
<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'

@Component({})
export default class UserData extends Vue {
    @Prop({ default: {} })
    user!: Object
}
</script>
<style lang="sass" scoped>
.user-data
    display: flex
.user-data div
    line-height: 3rem
    font-size: 1.4rem
    margin-bottom: 1.5rem
.user-icon
    width: 30px
    height: 30px
    margin-right: 10px
    img
        border-radius: 5px
.user-profile
    color: #888
#user-data
    display: flex
    color: #000
    .user-name
        margin-right: 10px
        font-weight: bold
        text-decoration: underline
</style>
