<div class="col-sm-12">
    <div class="card">
        <div class="card-body">
            {{-- <h4 class="header-title">Pré-visualização</h4> --}}
            <div id="preview" class="border p-3" style="font-size: 12px;">
                <strong>OUTORGANTE: </strong>__________________________<br>
                <strong>CPF: </strong>____________________________________<br>
                <strong>ENDEREÇO: </strong>_____________________________<br>
                ______________________________________________________________________________________<br><br>
                @foreach ($outs as $out)
                <strong>OUTORGADO: {{ $out->nome_outorgado }}</strong><br>
                <strong>CPF: {{ $out->cpf_outorgado }}</strong><br>
                <strong>ENDEREÇO: {{ $out->end_outorgado }}</strong><br>
                ______________________________________________________________________________________<br><br>
                @endforeach

                @foreach ($texts_starts as $texts_start)
                    <div class="row" style="text-align: justify;">
                        {{ $texts_start->texto_inicio}}<br>
                    </div>
                @endforeach

                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <strong>MARCA:</strong> ________________________ 
                    </div>
                    <div class="col-sm-6">
                        <strong>PLACA:</strong> ______________________ 
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <strong>CHASSI:</strong> ________________________ 
                    </div>
                    <div class="col-sm-6">
                        <strong>COR:</strong> ________________________ 
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <strong>ANO/MODELO:</strong> __________________ 
                    </div>
                    <div class="col-sm-6">
                        <strong>RENAVAM:</strong> ___________________ 
                    </div>
                </div>
                <br>

                <div class="row" style="text-align: justify;">
                    @foreach ($texts as $text)
                    {!! $text->html !!}
                    @endforeach
                </div>
                
                <br>
                <div class="row">
                    <div class="col text-end">
                        @foreach ($cidades as $cidade)
                        {{ $cidade->cidade }}
                        @endforeach
                        , 20 DE NOVEMBRO DE 2024
                    </div>
                </div>
                <div class="row justify-content-center text-center">
                    <div class="col-6">
                        <div>
                            _______________________________________________
                        </div>
                        <div>
                            <strong>NOME DO OUTORGANTE</strong>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>