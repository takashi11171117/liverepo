export default (ctx: any) => {
  ctx.store.dispatch('nuxtClientInit', ctx)
}
