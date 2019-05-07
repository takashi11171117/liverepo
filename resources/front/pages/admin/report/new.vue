<template>
    <section class="container">
        <h1 class="title">レポート追加</h1>
        <b-field
                label="タイトル"
                :type="error.hasOwnProperty('title') ? 'is-danger': ''"
                :message="error.hasOwnProperty('title') ? error.name[0] : ''"
        >
            <b-input id="title"
                     v-model="title">
            </b-input>
        </b-field>

        <b-field
                label="本文"
                :type="error.hasOwnProperty('content') ? 'is-danger': ''"
                :message="error.hasOwnProperty('content') ? error.email[0] : ''"
        >
            <b-input id="content"
                     type="textarea"
                     v-model="content">
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
                        v-bind:value="key"
                        :key="key">
                    {{ status }}
                </option>
            </b-select>
        </b-field>

        <div class="buttons">
            <button id="submit" @click="onSubmit()" class="button is-primary">保存する</button>
        </div>
    </section>
</template>

<script>
  import {mapActions} from 'vuex'

  export default {
    middleware: 'auth',

    layout: 'admin',

    data() {
      return {
        title: '',
        content: '',
        status: '0',
        error: {},
      }
    },
    methods: {
      async onSubmit() {
        if (confirm('追加してもよろしいですか？')) {
          await this.addReport(
            {
              title: this.title,
              content: this.content,
              status: this.status
            }
          ).then(() => {
            this.$snackbar.open({
              duration: 5000,
              message: 'レポートを追加しました。',
              type: 'is-success',
            });
            this.$router.push('/admin/report');
          }).catch((error) => {
            console.log(error);
            this.$set(this, 'error', error.response.data.errors);
          })
        }
      },
      ...mapActions('admin-report-index', ['addReport'])
    }
  }
</script>