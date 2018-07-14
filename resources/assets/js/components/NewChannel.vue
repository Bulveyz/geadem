<template>
    <div>
        <button class="btn btn-dark btn-block rounded-0" @click="active = !active">Новый канал</button>
        <div class="main-modal bg-light text-dark rounded shadow p-4" v-if="active">
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Название канала" v-model="channelName">
            </div>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Описание (необязательно)" v-model="description">
            </div>
            <label for="">Права доступа</label>
            <div class="form-group">
                <select class="form-control" v-model="channelAccess">
                    <option selected value="All">Общий</option>
                    <option value="Private">Приватный</option>
                    <option value="Password">По паролю</option>
                </select>
            </div>
            <div class="form-group">
                <input class="form-control" type="password" v-model="password" v-if="setPassword"
                       placeholder="Пароль канала">
            </div>
            <div class="form-group">
                <button class="btn btn-block btn-dark" @click="createChannel">Создать</button>
            </div>
            <div v-for="error in errors" v-if="errors">
                <p class="text-danger">{{error[0]}}</p>
            </div>
            <p class="text-success" v-if="success">Канал создан и добавлен в ваш список каналов</p>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        active: false,
        channelName: '',
        channelAccess: 'All',
        setPassword: false,
        password: '',
        description: '',
        errors: [],
        success: false
      }
    },
    watch: {
      channelAccess() {
        if (this.channelAccess == 'Password') {
          this.setPassword = true;
        } else {
          this.setPassword = false;
        }
      }
    },
    methods: {
      createChannel() {
        this.success = false;
        this.errors = [];
        axios.post('/channel', {
          channel_name: this.channelName,
          channel_access: this.channelAccess,
          hasPassword: this.setPassword,
          password: this.password,
          description: this.description
        }).then(response => {
          this.success = true;
          this.$emit('addedChannel', response.data);
        }).catch(error => {
          this.errors = error.response.data.errors;
        });
      }
    }
  }
</script>

<style scoped>
    .main-modal {
        position: absolute;
        left: 0;
        top: 100%;
        width: 100%;
        height: 700px;
        z-index: 10000;
    }

</style>