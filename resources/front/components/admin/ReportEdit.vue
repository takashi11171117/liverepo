<template>
    <section class="container">
        <h1 class="title">レポート編集</h1>
        <b-field
                label="タイトル"
                :type="error.hasOwnProperty('title') ? 'is-danger': ''"
                :message="error.hasOwnProperty('title') ? error.name[0] : ''"
        >
            <b-input type="text"
                     id="title"
                     @input="UPDATE_INPUT({'title': $event})"
                     :value="title">
            </b-input>
        </b-field>

        <b-field
                label="本文"
                :type="error.hasOwnProperty('content') ? 'is-danger': ''"
                :message="error.hasOwnProperty('content') ? error.content[0] : ''"
        >
            <b-input type="textarea"
                     id="content"
                     @input="UPDATE_INPUT({'content': $event})"
                     :value="content">
            </b-input>
        </b-field>

        <b-field
                label="ステータス"
                :type="error.hasOwnProperty('status') ? 'is-danger': ''"
                :message="error.hasOwnProperty('status') ? error.status[0] : ''"
        >
            <b-select
                    id="status"
                    @change="UPDATE_INPUT({'status': $event})"
                    :value="status"
            >
                <option
                        v-for="(status, key) in $data.reportStatus"
                        :value="key"
                        :key="key">
                    {{ status }}
                </option>
            </b-select>
        </b-field>

        <b-field
                label="評価"
                :type="error.hasOwnProperty('rating') ? 'is-danger': ''"
                :message="error.hasOwnProperty('rating') ? error.rating[0] : ''"
        >
            <b-select
                    id="rating"
                    @change="UPDATE_INPUT({'rating': $event})"
                    :value="rating"
            >
                <option
                        v-for="(rating, key) in $data.reportRating"
                        v-bind:value="key"
                        :key="key">
                    {{ rating }}
                </option>
            </b-select>
        </b-field>

        <div id="tagify">
            <p class="label">タグ</p>
            <Tagify
                    :tag="tag"
                    :tags="tags"
                    @tags-changed="newTags => tags = newTags"
            />
        </div>

        <div id="image-list">
            <p class="label">画像一覧</p>
            <ul v-if="report_images.length > 0">
                <li v-for="(report_image, index) in report_images">
                    <div class="thumb-image">
                        <img @click="openGallery(index)" :src="report_image.src" alt="thumbnail" class="thumbnail">
                    </div>
                </li>
            </ul>
        </div>
        <light-box
                v-if="report_images.length > 0"
                :images="report_images"
                :show-light-box="false"
                ref="lightbox"
        />

        <b-field label="画像1">
            <div class="file-button">
                <b-upload
                        id="image1"
                        @input="UPDATE_INPUT({'file': $event})"
                        :value="file"
                        v-preview-input="image1"
                        accept="image/*"
                >
                    <a class="button is-primary">
                        <b-icon icon="upload"></b-icon>
                        <span>Click to upload</span>
                    </a>
                </b-upload>
                <span class="file-name" v-if="file">
                    {{ file.name }}
                </span>
            </div>
            <div v-if="file">
                <img :src="image1">
            </div>
        </b-field>

        <div class="buttons">
            <button id="submit" @click="updateEachData({id: reportId})" class="button is-primary">保存する</button>
        </div>
    </section>
</template>

<script>
  import Tagify from '../../components/Tagify';
  import {mapGetters, mapActions, mapMutations} from 'vuex';

  export default {
    middleware: 'auth',

    layout: 'admin',

    components: {
      Tagify,
    },

    data() {
      return {
        image1: null,
        tag: '',
        tags: [],
      }
    },

    props: {
      reportId: {
        type: String,
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