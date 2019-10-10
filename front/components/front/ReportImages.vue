<template>
  <div v-if="$isset(images) && images.length > 0" class="thumbnail-box">
    <img :src="images[0].path" alt="thumbnail" class="thumbnail">
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'

@Component({})
export default class ReportImages extends Vue {
    @Prop({})
    images!: {path: string}[]
}
</script>

<style lang="sass" scoped>
.thumbnail-box
    width: 120px
</style>
