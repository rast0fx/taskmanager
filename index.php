<?php
require_once 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:'#3498db',secondary:'#e74c3c'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}};</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css">
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
            position: relative;
        }
        
        .task-container {
            max-height: 50vh;
            overflow-y: auto;
            scrollbar-width: thin;
        }
        
        .task-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .task-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }
        
        .task-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }
        
        .task-item {
            transition: all 0.3s ease;
        }
        
        .task-item:hover {
            transform: translateX(4px);
        }
        
        .custom-checkbox {
            transition: all 0.2s ease;
        }
        
        .custom-checkbox.checked {
            background-color: #3498db;
            border-color: #3498db;
        }
        
        .task-text {
            transition: all 0.3s ease;
        }
        
        .task-text.completed {
            text-decoration: line-through;
            color: #94a3b8;
        }
        
        .delete-btn {
            opacity: 0;
            transition: all 0.2s ease;
        }
        
        .task-item:hover .delete-btn {
            opacity: 1;
        }
        
        .progress-bar {
            transition: width 0.5s ease-in-out;
        }
        
        .category-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        
        .category-1 { background-color: #3498db; }
        .category-2 { background-color: #f39c12; }
        .category-3 { background-color: #2ecc71; }
        .category-4 { background-color: #9b59b6; }
        
        input[type="text"]:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.3);
        }
        
        .add-task-btn {
            transition: all 0.2s ease;
        }
        
        .add-task-btn:hover {
            transform: scale(1.05);
        }
        
        .add-task-btn:active {
            transform: scale(0.95);
        }
        
        .filter-btn {
            transition: all 0.2s ease;
        }
        
        .filter-btn.active {
            background-color: #3498db;
            color: white;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .new-task {
            animation: fadeIn 0.3s ease-out forwards;
        }
        
        .shake {
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
        
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-family: 'Pacifico', cursive;
            font-size: 24px;
            color: rgba(52, 152, 219, 0.3);
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:'#3498db',secondary:'#e74c3c'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css">
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
            position: relative;
        }
        
        .task-container {
            max-height: 50vh;
            overflow-y: auto;
            scrollbar-width: thin;
        }
        
        .task-container::-webkit-scrollbar {
            width: 6px;
        }
        
        .task-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }
        
        .task-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }
        
        .task-item {
            transition: all 0.3s ease;
        }
        
        .task-item:hover {
            transform: translateX(4px);
        }
        
        .custom-checkbox {
            transition: all 0.2s ease;
        }
        
        .custom-checkbox.checked {
            background-color: #3498db;
            border-color: #3498db;
        }
        
        .task-text {
            transition: all 0.3s ease;
        }
        
        .task-text.completed {
            text-decoration: line-through;
            color: #94a3b8;
        }
        
        .delete-btn {
            opacity: 0;
            transition: all 0.2s ease;
        }
        
        .task-item:hover .delete-btn {
            opacity: 1;
        }
        
        .progress-bar {
            transition: width 0.5s ease-in-out;
        }
        
        .category-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        
        .category-1 { background-color: #3498db; }
        .category-2 { background-color: #f39c12; }
        .category-3 { background-color: #2ecc71; }
        .category-4 { background-color: #9b59b6; }
        
        input[type="text"]:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.3);
        }
        
        .add-task-btn {
            transition: all 0.2s ease;
        }
        
        .add-task-btn:hover {
            transform: scale(1.05);
        }
        
        .add-task-btn:active {
            transform: scale(0.95);
        }
        
        .filter-btn {
            transition: all 0.2s ease;
        }
        
        .filter-btn.active {
            background-color: #3498db;
            color: white;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .new-task {
            animation: fadeIn 0.3s ease-out forwards;
        }
        
        .shake {
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
        
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-15deg);
            font-family: 'Pacifico', cursive;
            font-size: 24px;
            color: rgba(52, 152, 219, 0.3);
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>
<body class="flex flex-col items-center p-4">
    <div class="w-full max-w-3xl bg-white rounded-xl shadow-xl p-6 md:p-8">
        <header class="mb-8 text-center">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">My Tasks</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        Logout
                    </a>
                </div>
            </div>
            <p class="text-gray-500">Organize your day, achieve more</p>
        </header>
        
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-grow">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <div class="w-5 h-5 flex items-center justify-center text-gray-400">
                        <i class="ri-edit-line"></i>
                    </div>
                </div>
                <input type="text" id="taskInput" class="w-full pl-10 pr-4 py-3 border-none bg-gray-50 rounded text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-primary/30" placeholder="Add new task...">
            </div>
            
            <div class="flex gap-2">
                <select id="categorySelect" class="bg-gray-50 border-none rounded px-4 py-3 text-gray-700 pr-8">
                    <option value="1">Work</option>
                    <option value="2">Personal</option>
                    <option value="3">Shopping</option>
                    <option value="4">Health</option>
                </select>
                
                <button id="addTaskBtn" class="add-task-btn bg-primary text-white px-5 py-3 rounded-button whitespace-nowrap flex items-center justify-center gap-2 font-medium">
                    <div class="w-5 h-5 flex items-center justify-center">
                        <i class="ri-add-line"></i>
                    </div>
                    <span>Add Task</span>
                </button>
            </div>
        </div>
        
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Progress</h2>
                <span id="taskCounter" class="text-sm font-medium text-gray-500">0 tasks remaining</span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                <div id="progressBar" class="progress-bar h-full bg-primary rounded-full w-0"></div>
            </div>
        </div>
        
        <div class="flex gap-2 mb-6">
            <button data-filter="all" class="filter-btn active px-4 py-2 rounded-button whitespace-nowrap bg-gray-100 text-gray-700 text-sm font-medium">All Tasks</button>
            <button data-filter="active" class="filter-btn px-4 py-2 rounded-button whitespace-nowrap bg-gray-100 text-gray-700 text-sm font-medium">Active</button>
            <button data-filter="completed" class="filter-btn px-4 py-2 rounded-button whitespace-nowrap bg-gray-100 text-gray-700 text-sm font-medium">Completed</button>
        </div>
        
        <div class="task-container bg-gray-50 rounded-lg p-4 mb-6">
            <div id="taskList" class="space-y-3">
                <!-- Tasks will be added here dynamically -->
            </div>
            <div id="emptyState" class="py-8 text-center">
                <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center text-gray-300">
                    <i class="ri-checkbox-circle-line ri-3x"></i>
                </div>
                <h3 class="text-gray-500 font-medium mb-1">No tasks yet</h3>
                <p class="text-gray-400 text-sm">Add a task to get started</p>
            </div>
        </div>
        
        <footer class="flex justify-between items-center pt-4 border-t border-gray-100">
            <div class="text-sm text-gray-500" id="completedCounter">0 completed</div>
            <button id="clearCompletedBtn" class="px-4 py-2 text-sm text-gray-500 hover:text-secondary rounded-button whitespace-nowrap">Clear completed</button>
        </footer>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const taskInput = document.getElementById('taskInput');
            const addTaskBtn = document.getElementById('addTaskBtn');
            const taskList = document.getElementById('taskList');
            const emptyState = document.getElementById('emptyState');
            const progressBar = document.getElementById('progressBar');
            const taskCounter = document.getElementById('taskCounter');
            const completedCounter = document.getElementById('completedCounter');
            const categorySelect = document.getElementById('categorySelect');
            const clearCompletedBtn = document.getElementById('clearCompletedBtn');
            const filterBtns = document.querySelectorAll('.filter-btn');
            
            let tasks = JSON.parse(localStorage.getItem('tasks')) || [];
            let currentFilter = 'all';
            
            // Initialize the app
            renderTasks();
            updateCounters();
            
            // Add task event
            addTaskBtn.addEventListener('click', addTask);
            taskInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    addTask();
                }
            });
            
            // Clear completed tasks
            clearCompletedBtn.addEventListener('click', function() {
                tasks = tasks.filter(task => !task.completed);
                saveTasks();
                renderTasks();
                updateCounters();
            });
            
            // Filter tasks
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentFilter = this.dataset.filter;
                    renderTasks();
                });
            });
            
            function addTask() {
                const taskText = taskInput.value.trim();
                if (taskText === '') {
                    taskInput.classList.add('shake');
                    setTimeout(() => {
                        taskInput.classList.remove('shake');
                    }, 500);
                    return;
                }
                
                const newTask = {
                    id: Date.now(),
                    text: taskText,
                    completed: false,
                    category: categorySelect.value,
                    createdAt: new Date()
                };
                
                tasks.unshift(newTask);
                saveTasks();
                taskInput.value = '';
                renderTasks();
                updateCounters();
            }
            
            function toggleTaskStatus(id) {
                const task = tasks.find(task => task.id === id);
                if (task) {
                    task.completed = !task.completed;
                    saveTasks();
                    renderTasks();
                    updateCounters();
                }
            }
            
            function deleteTask(id) {
                tasks = tasks.filter(task => task.id !== id);
                saveTasks();
                renderTasks();
                updateCounters();
            }
            
            function editTask(id) {
                const task = tasks.find(task => task.id === id);
                if (task) {
                    const newText = prompt('Edit task:', task.text);
                    if (newText !== null && newText.trim() !== '') {
                        task.text = newText.trim();
                        saveTasks();
                        renderTasks();
                    }
                }
            }
            
            function renderTasks() {
                let filteredTasks = tasks;
                
                if (currentFilter === 'active') {
                    filteredTasks = tasks.filter(task => !task.completed);
                } else if (currentFilter === 'completed') {
                    filteredTasks = tasks.filter(task => task.completed);
                }
                
                if (filteredTasks.length === 0) {
                    taskList.innerHTML = '';
                    emptyState.style.display = 'block';
                    return;
                }
                
                emptyState.style.display = 'none';
                taskList.innerHTML = '';
                
                filteredTasks.forEach(task => {
                    const taskItem = document.createElement('div');
                    taskItem.className = 'task-item flex items-center p-3 bg-white rounded-lg shadow-sm new-task';
                    
                    taskItem.innerHTML = `
                        <div class="custom-checkbox ${task.completed ? 'checked' : ''} w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center mr-3 cursor-pointer">
                            ${task.completed ? '<i class="ri-check-line text-white"></i>' : ''}
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center">
                                <span class="category-dot category-${task.category}"></span>
                                <span class="task-text ${task.completed ? 'completed' : ''} text-gray-800">${task.text}</span>
                            </div>
                            <div class="text-xs text-gray-400 mt-1">${formatDate(task.createdAt)}</div>
                        </div>
                        <div class="flex gap-2">
                            <div class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-primary cursor-pointer edit-btn">
                                <i class="ri-edit-line"></i>
                            </div>
                            <div class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-secondary cursor-pointer delete-btn">
                                <i class="ri-delete-bin-line"></i>
                            </div>
                        </div>
                    `;
                    
                    taskList.appendChild(taskItem);
                    
                    // Add event listeners
                    const checkbox = taskItem.querySelector('.custom-checkbox');
                    checkbox.addEventListener('click', () => toggleTaskStatus(task.id));
                    
                    const deleteBtn = taskItem.querySelector('.delete-btn');
                    deleteBtn.addEventListener('click', () => deleteTask(task.id));
                    
                    const editBtn = taskItem.querySelector('.edit-btn');
                    editBtn.addEventListener('click', () => editTask(task.id));
                });
            }
            
            function updateCounters() {
                const totalTasks = tasks.length;
                const completedTasks = tasks.filter(task => task.completed).length;
                const remainingTasks = totalTasks - completedTasks;
                
                taskCounter.textContent = `${remainingTasks} task${remainingTasks !== 1 ? 's' : ''} remaining`;
                completedCounter.textContent = `${completedTasks} completed`;
                
                // Update progress bar
                const progressPercentage = totalTasks === 0 ? 0 : (completedTasks / totalTasks) * 100;
                progressBar.style.width = `${progressPercentage}%`;
            }
            
            function saveTasks() {
                localStorage.setItem('tasks', JSON.stringify(tasks));
            }
            
            function formatDate(dateString) {
                const date = new Date(dateString);
                const today = new Date();
                const yesterday = new Date(today);
                yesterday.setDate(yesterday.getDate() - 1);
                
                if (isSameDay(date, today)) {
                    return 'Today, ' + formatTime(date);
                } else if (isSameDay(date, yesterday)) {
                    return 'Yesterday, ' + formatTime(date);
                } else {
                    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) + ', ' + formatTime(date);
                }
            }
            
            function formatTime(date) {
                return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true }).toLowerCase();
            }
            
            function isSameDay(date1, date2) {
                return date1.getDate() === date2.getDate() &&
                       date1.getMonth() === date2.getMonth() &&
                       date1.getFullYear() === date2.getFullYear();
            }
        });
        
        // Enable drag and drop functionality
        document.addEventListener('DOMContentLoaded', function() {
            let draggedItem = null;
            
            document.addEventListener('dragstart', function(e) {
                if (e.target.classList.contains('task-item')) {
                    draggedItem = e.target;
                    setTimeout(() => {
                        e.target.style.opacity = '0.5';
                    }, 0);
                }
            });
            
            document.addEventListener('dragend', function(e) {
                if (e.target.classList.contains('task-item')) {
                    e.target.style.opacity = '1';
                }
            });
            
            document.addEventListener('dragover', function(e) {
                e.preventDefault();
                if (e.target.classList.contains('task-item') && draggedItem !== e.target) {
                    const taskList = document.getElementById('taskList');
                    const children = Array.from(taskList.children);
                    const draggedIndex = children.indexOf(draggedItem);
                    const targetIndex = children.indexOf(e.target);
                    
                    if (draggedIndex < targetIndex) {
                        taskList.insertBefore(e.target, draggedItem);
                    } else {
                        taskList.insertBefore(draggedItem, e.target);
                    }
                    
                    // Update tasks array to match new order
                    const tasks = JSON.parse(localStorage.getItem('tasks')) || [];
                    const reorderedTasks = Array.from(taskList.children).map(item => {
                        const taskId = parseInt(item.dataset.id);
                        return tasks.find(task => task.id === taskId);
                    });
                    
                    localStorage.setItem('tasks', JSON.stringify(reorderedTasks));
                }
            });
        });
    </script>
</body>
</html>
