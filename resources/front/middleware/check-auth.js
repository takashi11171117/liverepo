export default async ({ store, $axios }) => {
  const token = store.getters['token'];
  const admin = store.getters['admin'];

  if (process.server) {
    if (token) {
      $axios.setHeader('Authorization', `Bearer ${token}`)
    } else {
      $axios.setHeader('Authorization', '')
    }
  }

  if (!store.getters['check'] && token) {
    await store.dispatch('fetchAdmin', { admin })
  }
}