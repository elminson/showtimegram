<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="row" v-for="item in items">
                            <img class="image-card" :src="`images/${item.image_name}`" width="600px"
                                 img-alt="Card image"
                                 img-top>

                            <p class="card-text">by: {{item.username}}</p>
                            <p class="card-text">{{item.caption}}</p>
                            <p class="card-text">{{item.created_at}}</p>
                            <p>
                            <div class="col-md-3">
                              <button class="btn btn-block" @click="deleteImage"><i class="fas fa-trash-alt"></i> Delete ?</button>
                                        </div>

                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card card-default">
                                <div class="card-header">File Upload Component</div>
                                <div class="card-body">
                                    <div class="row">
                                        <input placeholder="Username" type="text" v-model="username">
                                        <input placeholder="Caption" type="text" v-model="caption">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3" v-if="image">
                                            <img :src="image" class="img-responsive" height="70" width="90">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="file" v-on:change="onImageChange" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-success btn-block" @click="uploadImage">Upload Image</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="pagination">
                <button class="btn btn-default" @click="fetchStories(pagination.prev_page_url)"
                :disabled="!pagination.prev_page_url">
                Previous
                </button>
                <span>Page {{pagination.current_page}} of {{pagination.last_page}}</span>
                <button class="btn btn-default" @click="fetchStories(pagination.next_page_url)"
                :disabled="!pagination.next_page_url">Next
                </button>
                </div>

                </div>
               

</template>
<script>
    var csrf_token = $('meta[name="csrf-token"]').attr('content');
    var apiURL = '/api/v1/posts';
    export default {
        name:'image-component',
        data(){
            return {
                id:    '',
                username: '',
                caption: '',
                image: '',
                token: csrf_token,
                items: null,
                pagination: {}
            }
        },
        data: {
            pagination: {}
        },
        created: function () {
            this.fetchData();
        },
        ready: function () {
        	this.fetchStories()
        },
        methods: {
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
                     alert(response.data.success);
                   } else {
                     alert(response.data.success);
                   }
                });
            },
            deleteImage(){
                axios.post('/image/destroy',{id: this.id, _token :   this.token}).then(response => {
                   if (response.data.success) {
                     alert(response.data.success);
                   } else {
                     alert(response.data.success);
                   }
                });
            },
            fetchStories: function (page_url) {
                let vm = this;
                page_url = page_url || '/api/v1/posts'
                this.$http.get(page_url)
                    .then(function (response) {
                        vm.makePagination(response.data)
                        vm.$set('items', response.data.data)
                    });
            },
            fetchData: function () {
                var self = this;
                $.get( apiURL, function( data ) {
                  self.items = data.data;
                });

            },
            makePagination: function(data){
                let pagination = {
                    current_page: data.current_page,
                    last_page: data.last_page,
                    next_page_url: data.next_page_url,
                    prev_page_url: data.prev_page_url
                }
                this.$set('pagination', pagination)
            }

        }
    }
</script>