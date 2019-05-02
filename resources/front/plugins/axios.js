import swal from 'sweetalert2'

process.env.NODE_TLS_REJECT_UNAUTHORIZED = '0';

export default ({ $axios, store, redirect }) => {
  $axios.defaults.baseURL = process.env.apiUrl;

  if (process.server) {
    return;
  }

  // Request interceptor
  $axios.onRequest(request => {
    request.baseURL = process.env.apiUrl;

    const token = store.getters['token'];

    if (token) {
      request.headers.common['Authorization'] = `Bearer ${token}`;
    }

    return request;
  });

  // Response interceptor
  $axios.onError(error => {
    const { status } = error.response || {};

    if (status >= 500) {
      swal({
        type: 'error',
        title: 'エラー',
        text: '500: サーバーエラー',
        reverseButtons: true,
        confirmButtonText: 'OK',
        cancelButtonText: 'キャンセル'
      })
    }

    if (status === 401 && store.getters['check']) {
      swal({
        type: 'warning',
        title: 'エラー',
        text: '401: 認証エラー',
        reverseButtons: true,
        confirmButtonText: 'ログインページ',
        cancelButtonText: 'キャンセル'
      }).then(() => {
        store.dispatch('logout');
        redirect({
          path: '/admin/login'
        });
      });
    }
  })
}
