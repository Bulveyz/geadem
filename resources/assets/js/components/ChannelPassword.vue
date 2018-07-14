<template>
    <div class="password-modal p-3 rounded">
        <h4 class="mb-3">Пароль канала {{channel.IsSubscribedTo}}</h4>
        <div class="form-group">
            <input class="form-control" type="password" placeholder="Введите пароль от канала" v-model="password">
        </div>
        <div class="form-group">
            <button class="btn btn-dark btn-block" @click="check" :disabled="success">Проверить</button>
        </div>
        <p class="text-danger" v-if="error">{{error}}</p>
        <div class="text-success" v-if="success">
            <p>Доступ открыт!</p>
            <a class="btn btn-dark btn-block mb-2" :href="href">Перейти к {{channel}}</a>
            <p class="text-center">или</p>
            <button class="btn btn-dark btn-block" :disabled="subscribeButton" @click="subscribe" v-tooltip.bottom="aboutSubscribe" v-text="subscribeText"></button>
        </div>
    </div>
</template>

<script>
  export default {
    props: ['channel'],
    data() {
      return {
        password: '',
        error: '',
        subscribeButton: false,
        subscribeText: 'Подписаться на канал',
        aboutSubscribe: 'Если вы подпишитесь на канал вам больше не нужно будет вводить пароль от канала каждый раз после входа в аккаунт.',
        success: false,
        href: '/channel/' + this.channel
      }
    },
    methods: {
      check() {
        this.error = '';
        this.success = false;

        axios.post('/channel/access/' + this.channel + '/password', {channel: this.channel, password: this.password})
            .then(response => {
              this.success = true;
            })
            .catch(error => {
              this.error = error.response.data;
            });
      },

      subscribe() {
        axios.get('/channel/' + this.channel + '/subscribe')
            .then(response => {
              this.subscribeText = 'Подписан!'
              this.subscribeButton = true;
            });
      }
    }
  }
</script>

<style scoped>

</style>