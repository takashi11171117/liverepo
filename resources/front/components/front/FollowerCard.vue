<template>
    <section class="follow-user-data">
        <n-link :to="{ name: 'users-name', params: {name: follower.name} }">
            <UserImage :user="follower" type="thumb"/>
            <div class="user-info">
                <h1>{{ follower.name }}</h1>
                <p>{{ follower.description }}</p>
            </div>
        </n-link>
        <div class="dropdown-divider"></div>
    </section>
</template>
<script>
  import UserImage from './UserImage';

  export default {
    components: {
      UserImage
    },
    props: {
      follower: Object,
    }
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