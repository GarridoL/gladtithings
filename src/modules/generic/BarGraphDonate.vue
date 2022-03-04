<script>
import AUTH from 'src/services/auth'
import { Line } from 'vue-chartjs'
export default {
  name: 'Line',
  extends: Line,
  props: ['data', 'options'],
  components: {
    Line
  },
  mounted() {
    console.log('[data received]', this.data)
    this.renderChart(this.data, this.options)
  },
  watch: {
    renderChart () {
      this.$data._chart.update()
    }
  },
  data(){
    return {
      user: AUTH.user
    }
  }
}
</script>
