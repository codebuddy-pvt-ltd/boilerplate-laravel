<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

@push('scripts')
<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function() {
        $('.dropzone').each(function () {
            const _el = $(this);
            const isMultiple = typeof _el.data('multiple') !== 'undefined' ? true : false;
            const showFileUrl = _el.data('file-url')
            let myDropzone = new Dropzone(`#${$(this).attr('id')}`, {
                accept: function(file, done) {
                    console.log("uploaded");
                    done();
                },
                init: function() {
                    if (typeof showFileUrl !== 'undefined' && $.trim(showFileUrl) !== '') {
                        $.ajax({
                            type: "get",
                            url: showFileUrl,
                            dataType: "json",
                            success: function (response) {
                                $.each(response, function(key,value) {
                                    var mockFile = { name: value.name, size: value.size };

                                    myDropzone.emit("addedfile", mockFile);
                                    myDropzone.emit("thumbnail", mockFile, value.path);
                                    myDropzone.emit("complete", mockFile);
                                });
                            }
                        });
                    }
                    if (!isMultiple) {
                        this.on("addedfile", function() {
                            if (this.files[1]!=null){
                                this.removeFile(this.files[0]);
                                // $(document).find('.file-path').html('');
                            }
                        });
                    }
                    $(document).find('.file-path').html('');
                },
                url: "{{ route('drop_zone_file_upload') }}",
                acceptedFiles: typeof _el.data('accept') !== 'undefined' ? _el.data('accept') : '*',
                timeout: 0,
                parallelUploads: 10,
                uploadMultiple: false,
                addRemoveLinks: false,
                dictDefaultMessage: `<div><h6>Drag and drop to upload</h6><h6>or <a href="javascript:void(0)">browse</a> to choose a file</h6></div>`,
                sending: function(file, xhr, formData) {
                    formData.append("_token", "{{ csrf_token() }}");

                    if (typeof _el.data('path') !== 'undefined') {
                        formData.append('path', _el.data('path'))
                    }
                },
                success: function(file, response) {
                    if (typeof response.data.imagePath === 'string') {
                        $(document).find('.file-path').html(`
                        <input name="${_el.data('name')}" value="${response.data.imagePath}">
                        `);
                    } else if (typeof response.data.imagePath === 'object') {
                        let content = '';
                        response.data.imagePath.forEach((imagePath) => {
                            content += `<input name="${_el.data('name')}[]" value="${imagePath}">`
                        })
                        $(document).find('.file-path').html(content);
                    }
                },
                error: function(file, errormessage, response) {
                    console.log(response);
                }
            });
        });
    });
</script>
@endpush
