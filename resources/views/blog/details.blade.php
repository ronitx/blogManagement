<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script>
        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
          alert(msg);
        }
      </script>
    
    
</head>
<body>

<div class="container">
    <h2>Blog Details</h2>
        <div class="form-group">
            <label for="email">Title </label>
            <input type="text" class="form-control"  value="{{$value->title}}" readonly>
        </div>
        <div class="form-group">
            <label for="email">Description </label>
            <textarea name="description" readonly cols="6" rows="6" class="form-control">{{$value->description}}</textarea>
        </div>
        <div class="form-group">
            <label for="email">Uploaded File </label><br>
            <a class="btn btn-info btn-sm" href="{{URL::to('/storage/uploads/'.$value->file)}}" target="_blank" >{{ $value->file }}</a>
        </div>
        <div class="form-group">
            <label for="email">Status </label> <br>
            <input type="radio" name="status" value="1" @if($value->status == true) checked @endif> Active &nbsp;
            <input type="radio" name="status"  value="0" @if($value->status == false) checked @endif> Inactive &nbsp;
        </div>
    <div class="form-group">
        <label for="email">Created By  </label> <br>
        @if(isset($value->user->name))
            {{
            $value->user->name
            }}
        @endif
        <div>

        <p><label>Comments:</label></p>

        @foreach ($comments as $comment)
        <div class="well">
            <p>{{ $comment->comment }}</p>
            <p>By: {{ $comment->user->name }}</p>
            <p>{{ $comment->created_at }}</p>
            @if (Auth::check() && Auth::user()->id == $comment->commented_by) 
            <form action="{{route('comments.destroy',$comment->id  )}}" method="post">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn"><i class="fa fa-trash-o"></i></button>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-sm btn-danger" onclick="alert('Are you sure want to delete ?')">Delete</button>

             </form>
                @endif    
        </div>

        @endforeach
        {!! $comments->withQueryString()->links('pagination::bootstrap-5') !!}

        <div class="form-group">
            @if (Auth::check() && Auth::user()->id !=$value->created_by)

            <form action="{{url('/comments')}}" method="POST">
                @csrf
                <input type="hidden" name="blog_id" value="{{ $value->id }}">
                <p><label>Add Your Comment:</label></p>
                <textarea name="comment" rows="4" cols="50" required placeholder="write some comment.."></textarea>
                <br>
                <button type="submit" class="btn btn-default">Post Comment</button>
                <a href="{{url('blogs')}}" class="btn btn-danger pull-right">Cancel</a>
            </form>
            @endif

        </div>
    </div>
</div>


</body>
</html>
