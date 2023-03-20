<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

@push('scripts')
<script>
    Dropzone.autoDiscover = false;
    $(document).ready(function() {
        $('.dropzone').each(function () {
            var _el = $(this);
            var myDropzone = new Dropzone(`#${$(this).attr('id')}`, {
                accept: function(file, done) {
                    console.log("uploaded");
                    done();
                },
                acceptedFiles: typeof _el.data('accept') !== 'undefined' ? _el.data('accept') : '*',
                init: function() {
                    this.on("addedfile", function() {
                        if (this.files[1]!=null){
                            this.removeFile(this.files[0]);
                            $(document).find('.file-path').html('');
                        }
                    });
                },
                url: "{{ route('drop_zone_file_upload') }}",
                timeout: 0,
                addRemoveLinks: false,
                dictDefaultMessage: `<div><h6>Drag and drop to upload</h6><h6>or <a href="javascript:void(0)">browse</a> to choose a file</h6></div>`,
                sending: function(file, xhr, formData) {
                    formData.append("_token", "{{ csrf_token() }}");

                    if (typeof _el.data('path') !== 'undefined') {
                        formData.append('path', _el.data('path'))
                    }
                },
                success: function(file, response) {
                    console.log(response);
                    $(document).find('.file-path').html(`
                    <input name="${_el.data('name')}" value="${response.data.imagePath}">
                    `);
                },
                error: function(file, errormessage, response) {
                    console.log(response);
                }
            });
        });
    });
</script>
@endpush