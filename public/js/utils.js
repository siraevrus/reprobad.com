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
}

const initializeEditor = {
    initializeEditor () {
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
                        let field = element.getAttribute('x-model').split('.')[1];
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
            this.form = await response.json()
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
        this.route = location.pathname.split('/')[2];
        this.action = location.pathname.split('/')[3];
        this.url = location.pathname.replace('create', '').replace('edit', '');

        if (this.action !== 'create') {
            await this.get();
        }

        this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        //await this.userIsNotActive();
        this.initializeEditor();
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
                    this.form[field].push({ url: e.target.result, name: file.name });
                };
                reader.readAsDataURL(file);
            }
        });
    },

    removeDropzoneImage(index, field) {
        this.form[field].splice(index, 1);
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
