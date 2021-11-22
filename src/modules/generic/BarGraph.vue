<script>
import AUTH from 'src/services/auth'
import { Line } from 'vue-chartjs'
export default {
  extends: Line,
  props: ['data'],
  components: {
    Line
  },
  mounted() {
    this.renderChart(this.data, {
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
