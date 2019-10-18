<template>
  <section class="main-content">
    <UserImage :user="user" type="src" />
    <h1>@{{ user.name }}</h1>
    <template v-if="$isset(user.user_name01)|| $isset(user.user_name02)">
      <template v-if="$isset(user.user_name01)">
        {{ user.user_name01 }}
      </template>
      <template v-if="$isset(user.user_name02)">
        {{ user.user_name02 }}
      </template>
    </template>
    <p>{{ $calcAge(user.birth) }} / {{ $data.genderOption[user.gender] }} / {{ $data.prefsOption[user.pref] }}</p>
    <template v-if="!$auth.$state.loggedIn || ($auth.$state.loggedIn && (user.name !== $auth.user.name))">
      <Follow
        :each-data="user"
        :current-following="currentFollowing"
        follow-type="follow_users"
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
      フォロー中のタグ <b-tag rounded>
        {{ user.follow_report_tags.length }}
      </b-tag>
      <div class="report-tags">
        <div v-for="tagName in user.follow_report_tags" :key="tagName">
          <Tag :tag-name="tagName" />
        </div>
      </div>
    </div>
    <hr class="dropdown-divider">
    <div>
      フォロー中のユーザー <b-tag rounded>
        {{ user.follow_users.length }}
      </b-tag>
      <template v-if="user.follow_users.length">
        <div class="columns users">
          <div v-for="follow_user in user.follow_users" :key="follow_user.id" class="column is-2">
            <n-link id="user-data" :to="{ name: 'users-name', params: {name: follow_user.name} }">
              <img :src="follow_user.thumb" alt="">
            </n-link>
          </div>
        </div>
      </template>
    </div>
    <hr class="dropdown-divider">
  </section>
</template>
<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'
import { FollowUserStore } from '@/store'
import Tag from '@/components/front/Tag.vue'
import UserImage from '@/components/front/UserImage.vue'
import Follow from '@/components/front/Follow.vue'

@Component({
  components: {
    Follow,
    Tag,
    UserImage
  }
})
export default class SideUserPage extends Vue {
  @Prop() user!: {
    id: number
  }

  get currentFollowing (): Object {
    return FollowUserStore.getFollowUsers
  }

  async created () {
    if ((this as any).$auth.$state.loggedIn) {
      await FollowUserStore.loadFollowUsers(this.user.id)
    }
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
