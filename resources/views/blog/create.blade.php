<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blog Create Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #e0e0e0; /* Grey background color */
        }
        .container {
            background: linear-gradient(to bottom, #ffffff, #f0f0f0); /* Gradient background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Box shadow */
        }
        .btn-success {
            background-color: #4caf50; /* Green color for the Submit button */
            transition: background-color 0.3s; /* Smooth transition on hover */
        }
        .btn-success:hover {
            background-color: #45a049; /* Darker green color on hover */
        }
        .btn-primary {
            background-color: #2196F3; /* Blue color for the "Go to Index Page" button */
            transition: background-color 0.3s; /* Smooth transition on hover */
        }
        .btn-primary:hover {
            background-color: #1e87f0; /* Darker blue color on hover */
        }
        .text-danger {
            color: #e74c3c; /* Red color for error messages */
        }
        input.form-control, textarea.form-control {
            transition: border-color 0.3s; /* Smooth transition on input focus */
        }
        input.form-control:focus, textarea.form-control:focus {
            border-color: #2196F3; /* Blue border color on input focus */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Blog Create Form</h2>
    @include('flash')
    
    <form action="{{ url('blogs') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="{{ old('title') }}" placeholder="Enter Title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description <span class="text-danger">*</span></label>
            <textarea name="description" cols="6" rows="6" class="form-control" required>{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label for="file">Upload a file</label>
            <input type="file" name="file" accept=".jpg, .png, .pdf" />
        </div>
        <div class="form-group">
            <label>Status</label><br>
            <label class="radio-inline">
                <input type="radio" name="status" value="1" checked> Active
            </label>
            <label class="radio-inline">
                <input type="radio" name="status" value="0"> Inactive
            </label>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
        
        <!-- Go to Index Page Button -->
        <a href="{{ url('blogs') }}" class="btn btn-primary">Go to Index Page</a>
    </form>
</div>

</body>
</html>
