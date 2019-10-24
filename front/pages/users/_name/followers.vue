<template>
  <section class="main-content border-radius">
    <h1>フォロワー</h1>
    <hr class="dropdown-divider">
    <template v-if="followers.data.length">
      <div v-for="(follower, index) in followers.data" :key="index" class="column is-12-mobile">
        <FollowerCard :follower="follower" />
      </div>
      <Pagination
        :current_path="`/users/${user.name}/followers`"
        :pagination="followers.meta"
      />
    </template>
    <template v-else>
      <p>まだフォロワーはいません。</p>
    </template>
  </section>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'
import { nuxtContext } from '@/src/@types'
import { UserStore } from '@/store'
import Pagination from '@/components/Pagination.vue'
import FollowerCard from '@/components/front/FollowerCard.vue'

@Component({
  components: {
    FollowerCard,
    Pagination
  },
  watchQuery: ['page']
})
export default class User extends Vue {
  @Prop() user!: Object

  get followers (): Object {
    return UserStore.getFollowers
  }

  async fetch (this: void, ctx: nuxtContext): Promise<void> {
    await UserStore.loadFollowers(
      ctx.params.name,
      {
        page: ctx.app.context.query.page,
        per_page: ctx.app.context.query.per_page
      }
    )
  }
}
</script>
