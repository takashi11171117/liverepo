<template>
    <div class="review-content">
        <div class="review-star">
            <div class="star-rating">
                <div class="star-rating-front" :style="'width: ' + report.rating/5*100 + '%'">★★★★★</div>
                <div class="star-rating-back">★★★★★</div>
            </div>
            <div class="star-number">{{ report.rating }}</div>
        </div>
        <p class="review-text">{{ $truncate(report.content, 80) }}</p>
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
    .review-text
        padding-right: 10px
        line-height: 150%
        margin-bottom: 10px
        font-size: 16px

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

    .star-rating-back
        color: #ccc

    .review-content
        overflow: hidden
        width: calc(100% - 120px)
        display: flex
        flex-direction: column

    .review-star
        padding-bottom: 15px
        display: flex

    .star
        font-size: 14px
        font-weight: bold
        color: #f8d048

    .star-number
        font-size: 20px
        font-weight: bold
        color: #000
        margin-left: 5px
        align-items: center
</style>