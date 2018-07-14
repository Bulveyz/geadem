<template>
    <div class="container">
        <button class="btn btn-dark btn-block" @click="addThread">Опубликовать</button>
        <div class="row no-gutters">
            <div class="col-4">
                <multi-select
                        v-model="channel"
                        search
                        :options="options"
                        :selectOptions="channels" btnLabel="Выбрать канал"/>
            </div>
            <div class="col-4">
                <div class="d-flex">
                    <input class="form-control rounded-0" disabled="true" placeholder="Скоро..." type="text">
                </div>
            </div>
            <div class="col-4">
                <new-channel @addedChannel="channelCreated"></new-channel>
            </div>
            <div class="col-12">
                <input class="form-control rounded-0" placeholder="Заголовок" v-model="title" type="text">
            </div>
        </div>
        <vue-editor useCustomImageHandler :editorToolbar="customToolbar" class="bg-light text-dark"
                    @imageAdded="handleImageAdded" v-model="body"></vue-editor>
        <button class="btn btn-dark btn-block" @click="addThread">Опубликовать</button>
    </div>
</template>

<script>
  import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css'
  import {VueEditor, Quill} from 'vue2-editor'
  import multiSelect from 'vue-multi-select';
  import 'vue-multi-select/dist/lib/vue-multi-select.min.css';
  import NewChannel from './NewChannel'
  import MultipleFileUploader from 'vue2-multi-uploader'

  export default {
    components: {
      VueEditor,
      Quill,
      multiSelect,
      NewChannel,
      MultipleFileUploader
    },
    data() {
      return {
        noty: false,
        title: '',
        attachmentsFiles: [],
        errors: '',
        channel: [],
        body: '',
        channels: [{
          title: 'Все каналы',
          elements: [],
        }, {
          title: 'Мои каналы',
          elements: [],
        }],
        options: {
          multi: false,
          groups: true,
          labelName: 'name',
          labelList: 'elements',
          groupName: 'title',
          cssSelected: option => (option.selected ? {'background-color': '#ddd'} : ''),
        },
        customToolbar: [
          ['bold', 'italic', 'underline'],
          [{'list': 'ordered'}, {'list': 'bullet'}],
          ['code-block', 'link', 'image'],
          [{'script': 'sub'}, {'script': 'super'}],
          [{'align': ''}, {'align': 'center'}, {'align': 'right'}],
          ['clean'],
          [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
          [{'header': [1, 2, 3, 4, 5, 6, false]}],
          [{'color': []}, {'background': []}],
        ]
      }
    },
    methods: {
      handleImageAdded(file, Editor, cursorLocation, resetUploader) {
        const formData = new FormData();
        formData.append('image', file, file.name);
        axios.post('/lol', formData).then(response => {
          Editor.insertEmbed(cursorLocation, 'image', response.data);
          resetUploader();
        });
      },
      getChannels() {
        axios.get('/thread/channels').then(response => {
          this.channels[0].elements = response.data[0];
          this.channels[1].elements = response.data[1];
        });
      },
      channelCreated(data) {
        this.channels[1].elements.unshift(data);
      },
      addThread() {
        axios.post('/thread/', {
          body: this.body,
          channel: this.channel,
          title: this.title,
          attachments: this.attachmentsFiles,
        })
            .then(response => {
              console.log(response.data);
              console.log(this.attachmentsFiles);
              this.$toast.success({
                title: 'Поток опубликован!',
                message: 'Ваша запись добавлена в канал.'
              })
            })
            .catch(error => {
              this.errors = error.response.data.errors;
              this.$toast.error({
                title: 'Ошибка',
                message: 'Заполните все поля и выберите канал!'
              })
            });
      }
    },
    mounted() {
      this.getChannels();
    },
  }
</script>

<style>
    .ql-editor {
        height: 100vh !important;
    }

    .select > button[data-v-48cef498] {
        width: 100% !important;
        padding: 10px 8px !important;
        border-radius: 0;
    }

    .select[data-v-48cef498] {
        width: 100% !important;
    }

    .pointer {
        color: #6e7991 !important;
    }
</style>