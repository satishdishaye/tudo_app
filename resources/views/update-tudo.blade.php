<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-container {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    form h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #555;
    }

    input, textarea, select, button {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    textarea {
      resize: vertical;
    }

    button {
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 18px;
    }

    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="form-container">
  <form action="{{ route('todos.update', ['todo' => $tasks->id]) }}" method="POST">
    @csrf
    @method('PUT')

    

      <h2>Update Task</h2>
      <label for="task-title">Task Title:</label>
      <input type="text" id="task-title" name="title" value="{{$tasks->title}}" required>

      <label for="task-desc">Task Description:</label>
      <textarea id="task-desc" name="description" rows="5" required>{{$tasks->description}}</textarea>

      <label for="due-date">Due Date:</label>
      <input type="date" id="due-date" name="due_date" value="{{$tasks->due_date}}"required 
             min="<?= date('Y-m-d') ?>">

      <label for="status">Status:</label>
      <select id="status" name="status" required>
        <option value="pending" @if($tasks->status=="pending")selected @endif>Pending</option>
        <option value="progress" @if($tasks->status=="progress")selected @endif>Progress</option>
        <option value="completed" @if($tasks->status=="completed")selected @endif>Completed</option>
      </select>

      <button type="submit">Submit</button>
    </form>
  </div>
</body>



</html>




