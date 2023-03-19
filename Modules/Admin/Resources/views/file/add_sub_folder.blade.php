@extends('admin::layouts.master')
@section('title')
 @if($title != null && $title!= "")  {{$title}} |  @endif  {{trans('message.app_name')}}
@endsection
@section('style')

    <link href="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      {{-- <link rel="stylesheet" href="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/css/zTreeStyle/zTreeStyle.css" type="text/css"> --}}

<style>
  
  .radius {
  border-radius: 50%;
}
.add_sub_folder{

    cursor: pointer;
}

*{box-sizing:border-box;}

body{
  font-family:source sans pro;
}
h3{
  font-weight:400;
  font-size:16px;
}
p{
  font-size:12px;
  color:#888;
}

.stage{
  max-width:80%;margin:60px 10%;
  position:relative;  
}
.folder-wrap{
  display: flex;
  flex-wrap:wrap;
}
.folder-wrap::before{
  content:'Folder name';
  display: block;
  position: absolute;
  top:-40px;
}
.folder-wrap:first-child::before{
  content:'S3 Documents';
  display: block;
  position: absolute;
  top:-40px;
}
.tile{
    border-radius: 3px;
    width: calc(20% - 17px);
    margin-bottom: 23px;
    text-align: center;
    border: 1px solid #eeeeee;
    transition: 0.2s all cubic-bezier(0.4, 0.0, 0.2, 1);
    position: relative;
    padding: 35px 16px 25px;
    margin-right: 17px;
    cursor: pointer;
}
.tile:hover{
  box-shadow: 0px 7px 5px -6px rgba(0, 0, 0, 0.12);
}
.tile i{
    color: #00A8FF;
    height: 55px;
    margin-bottom: 20px;
    font-size: 55px;
    display: block;
    line-height: 54px;
    cursor: pointer;
}
.tile i.mdi-file-document{
  color:#8fd9ff;
}

.back{
  font-size: 26px;
  border-radius: 50px;
  background: #00a8ff;
  border: 0;
  color: white;
  width: 60px;
  height: 60px;
  margin: 20px 20px 0;
  outline:none;
  cursor:pointer;
}

/* Transitioning */
.folder-wrap{
  position: absolute;
  width: 100%;
  transition: .365s all cubic-bezier(.4,0,.2,1);
  pointer-events: none;
  opacity: 0;
  top: 0;
}
.folder-wrap.level-up{
  transform: scale(1.2);
    
}
.folder-wrap.level-current{
  transform: scale(1);
  pointer-events:all;
  opacity:1;
  position:relative;
  height: auto;
  overflow: visible;
}
.folder-wrap.level-down{
  transform: scale(0.8);  
}

</style>
@endsection
@section('content')

<div class="preloader" style="text-align: center;
    position: fixed;
    display: none;
    left: 50%;
    top: 35%;
    z-index: 1000;">
      <img src="{{asset('/')}}assets/image/200w.gif" alt="" >
    </div>

<div class="page-wrapper">

    <div class="page-content">
        
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{trans('message.email_template_managment')}} </div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">{{trans('message.index_email_template_breadcrum')}}</li>
                    </ol>
                </nav>
            </div>
            
        </div>
        
        <div class="card">
            <div class="card-body">
                <div class="col-md-6">
                  
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary add_folder" data-toggle="modal" data-target="#add_folder">Add Folder</button>
                    <button class="btn btn-info text-white upload_file" data-toggle="modal" data-target="#upload_file">Upload File</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="stage">
  
  <div class="folder-wrap level-current scrolling">
      
      @if( !$folders->isEmpty() )
        @foreach( $folders as $ke => $folder)
          <div class="tile folder main_folder">
            <a href="{{ route('admin.file.add_sub_folder', $folder->id) }}">
              <i class="fa fa-folder"></i>
              <h3>{{ $folder->name }}</h3>
              <p>Created At: {{ date('d-m-y H:i:s', strtotime($folder->created_at)) }}</p>
            </a>
          </div>
        @endforeach
      @endif
      @if( isset( $files ) && !$files->isEmpty())

            @foreach( $files as $k => $file )

                <div class="tile folder main_folder">
                  <a href="http://{{ env('AWS_BUCKET') }}.s3.amazonaws.com/{{ $file->name }}" target="_blank">
                    <i class="fa fa-file"></i>
                    <h3>{{ $file->name }}</h3>
                    <p>Created At: {{ date('d-m-y H:i:s', strtotime($file->created_at)) }}</p>
                  </a>
                </div>
            @endforeach
      @endif

  </div>


  
   
  
</div>
            </div>
        </div>
    </div>
</div>


        <div class="modal fade" id="add_folder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form class="FromSubmit" action="{{ route('admin.file.store_sub_folder') }}" id="add_folder" />
              <input type="hidden" name="parent_id" value="{{ $parent_id }}" />
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Add Folder Name</label>
                          <input type="text" class="form-control" name="sub_folder_name" />
                          <span class="text-danger error_form" id="sub_folder_error"></span>

                      </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="add_sub_folder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form class="FromSubmit" action="{{ route('admin.file.store_sub_folder') }}" id="add_folder" />
              <input type="hidden" value="{{ $parent_id }}" />
              <div class="modal-body">
                <div class="row add_sub_folder_response">
                    
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
            </div>
          </div>
        </div>

        <div class="modal fade" id="upload_file" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form class="FromSubmit" action="{{ route('admin.file.store_sub_file') }}" id="upload_file" />
              <input type="hidden" name="parent_id" value="{{ $parent_id }}" />
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Upload File</label>
                          <input type="file" class="form-control" name="sub_file_name" />
                          <span class="text-danger error_form" id="sub_file_name_error"></span>

                      </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
            </div>
          </div>
        </div>
@endsection
@section('javascript')
    <script src="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" src="{{UPLOAD_AND_DOWNLOAD_URL()}}/admin/js/jquery.ztree.core.js"></script>

    <script>

  $(document).ready(function() {
         

      $(document).on('click', '.add_folder', function(event) {
        event.preventDefault();
        
        $('#add_folder').modal('show')
      });

      $(document).on('click', '.upload_file', function(event) {
        event.preventDefault();
        
        // $()
        $('#upload_file').modal('show')
      });

  });


</script>
  
@endsection
