<template>
    <div>
        <vue-tags-input
                v-model="tag"
                :tags="tags"
                :autocomplete-items="autocomplete_tags"
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
        autocomplete_tags: [],
        debounce: null,
      };
    },

    mounted: function() {
      this.tags = this.prop_tags;
    },

    props: {
      prop_tags: {
        required: true,
        type: Array
      },
      onUpdate: {
        required: true,
        type: Function,
      }
      // autocomplete_tags: {
      //   type: Array
      // }
    },

    watch: {
      'tag': 'initItems',
    },

    methods: {
      update(newTags) {
        this.autocomplete_tags = [];
        this.tags = newTags;
        this.onUpdate(newTags);
      },
      initItems() {
        if (this.tag.length < 2) return;

        clearTimeout(this.debounce);
        this.debounce = setTimeout(() => {
          this.$axios.$get(`/admin/report_tag/tagify?tag=${this.tag}`).then(({data}) => {
            this.autocomplete_tags = data.map(name => {
              return { text: name };
            });
          }).catch((e) => console.warn(e));
        }, 600);
      },
    },
  };
</script>