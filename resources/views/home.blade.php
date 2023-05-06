@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="d-flex bd-highlight mb-4">
            <div class="p-2 w-100 bd-highlight">
                <h2>Laravel AJAX Example</h2>
            </div>
            <div class="p-2 flex-shrink-0 bd-highlight">
                <button class="btn btn-success" id="btn-add">
                    Add Todo
                </button>
            </div>
        </div>
        <div>
            <table class="table table-inverse">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody id="todos-list" name="todos-list">

                </tbody>
                <ul id="toDos">

                </ul>
            </table>
            <div class="modal fade" id="formModalDelete" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="formModalLabel">Delete TODO</h4>
                        </div>
                        <div class="modal-body">
                            <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
                                <div class="form-group">
                                    <label>did you want to delete it ??</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-delete" value="myForm">Yes
                                    </button>
                                    <input type="hidden" id="todo_id" name="todo_id" value="0">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="formModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="formModalLabel">Create Todo</h4>
                        </div>
                        <div class="modal-body">
                            <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" id="title"
                                           placeholder="Enter title" value="">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" id="description"
                                           placeholder="Enter Description" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="btn-save" value="myForm">Save
                                        changes
                                    </button>
                                    <input type="hidden" id="todo_id" name="todo_id" value="0">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        window.axios.get('/api/toDos')
            .then((response) => {
                const todosElement = document.getElementById('todos-list');
                let todos = response.data;
                todos.forEach((todo, index) => {
                    let element = document.createElement('tr');
                    element.setAttribute('id', "todo" + todo.id);
                    let elementTd = document.createElement('td');
                    elementTd.innerText = todo.id;
                    let elementTi = document.createElement('td');
                    elementTi.innerText = todo.title;
                    let elementDes = document.createElement('td');
                    elementDes.innerText = todo.description;
                    let elementDelete = document.createElement('button');
                    elementDelete.setAttribute('data-id', todo.id);
                    elementDelete.setAttribute('class', "btn btn-danger delete-row");
                    elementDelete.innerHTML = '<lord-icon src="https://cdn.lordicon.com/kfzfxczd.json" trigger="hover" colors="primary:#121331" style="width:25px;height:25px"></lord-icon>';

                    todosElement.appendChild(element);
                    todosElement.appendChild(elementTd);
                    todosElement.appendChild(elementTi);
                    todosElement.appendChild(elementDes);
                    todosElement.appendChild(elementDelete);
                    // todosElement.appendChild(elementTitle);
                })
            });

        $(document).on('click', '.delete-row', function() {
            var id = $(this).data('id');
            $(document).ready(function() {
                $('#formModalDelete').modal('show');
            });

            $("#btn-delete").click(function () {
                axios.delete('/api/toDos/' + id)
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                location.reload();
            });

        });

        jQuery(document).ready(function ($) {
            //----- Open model CREATE -----//
            jQuery('#btn-add').click(function () {
                jQuery('#btn-save').val("add");
                jQuery('#myForm').trigger("reset");
                jQuery('#formModal').modal('show');
            });

            // CREATE
            $("#btn-save").click(function (e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                var formData = {
                    title: jQuery('#title').val(),
                    description: jQuery('#description').val(),
                };
                var state = jQuery('#btn-save').val();
                if (state === "add") {

                    axios.post('/api/toDos', {
                        id: formData.id,
                        title: formData.title,
                        description: formData.description
                    })
                        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                }
                location.reload()
            });
        });

    </script>
@endpush
