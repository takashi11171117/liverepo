<template>
  <no-ssr>
    <vue-tags-input
      v-model="tag"
      :tags="innerTags"
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
  @Prop() prop_tags!: { text: string }[]
  @Prop() onUpdate!: Function

  tag: string = ''
  tags: { text: string }[] = []
  autocompleteTags: Array<string> = []
  debounce = 10

  mounted () {
    this.tags = this.prop_tags
  }

  get innerTags (): { text: string }[] {
    return this.tags
  }

  set innerTags (newTags: { text: string }[]) {
    this.tags = newTags
  }

  update (newTags: { text: string }[]) {
    this.autocompleteTags = []
    this.innerTags = newTags
    this.onUpdate(newTags)
  }

  @Watch('tag')
  initItems () {
    if (this.tag.length < 1) { return }

    window.clearTimeout(this.debounce)
    this.debounce = window.setTimeout(async () => {
      await ReportTagStore.loadTagify(this.tag).then(({ data }) => {
        console.log(data)
        this.autocompleteTags = data.map((tag: {name: string}) => {
          return { text: tag.name }
        })
      // eslint-disable-next-line
      }).catch(e => console.warn(e))
    }, 10)
  }
}
</script>
