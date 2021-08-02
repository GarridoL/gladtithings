<template>
  <div style="margin: 56px;" v-if="item">
   <div class="modal fade" id="showBooking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{item.reservee}}</h5>
          <button type="button" class="close" @click="hideModal()" aria-label="Close">
            <span aria-hidden="true" class="text-primary">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <div class="form-group">
            <label for="name"><b>Date of Reservation:</b></label>
            <span>{{item.date_time_at_human}}</span>
          </div>
          <div class="form-group">
            <label for="name"><b>Code:</b></label>
            <span>{{item.code}}</span>
          </div>
          <div class="form-group">
            <label for="name"><b>Status:</b></label>
            <span>{{item.status}}</span>
          </div>
          <div class="form-group">
            <label for="name"><b>No. of Guest(s):</b></label>
            <span>{{item.guest}}</span>
          </div>
          <div class="form-group">
            <label for="name"><b>Guest(s):</b></label>
            <p v-for="(item, index) in item.members" :key="index">• {{item.name}}</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" @click="hideModal()">Close</button>
        </div>
      </div>
    </div>
    </div>
  </div>
</template>
<script>
import AUTH from 'src/services/auth'
import moment from 'moment'
export default {
  mounted() {},
  data() {
    return {
      item: null
    }
  },
  components: {},
  methods: {
    show(item) {
      item.guest = item.members ? item.members.length : 0
      this.item = item
      $('#showBooking').modal('show')
    },
    hideModal() {
      $('#showBooking').modal('hide')
    }
  }
}

</script>
