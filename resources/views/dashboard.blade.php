<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Dashboard</title>

    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and Header */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Task Dashboard Container */
        .task-dashboard {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .filter {
            margin-bottom: 20px;
        }

        #status-filter {
            padding: 5px;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f1f1f1;
        }

        /* Task Rows */
        .task-row {
            transition: background-color 0.3s ease;
        }

        .task-row.pending {
            background-color: #fff;
        }

        .task-row.completed {
            background-color: #d4edda; /* Green background for completed */
        }

        .task-row.pending.due-passed {
            background-color: #f8d7da; /* Red background for overdue tasks */
        }

        /* Button Styling */
        button {
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f0f0f0;
            cursor: pointer;
        }

        button:disabled {
            background-color: #ddd;
            cursor: not-allowed;
        }

        button:hover:not(:disabled) {
            background-color: #007BFF;
            color: #fff;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .page-btn {
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f0f0f0;
            cursor: pointer;
        }

        .page-btn:hover {
            background-color: #007BFF;
            color: #fff;
        }

        .page-number {
            font-size: 16px;
        }

        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
        }

        .close-btn {
            font-size: 20px;
            font-weight: bold;
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #000;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <h1>Task Dashboard</h1>
    </header>

    <!-- Filter and Task Table -->
    <div class="task-dashboard">
        <!-- Task filter -->

        <form action="{{ route('todos.index') }}" method="get">
        <div class="filter">
            <label for="status-filter">Filter by Status:</label>
            <select id="status-filter" name="status">
                <option value="">All</option>
                <option value="completed">Completed</option>
                <option value="pending">Pending</option>
            </select>
            <button type="submit">Submit</button>
            <a href="{{ route('todos.create') }}" class="edit-btn">Add Task</a>

        </div>
        
    </form>


        <!-- Task Table -->
        <table id="task-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows will be dynamically filled here -->

                @foreach($tasks as $itask)
                <tr class="task-row pending" id="task1">
                    <td>{{$itask->title}}</td>
                    <td>{{$itask->due_date}}</td>
                    <td>{{$itask->status}}</td>
                    <td>
                        <a onclick="taskview('{{ $itask->title }}',
                                             '{{ $itask->desc }}',
                                             '{{ $itask->due_date }}',
                                             '{{ $itask->status }}')" 
                                                        
                                                        class="view-btn">View</a>
                                                        <a href="{{ route('todos.show', ['todo' => $itask->id]) }}" class="edit-btn">Edit</a>
                                                        <form action="{{ route('todos.destroy', $itask->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this task?');">
                            Delete
                        </button>
                    </form>
                  </td>
                </tr>

                @endforeach
                
                <!-- More task rows can be added here -->
            </tbody>
        </table>

                            <div style="display: flex; justify-content: space-between;  align-items: center;width: 100%; height:100%" class="pagination ">
                                    <div class="pagination-left">
                                        Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} entries
                                    </div>
                                    <div class="pagination-right " >
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination justify-content-end">
                                                {{ $tasks->links() }}
                                            </ul>
                                        </nav>
                                    </div>
                                </div>


        <!-- Pagination -->
       
    </div>

    <!-- Task Details Modal -->
    <div id="task-details-modal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Task Details</h2>
        <p><strong>Title:</strong> <span id="title">Task</span></p>
        <p><strong>Description:</strong> <span id="desc">This is a description of Task 1</span></p>
        <p><strong>Due Date:</strong> <span id="dueDate">2024-12-05</span></p>
        <p><strong>Status:</strong> <span id="status">Pending</span></p>
    </div>
</div>
    <!-- Add jQuery from a CDN (e.g., Google CDN) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
   function taskview(title, desc, dueDate, status) {
    $('#title').text(title);  // Using .text() for non-input elements
       $('#desc').text(desc);
       $('#dueDate').text(dueDate);
       $('#status').text(status);
    // Show the modal
    $('#task-details-modal').modal('show');    

    // Refresh the page when the modal is closed
    // $('#task-details-modal').on('hidden.bs.modal', function () {
    //     location.reload();
    // });
}
</script>

    <script>
        // JavaScript to handle task row color change for overdue tasks
        const taskRows = document.querySelectorAll('.task-row');
        taskRows.forEach(row => {
            const dueDate = new Date(row.cells[1].textContent);
            const currentDate = new Date();
            const status = row.cells[2].textContent.trim();
            const editButton = row.querySelector('.edit-btn');
            
            // Check if the due date has passed and status is not completed
            if (dueDate < currentDate && status !== 'Completed') {
                row.classList.add('due-passed');
            }
            
            // Disable edit button if the due date is passed and status is not completed
            if (dueDate < currentDate && status !== 'Completed') {
                editButton.disabled = true;
            }
        });

        // Modal Handling for "View" button
        const viewButtons = document.querySelectorAll('.view-btn');
        const modal = document.getElementById('task-details-modal');
        const closeBtn = document.querySelector('.close-btn');
        
        viewButtons.forEach(button => {
            button.addEventListener('click', () => {
                modal.style.display = 'flex';
            });
        });

        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Close modal if clicked outside of modal content
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>

</body>
</html>
