<script>
import AUTH from 'src/services/auth'
import { Bar } from 'vue-chartjs'
export default {
  extends: Bar,
  props: ['data'],
  components: {
    Bar
  },
  mounted() {
    this.renderChart({
      labels: this.data.labels,
      datasets: this.data.datasets
    }, {
      maintainAspectRatio: false
    })
  },
  data(){
    return {
      user: AUTH.user
    }
  }
}
</script>
