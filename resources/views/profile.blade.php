@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

       
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                       
                            <img src="{{ asset('storage/product/'.$user->profile_picture)}}" alt="{{$user->profile_picture}}"/>
                   


                          <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Small Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
            <!-- <form  action="{{ url('/updateprofileimage') }}" method="post" enctype="multipart/form-data"> 
            {{ csrf_field() }} 
            <input id="image-update" type="file" name="file"  accept="image/*" />
            </form> -->


<form method="POST" enctype="multipart/form-data" id="laravel-ajax-file-upload" action="javascript:void(0)" >
<div class="row">
{{ csrf_field() }} 
<div class="col-md-12">
<div class="form-group">
<input type="file" name="file" placeholder="Choose File" id="file">
<span class="text-danger">{{ $errors->first('file') }}</span>
</div>
</div>
<div class="col-md-12">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>     
</form>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

                        </div>
                    </div>
                    <div class="col-md-8">
                       
                    <form class="form-horizontal" method="POST" action="{{ route('updateprofile') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('full_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-md-4 control-label">Full Name</label>

                            <div class="col-md-6">
                                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $user->first_name }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-md-4 control-label">Last  Name</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $user->last_name }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" type="number" class="form-control" name="phone" value="{{ $user->phone }}" required autofocus>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
            
                   
                    </div>
              
                </div>






             </div>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function(){
    $("#image-update").change(function() {

        let form_data = new FormData();
        form_data.append("image", document.getElementById('image-update').files[0]);
  
   console.log(form_data);
   // let fileName = e.target.files[0];

        $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      url: "{{ url('/updateprofileimage') }}",
      type: 'POST',  
      data: form_data,
      success: function (data) {
          alert(data)
      },
      cache: false,
      processData: false
  });


  });

});


</script>

<script type="text/javascript">
$(document).ready(function (e) {
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$('#laravel-ajax-file-upload').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
var fd = new FormData();

$.ajax({
type:'POST',
url: "{{ url('updateprofileimage')}}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: (data) => {
this.reset();
alert('File has been uploaded successfully');
console.log(data);
},
error: function(data){
console.log(data);
}
});
});
});
</script>
@endsection
