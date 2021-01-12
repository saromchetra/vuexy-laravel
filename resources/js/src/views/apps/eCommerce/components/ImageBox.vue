<template>
<div class="grid">
  
  <div class="vx-row">
      <div class="vx-col w-full sm:w-1/3 lg:w-1/4 mb-base" :key="index" v-for="post,index in results">
          <vx-card>
              <div slot="no-body">
                  <img :src="post.largeImageURL" alt="content-img" class="responsive card-img-top">
              </div>
          </vx-card>
      </div>
  </div>          
</div>
</template>

<script>
import { saveAs } from 'file-saver';

export default {
  name: 'NewsList',
  props: ['results'],
  components: {
      //ImageDownload: () => import('./components/ImageDownload.vue'),
  },
  data: function () {
    return {
      modal: false,
      imgDetail: ''
    }  
  },
  methods: {
    downloadImg(url) {
      fetch(url)
      .then((response) => response.blob())
      .then((blob) => {
        saveAs(blob, url);
      });
    },
    goTodetail(data) {
      this.$router.push({name:'image-detail',params:{id:data.id}})
    },
    showDownload(value) {
      this.modal = true;
      this.imgDetail = value;
      //this.$router.push({name:'image-detail',params:{id:data.id}})
    },
    hideDownload() {
      this.modal = false;
      //this.$router.push({name:'image-detail',params:{id:data.id}})
    }
  }
}
</script>


