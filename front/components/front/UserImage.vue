<template>
  <div class="user-img">
    <template v-if="$isset(user[type])">
      <img :src="user[type]">
    </template>
    <template v-else>
      <img src="~assets/none_image.jpg">
    </template>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'

@Component({})
export default class UserImage extends Vue {
  @Prop() user!: Object
  @Prop() type!: string
}
</script>

<style lang="sass" scoped>
.user-img
    margin-bottom: 10px
    img
        border-radius: 5px
</style>
