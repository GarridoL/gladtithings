<script>
import AUTH from 'src/services/auth'
import { Line } from 'vue-chartjs'
export default {
  name: 'Line',
  extends: Line,
  props: ['chartData', 'options'],
  components: {
    Line
  },
  mounted() {
    this.renderChart(this.chartData, this.options)
  },
  data(){
    return {
      user: AUTH.user
    }
  },
  methods: {
    retrieve(data, option){
      return this.renderChart(data, option)
    }
  }
}

</script>
