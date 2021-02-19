<!-- =========================================================================================
  File Name: ECommerceShop.vue
  Description: eCommerce Shop Page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
      <div class="vx-row">

    <!-- Record Type -->
    <div class="vx-col md:w-1/2 w-full mb-base">
      <vx-card title="Record Type" code-toggler>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Record Type</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-select v-model="city" class="w-full">
                <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="(item,index) in cityOptions" class="w-full" />
            </vs-select>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Property Type</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-select v-model="city" class="w-full">
                <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="(item,index) in cityOptions" class="w-full" />
            </vs-select>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Type of Land/Building/Current Use</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-select v-model="city" class="w-full">
                <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="(item,index) in cityOptions" class="w-full" />
            </vs-select>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Occupancy Type</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-select v-model="city" class="w-full">
                <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="(item,index) in cityOptions" class="w-full" />
            </vs-select>
          </div>
        </div>

        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>User Type</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-select v-model="city" class="w-full">
                <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="(item,index) in cityOptions" class="w-full" />
            </vs-select>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Phone</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input type="email" class="w-full" icon-pack="feather" icon="icon-mail" icon-no-border v-model="input6" />
          </div>
        </div>
      </vx-card>
    </div>



    <!-- VERTICAL DESCRIPTION -->
    <div class="vx-col md:w-1/2 w-full mb-base">
      <vx-card title="ADDRESS" code-toggler>
        <vs-tabs alignment="fixed">
        <vs-tab label="POSTAL" icon-pack="feather" icon="icon-home">
          <div>
            <div class="vx-row mb-6">
                <div class="vx-col w-full">
                  <vs-select v-model="city" class="w-full" label="Province/City">
                                <vs-select-item :key="index" :value="item.Code" :text="item.Name" v-for="(item,index) in provinceOptions" class="w-full" />
                            </vs-select>
                </div>
              </div>
              <div class="vx-row mb-6">
                <div class="vx-col w-full">
                  <vs-select v-model="city" class="w-full" label="District/Khan">
                                <vs-select-item :key="index" :value="item.Code" :text="item.Name" v-for="(item,index) in khanOptions" class="w-full" />
                            </vs-select>
                </div>
              </div>
              <div class="vx-row mb-6">
                <div class="vx-col w-full">
                  <vs-select v-model="city" class="w-full" label="Commune/Sangkat">
                                <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="(item,index) in sangkatOptions" class="w-full" />
                            </vs-select>
                </div>
              </div>
              <div class="vx-row mb-6">
                <div class="vx-col w-full">
                  <vs-select v-model="city" class="w-full" label="Village/Phum">
                                <vs-select-item :key="index" :value="item.value" :text="item.text" v-for="(item,index) in villageOptions" class="w-full" />
                            </vs-select>
                </div>
              </div>
          </div>
        </vs-tab>
        <vs-tab label="LAND" icon-pack="feather" icon="icon-home">
          <div>

          </div>
        </vs-tab>
        <vs-tab label="BUILDING" icon-pack="feather" icon="icon-home">
          <div></div>
        </vs-tab>
        <vs-tab label="TRANSACTION" icon-pack="feather" icon="icon-home">
          <div></div>
          </vs-tab>
        </vs-tabs>
        
      </vx-card>
    </div>

        <!-- VERTICAL LAYOUT WITH ICON-->
    <div class="vx-col md:w-2/2 w-full mb-base">
      <vx-card title="Map" code-toggler>
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <vs-input class="w-full" icon-pack="feather" icon="icon-user" icon-no-border label="First Name" v-model="input13" />
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <vs-input type="email" class="w-full" icon-pack="feather" icon="icon-mail" icon-no-border label="Email" v-model="input14" />
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <vs-input class="w-full" icon-pack="feather" icon="icon-smartphone" icon-no-border label="Mobile" v-model="input15" />
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <vs-input type="password" class="w-full" icon-pack="feather" icon="icon-lock" icon-no-border label="Password" v-model="input16" />
          </div>
        </div>

        <div class="vx-row">
          <div class="vx-col w-full">
            <vs-button class="mr-3 mb-2">Submit</vs-button>
            <vs-button color="warning" type="border" class="mb-2" @click="input13 = input14 = input15 = input16 = ''; check4 = false;">Cancle</vs-button>
          </div>
        </div>
      </vx-card>
    </div>



    
  </div>
</template>

