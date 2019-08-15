<template>
    <div v-if="$isset(images) && images.length > 0" class="thumbnail-box">
        <img :src="images[0].path" alt="thumbnail" class="thumbnail">
    </div>
</template>
<script>
  export default {
    props: {
      images: Array,
    }
  }
</script>
<style lang="sass" scoped>
    .thumbnail-box
        width: 120px
</style>

