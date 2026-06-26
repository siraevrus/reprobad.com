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
        this.url = location.pathname.replace('/create', '').replace(/\/edit$/, '').replace(/\/$/, '');
        this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }
}

const initializeEditor = {
    initializeEditorJs () {
        document.querySelectorAll('.editor-js').forEach((element, index) => {
            if (!element.id) {
                element.id = `editor-js-${index}`;
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
                element.id = `editor-${index}`;
            }

            tinymce.init({
                selector: `#${element.id}`,
                license_key: 'gpl',
                height: 300,
                menubar: false,
                language: 'ru',
                language_url: '/js/ru.min.js',
                plugins: 'advlist autolink lists link image charmap preview anchor code',
                toolbar1: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | removeformat link code',
                extended_valid_elements: 'iframe[src|width|height|style|allow|allowfullscreen|frameborder|loading|referrerpolicy]',
                valid_children: '+body[iframe],+div[iframe],+p[iframe]',
                setup: (editor) => {
                    const syncField = () => {
                        const model = element.getAttribute('x-model');
                        if (!model) return;
                        const field = model.split('.')[1];
                        if (field) {
                            this.form[field] = editor.getContent();
                        }
                    };

                    editor.on('change input undo redo', syncField);
                }
            });
        });
    },

    syncTinyMCEToForm () {
        if (typeof tinymce === 'undefined') {
            return;
        }

        tinymce.editors.forEach((editor) => {
            const textarea = editor.getElement();
            if (!textarea) {
                return;
            }

            const model = textarea.getAttribute('x-model');
            if (!model) {
                return;
            }

            const field = model.split('.')[1];
            if (field) {
                this.form[field] = editor.getContent();
            }
        });
    },

    updateTinyMCEFromForm () {
        if (typeof tinymce === 'undefined') {
            return;
        }

        tinymce.editors.forEach((editor) => {
            const textarea = editor.getElement();
            if (!textarea) {
                return;
            }

            const model = textarea.getAttribute('x-model');
            if (!model) {
                return;
            }

            const field = model.split('.')[1];
            if (field && Object.prototype.hasOwnProperty.call(this.form, field)) {
                editor.setContent(this.form[field] || '', { format: 'html' });
            }
        });
    }
};

