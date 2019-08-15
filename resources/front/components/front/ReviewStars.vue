<template>
    <div class="review-star">
        <div class="star-rating">
            <div class="star-rating-front" :style="'width: ' + report.rating/5*100 + '%'">★★★★★</div>
            <div class="star-rating-back">★★★★★</div>
        </div>
        <div class="star-number">{{ report.rating }}</div>
    </div>
</template>

<script>
  export default {
    name: "ReviewStars",
    props: {
      report: Object,
    }
  }
</script>

<style lang="sass" scoped>
    .star-rating
        position: relative
        width: 5em
        height: 1em
        font-size: 20px
        display: flex
        align-items: center

    .star-rating-front
        position: absolute
        left: 0
        overflow: hidden
        color: #ffcc33
        word-wrap: normal
        z-index: 10

    .star-rating-back
        position: absolute
        color: #ccc
        z-index: 1

    .review-star
        padding-bottom: 15px
        display: flex
        align-items: center

    .star
        font-size: 14px
        font-weight: bold
        color: #f8d048

    .star-number
        font-size: 16px
        font-weight: bold
        color: #000
        margin-left: 5px
</style>