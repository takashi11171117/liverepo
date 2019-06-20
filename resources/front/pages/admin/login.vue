<template>
    <section class="hero is-fullheight is-medium is-bold">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-three-quarters">
                        <article class="card" :class="{'is-waiting': loader}">
                            <div class="card-header">
                                <div class="card-header-title">管理画面ログイン</div>
                            </div>
                            <div class="card-content">
                                <div class="field">
                                    <div class="control has-icons-left">
                                        <input v-model.trim="email" class="input" type="email" placeholder="メールアドレス"
                                               required>
                                        <span class="icon is-small is-left">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                    </div>
                                    <template v-if="error.hasOwnProperty('email') && error.email.length > 0">
                                        <p class="info info--error" v-for="value in error.email">
                                            {{ value }}
                                        </p>
                                    </template>
                                </div>
                                <div class="field">
                                    <div class="control has-icons-left">
                                        <input v-model.trim="password" class="input" type="password"
                                               placeholder="パスワード" required>
                                        <span class="icon is-small is-left">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </div>
                                    <template v-if="error.hasOwnProperty('password') && error.password.length > 0">
                                        <p class="info info--error" v-for="value in error.password">
                                            {{ value }}
                                        </p>
                                    </template>
                                </div>
                                <p class="control">
                                    <button
                                        @click.stop.prevent="login()"
                                        class="button is-primary is-medium is-fullwidth form__submit"
                                    >
                                        ログイン
                                    </button>
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
  import { mapActions } from 'vuex';

  export default {
    layout: 'admin_login',
    data() {
      return {
        loader: false,
        error: {},
        email: '',
        password: '',
        remember: false
      }
    },

    middleware: [
      'redirectIfAdminAuthenticated'
    ],

    methods: {
      async login () {
        this.loader = true;
        this.error = {};

        await this.$axios.$post('auth/admin', {
          email: this.email,
          password: this.password
        })
          .then((data) => {
            console.log(data);
            this.saveToken({
              token: data.token,
              remember: data.expires_in
            });

            this.fetchAdmin({ admin: data.admin });

            this.$router.push('/admin');
          })
          .catch(error => {
            this.loader = false;
            this.password = '';
            this.error = error.response.data.errors;
          });
      },
      ...mapActions(['saveToken', 'fetchAdmin'])
    }
  }
</script>

