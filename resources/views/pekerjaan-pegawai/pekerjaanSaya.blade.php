<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Board</title>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; }
        .kanban-board { display: flex; justify-content: space-between; max-width: 900px; margin: 20px auto; }
        .kanban-column { width: 30%; padding: 10px; background: #f1f1f1; border-radius: 5px; min-height: 300px; }
        .kanban-task { background: white; padding: 10px; margin: 5px; border-radius: 5px; cursor: grab; position: relative; }
        .task-actions { position: absolute; top: 5px; right: 5px; display: flex; gap: 5px; }
        .task-actions button { font-size: 12px; cursor: pointer; border: none; background: red; color: white; padding: 3px 5px; border-radius: 3px; }
        .edit-btn { background: orange; }

        .priority-label {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .priority-label.penting { background-color: #ff4d4d; }  /* Merah */
        .priority-label.normal { background-color: #f39c12; }   /* Kuning */
        .priority-label.rendah { background-color: #3498db; }   /* Biru */

    </style>
</head>
<body>

    <h2 style="text-align: center;">Kanban Board</h2>

    <form method="POST" action="/tasks" style="text-align: center;">
        @csrf
        <input type="text" name="title" placeholder="Tambahkan tugas..." required>
        <button type="submit">Tambah</button>
    </form>

    <div class="kanban-board">
        @foreach (['todo' => 'To Do', 'in-progress' => 'In Progress', 'done' => 'Done'] as $status => $label)
            <div class="kanban-column" id="{{ $status }}">
                <h3>{{ $label }}</h3>
                @foreach ($tasks->where('status', $status) as $task)
                    <div class="kanban-task" data-id="{{ $task->id }}">
                        <span class="task-title">{{ $task->title }}</span>
                        <small class="priority-label {{ $task->priority }}">
                            {{ ucfirst($task->priority) }}
                        </small>

                        {{-- <small style="display: block; font-size: 12px; color: gray;">✍️ Dibuat oleh: {{ $task->user->name }}</small> --}}
                        <small style="display: block; font-size: 12px; color: gray;">
                            ⏲ Dibuat pada: {{ $task->created_at->translatedFormat('d F Y') }}
                        </small>
                        
                        <div class="task-actions">
                            <button class="edit-btn" 
                                onclick="editTask({{ $task->id }}, '{{ $task->title }}', '{{ $task->priority }}')">✏️
                            </button>

                            <button onclick="deleteTask({{ $task->id }})">🗑️</button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    <!-- Modal Edit -->
    <div id="editModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
        background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.3);">
        <h3>Edit Tugas</h3>
        <input type="hidden" id="editTaskId">
        <input type="text" id="editTaskTitle">

        <label for="editTaskPriority">Prioritas:</label>
        <select id="editTaskPriority">
            <option value="penting">Penting</option>
            <option value="normal">Normal</option>
            <option value="rendah">Rendah</option>
        </select>

        <button onclick="saveTask()">Simpan</button>
        <button onclick="document.getElementById('editModal').style.display = 'none'">Batal</button>
    </div>

    <script>
        // Drag and Drop
        document.querySelectorAll('.kanban-column').forEach(column => {
            new Sortable(column, {
                group: "tasks",
                animation: 150,
                onEnd: function (evt) {
                    let taskId = evt.item.getAttribute('data-id');
                    let newStatus = evt.to.id;

                    fetch(`/tasks/${taskId}/status`, {
                        method: 'PATCH',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                        body: JSON.stringify({ status: newStatus })
                    });
                }
            });
        });

        // Hapus Tugas
        function deleteTask(taskId) {
            if (!confirm("Apakah Anda yakin ingin menghapus tugas ini?")) return;

            fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`[data-id='${taskId}']`).remove();
                }
            });
        }

        // Edit Tugas
        function editTask(taskId, taskTitle, taskPriority) {
            document.getElementById("editTaskId").value = taskId;
            document.getElementById("editTaskTitle").value = taskTitle;

            let prioritySelect = document.getElementById("editTaskPriority");
            for (let option of prioritySelect.options) {
                if (option.value === taskPriority) {
                    option.selected = true;
                } else {
                    option.selected = false;
                }
            }

            document.getElementById("editModal").style.display = "block";
        }



        // Simpan Edit
        function saveTask() {
            let taskId = document.getElementById('editTaskId').value;
            let title = document.getElementById('editTaskTitle').value;
            let priority = document.getElementById('editTaskPriority').value;

            fetch(`/tasks/${taskId}`, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                body: JSON.stringify({ title: title, priority: priority })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // let taskElement = document.querySelector(`[data-id='${taskId}']`);
                    // taskElement.querySelector('.task-title').innerText = title;
                    // taskElement.querySelector('.priority-label').innerText = priority.charAt(0).toUpperCase() + priority.slice(1);
                    // taskElement.querySelector('.priority-label').className = `priority-label ${priority}`;
                    // document.getElementById('editModal').style.display = 'none';
                    location.reload();
                }
            });
        }

    </script>

</body>
</html>
