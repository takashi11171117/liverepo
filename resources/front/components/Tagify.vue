<template>
    <div>
        <vue-tags-input
                v-model="tag"
                :tags="tags"
                :autocomplete-items="autocompleteTags"
                @tags-changed="update"
                placeholder="タグを入力"
        />
    </div>
</template>

<script>
  export default {
    data() {
      return {
        tag: '',
        tags: [],
        autocompleteTags: [],
        debounce: null,
      };
    },

    watch: {
      'tag': 'initItems',
    },

    methods: {
      update(newTags) {
        this.autocompleteTags = [];
        this.tags = newTags;
      },
      initItems() {
        if (this.tag.length < 2) return;
        const url = `https://itunes.apple.com/search?term=
        ${this.tag}&entity=allArtist&attribute=allArtistTerm&limit=6`;

        clearTimeout(this.debounce);
        this.debounce = setTimeout(() => {
          this.$axios.$get(url).then(response => {
            this.autocompleteTags = response.results.map(a => {
              return { text: a.artistName };
            });
          }).catch((e) => console.warn(e));
        }, 600);
      },
    },
  };
</script>