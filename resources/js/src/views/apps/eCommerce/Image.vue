<!-- =========================================================================================
  File Name: ECommerceShop.vue
  Description: eCommerce Shop Page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
    <div>
        <div class="ais-InstantSearch"
            index-name="instant_search" id="algolia-instant-search-demo">

            
            <div class="algolia-header mb-4">
                <div class="flex md:items-end items-center justify-between flex-wrap">
                    <!-- TOGGLE SIDEBAR BUTTON -->
                    <feather-icon
                        class="inline-flex lg:hidden cursor-pointer mr-4"
                        icon="MenuIcon"
                        @click.stop="toggleFilterSidebar" />

                    <p class="lg:inline-flex hidden font-semibold algolia-filters-label">Filters</p>

                    <div class="flex justify-between items-end flex-grow">
                        <!-- Stats -->

                        
                    </div>
                </div>
            </div>

            <div id="algolia-content-container" class="relative clearfix">
                <vs-sidebar
                    class="items-no-padding vs-sidebar-rounded background-absolute"
                    parent="#algolia-content-container"
                    :click-not-close="clickNotClose"
                    :hidden-background="clickNotClose"
                    v-model="isFilterSidebarActive">

                    <div class="p-6 filter-container">
                        <!-- Orientation -->
                        <h6 class="font-bold mb-4">Orientation </h6>
                        <vs-select placeholder="Select" v-model="orientation" @change="getPosts(search)">
                          <vs-select-item label="all" value="all" text="All"/>
                          <vs-select-item label="horizontal" value="horizontal" text="Horizontal"/>
                          <vs-select-item label="Vertical" value="vertical" text="Vertical"/>
                        </vs-select>
                        

                        <vs-divider />
                        <!-- CATEGORIES -->
                        <h6 class="font-bold mb-4">Category</h6>
                        <ul class="">
                            <li v-for="(item, index) in sections" :key="index" v-bind:value="item">
                                <vs-radio v-model="catSelected" :vs-value="item.value" @change="getPosts(search)">{{item.name}}</vs-radio>
                            </li>
                        </ul>
                    </div>
                </vs-sidebar>

                <!-- RIGHT COL -->
                <div :class="{'sidebar-spacer-with-margin': clickNotClose}">
                    <div class="ais-SearchBox">
                        <div class="relative mb-8">

                          <!-- SEARCH INPUT -->
                          <vs-input class="w-full vs-input-shadow-drop vs-input-no-border d-theme-input-dark-bg" placeholder="Search here" size="large" v-model="search" @keyup="getPosts(search)"/>
                          <!-- SEARCH ICON -->
                          <div slot="submit-icon" class="absolute top-0 right-0 py-4 px-6">
                              <feather-icon icon="SearchIcon" svgClasses="h-6 w-6" />
                          </div>
                          
                        </div>    
                    </div>
                    <image-box v-if="!loading" :results="results"></image-box>
                    <vs-pagination
                              v-model="pagination"
                              @change="nextPage(pagination)"
                              :total="totalRec"
                              :max="7" />  
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
  components: {
    ItemGridView: () => import('./components/ItemGridView.vue'),
    ItemListView: () => import('./components/ItemListView.vue'),
    ImageBox: () => import('./components/ImageBox.vue')
  },
  data () {
    return {
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

    
  },
  created () {
    this.setSidebarWidth()
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

