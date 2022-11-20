<script type="text/javascript">
	if(typeof(itemPopup) != "undefined"){
		$( itemPopup ).one( "loaded", function(e){
			@if($mode == 'add')
			Loading.remove($('#add_item'));
			@endif
		});
	}
</script>
<form id="save-item-form" method="post">
    <input type="hidden" class="hidden_id" name="id" value={{ $item->id }} />
    @csrf
    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">Icon</div>
                <div class="card-body text-center">
                    <!-- Profile picture image-->
                    <div class="image-upload-container" id="cover">
                        <div class="image-part">
                            <img class="thumbnail" src="@if ($item->icon) {{ $item->icon }} @else {!! asset('backend/img/no_avatar.jpg') !!} @endif"/>
                            <input type="hidden" name="cover" class="cover" value="@if ($item->icon) {{ $item->id }} @endif" />
                        </div>
                        <div class="image-action @if ($item->icon) fileExist @else fileNotExist @endif">
                            <div class="img-not-exist">
                                <span id="uploadBtn" class="btn btn-success">Select image </span>
                            </div>
                            <div class="img-exist">
                                <span class="btn btn-danger remove-image">Remove </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">Details</div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="form-row">  
                            <div class="form-group col-12">
                                <span class="el_item">Parent category:
                                    <select class="form-select form-control" name="parent_id" id="parent_id" aria-label="Default select example">
                                        <option value="0">- Root -</option>
                                        <?= $categories; ?>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="my-2"></div>
                        <div class="form-group">
                            <span class="el_item">Status:
                                <select class="form-select form-control" name="published" aria-label="Default select example">
                                    <option @if($item->published == 1) selected @endif value="1">Active</option>
                                    <option @if($item->published == 0) selected @endif value="0">Disabled</option>
                                </select>
                            </span>
                        </div>
                        <div class="my-2"></div>
                        <!-- Tab nav start-->
                        <div class="card-header border-bottom" style="background-color:#fff;">
                            <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                                @foreach (Session::get('bLangs') as $index => $lang)
                                    <li class="nav-item mr-1"><a class="nav-link @if($index == 0) active @endif" id="multi_content_{{ $lang['lang'] }}-pill" href="#multi_content_{{ $lang['lang'] }}" data-toggle="tab" role="tab" aria-controls="multi_content_{{ $lang['lang'] }}" aria-selected="@if($index == 0) true @else false @endif">{{ $lang['title'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="my-2"></div>
                        <!-- Tab nav start-->
                        <!-- Tab content start-->
                        <div class="tab-content" id="dashboardNavContent">
                            @foreach (Session::get('bLangs') as $index => $lang)
                            <?php $title = "title_".$lang['lang']?>
                            <!-- Dashboard Tab Pane 1-->
                            <div class="tab-pane fade @if($index == 0) show active @endif" id="multi_content_{{ $lang['lang'] }}" role="tabpanel" aria-labelledby="multi_content_{{ $lang['lang'] }}-pill">
                                <div class="container mt-4">
                                    <div class="form-group">
                                        <label class="small mb-1" for="title_{{ $lang['lang'] }}">Title</label>
                                        <input class="form-control" id="title_{{ $lang['lang'] }}" name="title_{{ $lang['lang'] }}" type="text" placeholder="title" value="{{$item->$title}}" />
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="modal-buttons">
                                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" onclick="save()"  id="saveItemBtn" class="btn btn-success" >Save</button>
                                </div>
                        </div>
                        <!-- Tab content end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal-buttons">
    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" onclick="save()"  id="saveItemBtn" class="btn btn-success">Save</button>
</div>
<script>
function save(){
    Loading.add($('#saveItemBtn'));
    var data = $('#save-item-form').serializeFormJSON();
    
    $.ajax({
        type: "POST",
        url: "{{route('adminCategorySave')}}",
        data: data,
        dataType: 'json',
        success: function(response){
            if(response.status == 0){
                if(response.messages){
                    toastr['error'](response.messages, 'Error');
                }else{
                    toastr['error'](response.errors, 'Error');
                }
            }
            if(response.status == 1){
                toastr['success']('Saved.', 'Success');
                window.datatable.ajax.reload(null, false);
                itemPopup.close();
            }
            Loading.remove($('#saveItemBtn'));
        },
        error: function(jqXHR, textStatus, errorThrown) {
            toastr['error'](errorThrown, 'Error');
            Loading.remove($('#saveItemBtn'));
        }
    });  
}
$(document).ready(function(){

        var upload = new SUpload;
    	upload.init({
    		uploadContainer: 'cover',
    		token: "<?php echo csrf_token(); ?>",
    		imageIdReturnEl: ".cover",
    		category: "{{$item->id}}"
    	});

      $(document).on('focusin', function(e) {
        if ($(e.target).closest(".tox-dialog").length) {
            e.stopImmediatePropagation();
        }
    });
});
</script>