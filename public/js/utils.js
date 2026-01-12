// utils.js

const variables = {
    alert: {
        show: false,
        message: '',
        error: ''
    },
    isDragging: false,
    errors: {},
    route: '',
    action: '',
    url: '',
    loading: false,

    initVariables() {
        this.route = location.pathname.split('/')[2];
        this.action = location.pathname.split('/')[3];
        this.url = location.pathname.replace('create', '').replace('edit', '');
        this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }
}

const initializeEditor = {
    initializeEditorJs () {
        document.querySelectorAll('.editor-js').forEach((element, index) => {
            if (!element.id) {
                element.id = `editor-js-${index}`; // Назначаем уникальный ID
            }

            const editor = new EditorJS({
                holder: element.id,
                onChange: (api, event) => {
                    const field = element.getAttribute('x-model').split('.')[1];
                    this.form[field] = event.detail.target.holder;
                }
            });
        });
    },
    initializeTinyMCE () {
        document.querySelectorAll('.editor').forEach((element, index) => {
            if (!element.id) {
                element.id = `editor-${index}`; // Назначаем уникальный ID
            }

            tinymce.init({
                selector: `#${element.id}`, // Используем уникальный ID
                height: 300,
                menubar: false,
                language: 'ru',
                language_url: '/js/ru.min.js',
                plugins: 'advlist autolink lists link image charmap preview anchor code',
                toolbar1: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat link code',
                setup: (editor) => {
                    editor.on('change', () => {
                        const field = element.getAttribute('x-model').split('.')[1];
                        this.form[field] = editor.getContent();
                    });
                }
            });
        });
    }
};

const userIsNotActive = {
    async userIsNotActive() {
        let idleTime = 0;
        const idleLimit = 10; // Время бездействия в секундах

        const resetIdleTimer = () => {
            idleTime = 0;
        };

        document.addEventListener('mousemove', resetIdleTimer);
        document.addEventListener('keydown', resetIdleTimer);
        document.addEventListener('mousedown', resetIdleTimer);
        document.addEventListener('scroll', resetIdleTimer);

        setInterval(async () => {
            idleTime++;
            if (idleTime >= idleLimit) {
                console.log('Пользователь неактивен');
                await this.save(true);
            }
        }, 1000);
    },
}

const imageUpload = {
    cropperModal: {
        show: false,
        imageUrl: '',
        field: '',
        cropper: null,
        targetWidth: 1280,
        targetHeight: 853
    },
    
    uploadImage(event, field) {
        const reader = new FileReader();
        reader.onload = () => {
            this.form[field] = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
        event.target.value = '';
    },
    
    removeImage(field) {
        this.form[field] = null;
    },
    
    openImageCropper(event, field, targetWidth = 1280, targetHeight = 853) {
        const file = event.target.files[0];
        if (!file) return;
        
        const reader = new FileReader();
        reader.onload = (e) => {
            this.cropperModal.imageUrl = e.target.result;
            this.cropperModal.field = field;
            this.cropperModal.show = true;
            this.cropperModal.targetWidth = targetWidth;
            this.cropperModal.targetHeight = targetHeight;
            
            // Ждем, пока DOM обновится
            this.$nextTick(() => {
                const imageElement = document.getElementById(`cropper-image-${field}`);
                if (imageElement) {
                    // Уничтожаем предыдущий cropper, если он существует
                    if (this.cropperModal.cropper) {
                        this.cropperModal.cropper.destroy();
                    }
                    
                    // Инициализируем новый cropper
                    this.cropperModal.cropper = new Cropper(imageElement, {
                        aspectRatio: targetWidth / targetHeight,
                        viewMode: 1,
                        autoCropArea: 1,
                        responsive: true,
                        background: false,
                        guides: true,
                        center: true,
                        highlight: true,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                    });
                }
            });
        };
        reader.readAsDataURL(file);
        event.target.value = '';
    },
    
    closeCropper() {
        if (this.cropperModal.cropper) {
            this.cropperModal.cropper.destroy();
            this.cropperModal.cropper = null;
        }
        this.cropperModal.show = false;
        this.cropperModal.imageUrl = '';
        this.cropperModal.field = '';
    },
    
    cropAndSaveImage(field) {
        if (!this.cropperModal.cropper) return;
        
        const canvas = this.cropperModal.cropper.getCroppedCanvas({
            width: this.cropperModal.targetWidth,
            height: this.cropperModal.targetHeight,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });
        
        if (canvas) {
            const croppedImageUrl = canvas.toDataURL('image/jpeg', 0.9);
            this.form[field] = croppedImageUrl;
            this.closeCropper();
        }
    },
}

const fileUpload = {
    async fileUpload(event, field) {
        const file = event.target.files[0];
        if (file) {
            try {
                this.form[field] = await this.convertFileToBase64(file);
            } catch (error) {
                this.showAlert(error, true);
            }
        }
    },

    removeFile(field) {
        this.form[field] = '';
    },

    convertFileToBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
            reader.readAsDataURL(file);
        });
    }
}

