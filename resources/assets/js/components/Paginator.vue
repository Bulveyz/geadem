<template>
  <div v-if="shouldPaginate">
    <nav class="float-right">
      <ul class="pagination">
        <li v-show="prevUrl" class="page-item"><a class="btn btn-dark" rel="prev" href="#" @click.prevent="page--"><i class="fa fa-arrow-left"></i></a></li>

        <li v-show="nextUrl" class="page-item"><a class="btn btn-dark" rel="next" href="#" @click.prevent="page++"><i class="fa fa-arrow-right"></i></a></li>
      </ul>
    </nav>
  </div>
</template>

<script>
  export default {
    props: ['dataSet'],
    data() {
      return {
        page: 1,
        prevUrl: false,
        nextUrl: false
      }
    },
    watch: {
      dataSet() {
        this.page = this.dataSet.current_page;
        this.prevUrl = this.dataSet.prev_page_url;
        this.nextUrl = this.dataSet.next_page_url;
      },
      page() {
        this.broadcast().updateUrl();
      }
    },
    computed: {
      shouldPaginate() {
        return !!this.prevUrl || !!this.nextUrl;
      }
    },
    methods: {
      broadcast() {
        this.$emit('updated', this.page);

        return this;
      },
      updateUrl() {
        history.pushState(null, null, '?page=' + this.page);
      }
    }
  }
</script>

<style scoped>

</style>