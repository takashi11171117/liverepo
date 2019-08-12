<template>
    <n-link :to="{name: 'comedy-report_tags-name', params: {name: tagName}}">
        <div class="tag-card">
            <p>{{ tagName }}</p>
        </div>
    </n-link>
</template>
<script>
  export default {
    props: {
      tagName: String,
    },
  }
</script>

<style lang="sass" scoped>
    a
        display: inline-block
    .tag-card p
        margin-bottom: 10px
        display: inline-block
        position: relative
        padding: 0.4em 1.4em
        margin-right: 10px
        background: #fff
        color: #000
        border-top: solid 0.5px #000
        border-left: solid 0.5px #000
        border-bottom: solid 5px #000
        border-right: solid 5px #000
        font-size: 14px
        font-weight: bold
        &:before
            content: " "
            position: absolute
            bottom: -5px
            left: -1px
            width: 0
            height: 0
            border-width: 0 6px 6px 0
            border-style: solid
            border-color: transparent
            border-bottom-color: #FFF
        &:after
            content: " "
            position: absolute
            top: -1px
            right: -5px
            width: 0
            height: 0
            border-width: 0 6px 6px 0
            border-style: solid
            border-color: #FFF
            border-bottom-color: transparent
</style>