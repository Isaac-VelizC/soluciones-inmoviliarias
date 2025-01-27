<div class="row">
    <div class="col-lg-12">
        <h4>Resultado de su encuesta:</h4>
        @if(!empty($respuestas))
            {!! $respuestas !!}
        @else
            <p>Aun no se tiene resultados</p>
        @endif
    </div>
</div>
