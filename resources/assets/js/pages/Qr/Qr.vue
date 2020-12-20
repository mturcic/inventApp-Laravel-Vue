<template>
    <div v-if="this.app.user">
        <b-jumbotron header="Qr-čitač" lead="Skenirajte Qr-kod kamerom uređaja">
            <b class="decode-result">
            Posljednje očitanje: {{ result }}
            </b>
        </b-jumbotron>
    
        <qrcode-stream  id="qrstream" :key="_uid" :track="paintGreenText" @decode="onDecode">
        </qrcode-stream>
    </div>
    <div id="404" v-else>
        <router-view></router-view>
        <not-found/>
    </div>
</template>

<script>
import notFound from '../404';
export default {
    data () {
        return { result: null }
    },
    props: ['app'],
        components: {
            notFound
        },
    methods: {
        onDecode (result) {
            this.result = result
        },

        paintGreenText (location, ctx) {
      const {
        topLeftCorner,
        topRightCorner,
        bottomLeftCorner,
        bottomRightCorner
      } = location

      const pointArray = [
        topLeftCorner,
        topRightCorner,
        bottomLeftCorner,
        bottomRightCorner
      ]

      const centerX = pointArray.reduce((sum, { x }) => x + sum, 0) / 4
      const centerY = pointArray.reduce((sum, { y }) => y + sum, 0) / 4

      ctx.font = "bold 24px sans-serif"
      ctx.textAlign = "center"

      ctx.lineWidth = 3
      ctx.strokeStyle = '#35495e'
      ctx.strokeText(this.result, centerX, centerY)

      ctx.fillStyle = '#5cb984'
      ctx.fillText(this.result, centerX, centerY)
    },
    }
}
</script>

<style>
    #qrstream{
        width: 80%;
        left: 10%;
    }
</style>