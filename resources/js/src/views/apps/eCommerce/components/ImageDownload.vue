<template>
    <div class="modal fade text-left show wrap-modal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg cus-modal" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myModalLabel16">Extra Large Modal</h4>
                  <button type="button" class="close" data-dismiss="modal" @click="hideDownload()">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  
                  <div class="row">
                      <div class="col-12 col-md-8 d-flex align-items-center justify-content-center mb-2 mb-md-0">
                          <div class="d-flex align-items-center justify-content-center">
                              <img :src="results.largeImageURL" class="img-fluid product-img" alt="product image" />
                          </div>
                      </div>
                      <div class="col-12 col-md-4">
                          <div class="d-flex flex-column flex-sm-row pb-1">
                              <a @click="downloadImg(results.largeImageURL)" href="javascript:void(0)" class="btn btn-primary btn-cart" style="width: 100%;">
                                  
                                  <img class="image-icon" src="/assets/fonts-svg/download.svg" alt="download">
                                  <span class="add-to-cart ml-1">Free Download</span>
                              </a>
                              
                          </div>
                          
                          <ul class="product-features list-unstyled">
                              <li>
                                <span class="mr-1">Image type: </span>	{{results.type}}
                              </li>
                              <li>
                                  <span class="mr-1">Resolution: </span>	{{results.imageWidth}} x {{results.imageHeight}}
                              </li>
                              <li>
                                  <span class="mr-1">Category: </span>	{{results.tags}} 
                              </li>
                              <li>
                                  <span class="mr-1">Views: </span>	{{results.views}} 
                              </li>
                              <li>
                                  <span class="mr-1">Downloads: </span>	{{results.downloads}} 
                              </li>
                          </ul>
                          
                          
                      </div>
                  </div>
                
              </div>
          </div>
      </div>
  </div>
    
</template>
<style>
.wrap-modal {
    display: block;
    padding-right: 13.9873px;
    background-color: #9c9c9c87;
}
.cus-modal {
  max-width: 1000px;
}
.modal-body {
  padding-top: 20px;
  padding-bottom: 20px;
}
</style>
<script>
// @ is an alias to /src
import { saveAs } from 'file-saver';
export default {
  name: "Home",
  components: {
      
  },
  props: ['modal','results'],
  data: function () {
    return {
    };
  },
  mounted() {
    
  },
  methods: {
    hideDownload() {
      this.$emit('clicked', true)
      //this.$router.push({name:'image-detail',params:{id:data.id}})
    },
    downloadImg(url) {
      fetch(url)
      .then((response) => response.blob())
      .then((blob) => {
        saveAs(blob, url);
      });
    },
    
  },
};
</script>