const userIsNotActive = {
    async userIsNotActive() {
        let idleTime = 0;
        const idleLimit = 10;

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
        if (!file) {
            
            return;
        }
        
        const reader = new FileReader();
        reader.onload = (e) => {
            
            this.cropperModal.imageUrl = e.target.result;
            this.cropperModal.field = field;
            this.cropperModal.show = true;
            this.cropperModal.targetWidth = targetWidth;
            this.cropperModal.targetHeight = targetHeight;
            this.$nextTick(() => {
                const imageElement = document.getElementById(`cropper-image-${field}`);
                if (imageElement) {
                    if (this.cropperModal.cropper) {
                        this.cropperModal.cropper.destroy();
                    }
                    if (typeof Cropper === 'undefined') {
                        alert('Ошибка: библиотека Cropper.js не загружена. Пожалуйста, обновите страницу.');
                        return;
                    }
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
                } else {
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
        if (typeof errorObject === 'string') {
            return errorObject;
        }
        if (typeof errorObject !== 'object' || errorObject === null) {
            return String(errorObject);
        }
        
        for (const key in errorObject) {
            if (errorObject.hasOwnProperty(key)) {
                const value = errorObject[key];
                if (Array.isArray(value)) {
                    messages += value.join("\n") + "\n";
                } else if (typeof value === 'string') {
                    messages += value + "\n";
                } else {
                    messages += String(value) + "\n";
                }
            }
        }
        return messages;
    },

    humanizeServerMessage(message) {
        if (!message || typeof message !== 'string') {
            return '';
        }

        if (message.includes('Duplicate entry')) {
            const match = message.match(/Duplicate entry '([^']+)'/);
            return match
                ? `Такой алиас уже используется: «${match[1]}». Выберите другой.`
                : 'Такой алиас уже используется. Выберите другой.';
        }

        if (message.includes('Data too long for column')) {
            const match = message.match(/Data too long for column '([^']+)'/);
            const labels = {
                alias: 'алиас',
                description: 'короткий текст',
                title: 'заголовок',
                content: 'содержание',
            };
            const field = match ? (labels[match[1]] || match[1]) : null;

            return field
                ? `Поле «${field}» слишком длинное. Сократите текст или уберите форматирование.`
                : 'Одно из полей слишком длинное. Сократите текст или уберите форматирование.';
        }

        if (message.includes('SQLSTATE') && message.includes('Integrity constraint')) {
            return 'Нарушение ограничений данных. Проверьте уникальность алиаса и длину полей.';
        }

        if (message.includes('(Connection:')) {
            return message.split('(Connection:')[0].trim();
        }

        return message;
    },

    formatSaveError(response, data) {
        const parts = [];

        if (data.errors) {
            const fieldErrors = this.getErrorMessages(data.errors).trim();
            if (fieldErrors) {
                parts.push(fieldErrors);
            }
        }

        const serverMessage = data.message || data.error;
        if (serverMessage) {
            const humanized = this.humanizeServerMessage(serverMessage);
            if (humanized && !parts.includes(humanized)) {
                parts.push(humanized);
            }
        }

        if (parts.length > 0) {
            return parts.join('\n');
        }

        if (response.status === 419) {
            return 'Сессия истекла. Обновите страницу и попробуйте снова.';
        }

        if (response.status === 413) {
            return 'Данные слишком большие (фото или текст). Уменьшите размер изображения.';
        }

        return `Ошибка сервера (${response.status} ${response.statusText})`;
    },

    showAlert(message, error = false) {
        this.alert.show = false;
        this.$nextTick(() => {
            this.alert.show = true;
            this.alert.message = error ? this.getErrorMessages(message) : message;
            this.alert.error = error;
            setTimeout(() => this.alert.show = false, error ? 8000 : 2500);
        });
    },
}

const save = {
    _saving: false,
    
    async save() {
        if (window.__adminUploadInProgress) {
            this.showAlert('Дождитесь окончания загрузки изображения', true);
            return;
        }
        if (this._saving) return;
        this._saving = true;
        this.loading = true;

        this.syncTinyMCEToForm();
        
        // base64 при новой загрузке, URL при пересохранении без изменений
        const formData = { ...this.form };
        ['image', 'logo', 'file'].forEach(field => {
            if (!(field in formData) || formData[field] === undefined) {
                formData[field] = null;
            }
        });
        
        try {
            const response = await fetch(this.url, {
                method: this.action !== 'create' ? 'PUT' : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.token
                },
                body: JSON.stringify(formData)
            });

            let data = {};
            try {
                data = await response.json();
            } catch (e) {
                this.errors = {};
                if (response.status === 413) {
                    this.showAlert('Данные слишком большие (фото или текст). Уменьшите размер изображения.', true);
                } else {
                    this.showAlert(`Ошибка сервера (${response.status} ${response.statusText})`, true);
                }
                return;
            }

            if (response.ok && data.success) {
                const seoAiMessage = 'Сохранено. Пустые SEO-поля будут заполнены автоматически в фоне.';
                if (this.action === 'create') {
                    if (data.seo_ai_queued) {
                        this.showAlert(seoAiMessage);
                        setTimeout(() => {
                            window.location.href = '/admin/' + this.route + '/';
                        }, 2000);
                    } else {
                        window.location.href = '/admin/' + this.route + '/';
                    }
                } else {
                    this.form = data.resource;
                    this.$nextTick(() => this.updateTinyMCEFromForm());
                    this.showAlert(data.seo_ai_queued ? seoAiMessage : 'Сохранено');
                }
            } else {
                this.errors = data.errors || {};
                this.showAlert(this.formatSaveError(response, data), true);
            }
        }
        catch (e) {
            this.errors = {};
            this.showAlert('Ошибка при сохранении: ' + e.message, true);
        }
        finally {
            this.loading = false;
            this._saving = false;
        }
    },
}

const get = {
    async get() {
        this.loading = true;
        try {
            const response = await fetch('/admin/' + this.route + '/' + this.action);
            const data = await response.json();
            if (data.images !== undefined) {
                if (!Array.isArray(data.images)) {
                    if (typeof data.images === 'string') {
                        try {
                            data.images = JSON.parse(data.images);
                        } catch (e) {
                            data.images = [];
                        }
                    } else {
                        data.images = data.images ? [data.images] : [];
                    }
                }
                data.images = (data.images || []).map(img => (typeof img === 'object' && img !== null)
                    ? { ...img, alt: img.alt ?? '' }
                    : { url: img, name: '', alt: '' });
            }
            // Явное присваивание для корректной реактивности Alpine.js
            for (const key in data) {
                this.form[key] = data[key];
            }
            this.loading = false;
        }
        catch (e) {
            
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
                    if (!Array.isArray(this.form[field])) {
                        if (typeof this.form[field] === 'string') {
                            try {
                                this.form[field] = JSON.parse(this.form[field]);
                            } catch (e) {
                                this.form[field] = [];
                            }
                        } else {
                            this.form[field] = this.form[field] ? [this.form[field]] : [];
                        }
                    }
                    this.form[field].push({ url: e.target.result, name: file.name, alt: '' });
                };
                reader.readAsDataURL(file);
            }
        });
    },

    removeDropzoneImage(index, field) {
        if (!Array.isArray(this.form[field])) {
            if (typeof this.form[field] === 'string') {
                try {
                    this.form[field] = JSON.parse(this.form[field]);
                } catch (e) {
                    this.form[field] = [];
                }
            } else {
                this.form[field] = this.form[field] ? [this.form[field]] : [];
            }
        }
        
        if (this.form[field][index] && this.form[field][index].url && this.form[field][index].url.startsWith('data:')) {
            this.form[field].splice(index, 1);
        }
        else if (this.form[field][index]) {
            this.form[field][index]['remove'] = !this.form[field][index]['remove'];
        }
    },

    dragDropzoneImageStart(event, index, field) {
        if (!Array.isArray(this.form[field])) {
            if (typeof this.form[field] === 'string') {
                try {
                    this.form[field] = JSON.parse(this.form[field]);
                } catch (e) {
                    this.form[field] = [];
                }
            } else {
                this.form[field] = this.form[field] ? [this.form[field]] : [];
            }
        }
        this.draggedItem = this.form[field][index];
    },

    dragDropzoneImageOver(event, index, field) {
        if (!Array.isArray(this.form[field])) {
            if (typeof this.form[field] === 'string') {
                try {
                    this.form[field] = JSON.parse(this.form[field]);
                } catch (e) {
                    this.form[field] = [];
                }
            } else {
                this.form[field] = this.form[field] ? [this.form[field]] : [];
            }
        }
        
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
