<template>
  <no-ssr>
    <vue-tags-input
      v-model="tag"
      :tags="tags"
      :autocomplete-items="autocompleteTags"
      placeholder="タグを入力"
      @tags-changed="update"
    />
  </no-ssr>
</template>

<script lang="ts">
import { Component, Vue, Prop, Watch } from 'nuxt-property-decorator'
import { ReportTagStore } from '@/store'

@Component({})
export default class Tagify extends Vue {
  @Prop() propTags!: Array<string>
  @Prop() onUpdate!: Function

  tag: string = ''
  tags: Array<string> = []
  autocompleteTags: Array<string> = []
  debounce: number | undefined = undefined

  get innerTags (): Array<string> {
    return this.tags
  }

  set innerTags (newTags: Array<string>) {
    this.tags = newTags
  }

  update (newTags: Array<string>) {
    this.autocompleteTags = []
    this.innerTags = newTags
    this.onUpdate(newTags)
  }

  @Watch('tag')
  initItems () {
    if (this.tag.length < 2) { return }

    window.clearTimeout(this.debounce)
    this.debounce = window.setTimeout(async () => {
      await ReportTagStore.loadTagify(this.tag).then(({ data }) => {
        this.autocompleteTags = data.map((tag: {name: string}) => {
          return { text: tag.name }
        })
      }).catch(e => console.warn(e))
    }, 600)
  }
}
</script>
