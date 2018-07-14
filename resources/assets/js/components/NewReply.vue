<template>
  <div class="thread-show p-4">
    <div class="form-group">
      <textarea class="form-control" v-model="body" rows="8" placeholder="Ваш ответ..."></textarea>
    </div>
    <div class="form-group">
      <button class="btn btn-success btn-block" @click="add">Ответить</button>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['threadId'],
    data() {
      return {
        body: ''
      }
    },
    methods: {
      add() {
        axios.post('/reply/'+this.threadId, {body: this.body}).then(response => this.$emit('added', response));
        this.body = '';
      }
    }
  }
</script>

<style scoped>

</style>