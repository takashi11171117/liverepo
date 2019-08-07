<template>
    <div class="user-data">
        <div class="user-icon">
            <template v-if="user.thumb !== null && user.thumb !== undefined">
                <img :src="user.thumb">
            </template>
            <template v-else>
                <img src="~assets/none_image.jpg">
            </template>
        </div>
        <div class="user-name">By {{ user.name }}</div>
        <div class="user-profile">{{ $calcAge(user.birth) }} / {{ $data.genderOption[user.gender] }} / {{ $data.prefsOption[user.pref] }}</div>
    </div>
</template>
<script>
  export default {
    props: {
      user: Object,
    }
  }
</script>
<style lang="sass" scoped>
    .user-data
        display: flex
    .user-data div
        line-height: 30px
        font-size: 14px
        margin-bottom: 15px
    .user-icon
        width: 30px
        height: 30px
        margin-right: 10px
        img
            border-radius: 5px
    .user-name
        margin-right: 10px
        font-weight: bold
    .user-profile
        color: #888
</style>