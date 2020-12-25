const todos = document.getElementById('todos');

if (todos) {
    todos.addEventListener('click', e => {
    if (e.target.className === 'text-white delete-todo') {
      if (confirm('Are you sure?')) {
        const id = e.target.getAttribute('data-id');

        fetch(`/todo/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload());
      }
    }
  });
}