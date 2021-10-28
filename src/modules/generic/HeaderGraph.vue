<template>
	<div class="card-group">
		<div class="card">
			<div class="card-body">
				<!-- <h5 class="card-title">Card title</h5> -->
				<p class="card-text">Yearly</p>
				<!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<!-- <h5 class="card-title">Card title</h5> -->
				<p class="card-text">This Year</p>
				<!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<!-- <h5 class="card-title">Card title</h5> -->
				<p class="card-text">Last Month</p>
				<!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<!-- <h5 class="card-title">Card title</h5> -->
				<p class="card-text">This Month</p>
				<!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<!-- <h5 class="card-title">Card title</h5> -->
				<p class="card-text">Last 7 Days</p>
				<!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
			</div>
		</div>
		<div class="card">
			<div class="card-body cardCollapsible" style="display:flex; flex-direction: row">
				<!-- <h5 class="card-title">Card title</h5> -->
				<p class="card-text paragraphStyling">Custom: </p>
				<!-- <date-picker
					class="date"
					v-model="custom"
					range
					:value-type="'YYYY-MM-DD'"
					:format="'MMM D, YYYY'"
					:input-class="'form-control'"
				> -->
					<!-- :type="'date'" -->
				<!-- </date-picker> -->
				<!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
			</div>
		</div>
	</div>
</template>
<script>
import DatePicker from 'vue2-datepicker'
import 'vue2-datepicker/index.css'
export default {
  data(){
  },
  components: {
    DatePicker
  }
}
</script>
<style scoped>
.card{
	padding: -3%;
	text-align: center;
}
.card-group{
	display: flex;
}
</style>
