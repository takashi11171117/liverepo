<template>
  <div class="container">
    <h1>{{ error.statusCode }}</h1>
    <p v-if="error.statusCode === 404">
      ページが見つかりません。
    </p>
    <p v-if="error.statusCode === 401">
      認証エラーです。
    </p>
    <p v-else>
      エラーが発生しました
    </p>
  </div>
</template>

<script lang="ts">
import { Component, Vue, Prop } from 'nuxt-property-decorator'

@Component({})
export default class ErrorComponent extends Vue {
  @Prop() error!: Object
}
</script>
