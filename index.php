<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <title>File Upload Template</title>
    <style>
        /* https://tympanus.net/codrops/2015/09/15/styling-customizing-file-inputs-smart-way/ */
        .js .inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .inputfile+label {
            max-width: 80%;
            font-size: 1.25rem;
            /* 20px */
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer;
            display: inline-block;
            overflow: hidden;
            padding: 0.625rem 1.25rem;
            /* 10px 20px */
            outline: none !important;
        }

        .no-js .inputfile+label {
            display: none;
        }

        .inputfile:focus+label,
        .inputfile.has-focus+label {
            outline: 1px dotted #000;
            outline: -webkit-focus-ring-color auto 5px;
        }

        .inputfile+label * {
            /* pointer-events: none; */
            /* in case of FastClick lib use */
        }

        .inputfile+label svg {
            width: 1em;
            height: 1em;
            vertical-align: middle;
            fill: currentColor;
            margin-top: -0.25em;
            /* 4px */
            margin-right: 0.25em;
            /* 4px */
        }


        /* style 1 */

        .inputfile-1+label {
            color: #f1e5e6;
            background-color: #d3394c;
        }

        .inputfile-1:focus+label,
        .inputfile-1.has-focus+label,
        .inputfile-1+label:hover {
            background-color: #722040;
        }


        /* style 2 */

        .inputfile-2+label {
            color: #d3394c;
            border: 2px solid currentColor;
        }

        .inputfile-2:focus+label,
        .inputfile-2.has-focus+label,
        .inputfile-2+label:hover {
            color: #722040;
        }


        /* style 3 */

        .inputfile-3+label {
            color: #d3394c;
        }

        .inputfile-3:focus+label,
        .inputfile-3.has-focus+label,
        .inputfile-3+label:hover {
            color: #722040;
        }


        /* style 4 */

        .inputfile-4+label {
            color: #d3394c;
        }

        .inputfile-4:focus+label,
        .inputfile-4.has-focus+label,
        .inputfile-4+label:hover {
            color: #722040;
        }

        .inputfile-4+label figure {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #d3394c;
            display: block;
            padding: 20px;
            margin: 0 auto 10px;
        }

        .inputfile-4:focus+label figure,
        .inputfile-4.has-focus+label figure,
        .inputfile-4+label:hover figure {
            background-color: #722040;
        }

        .inputfile-4+label svg {
            width: 100%;
            height: 100%;
            fill: #f1e5e6;
        }


        /* style 5 */

        .inputfile-5+label {
            color: #d3394c;
        }

        .inputfile-5:focus+label,
        .inputfile-5.has-focus+label,
        .inputfile-5+label:hover {
            color: #722040;
        }

        .inputfile-5+label figure {
            width: 100px;
            height: 135px;
            background-color: #d3394c;
            display: block;
            position: relative;
            padding: 30px;
            margin: 0 auto 10px;
        }

        .inputfile-5:focus+label figure,
        .inputfile-5.has-focus+label figure,
        .inputfile-5+label:hover figure {
            background-color: #722040;
        }

        .inputfile-5+label figure::before,
        .inputfile-5+label figure::after {
            width: 0;
            height: 0;
            content: '';
            position: absolute;
            top: 0;
            right: 0;
        }

        .inputfile-5+label figure::before {
            border-top: 20px solid #dfc8ca;
            border-left: 20px solid transparent;
        }

        .inputfile-5+label figure::after {
            border-bottom: 20px solid #722040;
            border-right: 20px solid transparent;
        }

        .inputfile-5:focus+label figure::after,
        .inputfile-5.has-focus+label figure::after,
        .inputfile-5+label:hover figure::after {
            border-bottom-color: #d3394c;
        }

        .inputfile-5+label svg {
            width: 100%;
            height: 100%;
            fill: #f1e5e6;
        }


        /* style 6 */

        .inputfile-6+label {
            color: #d3394c;
        }

        .inputfile-6+label {
            border: 1px solid #d3394c;
            background-color: #f1e5e6;
            padding: 0;
        }

        .inputfile-6:focus+label,
        .inputfile-6.has-focus+label,
        .inputfile-6+label:hover {
            border-color: #722040;
        }

        .inputfile-6+label span,
        .inputfile-6+label strong {
            padding: 0.625rem 1.25rem;
            /* 10px 20px */
        }

        .inputfile-6+label span {
            width: 200px;
            min-height: 2em;
            display: inline-block;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            vertical-align: top;
        }

        .inputfile-6+label strong {
            height: 100%;
            color: #f1e5e6;
            background-color: #d3394c;
            display: inline-block;
        }

        .inputfile-6:focus+label strong,
        .inputfile-6.has-focus+label strong,
        .inputfile-6+label:hover strong {
            background-color: #722040;
        }

        @media screen and (max-width: 50em) {
            .inputfile-6+label strong {
                display: block;
            }
        }

        .btn {
            border-radius: 0;
            outline: none;
            border: none;
        }

        .card {
            min-height: 250px;
            ;
        }

        input:disabled {
            pointer-events: none;
            opacity: .5;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        }

        .img-thumbnail {
            object-fit: cover;
        }

        .figure {
            width: 70px;
            height: 100px;
            flex: 0 0 auto;
        }

        small {
            word-break: break-all;
        }

        .opacity-low {
            opacity: .5;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-12 col-md-6 p-3">
                <div class="card bordered m-3 p-4">
                    <div class="h4 text-secondary">Classic No JS Reload</div>
                    <?php
                    // echo '<pre>';
                    // echo htmlspecialchars(print_r($_SESSION,1));
                    // var_dump(ini_get('max_file_uploads'));
                    // echo '</pre>';           
                    $upload_files = $_SESSION['upload_files'] ?? [];

                    if (count($upload_files) > 0) {

                        if (!empty($upload_files['errors'])) {
                            echo '<div class="alert alert-danger"><ul class="m-0">';
                            foreach ($upload_files['errors'] as $message) {
                                echo '<li>' . $message . '</li>';
                            }
                            echo '</ul></div>';
                        }

                        if (!empty($upload_files['success'])) {
                            echo '<div class="alert alert-success"><ul class="m-0">';
                            foreach ($upload_files['success'] as $message) {
                                echo '<li>' . $message . '</li>';
                            }
                            echo '</ul></div>';
                        }
                    }
                    unset($_SESSION['upload_files']);
                    ?>
                    <form action="upload.php" method="post" enctype="multipart/form-data" class="mx-auto w-100 px-2">

                        <div class="input-group my-3">
                            <input type="file" name="filename[]" id="filename" multiple>
                        </div>

                        <input type="hidden" name="MAX_FILE_SIZE" value="4096">

                        <div class="input-group my-3">
                            <input type="submit" name="upload" value="Send" class="btn btn-outline-primary shadow w-100 mt-3">
                        </div>

                    </form>
                </div>
            </div>
            <div class="col-12 col-md-6 p-3">
                <div class="card bordered m-3 p-4">
                    <div class="h4 text-secondary">Ajax</div>
                    <div id="alert-ajax-danger"></div>
                    <div id="alert-ajax-success"></div>
                    <div id="gallery" class="d-flex flex-column"></div>
                    <form action="upload.php" method="post" enctype="multipart/form-data" class="mx-auto w-100 px-2 js" id="ajax">

                        <input type="hidden" name="MAX_FILE_SIZE" value="4096">

                        <div class="box">
                            <input type="file" name="file-3[]" id="file-3" class="inputfile inputfile-3" multiple />
                            <label for="file-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" /></svg>
                                <span>Choose a file&hellip;</span>
                            </label>
                        </div>

                        <div class="progress" style="height: 15px;">
                            <div class="progress-bar" style="width: 0%;"></div>
                        </div>

                        <div class="input-group my-3">
                            <input type="submit" name="upload" value="Send" class="btn btn-outline-primary shadow w-100 ">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        class Reactive {
            constructor(options) {
                this.subscribers = []
                this.target = null
                this.data = options.data
                this.init(this.data)
            }
            depend() {
                if (this.target && !this.subscribers.includes(this.target)) {
                    this.subscribers.push(this.target)
                }
            }
            notify() {
                this.subscribers.forEach(sub => sub())
            }
            init(data) {
                let self = this
                Object.keys(data).forEach(key => {
                    let internalValue = data[key]
                    Object.defineProperty(data, key, {
                        get() {
                            self.depend()
                            return internalValue
                        },
                        set(newVal) {
                            internalValue = newVal
                            self.notify()
                        }
                    })
                })
            }
            watcher(myFunc) {
                this.target = myFunc
                this.target()
                this.target = null
            }

        }



        class Upload {

            constructor() {

                // https://ru.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B8%D1%81%D0%BE%D0%BA_MIME-%D1%82%D0%B8%D0%BF%D0%BE%D0%B2
                this.PERMITED_TYPES = ['application/pdf', 'image/jpeg', 'image/png']

                this.form = document.querySelector('#ajax')
                this.input = this.form.querySelector('input[type=file]')
                this.button = this.form.querySelector('input[type=submit]')
                this.label = this.form.querySelector('.box').querySelector('span')
                this.errorsInfo = document.querySelector('#alert-ajax-danger')
                this.successInfo = document.querySelector('#alert-ajax-success')

                this.load()
                this.send()
            }

            load() {
                this.input.addEventListener('change', (e) => {
                    this.checkFiles(Array.from(e.currentTarget.files))
                    this.showProgress(0)
                })
            }

            send() {
                this.form.addEventListener('submit', (e) => {
                    e.preventDefault()
                    this.errorsInfo.innerHTML = ''
                    this.successInfo.innerHTML = ''
                    const self = this
                    const formData = new FormData()
                    reactive.data.files.forEach((file, i) => formData.append(i, file))
                    const config = {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        onUploadProgress(e) {
                            let progress = Math.round((e.loaded * 100) / e.total)
                            console.log('e: ', e)
                            self.showProgress(progress)
                        }
                    }
                    axios.post('upload.php', formData, config)
                        .then(res => {
                            // console.log('res: ', res)
                            // console.log('res.request.responseText: ', res.request.responseText)
                            try {
                                const result = JSON.parse(res.request.responseText)
                                // console.log('result: ', result)
                                if (result.errors && result.errors.length > 0) {
                                    const errors = result.errors.map(error => `<li>${error}</li>`).join('')
                                    this.errorsInfo.innerHTML = `<div class="alert alert-danger"><ul class="m-0">${errors}</ul></div>`
                                }
                                if (result.success && result.success.length > 0) {
                                    const success = result.success.map(success => `<li>${success}</li>`).join('')
                                    this.successInfo.innerHTML = `<div class="alert alert-success"><ul class="m-0">${success}</ul></div>`
                                }
                                this.input.value = null
                            } catch (error) {
                                // console.log('parse error: ', error)
                            }
                            reactive.data.files = []
                            this.input.value = null
                        })
                        .catch(rej => {
                            // https://kapeli.com/cheat_sheets/Axios.docset/Contents/Resources/Documents/index
                            if (rej.response) {
                                // The request was made and the server responded with a status code
                                // that falls out of the range of 2xx
                                // console.log('rej.response: ',rej.response);
                                // console.log('rej.response.data: ',rej.response.data);
                                if (rej.response.data) {
                                    document.querySelector('#alert-ajax-danger').innerHTML = `<div class="alert alert-danger">${rej.response.data}</div>`
                                }
                                // console.log('rej.response.status: ',rej.response.status);
                                // console.log('rej.response.headers: ',rej.response.headers);
                            } else if (rej.request) {
                                // The request was made but no response was received
                                // `rej.request` is an instance of XMLHttpRequest in the browser and an instance of
                                // http.ClientRequest in node.js
                                console.log('rej.request: ', rej.request);
                            } else {
                                // Something happened in setting up the request that triggered an Error
                                // console.log('Error', rej.message);
                            }
                            // console.log('rej.config: ', rej.config);
                        })
                })
            }

            render() {
                reactive.data.files.length > 0 ? this.button.removeAttribute('disabled') : this.button.setAttribute('disabled', '')
                reactive.data.files.length > 0 ? (this.label.innerHTML = `${reactive.data.files.length} files selected`) : (this.label.innerHTML = 'Choose a file&hellip;')
                this.showThumbnails()
            }

            showProgress(progress){
                document.querySelector('.progress-bar').style.width = `${progress}%`
                document.querySelector('.progress-bar').innerText = `${progress}%`
            }

            checkFiles(files) {
                Promise.allSettled(files.map(file => {
                        // https://stackoverflow.com/questions/46399223/async-await-in-image-loading
                        return new Promise((resolve, reject) => {
                            if (!this.PERMITED_TYPES.includes(file.type)) {
                                file.error = 'Type is not permitted'
                                return reject(file)
                            }
                            const reader = new FileReader()
                            reader.readAsDataURL(file)
                            reader.onerror = (e) => {
                                file.error = 'e'
                                return reject(file)
                            }
                            reader.onload = (e) => {
                                file.src = reader.result
                                return resolve(file)
                            }
                        })
                    }))
                    .then(res => {
                        // console.log('res: ', res)
                        reactive.data.files = res.map(file => file.status === "fulfilled" ? file.value : file.reason)                      
                    })
                    .catch(rej => {
                        // console.log('rej: ',rej)
                    })
            }

            showThumbnails() {
                const gallery = document.querySelector('#gallery')
                gallery.innerHTML = reactive.data.files.map(file => {
                    if (!file.error) {
                        let result = `
                            <div class="w-100 m-2 d-flex">
                                <figure class="figure m-2 rounded">
                            `
                        switch (file.type) {
                            case 'image/jpeg':
                            case 'image/png':
                                result += `<img src=${file.src} class="img-thumbnail h-100 w-100">`
                                break;
                            case 'application/pdf':
                                result += `
                                                <div class="d-flex justify-content-center align-items-center  h-100 w-100 text-secondary">
                                                    <i class="far fa-5x fa-file-pdf"></i>
                                                </div>
                                            `
                                break;
                            default:
                                result += `
                                                <div class="d-flex justify-content-center align-items-center  h-100 w-100 text-secondary">
                                                    <i class="far fa-5x fa-file"></i>
                                                </div>
                                            `
                                break;
                        }
                        result += `              
                                </figure>
                                <nav class="d-flex flex-column">
                                    <small class="text-secondary m-2">${file.name}</small>
                                    <div class="m-2">
                                        <a href="#" class="text-secondary" data-name="${file.name}">
                                            <i class="fas fa-trash"></i>
                                        </a>                                       
                                    </div>
                                </nav>
                            </div>
                        `
                        return result
                    } else {
                        return `
                            <div class="w-100 m-2 d-flex opacity-low">
                                <figure class="figure m-2 rounded">
                                    <div class="text-danger d-flex justify-content-center align-items-center  h-100 w-100">
                                        <i class="far fa-5x fa-file"></i>
                                    </div>
                                </figure>
                                <nav class="d-flex flex-column">
                                    <small class="text-secondary m-2">${file.name}</small>
                                    <div class="text-danger m-2">
                                        <small>${file.error}</small>
                                    </div>
                                    <div class="m-2">
                                        <a href="#" class="text-danger" data-name="${file.name}">
                                            <i class="fas fa-trash"></i>
                                        </a>                                       
                                    </div>
                                </nav>
                            </div>
                        `
                    }
                }).join('')

                Array.from(document.querySelectorAll('a[data-name]')).forEach(a => {
                    a.addEventListener('click', (e) => {
                        e.preventDefault()
                        const dataName = e.currentTarget.getAttribute('data-name')
                        reactive.data.files = reactive.data.files.filter(file => file.name !== dataName)
                    })
                })

            }


        }


        let upload = new Upload()
        let reactive = new Reactive({
            data: {
                files: []
            }
        })

        reactive.watcher(() => {
            console.log('watcher')
            reactive.data.files
            upload.render()
        })
    </script>
</body>

</html>