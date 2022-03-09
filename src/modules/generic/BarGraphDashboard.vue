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
    this.renderChart(this.data, this.options)
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
