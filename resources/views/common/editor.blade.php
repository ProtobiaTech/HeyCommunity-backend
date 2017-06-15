{{-- simditor --}}
<link rel="stylesheet" type="text/css" href="{{ asset('/bower-assets/simditor/styles/simditor.css') }}"/>
<script type="text/javascript" src="{{ asset('/bower-assets/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/bower-assets/simple-module/lib/module.js') }}"></script>
<script type="text/javascript" src="{{ asset('/bower-assets/simple-hotkeys/lib/hotkeys.js') }}"></script>
<script type="text/javascript" src="{{ asset('/bower-assets/simple-uploader/lib/uploader.js') }}"></script>
<script type="text/javascript" src="{{ asset('/bower-assets/simditor/lib/simditor.js') }}"></script>
{{-- markdown --}}
{{--<link rel="stylesheet" href="{{ asset('/bower-assets/simditor-markdown/styles/simditor-markdown.css') }}"/>--}}
{{--<script type="text/javascript" src="{{ asset('/bower-assets/marked/lib/marked.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('/bower-assets/to-markdown/dist/to-markdown.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ asset('/bower-assets/simditor-markdown/lib/simditor-markdown.js') }}"></script>--}}
{{-- init simditor --}}
<script>
    var editor = new Simditor({
        textarea: $('#editor'),
        upload: {
            {{--url: '{{ route('upload') }}',--}}
            params: null,
            fileKey: 'upload_file',
            connectionCount: 3,
            leaveConfirm: 'Uploading is in progress, are you sure to leave this page?'
        },
        toolbar: ['bold', 'italic', 'underline', 'color', '|', 'ol', 'ul', '|', 'image', '|']
    });
</script>