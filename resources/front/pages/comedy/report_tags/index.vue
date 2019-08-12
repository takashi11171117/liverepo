<template>
    <main class="main">
        <article class="main-content border-radius">
            <h1>タグ一覧</h1>
            <div class="category">
                <div class="columns">
                    <template v-if="tagList.length" v-for="tagCulomn in tagList">
                        <div class="report-tags column is-desktop is-3">
                            <template v-for="tagName in tagCulomn">
                                <Tag :tagName="tagName"/>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </article>
    </main>
</template>

<script>
  import UserData from '../../../components/front/UserData';
  import ReviewStars from '../../../components/front/ReviewStars';
  import Tag from '../../../components/front/Tag';

  const splitArray = (list, divide) => {
    const splitList = [];
    for(let i = 0; i < list.length; i += divide){
      // 指定した個数ずつに分割する
      splitList.push(list.slice(i, i + divide));
    }

    return splitList;
  };

  export default {
    data() {
      return {
        tagList: [],
      }
    },
    components: {
      UserData,
      ReviewStars,
      Tag,
    },
    async asyncData({$axios}) {
      const {data} = await $axios.$get('/comedy/report_tags');
      const tagList = splitArray(data, 25);

      return {tagList};
    },
  }
</script>

<style lang="sass" scoped>
    main
        background-color: #f8d048
        height: auto
        color: #000
        padding: 20px

        .main-content
            background-color: #fff
            border-radius: 8px
            padding: 15px 20px
            h1
                padding: 10px 0 10px 0
                font-size: 20px
                font-weight: bold
                line-height: 1.2

    .report-tags /deep/ a
        display: block
</style>