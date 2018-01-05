@extends('frontend.layouts.app')

@section('title', 'Writing')

@section('content')
<section id="postNewJob">
    <div class="container">
        <div class="col-md-9">
            <div class="pnj-box">
                <form id="pnj-form" action="" method="post" class="writing-form">
                    {{ csrf_field() }}
                    <input type="hidden" name="prevIcon" value="{{ $article->wIcon }}">
                    <input type="hidden" name="writingId" value="{{ $article->writingId }}">
                    <h3>Write an Article</h3>
                    <div class="pnj-form-section">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Title</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title" required="" value="{{ $article->title }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Category</label>
                            <div class="col-sm-9 pnj-form-field">
                               <select class="form-control select2" name="category" required="">
                                    <option value="">Select Type</option>
                                    @foreach(JobCallMe::getCategories() as $cat)
                                        <option value="{!! $cat->categoryId !!}" {{ $cat->categoryId == $article->category ? 'selected="selected"' : '' }}>{!! $cat->name !!}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Description</label>
                            <div class="col-sm-9 pnj-form-field">
                                <textarea name="description" class="form-control tex-editor">{{ $article->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Citation</label>
                            <div class="col-sm-9 pnj-form-field">
                                <textarea name="citation" class="form-control" placeholder="Citation" required="" rows="6">{{ $article->citation }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">&nbsp;</label>
                            <div class="col-sm-9 pnj-form-field">
                                <input type="file" name="articleImage" class="form-control">
                            </div>
                        </div>
                        @if($article->wIcon != '')
                        <div class="form-group">
                            <label class="control-label col-sm-3">&nbsp;</label>
                            <div class="col-sm-9 pnj-form-field">
                                <span style="background-color: #f8f8f8;padding: 10px;text-align: center;display: block;">
                                    <img src="{{ url('article-images/'.$article->wIcon) }}" alt="" style="max-width: 200px;">
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-offset-4 col-md-8  pnj-btns">
                        <button type="submit" class="btn btn-primary" name="publis" onclick="saveOption('p')">PUBLISH</button>
                        <button type="submit" class="btn btn-default" name="draft" onclick="saveOption('d')">DRAFT</button>
                        <a href="{{ url('account/writings') }}" class="btn btn-default">CANCEL</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
@section('page-footer')
<style type="text/css">
input[type="file"] {
    padding: 0;
}
.text-danger{color: #ff0000 !important;}
</style>
<script type="text/javascript">
tinymce.init({
    selector: '.tex-editor',
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    },
    height: 200,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
    ],
    toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify bullist numlist outdent indent | link'
});
var isARunning = false;
var svOption = 'Publish';
function saveOption(op){
    if(op == 'd'){
        svOption = 'Draft';
    }else{
        svOption = 'Publish';
    }
}
$('form.writing-form').submit(function(e){
    if(isARunning == true){
        return false;
    }
    isARunning = true;
    var formData = new FormData($(this)[0]);
    $('.writing-form .text-danger').remove();
    $('.writing-form button[type="submit"]').prop('disabled',true);
    $.ajax({
        url: window.location.href+'?option='+svOption,
        type: 'POST',
        data: formData,
        async: false,
        success: function(response) {
            isARunning = false;
            toastr.success('Article successfully saved', '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            window.location.href = "{{ url('account/writings') }}";
            $('.writing-form button[type="submit"]').prop('disabled',false);
        },
        error: function(data){
            isARunning = false;
            var errors = data.responseJSON;
            var j = 1;
            var vError = '';
            $.each(errors, function(i,k){
                var vParent = $('.writing-form input[name="'+i+'"]').parent();
                vParent.append('<p class="text-danger">'+k+'</p>');

                var vParent = $('.writing-form select[name="'+i+'"]').parent();
                vParent.append('<p class="text-danger">'+k+'</p>');
                
                var vParent = $('.writing-form textarea[name="'+i+'"]').parent();
                vParent.append('<p class="text-danger">'+k+'</p>');
                if(j == 1){
                    vError = k;
                }
                j++;
            });
            toastr.error(vError, '', {timeOut: 5000, positionClass: "toast-bottom-center"});
            $('.writing-form button[type="submit"]').prop('disabled',false);
        },
        cache: false,
        contentType: false,
        processData: false
    });
    e.preventDefault();
})
</script>
@endsection