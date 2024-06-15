@extends('adminlte::page')

@section('title', 'Cadastro de Novo Cliente')

@section('content_header')
<h1>Cadastro de Novo Cliente</h1>
@stop

@section('content')
<div class="card p-3 mb-3">
    <form method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cnpj">CNPJ</label>
                    <x-adminlte-input id="cnpj" name="cnpj" fgroup-class="col-sm-12" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="razaoSocial">Razão Social</label>
                    <x-adminlte-input name="razaoSocial" fgroup-class="col-sm-12" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="nome">Nome Fantasia/Apelido</label>
                    <x-adminlte-input name="nome" fgroup-class="col-sm-12" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="classificacao">Classificação</label>
                    <x-adminlte-select name="classificacao" igroup-size="md">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-info"></div>
                        </x-slot>
                        <option>Grande Porte</option>
                        <option>Médio Porte</option>
                        <option>Pequeno Porte</option>
                    </x-adminlte-select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="endereco">Endereço</label>
                    <x-adminlte-input name="endereco" fgroup-class="col-sm-12" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="bairro">Bairro</label>
                    <x-adminlte-input name="bairro" fgroup-class="col-sm-12" />
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="cidade">Cidade</label>
                    <x-adminlte-input name="cidade" fgroup-class="col-sm-12" />
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="uf">Estado</label>
                    <x-adminlte-input name="uf" fgroup-class="col-sm-12" />
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <x-adminlte-input name="cep" fgroup-class="col-sm-12" />
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4">
                <div class="form-group">
                    <label for="email">Telefone</label>
                    <x-adminlte-input name="telefone" fgroup-class="col-sm-12" />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <x-adminlte-input name="email" fgroup-class="col-sm-12" />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="emailcobranca">E-mail Cobrança</label>
                    <x-adminlte-input name="emailcobranca" fgroup-class="col-sm-12" />
                </div>
            </div>
        </div>

        <hr>

        <br><br>
        <div id="buttons">
            <button class="btn btn-block btn-success" type="submit"><i class="fas fa-upload"></i> Salvar</button>
        </div>
    </form>
</div>
@stop

@section('css')
<link href="{{ asset('vendor/autocomplete/easy-autocomplete.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/autocomplete/easy-autocomplete.themes.min.css') }}" rel="stylesheet">


@stop


@section('js')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#cnpj').blur(function() {
            const cnpj = $(this).val();

            let numerosCnpj = '';

            for (let i = 0; i < cnpj.length; i++) {
                if (!isNaN(cnpj[i])) { // Verifica se o caractere é um número
                    numerosCnpj += cnpj[i];
                }
            }

            console.log(numerosCnpj);

            if (cnpj) {
                $.ajax({
                    url: `https://apiessencial.com.br/cnpj/getcnpj/${numerosCnpj}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.estabelecimento.complemento == null) {
                            data.estabelecimento.complemento = '';
                        }

                        let end = `${data.estabelecimento.tipo_logradouro} ${data.estabelecimento.logradouro}, ${data.estabelecimento.numero} ${data.estabelecimento.complemento}`;
                         
                        let tel = `${data.estabelecimento.ddd1} ${data.estabelecimento.telefone1}`;
                        // Preencha os outros campos com os dados recebidos
                        $('input[name="razaoSocial"]').val(data.razao_social);
                        $('input[name="nome"]').val(data.estabelecimento.nome_fantasia);
                        $('input[name="endereco"]').val(end);
                        $('input[name="bairro"]').val(data.estabelecimento.bairro);
                        $('input[name="cep"]').val(data.estabelecimento.cep);
                        $('input[name="cidade"]').val(data.estabelecimento.cidade.nome);
                        $('input[name="uf"]').val(data.estabelecimento.estado.sigla);
                        $('input[name="email"]').val(data.estabelecimento.email);
                        $('input[name="telefone"]').val(tel);
                    },
                    error: function(error) {
                        console.error('Erro na requisição: ', error);
                    }
                });
            }
        });
    });
</script>

@stop