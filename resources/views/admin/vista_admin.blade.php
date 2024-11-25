@extends('adminlte::page')

@section('title', 'Gestión de Usuarios')

@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>Gestión de Usuarios</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h3>Lista de Usuarios</h3>
                </div>
                <div class="col-6 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
                        <i class="fas fa-user-plus"></i> Nuevo Usuario
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body"></div>
            <table class="table table-striped" id="tablaPrincipal">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->hasRole('Titular'))
                                <span class="badge badge-primary">Titular</span>
                            @elseif($user->hasRole('Adjunto'))
                                <span class="badge badge-success">Adjunto</span>
                            @elseif($user->hasRole('Tecnico'))
                                <span class="badge badge-info">Técnico</span>
                            @elseif($user->hasRole('Auxiliar'))
                                <span class="badge badge-warning">Auxiliar</span>
                            @else
                                <span class="badge badge-secondary">Sin rol</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="editarUsuario({{ $user->id }})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm eliminar-usuario" data-id="{{ $user->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para agregar usuario -->
    <div class="modal fade" id="modalAgregarUsuario" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin_user.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>Rol</label>
                            <select class="form-control" name="role" required>
                                <option value="">Seleccione un rol</option>
                                <option value="Titular">Titular</option>
                                <option value="Adjunto">Adjunto</option>
                                <option value="Tecnico">Técnico</option>
                                <option value="Auxiliar">Auxiliar</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para editar usuario -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form id="formEditar" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="name" id="edit_name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email" required>
                        </div>
                        <div class="form-group">
                            <label>Rol</label>
                            <select class="form-control" name="role" id="edit_role" required>
                                <option value="Titular">Titular</option>
                                <option value="Adjunto">Adjunto</option>
                                <option value="Tecnico">Técnico</option>
                                <option value="Auxiliar">Auxiliar</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#tablaPrincipal').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                }
            });

            // Eliminar usuario
            $('.eliminar-usuario').click(function() {
                if(confirm('¿Está seguro de eliminar este usuario?')) {
                    const id = $(this).data('id');
                    $.ajax({
                        url: `/vista_admin/${id}`,
                        method: 'DELETE',
                        success: function(response) {
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Error al eliminar el usuario');
                        }
                    });
                }
            });

            $('#formEditar').on('submit', function(e) {
                e.preventDefault();
                const action = $(this).attr('action');
                const formData = $(this).serialize();

                $.ajax({
                    url: action,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#modalEditarUsuario').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error al actualizar el usuario');
                    }
                });
            });
        });

        function editarUsuario(id) {
            $.ajax({
                url: `/vista_admin/${id}/edit`,
                method: 'GET',
                success: function(response) {
                    $('#edit_name').val(response.user.name);
                    $('#edit_email').val(response.user.email);
                    $('#edit_role').val(response.role);
                    $('#formEditar').attr('action', `/vista_admin/${id}`);
                    $('#modalEditarUsuario').modal('show');
                },
                error: function(xhr) {
                    alert('Error al cargar los datos del usuario');
                }
            });
        }
    </script>
@stop