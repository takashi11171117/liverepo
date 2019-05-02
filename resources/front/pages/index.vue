<template>
  <div> {{data}} </div>
</template>
<script>
  export default{
    async asyncData({$axios}){
      const data = await $axios.$get('/');
      return {data};
    }
  }
</script>