<template>

  <div :class="{'loading': loading}" class="pager-data-wrapper">
      
      <div class="row header">
        <div class="col-sm-6 text-left">
        <h1>Showtimegram</h1>
        </div>
        <div class="col-sm-6 text-right">
        <b-btn class="btn text-left post-color" v-b-modal.modalPrevent>Post Picture</b-btn>
        </div>
      </div>
      

    <!-- Main UI -->

    <!-- Modal Component -->
    <b-modal id="modalPrevent"
             ref="modal"
             title="Post Image"
             hide-footer
             @shown="clearName">

      <form @submit.stop.prevent="handleSubmit">
                                <div class="card-body">
                                    <div class="row">
                                        <b-form-input placeholder="Username" class="form-control" type="text" v-model="username"></b-form-input>
                                        <b-form-input placeholder="Caption" class="form-control" type="text" v-model="caption"></b-form-input>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3" v-if="image">
                                            <img :src="image" class="img-responsive form-control" height="70" width="90">
                                        </div>
                                        </div>
                                        <div class="row">
                                        <div class="col-md-6">
                                            <input type="file" v-on:change="onImageChange" class="form-control form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <button class="form-control btn btn-success btn-block" @click="uploadImage">Upload Image</button>
                                        </div>
                                    </div>
                                </div>


      </form>
    </b-modal>

      <!-- Pagination Slot -->
      <slot :result="getResult()">
          <div class="text-center center pb-3">
            <span v-if="!loading">
                  <b-card v-for="(item,key) in result" :key=item.id
          img-alt="Image"
          img-top
          tag="div"
          class=" post-image mb-2 default-size-items center text-center" >
          <img :src=item.image_name class="img-fluid">
    <p class="card-text">
      <h4 class="card-title text-left text-color">by: {{item.username}}</h4>
    </p>
    <div class="row">
    <div class="col-sm-6 text-left">
    <p class="card-text text-left text-color">
      {{item.caption}} <small>({{item.created_at}})</small>
    </p>
    </div>
    <div class="col-sm-6 text-right"> 
    <button href="#" class="btn btn-primary" variant="primary" v-on:click="deleteImage(key)" ><i class="fas fa-trash-alt"></i> Delete ?</button>
    </div>
    </div>
  </b-card>


                
            </span>
            <span v-if="loading">
                Loading...
            </span>
        
        </div>
      </slot>

      <!-- Pagination links -->
      <div class="pager-link text-center">
          <div v-if="pagerType == 'paged'">
              <a 
                v-show="result.length"
                :disabled="!prevPageUrl || loading" 
                :href="prevPageUrl" 
                @click.prevent="prevPage" 
                :class="{loading: loading}"
                class="btn btn-primary">Prev</a>
              
              <a 
                :disabled="!nextPageUrl || loading" 
                :href="nextPageUrl" 
                @click.prevent="nextPage" 
                :class="{loading: loading}"                
                class="btn btn-primary">Next</a>
          </div>
          
          <button
            v-if="pagerType == 'single'"
            @click.prevent="nextPage"
            class="btn btn-block btn-primary"
            :class="{loading: loading}"
            :disabled="loading || !nextPageUrl">
                {{ loading ? 'Loading...' : moreBtnText }}
          </button>
      </div>
  </div>
</template>

