@extends('layout.index')
@section('content')

    @include('common.preloader')
    <div class="dashboard-area">
        @include('admin.headerbar')

        <div class="dashboard-background question-area">
            <div class="container admin-question">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="row question-header">
                                <h4 class="card-title">Pregunta</h4>

                                <div class="form-group">
                                    <label>Categoría</label>
                                    <select id="select-category" class="form-control">
                                        <option></option>
                                        @foreach ($categories as $category)
                                            <option value={{$category->id}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <a type="button" class="btn btn-info" href="/admin/question/create"><i class="fas fa-plus-circle"></i> Crear pregunta</a>
                                
                            </div>

                            <div class="table-responsive m-t-10">
                                <table id="table-questions" class="table table-bordered table-striped" style="margin-bottom: 0px">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>CategoríaId</th>
                                            <th>Categoría</th>
                                            <th>Título</th>
                                            <th>Contenido</th>
                                            <th>Puntaje</th>
                                            <th>Adjunto</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($questions as $question)
                                            <tr id={{"question" . $question->id}}>
                                                <td>{{$loop->index + 1}}</td>
                                                <td>{{$question->sCategory->id}}</td>
                                                <td>{{$question->sCategory->name}}</td>
                                                <td>{{$question->title}}</td>
                                                <td><div>{!! $question->contents !!}</div></td>
                                                <td>{{$question->score / 10}}</td>
                                                <td>
                                                    @foreach (explode(",",$question->attached_files) as $file)
                                                        <a href={{"/attached/admin/question/" . $question->id . "/" . $file}} target="_blank" class="attach-file-link">{{$file}}</a>
                                                    @endforeach
                                                    {{-- $question->attached_files --}}
                                                </td>

                                                <td>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <a href={{"/admin/question/" . $question->id . "/edit"}}><i class="fas fa-edit"></i></a>
                                                        </div>
                                                        
                                                        <div class="col-6">
                                                            <a onclick="deleteQuestion({{$question->id}})"><i class="fas fa-trash"></i></a>
                                                        </div>
                                                    </div>
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('script.datatable')
    <script src="/assets/node_modules/sweetalert/sweetalert.min.js"></script>

    <script>
        $(function() {
            $('#table-questions').DataTable();
        });

        function deleteQuestion(id){
            Swal.fire({
                title: 'Advertencia',
                text: '¿Estás seguro de eliminar la pregunta?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '/admin/question/' + id,
                        method: 'DELETE',
                        dataType: false,
                        success: function(data) {
                            if(data.status == "ok"){
                                window.location.reload(true);
                            }else if(data.status == "fail"){
                                Swal.fire({
                                    title: 'Información',
                                    text: 'Existe usuario respondido.',
                                    icon: 'warning',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        }
                    });
                }
            });
        }
    </script>
@endsection