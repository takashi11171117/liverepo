<template>
    <section class="main-content">
        <UserImage :user="user" type="src"/>
        <h1>@{{ user.name }}</h1>
        <template v-if="$isset(user.user_name01)|| $isset(user.user_name02)">
            <template v-if="$isset(user.user_name01)">{{ user.user_name01 }} </template>
            <template v-if="$isset(user.user_name02)">{{ user.user_name02 }}</template>
        </template>
        <p>{{ $calcAge(user.birth) }} / {{ $data.genderOption[user.gender] }} / {{ $data.prefsOption[user.pref] }}</p>
        <template v-if="!$auth.$state.loggedIn || ($auth.$state.loggedIn && (user.name !== $auth.user.name))">
            <Follow
                    :eachData="user"
                    :currentFollowing="currentFollowing"
                    followType="follow_users"
            />
        </template>
        <hr class="dropdown-divider">
        <template v-if="$isset(user.email)">
            <p>
                {{ user.email }}
            </p>
            <hr class="dropdown-divider">
        </template>
        <template v-if="$auth.$state.loggedIn && (user.name === $auth.user.name)">
            <p>
                <n-link :to="{ name: 'setting-profile' }">
                    プロフィールを編集
                </n-link>
            </p>
            <hr class="dropdown-divider">
        </template>
        <template v-if="$isset(user.description)">
            <p>
                {{ user.description }}
            </p>
            <hr class="dropdown-divider">
        </template>
        <template v-if="$isset(user.url)">
            <p>
                <a :href="user.url" target="_blank">
                    {{ user.url }}
                </a>
            </p>
            <hr class="dropdown-divider">ß
        </template>
        <div class="follow-tag">
            フォロー中のタグ <b-tag rounded> {{ user.follow_report_tags.length }} </b-tag>
            <div class="report-tags">
                <template v-for="tagName in user.follow_report_tags">
                    <Tag :tagName="tagName"/>
                </template>
            </div>
        </div>
        <hr class="dropdown-divider">
        <div>
            フォロー中のユーザー <b-tag rounded> {{ user.follow_users.length }} </b-tag>
            <template v-if="user.follow_users.length">
                <div class="columns users">
                    <div class="column is-2" v-for="user in user.follow_users">
                        <n-link :to="{ name: 'users-name', params: {name: user.name} }" id="user-data">
                            <img :src="user.thumb" alt="">
                        </n-link>
                    </div>
                </div>
            </template>
        </div>
        <hr class="dropdown-divider">
    </section>
</template>
<script>
  import Tag from '../Tag';
  import UserImage from '../UserImage';
  import Follow from '../../Follow';

  export default{
    components: {
      Follow,
      Tag,
      UserImage
    },
    data() {
      return {
        currentFollowing: false,
      }
    },
    props: {
      user: Object,
    },
    async created() {
      let currentFollowing = false;
      if (this.$auth.$state.loggedIn) {
        const tempFollow = await this.$axios.$get(`/follow_users/${this.user.id}`);
        currentFollowing = tempFollow.result
      }

      return {currentFollowing};
    }
  }
</script>
<style lang="sass" scoped>
    .main-content
        background-color: #fff
        border-radius: 8px
        padding: 15px 20px
        h1
            font-size: 20px
            font-weight: bold
            line-height: 1.2
        p, > div
            margin-top: 10px
            margin-bottom: 10px
            font-size: 14px
            line-height: 1.5
        .follow-tag
            margin-bottom: 20px

    .report-tags
        margin-bottom: 10px
        margin-top: 10px

    .users
        margin-top: 4px
        img
            border-radius: 5px
</style>