<style lang="scss" type="text/scss">
    .info--error {
        margin-bottom: 10px;
        text-align: left;
        color: red;
        font-weight: bold;
        margin-top: 10px;
    }
    .is-waiting {
        position: relative;
        transition-duration: .3s;
        > * {
            opacity: .25;
        }
        &:before {
            content: '';
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 9;
        }
        &:after {
            background: {
                image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTA0cHgiIGhlaWdodD0iMTA0cHgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmlld0JveD0iMCAwIDEwMCAxMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIiBjbGFzcz0idWlsLWRlZmF1bHQiPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSJub25lIiBjbGFzcz0iYmsiPjwvcmVjdD48cmVjdCB4PSI0Ni41IiB5PSI0MCIgd2lkdGg9IjciIGhlaWdodD0iMjAiIHJ4PSI1IiByeT0iNSIgZmlsbD0iIzJjM2U1MCIgdHJhbnNmb3JtPSJyb3RhdGUoMCA1MCA1MCkgdHJhbnNsYXRlKDAgLTMwKSI+ICA8YW5pbWF0ZSBhdHRyaWJ1dGVOYW1lPSJvcGFjaXR5IiBmcm9tPSIxIiB0bz0iMCIgZHVyPSIxcyIgYmVnaW49IjBzIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSI+PC9hbmltYXRlPjwvcmVjdD48cmVjdCB4PSI0Ni41IiB5PSI0MCIgd2lkdGg9IjciIGhlaWdodD0iMjAiIHJ4PSI1IiByeT0iNSIgZmlsbD0iIzJjM2U1MCIgdHJhbnNmb3JtPSJyb3RhdGUoMzAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCkiPiAgPGFuaW1hdGUgYXR0cmlidXRlTmFtZT0ib3BhY2l0eSIgZnJvbT0iMSIgdG89IjAiIGR1cj0iMXMiIGJlZ2luPSIwLjA4MzMzMzMzMzMzMzMzMzMzcyIgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiPjwvYW5pbWF0ZT48L3JlY3Q+PHJlY3QgeD0iNDYuNSIgeT0iNDAiIHdpZHRoPSI3IiBoZWlnaHQ9IjIwIiByeD0iNSIgcnk9IjUiIGZpbGw9IiMyYzNlNTAiIHRyYW5zZm9ybT0icm90YXRlKDYwIDUwIDUwKSB0cmFuc2xhdGUoMCAtMzApIj4gIDxhbmltYXRlIGF0dHJpYnV0ZU5hbWU9Im9wYWNpdHkiIGZyb209IjEiIHRvPSIwIiBkdXI9IjFzIiBiZWdpbj0iMC4xNjY2NjY2NjY2NjY2NjY2NnMiIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIj48L2FuaW1hdGU+PC9yZWN0PjxyZWN0IHg9IjQ2LjUiIHk9IjQwIiB3aWR0aD0iNyIgaGVpZ2h0PSIyMCIgcng9IjUiIHJ5PSI1IiBmaWxsPSIjMmMzZTUwIiB0cmFuc2Zvcm09InJvdGF0ZSg5MCA1MCA1MCkgdHJhbnNsYXRlKDAgLTMwKSI+ICA8YW5pbWF0ZSBhdHRyaWJ1dGVOYW1lPSJvcGFjaXR5IiBmcm9tPSIxIiB0bz0iMCIgZHVyPSIxcyIgYmVnaW49IjAuMjVzIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSI+PC9hbmltYXRlPjwvcmVjdD48cmVjdCB4PSI0Ni41IiB5PSI0MCIgd2lkdGg9IjciIGhlaWdodD0iMjAiIHJ4PSI1IiByeT0iNSIgZmlsbD0iIzJjM2U1MCIgdHJhbnNmb3JtPSJyb3RhdGUoMTIwIDUwIDUwKSB0cmFuc2xhdGUoMCAtMzApIj4gIDxhbmltYXRlIGF0dHJpYnV0ZU5hbWU9Im9wYWNpdHkiIGZyb209IjEiIHRvPSIwIiBkdXI9IjFzIiBiZWdpbj0iMC4zMzMzMzMzMzMzMzMzMzMzcyIgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiPjwvYW5pbWF0ZT48L3JlY3Q+PHJlY3QgeD0iNDYuNSIgeT0iNDAiIHdpZHRoPSI3IiBoZWlnaHQ9IjIwIiByeD0iNSIgcnk9IjUiIGZpbGw9IiMyYzNlNTAiIHRyYW5zZm9ybT0icm90YXRlKDE1MCA1MCA1MCkgdHJhbnNsYXRlKDAgLTMwKSI+ICA8YW5pbWF0ZSBhdHRyaWJ1dGVOYW1lPSJvcGFjaXR5IiBmcm9tPSIxIiB0bz0iMCIgZHVyPSIxcyIgYmVnaW49IjAuNDE2NjY2NjY2NjY2NjY2N3MiIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIj48L2FuaW1hdGU+PC9yZWN0PjxyZWN0IHg9IjQ2LjUiIHk9IjQwIiB3aWR0aD0iNyIgaGVpZ2h0PSIyMCIgcng9IjUiIHJ5PSI1IiBmaWxsPSIjMmMzZTUwIiB0cmFuc2Zvcm09InJvdGF0ZSgxODAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCkiPiAgPGFuaW1hdGUgYXR0cmlidXRlTmFtZT0ib3BhY2l0eSIgZnJvbT0iMSIgdG89IjAiIGR1cj0iMXMiIGJlZ2luPSIwLjVzIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSI+PC9hbmltYXRlPjwvcmVjdD48cmVjdCB4PSI0Ni41IiB5PSI0MCIgd2lkdGg9IjciIGhlaWdodD0iMjAiIHJ4PSI1IiByeT0iNSIgZmlsbD0iIzJjM2U1MCIgdHJhbnNmb3JtPSJyb3RhdGUoMjEwIDUwIDUwKSB0cmFuc2xhdGUoMCAtMzApIj4gIDxhbmltYXRlIGF0dHJpYnV0ZU5hbWU9Im9wYWNpdHkiIGZyb209IjEiIHRvPSIwIiBkdXI9IjFzIiBiZWdpbj0iMC41ODMzMzMzMzMzMzMzMzM0cyIgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiPjwvYW5pbWF0ZT48L3JlY3Q+PHJlY3QgeD0iNDYuNSIgeT0iNDAiIHdpZHRoPSI3IiBoZWlnaHQ9IjIwIiByeD0iNSIgcnk9IjUiIGZpbGw9IiMyYzNlNTAiIHRyYW5zZm9ybT0icm90YXRlKDI0MCA1MCA1MCkgdHJhbnNsYXRlKDAgLTMwKSI+ICA8YW5pbWF0ZSBhdHRyaWJ1dGVOYW1lPSJvcGFjaXR5IiBmcm9tPSIxIiB0bz0iMCIgZHVyPSIxcyIgYmVnaW49IjAuNjY2NjY2NjY2NjY2NjY2NnMiIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIj48L2FuaW1hdGU+PC9yZWN0PjxyZWN0IHg9IjQ2LjUiIHk9IjQwIiB3aWR0aD0iNyIgaGVpZ2h0PSIyMCIgcng9IjUiIHJ5PSI1IiBmaWxsPSIjMmMzZTUwIiB0cmFuc2Zvcm09InJvdGF0ZSgyNzAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCkiPiAgPGFuaW1hdGUgYXR0cmlidXRlTmFtZT0ib3BhY2l0eSIgZnJvbT0iMSIgdG89IjAiIGR1cj0iMXMiIGJlZ2luPSIwLjc1cyIgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiPjwvYW5pbWF0ZT48L3JlY3Q+PHJlY3QgeD0iNDYuNSIgeT0iNDAiIHdpZHRoPSI3IiBoZWlnaHQ9IjIwIiByeD0iNSIgcnk9IjUiIGZpbGw9IiMyYzNlNTAiIHRyYW5zZm9ybT0icm90YXRlKDMwMCA1MCA1MCkgdHJhbnNsYXRlKDAgLTMwKSI+ICA8YW5pbWF0ZSBhdHRyaWJ1dGVOYW1lPSJvcGFjaXR5IiBmcm9tPSIxIiB0bz0iMCIgZHVyPSIxcyIgYmVnaW49IjAuODMzMzMzMzMzMzMzMzMzNHMiIHJlcGVhdENvdW50PSJpbmRlZmluaXRlIj48L2FuaW1hdGU+PC9yZWN0PjxyZWN0IHg9IjQ2LjUiIHk9IjQwIiB3aWR0aD0iNyIgaGVpZ2h0PSIyMCIgcng9IjUiIHJ5PSI1IiBmaWxsPSIjMmMzZTUwIiB0cmFuc2Zvcm09InJvdGF0ZSgzMzAgNTAgNTApIHRyYW5zbGF0ZSgwIC0zMCkiPiAgPGFuaW1hdGUgYXR0cmlidXRlTmFtZT0ib3BhY2l0eSIgZnJvbT0iMSIgdG89IjAiIGR1cj0iMXMiIGJlZ2luPSIwLjkxNjY2NjY2NjY2NjY2NjZzIiByZXBlYXRDb3VudD0iaW5kZWZpbml0ZSI+PC9hbmltYXRlPjwvcmVjdD48L3N2Zz4=);
                position: center;
                size: cover;
            }
            content: '';
            height: 64px;
            left: 50%;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 64px;
        }
    }
</style>