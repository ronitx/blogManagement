<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Blog Create Form</h2>
    <form action="{{ route('blogs.update', $value->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="email">Title <span class="text text-danger">*</span></label>
            <input type="text" class="form-control"  value="{{$value->title}}"  placeholder="Enter Title" name="title" required>
        </div>
        <div class="form-group">
            <label for="email">Description <span class="text text-danger">*</span></label>
            <textarea name="description" required cols="6" rows="6" class="form-control">{{$value->description}}</textarea>
        </div>
        <div class="form-group">
            <label for="email">Uploaded File </label><br>
            <a class="btn btn-info btn-sm" href="{{URL::to('/storage/uploads/'.$value->file)}}" target="_blank" >{{ $value->file }}</a>
        </div>
        <div class="form-group">
        <label for="form-file">Change uploaded file</label>
        <input type="file" name="file" accept=".jpg, .png, .pdf"  value="{{$value->file}}"/>
        </div>
        <div class="form-group">
            <label for="email">Status </label> <br>
            <input type="radio" name="status" value="1" @if($value->status == true) checked @endif> Active &nbsp;
            <input type="radio" name="status"  value="0" @if($value->status == false) checked @endif> Inactive &nbsp;
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
    <a  href="{{url('blogs')}}" class="btn btn-danger pull-right">Cancel</a>
</div>

</body>
</html>
