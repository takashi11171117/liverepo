<template>
    <section class="container">
        <h1 class="title">レポート編集</h1>
        <TextInput
                label="タイトル"
                name="title"
                :value="title"
                @input="UPDATE_INPUT({'title': $event})"
                placeholder="タイトル"
                :error="error"
        />

        <TextInput
                label="本文"
                name="content"
                :value="content"
                @input="UPDATE_INPUT({'content': $event})"
                placeholder="本文"
                :error="error"
                type="textarea"
        />

        <SelectInput
                label="ステータス"
                name="status"
                :value="status"
                @input="UPDATE_INPUT({'content': $event})"
                :error="error"
                :options="$data.reportStatus"
        />

        <SelectInput
                label="評価"
                name="rating"
                :value="rating"
                @input="UPDATE_INPUT({'content': $event})"
                :error="error"
                :options="$data.reportRating"
        />

        <TagifyInput
                name="tags"
                label="タグ"
                :error="error"
                :report_tags="report_tags"
                :onUpdate="newTags => report_tags = newTags"
        />

        <div id="image-list" v-if="report_images !== null && report_images.length > 0">
            <p class="label">画像一覧</p>
            <ul>
                <li v-for="(report_image, index) in report_images">
                    <div class="thumb-image">
                        <img @click="openGallery(index)" :src="report_image.src" alt="thumbnail" class="thumbnail">
                    </div>
                </li>
            </ul>
        </div>

        <light-box
                v-if="report_images !== null && report_images.length > 0"
                :images="report_images"
                :show-light-box="false"
                ref="lightbox"
        />

        <ImageInput
                label="画像1"
                v-model="file"
                @input="UPDATE_INPUT({'file': $event})"
                name="images.0"
                :error="error"
        />

        <div class="buttons">
            <button id="submit" @click="updateEachData({id: reportId})" class="button is-primary">保存する</button>
        </div>
    </section>
</template>

<script>
  import TextInput from '../../components/TextInput';
  import SelectInput from '../../components/SelectInput';
  import TagifyInput from '../../components/TagifyInput';
  import Tagify from '../../components/Tagify';
  import ImageInput from '../../components/ImageInput';
  import {mapGetters, mapActions, mapMutations} from 'vuex';

  export default {
    middleware: 'auth',

    layout: 'admin',

    components: {
      Tagify,
      TextInput,
      TagifyInput,
      SelectInput,
      ImageInput,
    },

    data() {
      return {
        image1: null,
      }
    },

    props: {
      reportId: {
        type: Number,
      },
    },

    computed: {
      ...mapGetters(
        {
          title: 'admin-report-edit/title',
          content: 'admin-report-edit/content',
          status: 'admin-report-edit/status',
          rating: 'admin-report-edit/rating',
          report_images: 'admin-report-edit/report_images',
          report_tags: 'admin-report-edit/report_tags',
          file: 'admin-report-edit/file',
          error: 'admin-report-edit/error',
        }
      ),
    },

    methods: {
      openGallery(index) {
        this.$refs.lightbox.showImage(index)
      },
      ...mapActions('admin-report-edit', ['updateEachData']),
      ...mapMutations('admin-report-edit', ['UPDATE_INPUT']),
    }
  }
</script>

<style scoped lang="sass">
#tagify
    margin-bottom: 20px
#image-list
    margin-bottom: 20px
    ul
        display: flex
        margin-left: -10px
        margin-right: -10px
        li
            padding-left: 10px
            padding-right: 10px
    .thumb-image
        position: relative
        > img
            width: 120px
            height: 120px
            object-fit: cover

.field
    flex-direction: column
    img
        width: 80px
        height: 80px
        object-fit: cover;

.file-button
    display: flex
    margin-bottom: 10px
</style>