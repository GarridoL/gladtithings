<template>
  <div class="container">
    <div class="row">
      <i class="fas fa-chevron-left icon-back" @click="back()"></i>
      <span style="font-size: 20px;"><b>{{languageUpdate.availableLanguages}}</b></span>
    </div>
    <p>{{languageUpdate.tapLanguage}}</p>
    <div :class="item.title.toLowerCase() === selectedLanguage ? selected : notSelected" v-on:click="changeLanguage(item.value)" v-for="(item, index) in languages" :key="index">
      <div class="column">
        <div class="flag-image-container">
          <img :src="item.title === 'English' ? require('src/assets/img/united-states.png') : require('src/assets/img/spain.png')" class="flag-image"/>
        </div>
      </div>
      <div class="column">
        <p :style="item.title.toLowerCase() === selectedLanguage ? 'color: white;' : null"><b>{{item.title}}</b></p>
        <p :style="item.title.toLowerCase() === selectedLanguage ? 'color: white;' : null">{{item.description}}</p>
      </div>
    </div>
  </div>
</template>
<script>
import ROUTER from 'src/router'
import Cards from 'src/modules/settings/CardSettings.vue'
import AUTH from 'src/services/auth'
import { English, Spanish } from 'src/modules/locales'
export default{
  data(){
    return {
      user: AUTH.user,
      languages: [
        {
          title: 'English',
          value: English,
          description: 'Hi. How are you?'
        },
        {
          title: 'Spanish',
          value: Spanish,
          description: 'Hola. ¿Cómo estás?'
        }
      ],
      language: AUTH.language,
      selected: 'containers-selected row',
      notSelected: 'containers row'
    }
  },
  computed: {
    languageUpdate: function() {
      return AUTH.language
    },
    selectedLanguage: function() {
      return AUTH.language.lang
    }
  },
  components: {
    Cards
  },
  methods: {
    back() {
      ROUTER.push('/settings')
    },
    changeLanguage(language) {
      AUTH.language = language
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.container{
  width: 60%;
  margin-top: 30px;
  margin-bottom: 50px;
}
.flag-image{
  height: 100%;
  width: 100%;
  object-fit: contain;
}
.flag-image-container{
  height: 40px;
  width: 40px;
  margin-right: 10px;
}
.icon-back{
  font-size: 20px;
  cursor: pointer;
  margin-right: 10px;
  margin-top: 4px;
  color: gray
}
.containers{
  width: 100%;
  background-color: white;
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 20px;
  cursor: pointer;
}
.containers-selected{
  width: 100%;
  background-color: $primary;
  padding: 10px;
  border-radius: 10px;
  border: .5px solid rgb(235, 235, 235);
  margin-top: 20px;
  cursor: pointer;
}
p{
  margin: 0px;
}
@media (max-width: 992px){
  .container{
    width: 100%;
    margin: 10px;
  }
}
</style>
