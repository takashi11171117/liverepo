<template>
  <no-ssr>
    <vue-tags-input
      v-model="tag"
      :tags="tags"
      :autocomplete-items="autocomplete_tags"
      placeholder="タグを入力"
      @tags-changed="update"
    />
  </no-ssr>
</template>

<script lang="ts">
import { Component, Vue, Prop, Watch } from 'nuxt-property-decorator'
import { Context } from '@nuxt/types'

@Component({})
export default class Tagify extends Vue {
  @Prop() propTags!: Array<string>
  @Prop() onUpdate!: Function

  tag: string = ''
  tags: Array<string> = []
  autocomplete_tags: Array<string> = []
  debounce: number | undefined = undefined

  get innerTags (): Array<string> {
    return this.tags
  }

  set innerTags (newTags: Array<string>) {
    this.tags = newTags
  }

  update (newTags: Array<string>) {
    this.autocomplete_tags = []
    this.innerTags = newTags
    this.onUpdate(newTags)
  }

  @Watch('tag')
  initItems (ctx: Context) {
    if (this.tag.length < 2) { return }

    window.clearTimeout(this.debounce)
    this.debounce = window.setTimeout(() => {
      ctx.app.$axios.$get(`/comedy/report_tags/tagify?tag=${this.tag}`).then(({ data }) => {
        this.autocomplete_tags = data.map((name: string) => {
          return { text: name }
        })
      }).catch(e => console.warn(e))
    }, 600)
  }
}
</script>