<script>
import axios from "axios";
import {APIService} from '@/plugins/APIService'
export default {
  components: {
    ItemGridView: () => import('./components/ItemGridView.vue'),
    ItemListView: () => import('./components/ItemListView.vue'),
    ImageBox: () => import('./components/ImageBox.vue')
  },
  data () {
    return {
      cityOptions: [
        {text: 'New York', value:'new-york'},
        {text: 'Chicago', value:'chicago'},
        {text: 'San Francisco', value:'san-francisco'},
        {text: 'Boston', value:'boston'}
      ],
      check1: '',
      check2: '',
      check3: '',
      check4: '',
      check5: '',
      check6: '',
      check7: '',
      input1: '',
      input2: '',
      input3: '',
      input4: '',
      input5: '',
      input6: '',
      input7: '',
      input8: '',
      input9: '',
      input10: '',
      input11: '',
      input12: '',
      input13: '',
      input14: '',
      input15: '',
      input16: '',
      input17: '',
      input18: '',
      input19: '',
      input20: '',
      input21: '',
      input22: '',
      input23: '',
      input24: '',
      input25: '',
      input26: '',
      input27: '',
      input28: '',
      input29: '',
      input30: '',
      pagination: 0,
      totalRec: 0,
      perPage: 30,
      page: 1,
      totalPage: 5,
      results: [],
      catSelected: "all",
      search: "",
      orientation: "horizontal",
      sections: [
        {
          "name":"Animals",
          "value":"Animals"
        },
        {  
          "name":"Architecture/Buildings",
          "value":"Buildings",
        },
        {
          "name":"Backgrounds/Textures",
          "value":"backgrounds",
        },  
        {
          "name":"Beauty/Fashion",
          "value":"Fashion",
        },
        {
          "name":"Business/Finance",
          "value":"Business",
        },  
        {
          "name":"Computer/Communication",
          "value":"Computer",
        },
        {
          "name":"Education",
          "value":"Education",
        },
        {
          "name":"Emotions",
          "value":"Emotions",
        },
        {
          "name":"Food/Drink",
          "value":"Food",
        },
        {
          "name":"Health/Medical",
          "value":"Health",
        },
        {
          "name":"Industry/Craft",
          "value":"Industry",
        },
        {
          "name":"Music",
          "value":"Music",
        },
        {
          "name":"Nature/Landscapes",
          "value":"Nature/Landscapes",
        },
        {
          "name":"People",
          "value":"People",
        },
        {
          "name":"Places/Monuments",
          "value":"Places",
        },
        {
          "name":"Religion",
          "value":"Religion",
        },
        {
          "name":"Science/Technology",
          "value":"Science",
        },
        {
          "name":"Sports",
          "value":"Sports",
        },
        {
          "name":"Transportation/Traffic",
          "value":"Transportation",
        },
        {
          "name":"Travel/Vacation",
          "value":"Travel"
        }
      ], // create an array of the sections
      loading: true,
      title: "",
      baseUrl: "https://pixabay.com/api/?key=10554881-bb20ed3ca38e6e550878acdc2&q=",
      // edit
      // Filter Sidebar
      isFilterSidebarActive: true,
      clickNotClose: true,
      provinceOptions: [],
      khanOptions: [],
      sangkatOptions: [],
      villageOptions: []
    }
  },
  computed: {
    toValue () {
      return (value, range) => [
        value.min !== null ? value.min : range.min,
        value.max !== null ? value.max : range.max
      ]
    },
    windowWidth () { return this.$store.state.windowWidth }
  },
  mounted() {
    this.getPosts("");
  },
  watch: {
    windowWidth () {
      this.setSidebarWidth()
    }
  },
  methods: {

    buildUrl(search) {
      return this.baseUrl + search + "&image_type=photo&page=" + this.page + "&category=" + this.catSelected.toLowerCase() +"&per_page="+ this.perPage +"&orientation="+ this.orientation + "&order=popular";
    },
    getPosts(search) {
      this.loading = true;
      let url = this.buildUrl(search);
      axios
        .get(url)
        .then((response) => {
          this.loading = false;
          this.results = response.data.hits;
          var totalRecs = response.data.totalHits / this.perPage;
          this.totalRec = totalRecs.toFixed(0);    
          console.log(this.results);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    nextPage(page) {
      this.page = page;
      this.getPosts(this.search);
    },
    nextPerPage(page) {
      this.page = page+1;
      this.getPosts(this.search);
    },
    prevPerPage(page) {
      this.page = page-1;
      this.getPosts(this.search);
    },    

    // edit
    setSidebarWidth () {
      if (this.windowWidth < 992) {
        this.isFilterSidebarActive = this.clickNotClose = false
      } else {
        this.isFilterSidebarActive = this.clickNotClose = true
      }
    },

    async getProvince() {
    //   axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
        APIService.post('get-province').then((response) => {
          this.loading = false;
          this.provinceOptions = response.data
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getKhan() {
    //   axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
        APIService.post('get-khan',{Code: 12}).then((response) => {
          this.loading = false;
          this.khanOptions = response.data
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getSangkat() {
    //   axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
        APIService.post('get-sangkat').then((response) => {
          this.loading = false;
          this.sangkatOptions = response.data
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async getVillage() {
    //   axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';
        APIService.post('get-village').then((response) => {
          this.loading = false;
          this.villageOptions = response.data
        })
        .catch((error) => {
          console.log(error);
        });
    },

    
  },
  created () {
    this.setSidebarWidth();
    this.getProvince();
    this.getKhan();
    this.getSangkat();
    this.getVillage();
  }
}

</script>


<style lang="scss">


#algolia-instant-search-demo {
  .algolia-header {
    .algolia-filters-label {
      width: calc(260px + 2.4rem);
    }
  }

  #algolia-content-container {

    .vs-sidebar {
      position: relative;
      float: left;
    }
  }

  .algolia-search-input-right-aligned-icon {
    padding: 1rem 1.5rem;
  }

  .algolia-price-slider {
    min-width: unset;
  }

  .item-view-primary-action-btn {
    color: #2c2c2c !important;
    background-color: #f6f6f6;
    min-width: 50%;
  }

  .item-view-secondary-action-btn {
    min-width: 50%;
  }
}

.theme-dark {
  #algolia-instant-search-demo {
    #algolia-content-container {
      .vs-sidebar {
        background-color: #10163a;
      }
    }
  }
}

@media (min-width: 992px) {
  .vs-sidebar-rounded {
    .vs-sidebar {
      border-radius: .5rem;
    }

    .vs-sidebar--items {
      border-radius: .5rem;
    }
  }
}

@media (max-width: 992px) {
  #algolia-content-container {
    .vs-sidebar {
      position: absolute !important;
      float: none !important;
    }
  }
}

</style>

