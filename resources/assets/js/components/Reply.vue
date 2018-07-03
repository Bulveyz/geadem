<template>
  <div class="thread-show mb-5 p-3">
    <h5>{{reply.owner.name}} <i class="fa fa-trash-o float-right" v-if="user.id == reply.user_id" @click="deleteReply"></i><i class="fa fa-pencil mr-2 float-right" v-if="user.id == reply.user_id" @click="editMode =! editMode"></i></h5>
    <p v-if="!editMode">{{body}}</p>
    <div v-if="editMode">
      <div class="form-group">
        <textarea class="form-control" v-model="body"></textarea>
      </div>
      <div class="d-felx">
        <button class="btn btn-sm btn-outline-success" @click="updateReply">Update</button>
        <button class="btn-link border-0" @click="cancleEditMode">Cancle</button>
      </div>
    </div>
    <div class="d-flex justify-content-end" v-if="signIn">
      <i class="fa fa-thumbs-o-up fa-2x" v-tooltip.top="fCount" :class="{'active': favorite}" @click="toggle"></i>
    </div>
  </div>
</template>

<script>
  import VueStar from 'vue-star'
  export default {
    props: ['reply'],
    data() {
      return {
        favorite: this.reply.IsFavorited,
        fCount: this.reply.favoritesCount,
        user: window.App.user,
        editMode: false,
        body: this.reply.body
      }
    },
    methods: {
      cancleEditMode() {
        this.body = this.reply.body;
        this.editMode = false;
      },
      updateReply() {
        axios.patch('/reply/'+this.reply.id, {
          body: this.body
        });

        this.editMode = false;
      },
      toggle() {
        this.favorite ? this.removeFavorite() : this.addFavorite();
      },
      deleteReply() {
        // $(this.$el).fadeOut(400);
        axios.delete('/reply/'+this.reply.id).then(response => {
          this.$emit('deleted')
        });
      },
      addFavorite() {
        this.favorite = true;
        this.fCount++;
        axios.post('/favorite/reply/'+this.reply.id);
      },
      removeFavorite() {
        this.favorite = false;
        this.fCount--;
        axios.delete('/favorite/reply/'+this.reply.id);
      },
      signIn() {
        return window.App.signedIn;
      }
    }
  }
</script>

<style scoped>

</style>