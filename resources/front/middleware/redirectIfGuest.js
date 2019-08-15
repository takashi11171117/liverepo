export default function ({ app, redirect, route }) {
  console.log(app.$auth.loggedIn);
  if (!app.$auth.loggedIn) {
    return redirect({
      name: 'auth-login',
      query: {
        redirect: route.fullPath
      }
    })
  }
}