<script>
var csrf_token = $('meta[name="csrf-token"]').attr('content');
var apiURL = '/api/v1/posts';
export default {
  props: {
    url: {
        required: true
    },
    moreBtnText: {
        type: String,
        default: 'Load More...'
    },
    chunked: {
        type: Number,
        default: 0
    },
    prepend: {
        default: null
    },
    apepend: {
        default: null
    },
    pagerType: {
        default: 'single'
    }
  },
  data: function () {
    return {
        result: []
        }
    },
  data() {
      return {
        result: [],
        loading: true,          
        nextPageUrl: null,
        prevPageUrl: null,
        prependData: null,
        appendData: null,
        id:    '',
        username: '',
        caption: '',
        image: '',
        token: csrf_token
      }
  },
  created() {
      // load the data initially 
      this.fetchData('/api/v1/posts');
  },
  methods: {
        fetchData(url) {
            let vm = this;
            let endpoint = url ? url : this.url;

            // show loader
            vm.loading = true;

            // fetch the data from passed url property
            axios.get(endpoint).then((res) => {
                // hide the loader
                vm.loading = false;

                // Assign returend data
                if( url && vm.pagerType == 'single' ) {
                    // push next page into result
                    _.forEach(res.data.data, (item) => vm.result.push(item))
                } else {
                    // add first page
                    vm.result = res.data.data;
                }
                
                // assigne next and prev page url
                vm.nextPageUrl = res.data.next_page_url;
                vm.prevPageUrl = res.data.prev_page_url;
            }).catch((err) => {
                vm.loading = false;
            })
        },

        getResult() {
            return (this.chunked > 0) ? _.chunk(this.result, this.chunked) : this.result;
        },

        prevPage() {
            this.fetchData(this.prevPageUrl)
        },

        nextPage() {
            this.fetchData(this.nextPageUrl)
        },
                    onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            uploadImage(){
                axios.post('/image/store',{username: this.username, caption: this.caption, image: this.image, _token :   this.token}).then(response => {
                   if (response.data.success) {
                     this.fetchData('/api/v1/posts');
                     alert(response.data.success);
                   } else {
                     alert(response.data.success);
                   }
                });
            },
            deleteImage(index){
                axios.post('/image/destroy',{id: this.result[index].id, _token :   this.token}).then(response => {
                   if (response.data.success) {
                     this.fetchData('/api/v1/posts');
                     alert(response.data.success);
                   } else {
                     alert(response.data.success);
                   }
                });
            },
    clearName () {
      this.uername = '',
      this.caption = ''
    },
    handleSubmit () {
      this.clearName()
      this.$refs.modal.hide()
    }


    },

    watch: {
        prepend(newVal) {
            if( newVal ) {
                this.prependData = newVal;
                this.result.unshift(newVal);
            }

            this.prependData = null
        },

        append(newVal) {
            if( newVal ) {
                this.appendData = newVal;
                this.result.push(newVal);
            }

            this.appendData = null
        }
    }
}
</script>

<style>
    body {
        background: #17667D;
    }
    @-webkit-keyframes spinAround {
        from {
            -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
        }
        to {
            -webkit-transform: rotate(359deg);
                    transform: rotate(359deg);
        }
    }
    @keyframes spinAround {
        from {
            -webkit-transform: rotate(0deg);
                    transform: rotate(0deg);
        }
        to {
            -webkit-transform: rotate(359deg);
                    transform: rotate(359deg);
        }
    }

    .btn.loading {
    color: transparent !important;
    pointer-events: none;
    position: relative;
    }

    .btn.loading:after {
    -webkit-animation: spinAround 500ms infinite linear;
            animation: spinAround 500ms infinite linear;
    border: 2px solid #dbdbdb;
    border-radius: 290486px;
    border-right-color: transparent;
    border-top-color: transparent;
    content: "";
    display: block;
    height: 1em;
    position: relative;
    width: 1em;
    position: absolute;
    left: calc(50% - (1em / 2));
    top: calc(50% - (1em / 2));
    position: absolute !important;
    border-color: transparent transparent #fff #fff !important;
    }

    .pb-3 {
        margin-bottom: 3rem
    }

    .default-size {
        max-width:600px;
    }

    .default-size-items {
        margin-left: auto;
        max-width:640px;
    }

    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
    }
    .header {
        color: white;
        margin-top: 10px;
        margin-botton: 15px;
    }
    .transp {
        opacity: 0.5;
        filter: alpha(opacity=50); /* For IE8 and earlier */
    }
    .post-color {
        background-color: #042255;
        border-color: #042255;
    }
    .text-color {
        color: white;
    }
    .post-image {
  position: relative;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #3b7e8e;
  background-clip: border-box;
  border: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: 0.25rem;
  margin-bottom: 20px;
}


</style>
