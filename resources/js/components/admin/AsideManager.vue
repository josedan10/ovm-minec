<template>
    <div class="d-flex aside-manager">
        <div class="mb-5 ml-5">
            <h1 class="">Panel lateral</h1>
            <h5 class="secondary">Agrega una nueva imagen</h5>
            <b-form @submit.prevent="onSubmit">
                <b-form-group
                    label="Nombre:"
                    label-for="name"
                >
                    <b-form-input
                        id="name"
                        v-model="form.name"
                        required
                    ></b-form-input>
                </b-form-group>
                <b-form-group
                    label="URL:"
                    label-for="url"
                >
                    <b-form-input
                        id="name"
                        v-model="form.url"
                        required
                    ></b-form-input>
                </b-form-group>
                <vue-dropzone 
                    class="dropzone"
                    ref="dropzone"
                    id="dropzone"
                    v-on:vdropzone-complete="handleUploadedFiles"
                    :options="dropzoneOptions"
                ></vue-dropzone>
                <small class="text-secondary">Compresor y redimensionador online: <a href="https://www.iloveimg.com/es">click aquí</a></small>

                <b-row class="mt-5">
                    <b-col>
                        <b-button class="submit-btn " size="lg" type="submit" variant="primary">Agregar imagen</b-button>
                    </b-col>
                </b-row>
            </b-form>
        </div>

        <div class="mb-5 ml-5 w-100">
            <!-- <h5 class="secondary">Arrastra y mueve las páginas para cambiar el orden</h5> -->
            
            <draggable v-bind="dragOptions" v-model="imagesList" :move="handleMove">
                <transition-group class="d-flex flex-wrap" type="transition" name="flip-list">
                    <div v-for="image in imagesList" :key="image.id" class="aside-img">
                        <img :src="'/storage/' + image.src" alt="aside img">
                        <a href="javascript:;" @click="deleteImage(image.id)" class='text-danger delete-icon'>
                            <font-awesome-icon size="2x" :icon="['fas', 'times-circle']"></font-awesome-icon>
                        </a>
                        <!-- <a href="javascript:;" @click="editImage(image.id)" class='text-danger delete-icon'>
                            <font-awesome-icon size="2x" :icon="['fas', 'times-circle']"></font-awesome-icon>
                        </a> -->
                    </div>
                </transition-group>
            </draggable>
            <b-row class="mt-5">
                <b-col>
                    <b-button @click="saveImages" class="submit-btn " size="lg" type="submit" variant="primary">Guardar</b-button>
                </b-col>
            </b-row>
        </div>
        
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import axios from 'axios'
// Dropzone
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    props: ['images'],
    data: () => ({
        imagesList: [],
        form: {
            name: '',
            url: ''
        },
        dropzoneOptions: {
            url: '#',
            paramName: 'images',
            uploadMultiple: true,
            maxFilesize: 2048,
            thumbnailWidth: 300,
            addRemoveLinks: true,
            autoProcessQueue: false,
            dictDefaultMessage: "<i class='fa fa-cloud-upload'></i> CARGAR IMAGEN (Máx. 2MB)",
            acceptedFiles: 'image/*',
            asides: {
                'x-csrf-token': document.querySelector('meta[name="csrf-token"]').content
            }
        }
    }),
    components: {
        draggable,
        vueDropzone: vue2Dropzone
    },
    methods: {
        handleMove(e,a) {
            let aux = this.imagesList[e.draggedContext.index].image_order
            this.imagesList[e.draggedContext.index].image_order = this.imagesList[e.relatedContext.index].image_order
            this.imagesList[e.relatedContext.index].image_order = aux
        },
        handleUploadedFiles (response) {
            let _this = this

            if(response.status === "success") {
                this.makeToast('Imagenes cargadas');
                _this.$refs.dropzone.removeAllFiles();
                _this.updateImages();
            } else {
                this.makeToast('Error al cargar las imágenes', "danger");
            }

        },
        onSubmit () {
            let submitForm = new FormData();
            let _this = this

            for (let key in _this.form) {
                submitForm.append(key, _this.form[key]);
            }

            submitForm.append('image', _this.$refs.dropzone.getAcceptedFiles()[0])

            axios
                .post('/dashboard/aside-manager', submitForm, {
                    headers: {
                    "Content-Type": "multipart/form-data"
                    }
                })
                .then(res => {
                   _this.makeToast(res.data);
                   _this.updateImages()
                })
                .catch(err => {
                    let { data } = err.response

                    if (data.errors !== undefined || data.errors !== null) {
                        let errors = Object.values(data.errors).toString()
                        _this.makeToast(errors, "danger");
                    } else {
                        _this.makeToast(data, "danger");
                    }
                })
        },
        deleteImage (id) {
            let _this = this;

            axios
                .delete(`/dashboard/aside-manager/${id}`)
                .then(res => {
                    _this.makeToast(res.data)
                    _this.updateImages()
                })
                .catch(err => {
                    let { data } = err.response

                    if (data.errors !== undefined || data.errors !== null) {
                        let errors = Object.values(data.errors).toString()
                        _this.makeToast(errors, "danger");
                    } else {
                        _this.makeToast(data, "danger");
                    }
                })
        },
        updateImages () {
            let _this = this

            axios
                .get('/aside-images')
                .then(res => {
                    _this.imagesList = [...res.data];
                })
                .catch(err => {
                    let { data } = err.response

                    if (data.errors !== undefined || data.errors !== null) {
                        let errors = Object.values(data.errors).toString()
                        _this.makeToast(errors, "danger");
                    } else {
                        _this.makeToast(data, "danger");
                    }
                })
        },
        saveImages () {
            let _this = this

            axios
                .post('/dashboard/aside-manager/updateAll', {images: [..._this.imagesList]})
                .then(res => _this.makeToast(res.data))
                .catch(err => {
                    let { data } = err.response
                    console.log(data)

                    if (data.errors !== undefined && data.errors !== null) {
                        let errors = Object.values(data.errors).toString()
                        _this.makeToast(errors, "danger");
                    } else {
                        _this.makeToast(data.message || data, "danger");
                    }
                })
        },
        makeToast(msg, variant = "success", delay = 3000, append = false) {
            this.$bvToast.toast(`${msg}`, {
                title: "Evento de actualización del panel lateral",
                autoHideDelay: delay,
                appendToast: append,
                variant
            });
        },
    },
    mounted () {        
        this.imagesList = this.images.map((page, mainIdx) => {
            page.image_order = mainIdx + 1;
            return page;
        })
    },
    computed: {
        dragOptions() {
            return {
                animation: 200,
                group: "main",
                disabled: false,
                ghostClass: "ghost"
            };
        },
        dragOptionsSub() {
            return {
                animation: 200,
                disabled: false,
                ghostClass: "ghost"
            };
        } 
  }
}
</script>

<style lang="scss">
    @import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");
    .dropzone {
        width: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .aside-img {
        width: 300px;
        border: solid 2px #343a40;
        border-radius: 5px;
        margin: 10px 20px;
        display: flex;
        align-items: center;
        position: relative;

        .delete-icon {
            top: 10px;
            right: 10px;
            opacity: 0;
            transition: all .5s ease;
            position: absolute;
            z-index: 4;
        }

        img {
            width: 100%;

            // &:hover ~ .icon {
            //     opacity: 1;
            //     transition: all .5s ease;
            // }
        }

        &:hover {
            .delete-icon {
                opacity: 1;
                transition: all .5s ease;
            }
        }
    }

    .aside-manager > div {
        margin: 0 120px;
    }
</style>