const showAlert = {

    getErrorMessages(errorObject) {
        let messages = '';
        for (const key in errorObject) {
            if (errorObject.hasOwnProperty(key)) {
                messages += errorObject[key].join("<br>") + "<br>";
            }
        }
        return messages;
    },

    showAlert(message, error = false) {
        this.alert.show = false;
        this.$nextTick(() => {
            this.alert.show = true;
            this.alert.message = error ? this.getErrorMessages(message) : message;
            this.alert.error = error;
            setTimeout(() => this.alert.show = false, 2500);
        });
    },
}

const save = {
    async save() {
        this.loading = true;
        try {
            const response = await fetch(this.url, {
                method: this.action !== 'create' ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.token
                },
                body: JSON.stringify(this.form)
            });

            const data = await response.json();
            if (data.success) {
                if(this.action === 'create') {
                    window.location.href = '/admin/' + this.route+ '/';
                }else {
                    this.form = data.resource;
                    this.showAlert('Сохранено');
                }
            } else {
                this.errors = data.errors;
                this.showAlert(data.errors, true);
            }
        }
        catch (e) {
            console.log(e)
        }
        finally {
            this.loading = false;
        }
    },
}

const get = {
    async get() {
        this.loading = true;
        try {
            const response = await fetch('/admin/' + this.route + '/' + this.action);
            this.form = Object.assign(this.form, await response.json());
            this.loading = false;
        }
        catch (e) {
            console.log(e)
        }
        finally {
            this.loading = false;
        }
    },
}

const init = {
    async init() {
        this.initVariables();

        if (this.action !== 'create') {
            await this.get();
        }

        //await this.userIsNotActive();
        this.initializeTinyMCE();
        this.initializeEditorJs();
    },
}

const dropzone = {
    handleDropzoneFiles(event, field) {
        const files = event.target.files;
        this.addDropzoneFiles(files, field);
    },

    handleDropzoneDrop(event, field) {
        this.isDragging = false;
        const files = event.dataTransfer.files;
        this.addDropzoneFiles(files, field);
    },

    addDropzoneFiles(files, field) {
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    if(this.form[field] === null) this.form[field] = [];
                    this.form[field].push({ url: e.target.result, name: file.name });
                };
                reader.readAsDataURL(file);
            }
        });
    },

    removeDropzoneImage(index, field) {
        if(this.form[field][index].url.startsWith('data:')) {
            this.form[field].splice(index, 1);
        }
        else {
            this.form[field][index]['remove'] = !this.form[field][index]['remove'];
        }
    },

    dragDropzoneImageStart(event, index, field) {
        this.draggedItem = this.form[field][index];
    },

    dragDropzoneImageOver(event, index, field) {
        const draggedOverItem = this.form[field][index];

        if (this.draggedItem === draggedOverItem) {
            return;
        }

        this.form[field] = this.form[field].filter((item) => item !== this.draggedItem);
        this.form[field].splice(index, 0, this.draggedItem);
    },

    dropDropzoneImage(event, index) {
        this.draggedItem = null;
    },

    dragDropzoneImageEnd(event) {
        this.draggedItem = null;
    }
}

const tags = {
    addTag(field) {
        if (this.form[field + '_input'].trim() !== '' && !this.form[field].includes(this.form[field + '_input'].trim())) {
            this.form[field].push(this.form[field + '_input'].trim());
        }
        this.form[field + '_input'] = '';
    },

    removeTag(index, field) {
        this.form[field].splice(index, 1);
    }
}
