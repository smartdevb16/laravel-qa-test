@extends('layout.index')
@section('content')

    @include('common.preloader')
    <div class="dashboard-area">
        @include('admin.headerbar')
        
        <div class="dashboard-background question-area">
            <div class="container admin-question">
                <div class="col-10">
                    <div class="card question-create">
                        <div class="card-body">
                            <h4 class="card-title" style="margin-bottom: 25px;">Crear pregunta</h4>

                            <div class="row">
                                <div class="col-sm-6">
                                    {{-- category --}}
                                    <div class="form-group">
                                        <label>Categoría</label>
                                        <select id="select-category" class="form-control">
                                            <option value="0"></option>
                                            @foreach ($categories as $category)
                                                <option value={{$category->id}}>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    {{-- score --}}
                                    <div class="form-group">
                                        <label>Puntaje</label>
                                        <input type="number" class="form-control" placeholder="Puntaje" id="question-score" step="0.1" min="0" max="10">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    {{-- title --}}
                                    <div class="form-group">
                                        <label>Título</label>
                                        <input class="form-control" placeholder="Título" id="question-title">
                                    </div>
                                </div>
                            </div>

                            {{-- text area --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    {{-- content --}}
                                    <div class="form-group">
                                        <label>Contenido</label>
                                        <textarea id="mymce"></textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- attach --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    {{-- attach --}}
                                    <div class="form-group">
                                        <label><i class="ti-link"></i>Acessório</label>
                                        <form action="/admin/question/upload-attached" method="post" class="dropzone">
                                            <div class="fallback">
                                                <input name="file" type="file" id="file"  />
                                            </div>
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <a class="btn btn-secondary" style="margin: auto;" href="/admin/question"><i class="fas fa-arrow-left"></i> Pregunta </a>
                                <button type="button" class="btn btn-success" style="margin: auto;" id="btn-create-question"><i class="fas fa-check"></i> Crear</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.textarea_editor').wysihtml5();
        });

        $("#btn-create-question").click(function(){
            var category = $("#select-category").val();
            var score = $("#question-score").val();
            var title = $("#question-title").val();
            var contents = tinymce.activeEditor.getContent({ format: "html" });

            if(category <= 0) {
                $.toast({
                    heading: 'Creación fallida',
                    text: 'Por favor seleccione categoría.',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 3000, 
                    stack: 6
                });

                $("#select-category").focus();

                return;
            }

            if(score <= 0 || score > 10) {
                $.toast({
                    heading: 'Creación fallida',
                    text: 'Por favor, introduzca la puntuación.',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 3000, 
                    stack: 6
                });

                $("#question-score").focus();

                return;
            }

            if(!title) {
                $.toast({
                    heading: 'Creación fallida',
                    text: 'Por favor ingrese el título.',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 3000, 
                    stack: 6
                });

                $("#question-title").focus();

                return;
            }

            if(!contents) {
                $.toast({
                    heading: 'Creación fallida',
                    text: 'Por favor ingrese el contenido.',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'error',
                    hideAfter: 3000, 
                    stack: 6
                });

                tinymce.activeEditor.focus();

                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/admin/question',
                method: 'POST',
                data: {
                    category: category,
                    score: score * 10,
                    title: title,
                    contents: contents,
                },
                dataType: false,
                success: function(data) {
                    if(data.status == "ok"){
                        window.location.href = "/admin/question";
                    }else{
                        if(data.result == "existed"){
                            $.toast({
                                heading: 'Creación fallida',
                                text: 'Existe la misma categoría.',
                                position: 'top-right',
                                loaderBg:'#ff6849',
                                icon: 'error',
                                hideAfter: 3000, 
                                stack: 6
                            });
                        }
                    }
                }
            });
        });
    </script>
@endsection