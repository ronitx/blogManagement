<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blog Management</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .post-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .post-header {
            padding: 10px 15px;
            border-bottom: 1px solid #ddd;
        }
        .post-content {
            padding: 15px;
        }
        .post-author {
            font-weight: bold;
        }
        .post-time {
            color: #777;
        }
        .post-votes {
            color: #777;
            margin-top: 5px;
        }
        .post-actions {
            padding: 10px 15px;
            border-top: 1px solid #ddd;
        }
        .post-image {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
        .uploaded-file-link {
            margin-top: 10px;
            display: block;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ url('blogs') }}">Blog Management</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ url('blogs') }}">Blog List</a></li>
            <li><a href="{{ url('blogs/create') }}">Create Blog</a></li>
        </ul>
        <form class="navbar-form navbar-right" action="{{ url('blogs') }}" method="GET">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Search...">
            </div>
            <button type="submit" class="btn btn-default">Search</button>
        </form>
    </div>
</nav>

<div class="container">
    <!-- Flash Messages -->
    @include('flash')

    @if(count($blogs) > 0)
        @foreach($blogs as $key => $value)
            <div class="post-card">
                <div class="post-header">
                    <span class="post-author">{{ $value->title }}</span>
                    <span class="post-time">Posted by {{ $value->user->name }} - {{ $value->created_at->diffForHumans() }}</span>
                </div>
                <div class="post-content">
                    {{ $value->description }}
                    @if ($value->image_path)
                        <img src="{{ asset($value->image_path) }}" class="post-image" alt="Blog Image">
                    @endif
                    @if ($value->file)
                        <img src="{{ asset('/storage/uploads/' . $value->file) }}" class="post-image" alt="Uploaded File">
                    @endif
                </div>
                <div class="post-actions">
                    <div class="btn-group">
                        <a href="{{ route('blogs.upvote', $value->id) }}" class="btn btn-default btn-sm gray-shadow">
                            <i class="fas fa-thumbs-up"></i>
                            <span class="post-votes">{{ $value->upvotes }}</span>
                        </a>
                        <a href="{{ route('blogs.downvote', $value->id) }}" class="btn btn-default btn-sm gray-shadow">
                            <i class="fas fa-thumbs-down"></i>
                            <span class="post-votes">{{ $value->downvotes }}</span>
                        </a>
                        @if (Auth::check() && Auth::user()->id == $value->created_by)
                            <a href="{{ url('blogs/'.$value->id.'/edit') }}" class="btn btn-default btn-sm gray-shadow"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-default btn-sm gray-shadow" data-toggle="modal" data-target="#deleteModal{{ $value->id }}"><i class="fas fa-trash-alt"></i></button>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal{{ $value->id }}" role="dialog">
                <!-- ... (delete modal content) ... -->
            </div>
        @endforeach
    @else
        <h4>No records found.</h4>
    @endif
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
