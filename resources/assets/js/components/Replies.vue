<template>
<div>
  <new-reply @added="addReply" class="mb-4" :thread-id="threadId"></new-reply>
  <div v-for="(reply, index) in items" :key="reply.id">
    <reply :reply="reply" @deleted="remove(index)"></reply>
  </div>
  <paginator :dataSet="dataSet" @updated="getReplies"></paginator>
</div>
</template>

<script>
  import NewReply from './NewReply'
  import Reply from './Reply'
  import Paginator from './Paginator'
  export default {
    props: ['threadId'],
    components: {
      NewReply,
      Reply,
      Paginator
    },
    data() {
      return {
        items: [],
        dataSet: false
      }
    },
    methods: {
      url(page) {
        if(!page) {
          let query = location.search.match(/page=(\d+)/);
          page = query ? query[1] : 1;
        }
        return `${location.pathname}/replies?page=${page}`;
      },
      refresh(response) {
        this.dataSet = response.data
        this.items = response.data.data

        window.scrollTo(0 ,0);
      },
      getReplies(page) {
        axios.get(this.url(page)).then(this.refresh);
      },
      remove(index) {
        this.items.splice(index, 1);
      },
      addReply(reply) {
        this.items.unshift(reply.data);
      }
    },
    created() {
      this.getReplies();
    }
  }
</script>

<style scoped>

</style>