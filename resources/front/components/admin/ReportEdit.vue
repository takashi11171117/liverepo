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
                :message="error.hasOwnProperty('status') ? error.email[0] : ''"
        >
            <b-select v-model="status" id="status">
                <option
                        v-for="(status, key) in $data.reportStatus"
                        :value="key"
                        :key="key">
                    {{ status }}
                </option>
            </b-select>
        </b-field>


        <div class="buttons">
            <button id="submit" @click="updateEachData({id: reportId})" class="button is-primary">保存する</button>
        </div>
    </section>
</template>

<script>
  import {mapGetters, mapActions, mapMutations} from 'vuex'

  export default {
    middleware: 'auth',

    layout: 'admin',

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
          error: 'admin-report-edit/error',
        }
      )
    },

    methods: {
      ...mapActions('admin-report-edit', ['updateEachData']),
      ...mapMutations('admin-report-edit', ['UPDATE_INPUT']),
    }
  }
</script>