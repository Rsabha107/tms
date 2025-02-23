<div class="d-flex justify-content-center">
    <div class="spinner-border" style="display:none;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<!-- <div class="card mb-4">
    <div class="card-body p-3 p-sm-4"> -->
<div class="mb-5">


    @if ($task->files->isEmpty())
    <div class="d-flex flex-wrap p-20" id="task-file-list">
        <div class="align-items-center d-flex flex-column text-lightest p-20 w-100">
            <i class="fa fa-file f-21 w-100"></i>
            <div class="f-15 mt-4">
                - No files found. -
            </div>
        </div>

    </div>
    @else
    <div class="card-group">
    @foreach ($task->files as $key => $file )
    <!-- <div class="border-top py-3"> -->
    <div class="card">
    <a href="#!" ><img class="card-img-top" src="{{asset('/storage/upload/event_files/')}}/{{$file->file_name}}" style="width:230px; height:120px;" alt="..." /></a>
    <div class="card-body">
      <h4 class="card-title">First card title</h4>
      <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      <p class="card-text">
        <small class="text-muted">Last updated 45 mins ago</small>
      </p>
    </div>
  </div>


    <!-- </div> -->
    @endforeach
    @endif
</div>
</div>
<!-- </div>
</div> -->
