<template>
  <div class="containers row" @click="redirect(route)" v-if="version === 3">
    <div class="column first">
      <i :class="description === 'Direct Transfer' ? 'fas fa-church' : 'fas fa-credit-card'" style="font-size: 30px; line-height: inherit;"></i>
    </div>
    <div class="column second">
      <p><b>{{title}}</b></p>
      <p>{{dates}}</p>
    </div>
    <div class="column third">
      <p class="amount" :style="styles"><b>{{amount}}</b></p>
    </div>
  </div>
  <div class="containers row" @click="redirect(route)" v-else>
    <div class="column" style="width: 50%;">
      <p><b>{{title}}</b></p>
      <p>{{description}}</p>
    </div>
    <div class="column" style="width: 50%;">
      <i class="fas fa-chevron-right icon" v-if="version === 1"></i>
      <p class="delete-button" v-if="version === 4" @click="deleteAnnouncement(route)">Delete</p>
      <i class="fas fa-toggle-on icon" @click="clickToggle(!toggle)" v-if="version === 2 && toggle === true"></i>
      <i class="fas fa-toggle-off icon-off" @click="clickToggle(!toggle)" v-if="version === 2 && toggle === false"></i>
    </div>
    <Confirmation
    ref="confirm"
    :title="'Confirmation'"
    :message="'Are you sure you want to delete this announcement?'"
    @onConfirm="remove($event)"
    />
  </div>
</template>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import Pager from 'src/modules/generic/Pager.vue'
import Confirmation from 'src/components/increment/generic/modal/Confirmation.vue'
export default{
  props: [
    'title',
    'description',
    'route',
    'version',
    'toggle',
    'amount',
    'dates',
    'payload',
    'styles'
  ],
  mounted(){},
  data(){
    return {
      user: AUTH.user
    }
  },
  components: {
    Confirmation
  },
  methods: {
    redirect(route) {
      if(this.version !== 4) {
        ROUTER.push(route)
      }
    },
    clickToggle(value) {
      this.$emit('click_toggle', value, this.payload)
    },
    deleteAnnouncement(id) {
      this.$refs.confirm.show(id)
    },
    remove(id) {
      let parameter = {
        id: id
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('announcements/delete', parameter).then(response => {
        $('#loading').css({display: 'none'})
        this.$parent.retrieve()
      })
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
p {
  margin: 1px;
}
.first{
  text-align: center;
  vertical-align: middle;
  width: 7%;
}
.second{
  width: 60%;
}
.third{
  width: 32%;
}
.amount{
  color: $primary;
  float: right;
  margin-top: 5%;
}
.icon{
  float: right;
  font-size: 20px;
  color: $primary;
  margin-top: 7px;
}
.icon-off{
  float: right;
  font-size: 20px;
  color: $danger;
  margin-top: 7px;
}
.delete-button{
  float: right;
  color: $danger;
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
@media (max-width: 992px){
  .container{
    width: 100%;
  }
  .first{
    width: 15%;
  }
  .second{
    width: 65%;
  }
  .third{
    width: 20%;
  }
}
</style>
