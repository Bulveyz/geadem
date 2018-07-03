<template>
  <div class="container">
    <button class="btn btn-dark btn-block">Publish</button>
    <div class="row no-gutters">
      <div class="col-4">
        <multi-select
                v-model="channel"
                search
                :selectOptions="channels" btnLabel="Select channel" />
      </div>
      <div class="col-4">
        <div class="d-flex">
          <input class="form-control rounded-0" placeholder="Add new channel to channels list" v-model="newChannel" type="text">
          <button class="btn btn-dark rounded-0" @click="addChannel">New channel</button>
        </div>
      </div>
      <div class="col-4">
        <new-channel></new-channel>
      </div>
    </div>
    <vue-editor useCustomImageHandler :editorToolbar="customToolbar" class="bg-light text-dark" @imageAdded="handleImageAdded" v-model="body"></vue-editor>
    <button class="btn btn-dark btn-block">Publish</button>
  </div>
</template>

<script>
  import { VueEditor, Quill } from 'vue2-editor'
  import multiSelect from 'vue-multi-select';
  import 'vue-multi-select/dist/lib/vue-multi-select.min.css';
  import NewChannel from './NewChannel'
  export default {
    components: {
      VueEditor,
      Quill,
      multiSelect,
      NewChannel
    },
    data() {
      return {
        channel: [],
        body: '',
        channels: [],
        newChannel: '',
        customToolbar: [
          ['bold', 'italic', 'underline'],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }],
          ['code-block', 'link'],
          [{ 'script': 'sub'}, { 'script': 'super' }],
          [{ 'align': '' }, { 'align': 'center' }, { 'align': 'right' }],
          ['clean'],
          [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
          [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
          [{ 'color': [] }, { 'background': [] }],
        ]
      }
    },
    methods: {
      handleImageAdded(file, Editor, cursorLocation, resetUploader) {

      },
      getChannels() {
        axios.get('/thread/channels').then(response => this.channels = response.data);
      },
      addChannel() {
        axios.post('/thread/new/channel', {name: this.newChannel}).then(response => {
          this.channels.unshift(response.data);
          this.newChannel = '';
        });
      }
    },
    mounted() {
      this.getChannels();
    }
  }
</script>

<style>
.ql-editor {
  height: 100vh !important;
}

.select>button[data-v-48cef498] {
  width: 100% !important;
  padding: 10px 8px !important;
  border-radius: 0;
}

.select[data-v-48cef498] {
  width: 100% !important;
}
</style>