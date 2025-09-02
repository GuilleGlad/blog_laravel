@extends('adminlte::page')

@section('title', 'Crear Artículo')

@section('content_header')
    <h2>Crear Nuevo Artículo</h2>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/46.0.2/ckeditor5.css" />
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('articles.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="">Título</label>
                <input type="text" class="form-control" id="title" name='title'
                    placeholder="Ingrese el nombre del artículo" minlength="5" maxlength="255" 
                    value="{{ old('title')}}">
                @error('title')
                <span class="text-danger">
                    <span>* {{ $message }}</span>
                </span>
                @enderror

            </div>

            <div class="form-group">
                <label for="">Slug</label>
                <input type="text" class="form-control" id="slug" name='slug' 
                    placeholder="Slug del artículo" readonly value="{{ old('slug')}}">
                @error('slug')
                <span class="text-danger">
                    <span>* {{ $message }}</span>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label>Introducción</label>
                <input type="text" class="form-control" id="introduction" name='introduction'
                    placeholder="Ingrese la introducción del artículo" minlength="5" maxlength="255"
                    value="{{ old('introduction')}}">
                @error('introduction')
                <span class="text-danger">
                    <span>*{{$message}}</span>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Subir imagen</label>
                <input type="file" class="form-control-file" id="image" name='image'>
                @error('image')
                <span class="text-danger">
                    <span>*{{$message}}</span>
                </span>
                @enderror

            </div>

            <div class="form-group w-5">
                <label for="">Desarrollo del artículo</label>
                <textarea class="form-control" id="body" name="body"> {{old('body')}} </textarea>
                @error('body')
                <span class="text-danger">
                    <span>*{{$message}}</span>
                </span>
                @enderror
                
            </div>

            <label for="">Estado</label>
            <div class="form-group">
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="">Privado</label>
                    <input class="form-check-input ml-2" type="radio" name='status' 
                    id="status" value="0" checked>
                </div>

                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="">Público</label>
                    <input class="form-check-input ml-2" type="radio" name='status' 
                    id="status" value="1">
                </div>

                @error('status')
                <span class="text-danger">
                    <span>*{{$message }}</span>
                </span>
                @enderror
            
            </div>

            <div class="form-group">
                <select class="form-control" name="category_id" id="category_id">
                    <option value="">Seleccione una categoría</option>
                    @foreach ($categories as $category)
                    <option 
                        value="{{ $category->id }}"  
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>

                @error('category_id')
                <span class="text-danger">
                    <span>*{{$message}}</span>
                </span>
                @enderror
                
            </div>

            <input type="submit" value="Agregar artículo" class="btn btn-primary">
        </form>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/46.0.2/ckeditor5.umd.js"></script>
<script>
const {
	ClassicEditor,
	Essentials,
	Bold,
	Italic,
	Font,
	Paragraph
} = CKEDITOR;

ClassicEditor
	.create( document.querySelector( '#body' ), {
		licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3ODc3MDIzOTksImp0aSI6IjEwMWFmNzc1LTZiNDMtNGY1My1hZTlmLTE4MWExOWUyNzVlOCIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiXSwiZmVhdHVyZXMiOlsiRFJVUCIsIkUyUCIsIkUyVyJdLCJ2YyI6IjhlMTFjYTQ3In0.kKsyiZyz0j5CBqyphEf5nS4MsI2bak7mFMLtDg43BjhUOa17HZyLjT0GFQkAwOZZPSzW9jQokJUTa7PdZtDQPA',
		plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
		toolbar: [
			'undo', 'redo', '|', 'bold', 'italic', '|',
			'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
		]
	} )
	.then( /* ... */ )
	.catch( /* ... */ );
</script>
<script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>
<script>
    $(document).ready( function() {
        $("#title").stringToSlug({
            setEvents: 'keyup keydown blur',
            getPut: '#slug',
            space: '-'
        });
    });
</script>
@endsection