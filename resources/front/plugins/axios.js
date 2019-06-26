import Cookies from "universal-cookie";
let cookies = null;

export default ({ $axios, store, redirect }) => {
  $axios.defaults.baseURL = process.env.apiUrl;
  let arrUrl = [];

  // Request interceptor
  $axios.onRequest(request => {
    request.baseURL = process.env.apiUrl;

    const token = store.getters['token'];

    arrUrl = request.url.split('/');

    if (token && arrUrl[0] === 'admin') {
      request.headers.common['Authorization'] = `Bearer ${token}`;
    } else {
      cookies = new Cookies(request.headers.common.cookie);
      if(cookies.get('auth._token.local')) {
        request.headers.common['Authorization'] = cookies.get('auth._token.local');
      }
    }

    return request;
  });

  // Response interceptor
  $axios.onError(error => {
    const { status } = error.response || {};

    if (status === 404) {
      if (arrUrl[0] === 'admin') {
        redirect('/admin');
      } else {
        redirect('/');
      }
    }

    if (status === 401 && store.getters['check'] && arrUrl[0] === 'admin') {
      redirect('/admin/logout');
    }
  })
}
