<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Revision;
use App\Models\Client;
use App\Models\ImageRevision;
use App\Models\Genset;
use App\Models\Image;
use App\Models\Allexoequipdata;
use App\Models\Municipio;
use App\Models\Prospecto;
use App\Models\Obsprospecto;
use App\Models\Locacaoavulsareport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Atendimentoreport;
use App\Models\Requisicaocompra;
use App\Models\Produtosrequisicaocompra;
use App\Models\Produto;
use App\Models\User;
use App\Models\Equip;
use App\Models\Questionarie;
use App\Models\Obsreqcompra;
use App\Models\Task;
use App\Models\Semaphore;
use App\Models\Call;
use App\Models\Serviceorder;
use App\Models\Servicereport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FarolExport;
use App\Exports\FarolFiltroExport;



use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ControleController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');

    }


    public function index()
    {
        return view('Admin.home');
    }

    public function revisaoCadastro()
    {
        return view('Admin.revisao');
    }

    public function novaRevisao(Request $request)
    {
        $idCliente = filter_input(INPUT_POST, 'id_cliente');
        $tipoEquipamento = filter_input(INPUT_POST, 'tipoEquipamento');
        $identificacao = filter_input(INPUT_POST, 'identificacao');
        $fabricante = filter_input(INPUT_POST, 'fabricante');
        $numeroSerie = filter_input(INPUT_POST, 'numeroSerie');
        $dataFabricacao = filter_input(INPUT_POST, 'dataFabricacao');
        $potencia = filter_input(INPUT_POST, 'potencia');
        $abrangencia = filter_input(INPUT_POST, 'abrangencia');
        $tanqueBase = filter_input(INPUT_POST, 'tanqueBase');
        $aberturaJanelaBase = filter_input(INPUT_POST, 'aberturaJanelaBase');
        $capacidadeTanqueBase = filter_input(INPUT_POST, 'capacidadeTanqueBase');
        $tanqueDiario = filter_input(INPUT_POST, 'tanqueDiario');
        $aberturaJanelaDiario = filter_input(INPUT_POST, 'aberturaJanelaDiario');
        $capacidadeTanqueDiario = filter_input(INPUT_POST, 'capacidadeTanqueDiario');
        $tanqueMensal = filter_input(INPUT_POST, 'tanqueMensal');
        $aberturaJanelaMensal = filter_input(INPUT_POST, 'aberturaJanelaMensal');
        $capacidadeTanqueMensal = filter_input(INPUT_POST, 'capacidadeTanqueMensal');
        $fabricanteMotor = filter_input(INPUT_POST, 'fabricanteMotor');
        $modeloMotor = filter_input(INPUT_POST, 'modeloMotor');
        $serieMotor = filter_input(INPUT_POST, 'serieMotor');
        $quantidadeOleoLubrificante = filter_input(INPUT_POST, 'quantidadeOleoLubrificante');
        $modeloFiltroCombustivel = filter_input(INPUT_POST, 'modeloFiltroCombustivel');
        $quantidadeFiltroCombustivel = filter_input(INPUT_POST, 'quantidadeFiltroCombustivel');
        $modeloFiltroSeparador = filter_input(INPUT_POST, 'modeloFiltroSeparador');
        $quantidadeFiltroSeparador = filter_input(INPUT_POST, 'quantidadeFiltroSeparador');
        $modeloFiltroAgua = filter_input(INPUT_POST, 'modeloFiltroAgua');
        $quantidadeFiltroAgua = filter_input(INPUT_POST, 'quantidadeFiltroAgua');
        $modeloFiltroOleo = filter_input(INPUT_POST, 'modeloFiltroOleo');
        $quantidadeFiltroOleo = filter_input(INPUT_POST, 'quantidadeFiltroOleo');
        $modeloFiltroAr = filter_input(INPUT_POST, 'modeloFiltroAr');
        $quantidadeFiltroAr = filter_input(INPUT_POST, 'quantidadeFiltroAr');
        $fabricanteAlternador = filter_input(INPUT_POST, 'fabricanteAlternador');
        $modeloAlternador = filter_input(INPUT_POST, 'modeloAlternador');
        $serieAlternador = filter_input(INPUT_POST, 'serieAlternador');
        $fabricanteModuloGrupo = filter_input(INPUT_POST, 'fabricanteModuloGrupo');
        $modeloModuloGrupo = filter_input(INPUT_POST, 'modeloModuloGrupo');
        $fabricanteModuloQta = filter_input(INPUT_POST, 'fabricanteModuloQta');
        $modeloModuloQta = filter_input(INPUT_POST, 'modeloModuloQta');
        $fabricanteChaveGrupo = filter_input(INPUT_POST, 'fabricanteChaveGrupo');
        $modeloChaveGrupo = filter_input(INPUT_POST, 'modeloChaveGrupo');
        $fabricanteChaveRede = filter_input(INPUT_POST, 'fabricanteChaveRede');
        $modeloChaveRede = filter_input(INPUT_POST, 'modeloChaveRede');

        $gmg = Genset::select()->where('numeroSerie', $numeroSerie)->first();

        if ($gmg === null) {

            $new_post = [
                'idCliente' => $idCliente,
                'tipoEquipamento' => $tipoEquipamento,
                'identificacao' => $identificacao,
                'fabricante' => $fabricante,
                'numeroSerie' => $numeroSerie,
                'dataFabricacao' => $dataFabricacao,
                'potencia' => $potencia,
                'abrangencia' => $abrangencia,
                'tanqueBase' => $tanqueBase,
                'aberturaJanelaBase' => $aberturaJanelaBase,
                'capacidadeTanqueBase' => $capacidadeTanqueBase,
                'tanqueDiario' => $tanqueDiario,
                'aberturaJanelaDiario' => $aberturaJanelaDiario,
                'capacidadeTanqueDiario' => $capacidadeTanqueDiario,
                'tanqueMensal' => $tanqueMensal,
                'aberturaJanelaMensal' => $aberturaJanelaMensal,
                'capacidadeTanqueMensal' => $capacidadeTanqueMensal,
                'fabricanteMotor' => $fabricanteMotor,
                'modeloMotor' => $modeloMotor,
                'serieMotor' => $serieMotor,
                'quantidadeOleoLubrificante' => $quantidadeOleoLubrificante,
                'modeloFiltroCombustivel' => $modeloFiltroCombustivel,
                'quantidadeFiltroCombustivel' => $quantidadeFiltroCombustivel,
                'modeloFiltroSeparador' => $modeloFiltroSeparador,
                'quantidadeFiltroSeparador' => $quantidadeFiltroSeparador,
                'modeloFiltroAgua' => $modeloFiltroAgua,
                'quantidadeFiltroAgua' => $quantidadeFiltroAgua,
                'modeloFiltroOleo' => $modeloFiltroOleo,
                'quantidadeFiltroOleo' => $quantidadeFiltroOleo,
                'modeloFiltroAr' => $modeloFiltroAr,
                'quantidadeFiltroAr' => $quantidadeFiltroAr,
                'fabricanteAlternador' => $fabricanteAlternador,
                'modeloAlternador' => $modeloAlternador,
                'serieAlternador' => $serieAlternador,
                'fabricanteModuloGrupo' => $fabricanteModuloGrupo,
                'modeloModuloGrupo' => $modeloModuloGrupo,
                'fabricanteModuloQta' => $fabricanteModuloQta,
                'modeloModuloQta' => $modeloModuloQta,
                'fabricanteChaveGrupo' => $fabricanteChaveGrupo,
                'modeloChaveGrupo' => $modeloChaveGrupo,
                'fabricanteChaveRede' => $fabricanteChaveRede,
                'modeloChaveRede' => $modeloChaveRede,

            ];

            $post = new Genset($new_post);
            $post->save();

            $gmg = Genset::select()->orderby('id', 'desc')->first();

            //cria posicao imagens
            $posicoes = array(
                'geralGmg',
                'fabricante',
                'serie',
                'dataFabricacao',
                'potencia',
                'tanqueBase',
                'tanqueDiario',
                'tanqueMensal',
                'plaquetaMotor',
                'filtroCombustivel',
                'filtroSeparador',
                'filtroAgua',
                'filtroOleo',
                'filtroAr',
                'plaquetaAlternador',
                'frontalModuloGrupo',
                'traseiraModuloGrupo',
                'frontalModuloQta',
                'traseiraModuloQta',
                'frontalChaveGrupo',
                'frontalChaveRede',
                'cabinadoOuSala',
                'pisoParedes',
                'geradorPortaAberta',
                'preAquecimento',
                'escapamento',
                'qtaFechado',
                'qtaAberto',
                'contencao',
                'faixada',
            );

            foreach ($posicoes as $posicao) {
                $image = new Image();
                $image->idGmg = $gmg->id;
                $image->posicao = $posicao;
                $image->save();
            };
        } else {
            $idGmg = $gmg->id;

            echo "GERADOR JA EXISTE - use a tela de alteração";
        }


        return redirect()->route('detalhecliente', $idCliente)->with('success', 'Atualizado.');


        /*
        if ($_FILES['fotoGeralGmg']['name']) {
            $posicao = '_geralGMG_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoGeralGmg']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoFabricante']['name']) {
            $posicao = '_fabricante_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoFabricante']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }


        if ($_FILES['fotoNumeroSerie']['name']) {
            $posicao = '_serie_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoNumeroSerie']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoDataFabricacao']['name']) {
            $posicao = '_fabricacao_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoDataFabricacao']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoPotencia']['name']) {
            $posicao = '_potencia_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoPotencia']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }


        if ($_FILES['fotoTanqueBase']['name']) {
            $posicao = '_tanqueBase_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoTanqueBase']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoTanqueDiario']['name']) {
            $posicao = '_tanqueDiario_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoTanqueDiario']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoTanqueMensal']['name']) {
            $posicao = '_tanqueMensal_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoTanqueMensal']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoPlaquetaMotor']['name']) {
            $posicao = '_plaquetaMotor_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoPlaquetaMotor']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoFiltroCombustivel']['name']) {
            $posicao = '_filtroCombustivel_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoFiltroCombustivel']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoFiltroSeparador']['name']) {
            $posicao = '_filtroSeparador_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoFiltroSeparador']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoFiltroAgua']['name']) {
            $posicao = '_filtroAgua_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoFiltroAgua']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoFiltroOleo']['name']) {
            $posicao = '_filtroOleo_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoFiltroOleo']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }


        if ($_FILES['fotoFiltroAr']['name']) {
            $posicao = '_filtroAr_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoFiltroAr']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoPlaquetaAlternador']['name']) {
            $posicao = '_plaquetaAlternador_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoPlaquetaAlternador']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoFrontalModuloGrupo']['name']) {
            $posicao = '_frontalModuloGrupo_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoFrontalModuloGrupo']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoTraseiraModuloGrupo']['name']) {
            $posicao = '_traseiraModuloGrupo_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoTraseiraModuloGrupo']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }


        if ($_FILES['fotoFrontalModuloQta']['name']) {
            $posicao = '_frontalModuloQta_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoFrontalModuloQta']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoTraseiraModuloQta']['name']) {
            $posicao = '_traseiraModuloQta_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoTraseiraModuloQta']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoFrontalChaveGrupo']['name']) {
            $posicao = '_frontalChaveGrupo_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoFrontalChaveGrupo']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoFrontalChaveRede']['name']) {
            $posicao = '_frontalChaveRede_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoFrontalChaveRede']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }


        if ($_FILES['fotoCabinadoOuSala']['name']) {
            $posicao = '_cabinadoSala_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoCabinadoOuSala']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }


        if ($_FILES['fotoPisoParedes']['name']) {
            $posicao = '_pisoParedes_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoPisoParedes']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }


        if ($_FILES['fotoGeradorPortaAberta']['name']) {
            $posicao = '_geradorPortaAberta_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoGeradorPortaAberta']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoPreAquecimento']['name']) {
            $posicao = '_preAquecimanto_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoPreAquecimento']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }


        if ($_FILES['fotoEscapamento']['name']) {
            $posicao = '_escapamento_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoEscapamento']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }


        if ($_FILES['fotoQtaFechado']['name']) {
            $posicao = '_qtaFechado_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoQtaFechado']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }


        if ($_FILES['fotoQtaAberto']['name']) {
            $posicao = '_qtaAberto_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoQtaAberto']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }


        if ($_FILES['fotoContencao']['name']) {
            $posicao = '_contencao_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoContencao']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        }

        if ($_FILES['fotoFaixada']['name']) {
            $posicao = '_faixada_';
            $nomefotocapa = $idCliente . $posicao . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/clients/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoFaixada']['tmp_name'], $nomefotocapacompleto);



            $image = new Image();
            $image->idCliente = $idCliente;
            $image->posicao = $posicao;
            $image->url =  $nomefotocapa;
            $image->save();
        } else {
            $nomefotocapa = null;
        } */
    }

    public function clients()
    {

        $clients = new Client();

        $client = $clients->all();

        foreach ($client as $row) {
            $data[] = array(

                'name' => $row["nome"],

            );
        }




        echo json_encode($data);
    }

    public function clientdata(Request $r)
    {

        $client = Client::select()
            ->where('nome', $r->client)
            ->first();

        $data = array(

            'id' => $client["id"],

        );


        echo json_encode($data);
    }

    public function clientes()
    {

        $clientes = Client::select()
            ->orderByRaw('id DESC')
            ->get();
        return view('Admin.clientes', ['clientes' => $clientes]);
    }

    public function detalhescliente($id)
    {

        $cliente = Client::select()
            ->where('id', $id)
            ->first();

        $maquinas = Genset::select()
            ->where('idCLiente', $id)
            ->get(); {
            return view(
                'Admin.detalhecliente',
                [
                    'cliente' => $cliente,
                    'maquinas' => $maquinas
                ]
            );
        }
    }
    public function alteracliente($id)
    {

        $cliente = Client::select()
            ->where('id', $id)
            ->first(); {
            return view(
                'Admin.alteracliente',
                ['cliente' => $cliente]
            );
        }
    }

    public function alteracaocliente($id)
    {
        $nome = filter_input(INPUT_POST, 'nome');
        $endereco = filter_input(INPUT_POST, 'endereco');
        $cep = filter_input(INPUT_POST, 'cep');
        $estado = filter_input(INPUT_POST, 'estado');
        $regiao = filter_input(INPUT_POST, 'regiao');
        $cnpj = filter_input(INPUT_POST, 'cnpj');
        $ie = filter_input(INPUT_POST, 'ie');
        $tipoContrato = filter_input(INPUT_POST, 'tipoContrato');
        $periodicidade = filter_input(INPUT_POST, 'periodicidade');
        $visitas = filter_input(INPUT_POST, 'visitas');
        $sla = filter_input(INPUT_POST, 'sla');
        $observacao = filter_input(INPUT_POST, 'observacao');
        $vendedor = filter_input(INPUT_POST, 'vendedor');
        $tecnico = filter_input(INPUT_POST, 'tecnico');

        $cliente = Client::select()
            ->where('id', $id)
            ->first();

        $cliente->nome = $nome;
        $cliente->endereco = $endereco;
        $cliente->cep = $cep;
        $cliente->estado = $estado;
        $cliente->regiao = $regiao;
        $cliente->cnpj = $cnpj;
        $cliente->ie = $ie;
        $cliente->tipoContrato = $tipoContrato;
        $cliente->periodicidade = $periodicidade;
        $cliente->visitas = $visitas;
        $cliente->sla = $sla;
        $cliente->observacao = $observacao;
        $cliente->vendedor = $vendedor;
        $cliente->tecnico = $tecnico;
        $cliente->save();

        return redirect()->route('detalhecliente', $id)->with('success', 'Atualizado.');
    }

    public function detalhemaquina($id)
    {

        $relatorioAberto = AtendimentoReport::where('idEquip', $id)
            ->where('statusRelatorio', '<>', 4)
            ->get();

        $avulsoAberto = Locacaoavulsareport::where('idEquip', $id)
            ->where('statusRelatorio', '<>', 4)
            ->get();




        $gmg = Genset::select()
            ->where('id', $id)
            ->first();

        $images = Image::select()
            ->where('idGmg', $id)
            ->get();


        return view('Admin.detalhemaquina', [
            'dados' => $gmg,
            'imagens' => $images,
            'id' => $id,
            'relatorioAberto' => $relatorioAberto,
            'avulsoAberto' => $avulsoAberto
        ]);
    }

    public function alteracaoimagem($id)
    {

        return view('Admin.alteraimagem');
    }

    public function processaimagem($id)
    {
        $image = Image::select()->where('id', $id)->first();

        $nomefotocapa = $image->idGmg . '_' . $image->posicao . '_' . date('dmYHis') . '.jpeg';
        $diretorio = "assets/images/clients/";
        $nomefotocapacompleto = $diretorio . $nomefotocapa;
        move_uploaded_file($_FILES['foto']['tmp_name'], $nomefotocapacompleto);

        $image->url = $nomefotocapa;
        $image->save();

        return redirect()->route('detalhemaquina', $image->idGmg)->with('success', 'Atualizado.');
    }

    public function listamaquinas()
    {

          $maquinas = Genset::select('gensets.*', 'clients.nome')
            ->join('clients', 'gensets.idCliente', '=', 'clients.id')
            ->orderByRaw('gensets.created_at DESC')
            ->get();

        //$maquinas = Equip::select()->get();
        return view('Admin.maquinas', ['maquinas' => $maquinas]);
    }


    public function telaMonitoramento($id)
    {

        $dados = Allexoequipdata::select('allexoequipdatas.*', 'allexoequipvars.name')
            ->join('allexoequipvars', 'allexoequipdatas.symbol', '=', 'allexoequipvars.symbol')
            ->where('allexoequipdatas.idEquip', $id)
            ->get();

        return view(
            'Admin.telamonitoramento',
            ['dados' => $dados]
        );
    }


    public function formprospeccao()
    {

        return view('Admin.telaprospeccao');
    }

    public function prospeccaoenviada($busca, $email)
    {

        return view('Admin.prospeccaoenviada', [
            'busca' => $busca,
            'email' => $email
        ]);
    }


    public function processaprospeccao()
    {
        $busca = filter_input(INPUT_POST, 'busca');
        $email = filter_input(INPUT_POST, 'email');



        $response = Http::get(
            'http://apiessencial.com.br/prospecta',
            //'http://localhost:456/',
            [
                'busca' => $busca,
                'email' => $email,
            ]
        );

        return redirect()->route(
            'prospeccaoenviada',
            [
                'busca' => $busca,
                'email' => $email,
            ]
        );
    }

    public function formbuscacnpj()
    {

        return view('Admin.telabuscacnpj');
    }

    public function listaCidadesIbge()
    {

        $municipios = Municipio::select('nome', 'ufSigla', 'id')->get();

        foreach ($municipios as $row) {
            $data[] = array(

                'name' => $row["nome"] . ' - ' . $row['ufSigla'] . ' | ' . $row['id'],


            );
        }

        echo json_encode($data);
    }
    public function codigoIbge($cidade)
    {

        $cidade = Municipio::select('id')->where('nome', $cidade)->first();

        $cidade = array(

            'id' => $cidade["id"],

        );

        echo json_encode($cidade);
    }

    public function buscaCnpj()
    {

        $cidade = filter_input(INPUT_POST, 'cidade');
        $cidade = explode('|', $cidade);
        $city = $cidade[0];
        $cidade = $cidade[1];
        $segmento = filter_input(INPUT_POST, 'segmento');
        $segmento = explode('|', $segmento);
        $seg = $segmento[0];
        $segmento = $segmento[1];


        $response = Http::get(
            //'http://apiessencial.com.br/buscacnpjs',
            'http://localhost:3000/',
            [
                'cidade' => $cidade,
                'segmento' => $segmento,
                'seg' => $seg,
            ]
        );

        return redirect()->route(
            'buscacnpjenviada',
            [
                'cidade' => $city,
                'segmento' => $seg,
            ]
        );

        //echo "A cidade é: ".$cidade."<br> E o segmento é: ".$seg;
    }

    public function inicioProspecoes()
    {

        $dados = Prospecto::select('id', 'razaoSocial', 'cidade', 'segmento')->get();
        $total = Prospecto::select()->count();

        return view('Admin.inicioProspecoes', [
            'dados' => $dados,
            'total' => $total
        ]);
    }

    public function detalheDaProspeccao($id)
    {

        $dados = Prospecto::select()
            ->where('id', $id)
            ->first();

        $obs = Obsprospecto::select()
            ->where('idprospect', $id)
            ->orderby('id', 'desc')
            ->get();

        return view(
            'Admin.detalheprospeccao',
            [
                'dados' => $dados,
                'observacoes' => $obs
            ]
        );
    }

    public function insereobsprospect($contato)
    {
        $obs = filter_input(INPUT_POST, 'obs');

        Obsprospecto::create([
            'idprospect' => $contato,
            'obs' => $obs
        ]);

        return redirect()->route('detalheprospeccao', $contato);
    }

    public function buscacnpjenviada($cidade, $segmento)
    {

        return view('Admin.buscacnpjenviada', [
            'cidade' => $cidade,
            'segmento' => $segmento
        ]);
    }

    public function telaAlteramaquina($id)
    {

        $dados = Genset::select()
            ->where('id', $id)
            ->first();

        return view('Admin.alteramaquina', [
            'dados' => $dados
        ]);
    }

    public function processaAlteracaoMaquina($id)
    {

        $tipoEquipamento = filter_input(INPUT_POST, 'tipoEquipamento');
        $identificacao = filter_input(INPUT_POST, 'identificacao');
        $fabricante = filter_input(INPUT_POST, 'fabricante');
        $numeroSerie = filter_input(INPUT_POST, 'numeroSerie');
        $dataFabricacao = filter_input(INPUT_POST, 'dataFabricacao');
        $potencia = filter_input(INPUT_POST, 'potencia');
        $abrangencia = filter_input(INPUT_POST, 'abrangencia');
        $tanqueBase = filter_input(INPUT_POST, 'tanqueBase');
        $aberturaJanelaBase = filter_input(INPUT_POST, 'aberturaJanelaBase');
        $capacidadeTanqueBase = filter_input(INPUT_POST, 'capacidadeTanqueBase');
        $tanqueDiario = filter_input(INPUT_POST, 'tanqueDiario');
        $aberturaJanelaDiario = filter_input(INPUT_POST, 'aberturaJanelaDiario');
        $capacidadeTanqueDiario = filter_input(INPUT_POST, 'capacidadeTanqueDiario');
        $tanqueMensal = filter_input(INPUT_POST, 'tanqueMensal');
        $aberturaJanelaMensal = filter_input(INPUT_POST, 'aberturaJanelaMensal');
        $capacidadeTanqueMensal = filter_input(INPUT_POST, 'capacidadeTanqueMensal');
        $fabricanteMotor = filter_input(INPUT_POST, 'fabricanteMotor');
        $modeloMotor = filter_input(INPUT_POST, 'modeloMotor');
        $serieMotor = filter_input(INPUT_POST, 'serieMotor');
        $quantidadeOleoLubrificante = filter_input(INPUT_POST, 'quantidadeOleoLubrificante');
        $modeloFiltroCombustivel = filter_input(INPUT_POST, 'modeloFiltroCombustivel');
        $quantidadeFiltroCombustivel = filter_input(INPUT_POST, 'quantidadeFiltroCombustivel');
        $modeloFiltroSeparador = filter_input(INPUT_POST, 'modeloFiltroSeparador');
        $quantidadeFiltroSeparador = filter_input(INPUT_POST, 'quantidadeFiltroSeparador');
        $modeloFiltroAgua = filter_input(INPUT_POST, 'modeloFiltroAgua');
        $quantidadeFiltroAgua = filter_input(INPUT_POST, 'quantidadeFiltroAgua');
        $modeloFiltroOleo = filter_input(INPUT_POST, 'modeloFiltroOleo');
        $quantidadeFiltroOleo = filter_input(INPUT_POST, 'quantidadeFiltroOleo');
        $modeloFiltroAr = filter_input(INPUT_POST, 'modeloFiltroAr');
        $quantidadeFiltroAr = filter_input(INPUT_POST, 'quantidadeFiltroAr');
        $fabricanteAlternador = filter_input(INPUT_POST, 'fabricanteAlternador');
        $modeloAlternador = filter_input(INPUT_POST, 'modeloAlternador');
        $serieAlternador = filter_input(INPUT_POST, 'serieAlternador');
        $fabricanteModuloGrupo = filter_input(INPUT_POST, 'fabricanteModuloGrupo');
        $modeloModuloGrupo = filter_input(INPUT_POST, 'modeloModuloGrupo');
        $fabricanteModuloQta = filter_input(INPUT_POST, 'fabricanteModuloQta');
        $modeloModuloQta = filter_input(INPUT_POST, 'modeloModuloQta');
        $fabricanteChaveGrupo = filter_input(INPUT_POST, 'fabricanteChaveGrupo');
        $modeloChaveGrupo = filter_input(INPUT_POST, 'modeloChaveGrupo');
        $fabricanteChaveRede = filter_input(INPUT_POST, 'fabricanteChaveRede');
        $modeloChaveRede = filter_input(INPUT_POST, 'modeloChaveRede');

        Genset::where('id', $id)->update([
            'tipoEquipamento' => $tipoEquipamento,
            'identificacao' => $identificacao,
            'fabricante' => $fabricante,
            'numeroSerie' => $numeroSerie,
            'dataFabricacao' => $dataFabricacao,
            'potencia' => $potencia,
            'abrangencia' => $abrangencia,
            'tanqueBase' => $tanqueBase,
            'aberturaJanelaBase' => $aberturaJanelaBase,
            'capacidadeTanqueBase' => $capacidadeTanqueBase,
            'tanqueDiario' => $tanqueDiario,
            'aberturaJanelaDiario' => $aberturaJanelaDiario,
            'capacidadeTanqueDiario' => $capacidadeTanqueDiario,
            'tanqueMensal' => $tanqueMensal,
            'aberturaJanelaMensal' => $aberturaJanelaMensal,
            'capacidadeTanqueMensal' => $capacidadeTanqueMensal,
            'fabricanteMotor' => $fabricanteMotor,
            'modeloMotor' => $modeloMotor,
            'serieMotor' => $serieMotor,
            'quantidadeOleoLubrificante' => $quantidadeOleoLubrificante,
            'modeloFiltroCombustivel' => $modeloFiltroCombustivel,
            'quantidadeFiltroCombustivel' => $quantidadeFiltroCombustivel,
            'modeloFiltroSeparador' => $modeloFiltroSeparador,
            'quantidadeFiltroSeparador' => $quantidadeFiltroSeparador,
            'modeloFiltroAgua' => $modeloFiltroAgua,
            'quantidadeFiltroAgua' => $quantidadeFiltroAgua,
            'modeloFiltroOleo' => $modeloFiltroOleo,
            'quantidadeFiltroOleo' => $quantidadeFiltroOleo,
            'modeloFiltroAr' => $modeloFiltroAr,
            'quantidadeFiltroAr' => $quantidadeFiltroAr,
            'fabricanteAlternador' => $fabricanteAlternador,
            'modeloAlternador' => $modeloAlternador,
            'serieAlternador' => $serieAlternador,
            'fabricanteModuloGrupo' => $fabricanteModuloGrupo,
            'modeloModuloGrupo' => $modeloModuloGrupo,
            'fabricanteModuloQta' => $fabricanteModuloQta,
            'modeloModuloQta' => $modeloModuloQta,
            'fabricanteChaveGrupo' => $fabricanteChaveGrupo,
            'modeloChaveGrupo' => $modeloChaveGrupo,
            'fabricanteChaveRede' => $fabricanteChaveRede,
            'modeloChaveRede' => $modeloChaveRede,
        ]);

        return redirect()->route('detalhemaquina', $id)->with('success', 'Atualizado.');
    }

    public function listaClientes()
    {

        $clientes = Client::select('id', 'nome')->get();
        foreach ($clientes as $cliente) {
            $data[] = array(

                'name' => $cliente["id"] . ' - ' . $cliente["nome"],



            );
        }

        echo json_encode($data);
    }

    public function telaRequisicaoCompra($id)
    {



        $detail = Requisicaocompra::select('requisicaocompras.*', 'clients.nome')
            ->join('clients', 'requisicaocompras.idCliente', '=', 'clients.id')
            ->where('requisicaocompras.id', $id)->first();





        if ($detail->solicitante == Auth::user()->id) {


            if ($detail->tipo == 1) {
                $detail->tipo = 'Orçamento';
            } else if ($detail->tipo == 2) {
                $detail->tipo = 'Compra';
            } else {
                $detail->tipo = 'Separação';
            }

            if ($detail->status == 1) {
                $detail->status = 'Aberto';
            } else if ($detail->status == 2) {
                $detail->status = 'Em analise';
            } else if ($detail->status == 3) {
                $detail->status = 'Em separação';
            } else if ($detail->status == 4) {
                $detail->status = 'Separado';
            } else if ($detail->status == 5) {
                $detail->status = 'Em conferencia';
            } else if ($detail->status == 6) {
                $detail->status = 'Conferido';
            } else if ($detail->status == 99) {
                $detail->status = 'Rejeitado';
            }


            if ($detail->resp) {
                $resp = User::select('name')->where('id', $detail->resp)->first();
                $detail->resp = $resp->name;
            } else {
                $detail->resp = 'Não Atribuido';
            }



            $products = Produtosrequisicaocompra::select()->where('idRequisicao', $id)->get();

            foreach ($products as $product) {
                if ($product->produtoCadastrado == 1) {
                    $product->produtoCadastrado = 'Sim';
                    $product->descricaoProduto = Produto::select('descricao')->where('id', $product->produto)->first();
                } else {
                    $product->produtoCadastrado = 'Não';
                }
            }

            //buscar observações de forma descendente
            $observacoes = Obsreqcompra::select()
                ->where('idreqcompra', $id)
                ->orderBy('created_at', 'desc')
                ->get();


            return view('Admin.detalheRequisicao', [
                'detail' => $detail,
                'products' => $products,
                'id' => $id,
                'observacoes' => $observacoes
            ]);
        } else {

            return redirect()->route('telaListaRequisicoes')->with('error', 'Você não tem permissão para acessar essa requisição.');
        }
    }

    public function listaRequisicoes()
    {

        $user = Auth::user()->id;

        $requisicoes = Requisicaocompra::select('requisicaocompras.*', 'clients.nome')
            ->join('clients', 'requisicaocompras.idCliente', '=', 'clients.id')
            ->where('requisicaocompras.solicitante', $user)
            ->orderBy('requisicaocompras.created_at', 'desc')
            ->get();

        foreach ($requisicoes as $requisicao) {
            if ($requisicao->tipo == 1) {
                $requisicao->tipo = 'Orçamento';
            } else if ($requisicao->tipo == 2) {
                $requisicao->tipo = 'Compra';
            } else {
                $requisicao->tipo = 'Separação';
            }

            if ($requisicao->status == 1) {
                $requisicao->status = 'Aberto';
            } else if ($requisicao->status == 2) {
                $requisicao->status = 'Em analise';
            } else if ($requisicao->status == 3) {
                $requisicao->status = 'Em separação';
            } else if ($requisicao->status == 4) {
                $requisicao->status = 'Separado';
            } else if ($requisicao->status == 5) {
                $requisicao->status = 'Em conferencia';
            } else if ($requisicao->status == 6) {
                $requisicao->status = 'Conferido';
            } else if ($requisicao->status == 99) {
                $requisicao->status = 'Rejeitado';
            } else if ($requisicao->status == 4) {
                $requisicao->status = 'Separado';
            } else if ($requisicao->status == 5) {
                $requisicao->status = 'Em conferencia';
            } else if ($requisicao->status == 6) {
                $requisicao->status = 'Conferido';
            } else if ($requisicao->status == 99) {
                $requisicao->status = 'Rejeitado';
            }
        }


        return view(
            'Admin.listarequisicoescompra',
            [
                'requisicoes' => $requisicoes
            ]
        );
    }

    public function setNewClient(Request $req)
    {

        $razaoSocial = $req->input('razaoSocial');
        $nome = $req->input('nome');
        $cnpj = $req->input('cnpj');
        $classificacao = $req->input('classificacao');
        $telefone = $req->input('telefone');
        $cep = $req->input('cep');
        $endereco = $req->input('endereco');
        $bairro = $req->input('bairro');
        $cidade = $req->input('cidade');
        $uf = $req->input('uf');
        $email = $req->input('email');
        $emailCobranca = $req->input('emailCobranca');


        $client = new client();
        $client->razaoSocial = $razaoSocial;
        $client->nome = $nome;
        $client->cnpj = $cnpj;
        $client->classificacao = $classificacao;
        $client->telefone = $telefone;
        $client->cep = $cep;
        $client->endereco = $endereco;
        $client->bairro = $bairro;
        $client->cidade = $cidade;
        $client->uf = $uf;
        $client->email = $email;
        $client->emailCobranca = $emailCobranca;
        $client->save();

        $idCriado = client::select('id')->orderByDesc('id')->first();


        return redirect()->route('detalhecliente', $idCriado->id)->with('success', 'Criado.');
    }

    public function farol()
    {

        $tasks = Semaphore::select()
            ->get();
        /*
        $resultados = Questionarie::select('equipId', DB::raw('MAX(id) as id'), DB::raw('MAX(created_at) as data_criacao'))
            ->where('questionDescription', 'Status geral do gerador')
            ->groupBy('equipId')
            ->get();
 */

        $totalVerde = 0;
        $totalAmarelo = 0;
        $totalVermelho = 0;


        foreach ($tasks as $task) {
            $codigoCliente = Equip::select('clientAuvoId')
                ->where('auvoId', '=', $task->equipId)
                ->first(); // Use first() em vez de get()

            if ($codigoCliente) { // Verifica se a consulta retornou um resultado
                $dadosCliente = Client::select('razaoSocial', 'nome')
                    ->where('idAuvo', '=', $codigoCliente->clientAuvoId)
                    ->first();

                if ($dadosCliente) { // Verifica se a segunda consulta retornou um resultado
                    $task->razaoSocial = $dadosCliente->razaoSocial;
                    $task->nome = $dadosCliente->nome;
                }
            }

            if (mb_strtolower($task->reply, 'UTF-8') == 'operando normalmente') {
                $totalVerde++;
            } elseif (mb_strtolower($task->reply, 'UTF-8') == 'operando com restrição') {
                $totalAmarelo++;
            } elseif (mb_strtolower($task->reply, 'UTF-8') == 'inoperante') {
                $totalVermelho++;
            }
        }


        /*
        $totalVerde = Semaphore::select()
            ->where('reply', 'Operando Normalmente')
            ->count();


        $totalAmarelo = Semaphore::select()
            ->where('reply', 'Operando com restrição')
            ->count();


        $totalVermelho = Semaphore::select()
            ->where('reply', 'Inoperante')
            ->count();
 */




        return view(
            'Admin.farol',
            [
                'tasks' => $tasks,
                'totalVerde' => $totalVerde,
                'totalAmarelo' => $totalAmarelo,
                'totalVermelho' => $totalVermelho,


            ]
        );
    }

    public function farol2()
    {

        $totalVerde = 0;
        $totalAmarelo = 0;
        $totalVermelho = 0;


        $tasks =  Questionarie::where('questionDescription', 'STATUS GERAL DO GRUPO GERADOR')
            ->orWhere('questionDescription', 'Status geral do gerador')
            ->orWhere('questionDescription', 'Status geral do grupo gerador e QTA')
            ->get();


        foreach ($tasks as $task) {

            $codigoCliente = Task::select('clientId')
                ->where('auvoId', '=', $task->taskId)
                ->first(); // Use first() em vez de get()

            $dadosCliente = Client::select('razaoSocial', 'nome')
                ->where('idAuvo', '=', $codigoCliente->clientId)
                ->first();

            $obs = Task::select('obs')
                ->where('auvoId', '=', $task->taskId)
                ->first();

            $task->obs = $obs->obs;

            if (mb_strtolower($task->reply, 'UTF-8') == 'operando normalmente') {
                $totalVerde++;
            } elseif (mb_strtolower($task->reply, 'UTF-8') == 'operando com restrição') {
                $totalAmarelo++;
            } elseif (mb_strtolower($task->reply, 'UTF-8') == 'inoperante') {
                $totalVermelho++;
            }


            if ($dadosCliente) {
                $task->razaoSocial = $dadosCliente->razaoSocial;
                $task->nome = $dadosCliente->nome;
            } else {
                $task->razaoSocial = "Sem cliente cadastrado";
                $task->nome = "Sem cliente cadastrado";
            }
        }







        return view(
            'Admin.farol2',
            [
                'tasks' => $tasks,
                'totalVerde' => $totalVerde,
                'totalAmarelo' => $totalAmarelo,
                'totalVermelho' => $totalVermelho,


            ]
        );
    }


    public function farol3()
    {


        $tasks = Questionarie::where('questionDescription', 'STATUS GERAL DO GRUPO GERADOR')
            ->orWhere('questionDescription', 'Status geral do gerador')
            ->orWhere('questionDescription', 'Status geral do grupo gerador e QTA')
            ->orderBy('created_at', 'desc')
            ->get();

        /*  echo '<pre>';
        var_dump($tasks);
        echo '</pre>'; */


        foreach ($tasks as $task) {

            $codigoCliente = Task::select('clientId')
                ->where('auvoId', '=', $task->taskId)
                ->first(); // Use first() em vez de get()


            $dadosCliente = Client::select('razaoSocial', 'nome')
                ->where('idAuvo', '=', $codigoCliente->clientId)
                ->first();

            $obs = Task::select('obs')
                ->where('auvoId', '=', $task->taskId)
                ->first();

            $task->obs = $obs->obs;
            $task->codCliente = $codigoCliente;




            if ($dadosCliente) {
                $task->razaoSocial = $dadosCliente->razaoSocial;
                $task->nome = $dadosCliente->nome;
            } else {
                $task->razaoSocial = "Sem cliente cadastrado";
                $task->nome = "Sem cliente cadastrado";
            }
        }

        $codigosClientesUnicos = new \Illuminate\Support\Collection();

        // Percorrer os elementos de $tasks
        foreach ($tasks as $index => $task) {
            // Verificar se o código do cliente já existe no conjunto
            if ($codigosClientesUnicos->contains($task->codCliente)) {
                // Remover o elemento duplicado do array $tasks
                unset($tasks[$index]);
            } else {
                // Adicionar o código do cliente ao conjunto
                $codigosClientesUnicos->push($task->codCliente);
            }
        }



        // Recalcular os totais de cores
        $totalVerde = 0;
        $totalAmarelo = 0;
        $totalVermelho = 0;



        foreach ($tasks as $task) {
            if (mb_strtolower($task->reply, 'UTF-8') == 'operando normalmente') {
                $totalVerde++;
            } elseif (mb_strtolower($task->reply, 'UTF-8') == 'operando com restrição') {
                $totalAmarelo++;
            } elseif (mb_strtolower($task->reply, 'UTF-8') == 'inoperante') {
                $totalVermelho++;
            }
        }


        return view(
            'Admin.farol',
            [
                'tasks' => $tasks,
                'totalVerde' => $totalVerde,
                'totalAmarelo' => $totalAmarelo,
                'totalVermelho' => $totalVermelho,


            ]
        );
    }

    public function baterias()
    {

        $tasks =  Questionarie::where('questionDescription', 'INFORMAR A DATA DE FABRICAÇÃO DE "CADA" BATERIA')
            ->get();

        foreach ($tasks as $task) {

            $codigoCliente = Task::select('clientId')
                ->where('auvoId', '=', $task->taskId)
                ->first();

            $dadosCliente = Client::select('razaoSocial', 'nome')
                ->where('idAuvo', '=', $codigoCliente->clientId)
                ->first();

            $obs = Task::select('obs')
                ->where('auvoId', '=', $task->taskId)
                ->first();

            if ($dadosCliente) {
                $task->nomeCliente = $dadosCliente->nome;
                $task->razaoSocial = $dadosCliente->razaoSocial;
            } else {
                $task->nomeCliente = 'Sem cliente cadastrado';
                $task->razaoSocial = 'Sem cliente cadastrado';
            }


            $task->obs = $obs->obs;
        }



        return view('Admin.baterias', [
            'tasks' => $tasks,
        ]);
    }

    public function atendimentoAuvo($id)
    {
        $answers = Questionarie::select('questionDescription', 'reply')
            ->where('taskId', $id)
            ->get();

        // Array para armazenar todas as respostas
        $allAnswers = [];

        foreach ($answers as $answer) {
            // Converte cada resposta para array e adiciona ao array principal
            $allAnswers[] = $answer->toArray();
        }

        // Converte o array de respostas para JSON
        $jsonAnswers = json_encode($allAnswers);

        // Imprime o JSON na tela
        echo $jsonAnswers;
    }

    public function novoChamado()
    {

        return view('Admin.novochamado');
    }

    public function criaChamado(Request $req)
    {
        $client = $req->input('client');
        $sep = explode("-", $client);
        $clientId = $sep[0];

        $contactName = $req->input('contactName');
        $position = $req->input('position');
        $phone = $req->input('phone');
        $description = $req->input('description');

        $call = new Call();
        $call->clientId = $clientId;
        $call->contactName = $contactName;
        $call->position = $position;
        $call->phone = $phone;
        $call->description = $description;
        $call->save();

        echo "gravou";
    }

    public function listaChamados()
    {

        $calls = Call::select()->get();

        foreach ($calls as $call) {
            $nome = Client::select()
                ->where('id', '=', $call->clientId)
                ->first();

            $call->name = $nome->nome;
        }


        return view(
            'Admin.chamados',
            ['calls' => $calls]

        );
    }

    public function detalheChamado($id)
    {
        $call = Call::select()->where('id', '=', $id)->first();

        $name = Client::select()->where('id', '=', $call->clientId)->first();

        $call->name = $name->razaoSocial;

        $serviceOrder = Serviceorder::select()->where('idCall', '=', $id)->first();
        if ($serviceOrder) {
            $serviceReport = Servicereport::select()->where('idOs', '=', $serviceOrder->id)->first();
        } else {

            $serviceReport = null;
        }


        return view('Admin.detalhechamado', [
            'call' => $call,
            'serviceOrder' => $serviceOrder,
            'serviceReport' => $serviceReport,
        ]);
    }

    public function novaOrdemServico($id)
    {
        $serviceOrder = new Serviceorder();
        $serviceOrder->idCall = $id;
        $serviceOrder->status = 1;
        $serviceOrder->save();

        $call = Call::select()->where('id', '=', $id)->first();



        $serviceReport = new Servicereport();
        $serviceReport->idOs = $serviceOrder->id;
        $serviceReport->problemDescription = $call->description;
        $serviceReport->save();


        return redirect()->back();
    }

    public function atendimentoChamado($id)
    {
        $reportData = Servicereport::select()->where('id', '=', $id)->first();
        $serviceOrder = Serviceorder::select()->where('id', '=', $reportData->idOs)->first();
        $callData = Call::select()->where('id', '=', $serviceOrder->idCall)->first();
        $name = Client::select()->where('id', '=', $callData->clientId)->first();
        $callData->name = $name->razaoSocial;

        return view('Admin.atendimentoChamado', [
            'reportData' => $reportData,
            'serviceOrder' => $serviceOrder,
            'callData' => $callData,
        ]);
    }

    public function exportaFarol()
    {
        return Excel::download(new FarolExport, 'farol.xlsx');
    }


    public function farol4()
    {
        //busca todos os clientes com tarefas
        $clientsId = Task::select('clientId')->distinct()->get();

        // Recalcular os totais de cores
        $totalVerde = 0;
        $totalAmarelo = 0;
        $totalVermelho = 0;

        $tasks = [];

        //loop para passar por todos os clientes
        foreach ($clientsId as $clientId) {

            //buscar última data de atendimento
            $lastDate = Task::select('created_at')
                ->where('clientId', '=', $clientId->clientId)
                ->orderBy('created_at', 'desc')
                ->first();

            //buscar todos os atendimentos para esse cliente na ultima data
            $services = Task::select()
                ->where('clientId', '=', $clientId->clientId)
                ->where('created_at', '=', $lastDate->created_at)
                ->get();

            $listaStatus = []; // Inicialize o array antes do loop foreach

            foreach ($services as $service) {
                $statusAtendimentos = Questionarie::where('taskId', $service->auvoId)
                    ->where(function ($query) {
                        $query->where('questionDescription', 'STATUS GERAL DO GRUPO GERADOR')
                            ->orWhere('questionDescription', 'Status geral do gerador')
                            ->orWhere('questionDescription', 'Status geral do grupo gerador e QTA')
                            ->orWhere('questionDescription', 'Status geral dos equipamentos (Farol)')
                            ->orWhere('questionDescription', 'Status geral do equipamento (Farol)');
                    })
                    ->get() // Use get() para obter todas as colunas
                    ->map(function ($item) {
                        return mb_strtolower($item->reply, 'UTF-8'); // Acesse a coluna 'reply' de cada item e aplique mb_strtolower()
                    })
                    ->toArray(); // Converta a coleção para um array simples

                // Adicione o array de status ao array $listaStatus
                $listaStatus = array_merge($listaStatus, $statusAtendimentos);
            }

            // Verifique os status obtidos
            if (in_array("inoperante", $listaStatus)) {
                $totalVermelho++;
                $service->statusFarol = 'inoperante';
            } elseif (in_array("operando com restrição", $listaStatus)) {
                $totalAmarelo++;
                $service->statusFarol = 'operando com restrição';
            } else {
                $totalVerde++;
                $service->statusFarol = 'operando normalmente';
            }

            //busca os dados do cliente
            $dadosCliente = Client::select('razaoSocial', 'nome')
                ->where('idAuvo', '=', $clientId->clientId)
                ->first();

            if ($dadosCliente) {
                $service->razaoSocial = $dadosCliente->razaoSocial;
                $service->nome = $dadosCliente->nome;
            } else {
                $service->razaoSocial = "Sem cliente cadastrado";
                $service->nome = "Sem cliente cadastrado";
            }

            $tasks[] = $service; // Adiciona o resultado ao array $tasks


        }



        return view(
            'Admin.farol4',
            [
                'tasks' => $tasks,
                'totalVerde' => $totalVerde,
                'totalAmarelo' => $totalAmarelo,
                'totalVermelho' => $totalVermelho,


            ]
        );
    }

    public function verificaCadastro()
    {
        $clientsId = Task::select('clientId')->distinct()->get();

        $noRecords = [];

        foreach ($clientsId as $id) {
            /*   echo $id->clientId.'<hr>'; */

            $verification = Client::select()
                ->where('idAuvo', '=', $id->clientId)
                ->first();

            if (!$verification) {
                $noRecords[] = ['id' => $id->clientId];
            }
        }

        $jsonList = json_encode($noRecords);
        echo $jsonList;
    }

    public function filtroFarol()
    {

        date_default_timezone_set('America/Sao_Paulo');

        // Obtém as datas de hoje e da semana passada
        $today = date('Y-m-d 23:59:59'); // Data final às 23:59:59
        $lastWeek = date('Y-m-d 00:00:00', strtotime('-7 days')); // Data inicial às 00:00:00


        $tasks = Questionarie::select(
            'questionaries.*',
            'tasks.auvoId',
            'tasks.type',
            'tasks.taskDate',
            'clients.razaoSocial',
            'clients.nome',
            'tasks.obs'
        )
            ->join('tasks', 'questionaries.taskId', '=', 'tasks.auvoId')
            ->join('clients', 'tasks.clientId', '=', 'clients.idAuvo')
            ->whereBetween('tasks.taskDate', [$lastWeek, $today])
            ->whereIn('questionDescription', [
                'STATUS GERAL DO GRUPO GERADOR',
                'Status geral do gerador',
                'Status geral do grupo gerador e QTA',
                'Status geral dos equipamentos (Farol)',
                'Status geral do equipamento (Farol)'
            ])
            ->distinct()
            ->get();


        $totalVerde = 0;
        $totalAmarelo = 0;
        $totalVermelho = 0;
        $tasksUnique = collect(); // Cria uma nova coleção para armazenar as tarefas únicas

        foreach ($tasks as $task) {
            // Verifica se o auvoId já existe na coleção de tarefas únicas
            if (!$tasksUnique->contains('auvoId', $task->auvoId)) {
                // Se não existir, adiciona a tarefa à coleção de tarefas únicas
                $tasksUnique->push($task);

                // Realiza a verificação do status e contagem
                if (mb_strtolower($task->reply, 'UTF-8') == 'inoperante') {
                    $totalVermelho++;
                    $task->statusFarol = 'inoperante';
                } elseif (mb_strtolower($task->reply, 'UTF-8') == 'operando com restrição') {
                    $totalAmarelo++;
                    $task->statusFarol = 'operando com restrição';
                } else {
                    $totalVerde++;
                    $task->statusFarol = 'operando normalmente';
                }
            }
        }

        // Agora você pode usar $tasksUnique na view
        return view(
            'Admin.farolFiltro',
            [
                'tasks' => $tasksUnique,
                'totalVerde' => $totalVerde,
                'totalAmarelo' => $totalAmarelo,
                'totalVermelho' => $totalVermelho,
            ]
        );

        /*  echo "<pre>";
        var_dump($tasksUnique);
        echo "</pre>"; */
    }


    public function atualizaFarolFiltro(Request $request)
    {
        $inicio = $request->input('dataInicio');
        $fim = $request->input('dataFim');

        $dataInicio = explode('/', $inicio);
        $dataInicio = $dataInicio[2] . '-' . $dataInicio[1] . '-' . $dataInicio[0] . ' 00:00:00';

        $dataFim = explode('/', $fim);
        $dataFim = $dataFim[2] . '-' . $dataFim[1] . '-' . $dataFim[0] . ' 23:59:59';

        $tasks = Questionarie::select(
            'questionaries.*',
            'tasks.auvoId',
            'tasks.type',
            'tasks.taskDate',
            'clients.razaoSocial',
            'clients.nome',
            'tasks.obs'
        )
            ->join('tasks', 'questionaries.taskId', '=', 'tasks.auvoId')
            ->join('clients', 'tasks.clientId', '=', 'clients.idAuvo')
            ->whereBetween('tasks.taskDate', [$dataInicio, $dataFim])
            ->whereIn('questionDescription', [
                'STATUS GERAL DO GRUPO GERADOR',
                'Status geral do gerador',
                'Status geral do grupo gerador e QTA',
                'Status geral dos equipamentos (Farol)',
                'Status geral do equipamento (Farol)'
            ])
            ->distinct()
            ->get();

        $totalVerde = 0;
        $totalAmarelo = 0;
        $totalVermelho = 0;
        $tasksUnique = collect(); // Cria uma nova coleção para armazenar as tarefas únicas

        foreach ($tasks as $task) {
            // Verifica se o auvoId já existe na coleção de tarefas únicas
            if (!$tasksUnique->contains('auvoId', $task->auvoId)) {
                // Se não existir, adiciona a tarefa à coleção de tarefas únicas
                $tasksUnique->push($task);

                // Realiza a verificação do status e contagem
                if (mb_strtolower($task->reply, 'UTF-8') == 'inoperante') {
                    $totalVermelho++;
                    $task->statusFarol = 'inoperante';
                } elseif (mb_strtolower($task->reply, 'UTF-8') == 'operando com restrição') {
                    $totalAmarelo++;
                    $task->statusFarol = 'operando com restrição';
                } else {
                    $totalVerde++;
                    $task->statusFarol = 'operando normalmente';
                }
            }
        }


        return response()->json([
            'tasks' => $tasksUnique,
            'totalVerde' => $totalVerde,
            'totalAmarelo' => $totalAmarelo,
            'totalVermelho' => $totalVermelho,

        ]);
    }

    public function exportaFarolFiltro(Request $request)
    {

        $inicio = $request->input('dataInicio');
        $fim = $request->input('dataFim');

        $dataInicio = explode('/', $inicio);
        $dataInicio = $dataInicio[2] . '-' . $dataInicio[1] . '-' . $dataInicio[0] . ' 00:00:00';

        $dataFim = explode('/', $fim);
        $dataFim = $dataFim[2] . '-' . $dataFim[1] . '-' . $dataFim[0] . ' 23:59:59';


        $tasks = Questionarie::select(
            'questionaries.*',
            'tasks.auvoId',
            'tasks.type',
            'tasks.osurl',
            'tasks.taskDate',
            'clients.razaoSocial',
            'clients.nome',
            'tasks.obs'
        )
            ->join('tasks', 'questionaries.taskId', '=', 'tasks.auvoId')
            ->join('clients', 'tasks.clientId', '=', 'clients.idAuvo')
            ->whereBetween('tasks.taskDate', [$dataInicio, $dataFim])
            ->whereIn('questionDescription', [
                'STATUS GERAL DO GRUPO GERADOR',
                'Status geral do gerador',
                'Status geral do grupo gerador e QTA',
                'Status geral dos equipamentos (Farol)',
                'Status geral do equipamento (Farol)'
            ])
            ->distinct()
            ->get();

        $totalVerde = 0;
        $totalAmarelo = 0;
        $totalVermelho = 0;
        $tasksUnique = collect(); // Cria uma nova coleção para armazenar as tarefas únicas

        foreach ($tasks as $task) {
            // Verifica se o auvoId já existe na coleção de tarefas únicas
            if (!$tasksUnique->contains('auvoId', $task->auvoId)) {
                // Se não existir, adiciona a tarefa à coleção de tarefas únicas
                $tasksUnique->push($task);

                // Realiza a verificação do status e contagem
                if (mb_strtolower($task->reply, 'UTF-8') == 'inoperante') {
                    $totalVermelho++;
                    $task->statusFarol = 'inoperante';
                } elseif (mb_strtolower($task->reply, 'UTF-8') == 'operando com restrição') {
                    $totalAmarelo++;
                    $task->statusFarol = 'operando com restrição';
                } else {
                    $totalVerde++;
                    $task->statusFarol = 'operando normalmente';
                }
            }
        }


        return Excel::download(new FarolFiltroExport($tasks), 'farol.xlsx');
    }


    public function filtroFarolCarrefour()
    {

        date_default_timezone_set('America/Sao_Paulo');

        // Obtém as datas de hoje e da semana passada
        $today = date('Y-m-d 23:59:59'); // Data final às 23:59:59
        $lastWeek = date('Y-m-d 00:00:00', strtotime('-7 days')); // Data inicial às 00:00:00

        // Busca todos os clientes com tarefas nos últimos 7 dias
        $clientsId = Task::select('clientId')
            ->distinct()
            ->whereBetween('taskDate', [$lastWeek, $today])
            ->get();

        // Recalcular os totais de cores
        $totalVerde = 0;
        $totalAmarelo = 0;
        $totalVermelho = 0;

        $tasks = [];

        // Loop para passar por todos os clientes
        foreach ($clientsId as $clientId) {

            $verificaGrupo = Client::select('groups')
                ->where('idAuvo', '=', $clientId->clientId)
                ->first();



            // Verifica se o grupo 111754 está presente na lista de grupos do cliente
            if ($verificaGrupo && strpos($verificaGrupo->groups, '111754') !== false) {
                // Buscar última data de atendimento
                $lastDate = Task::select('taskDate')
                    ->where('clientId', '=', $clientId->clientId)
                    ->orderBy('taskDate', 'desc')
                    ->first();

                // Buscar todos os atendimentos para esse cliente na última data
                $services = Task::select()
                    ->where('clientId', '=', $clientId->clientId)
                    ->where('taskDate', '=', $lastDate->taskDate)
                    ->get();

                $listaStatus = []; // Inicialize o array antes do loop foreach

                foreach ($services as $service) {
                    $statusAtendimentos = Questionarie::where('taskId', $service->auvoId)
                        ->where(function ($query) {
                            $query->where('questionDescription', 'STATUS GERAL DO GRUPO GERADOR')
                                ->orWhere('questionDescription', 'Status geral do gerador')
                                ->orWhere('questionDescription', 'Status geral do grupo gerador e QTA')
                                ->orWhere('questionDescription', 'Status geral dos equipamentos (Farol)')
                                ->orWhere('questionDescription', 'Status geral do equipamento (Farol)');
                        })
                        ->get() // Use get() para obter todas as colunas
                        ->map(function ($item) {
                            return mb_strtolower($item->reply, 'UTF-8'); // Acesse a coluna 'reply' de cada item e aplique mb_strtolower()
                        })
                        ->toArray(); // Converta a coleção para um array simples

                    // Adicione o array de status ao array $listaStatus
                    $listaStatus = array_merge($listaStatus, $statusAtendimentos);
                }

                // Verifique os status obtidos
                if (in_array("inoperante", $listaStatus)) {
                    $totalVermelho++;
                    $service->statusFarol = 'inoperante';
                } elseif (in_array("operando com restrição", $listaStatus)) {
                    $totalAmarelo++;
                    $service->statusFarol = 'operando com restrição';
                } else {
                    $totalVerde++;
                    $service->statusFarol = 'operando normalmente';
                }

                // Busca os dados do cliente
                $dadosCliente = Client::select('razaoSocial', 'nome')
                    ->where('idAuvo', '=', $clientId->clientId)
                    ->first();

                if ($dadosCliente) {
                    $service->razaoSocial = $dadosCliente->razaoSocial;
                    $service->nome = $dadosCliente->nome;
                } else {
                    $service->razaoSocial = "Sem cliente cadastrado";
                    $service->nome = "Sem cliente cadastrado";
                }

                $tasks[] = $service; // Adiciona o resultado ao array $tasks
            }
        }

        return view(
            'Admin.farolFiltroCarrefour',
            [
                'tasks' => $tasks,
                'totalVerde' => $totalVerde,
                'totalAmarelo' => $totalAmarelo,
                'totalVermelho' => $totalVermelho,
            ]
        );
    }



    public function atualizaFarolFiltroCarrefour(Request $request)
    {
        $inicio = $request->input('dataInicio');
        $fim = $request->input('dataFim');


        $dataInicio = explode('/', $inicio);
        $dataInicio = $dataInicio[2] . '-' . $dataInicio[1] . '-' . $dataInicio[0] . ' 00:00:00';

        $dataFim = explode('/', $fim);
        $dataFim = $dataFim[2] . '-' . $dataFim[1] . '-' . $dataFim[0] . ' 23:59:59';


        $clientsId = Task::select('clientId')
            ->distinct()
            ->whereBetween('taskDate', [$dataInicio, $dataFim])
            ->get();

        // Recalcular os totais de cores
        $totalVerde = 0;
        $totalAmarelo = 0;
        $totalVermelho = 0;

        $tasks = [];


        //loop para passar por todos os clientes
        foreach ($clientsId as $clientId) {

            $verificaGrupo = Client::select('groups')
                ->where('idAuvo', '=', $clientId->clientId)
                ->first();


            // Verifica se o grupo 111754 está presente na lista de grupos do cliente
            if ($verificaGrupo && strpos($verificaGrupo->groups, '111754') !== false) {

                //buscar última data de atendimento
                $lastDate = Task::select('taskDate')
                    ->where('clientId', '=', $clientId->clientId)
                    ->orderBy('taskDate', 'desc')
                    ->first();

                //buscar todos os atendimentos para esse cliente na ultima data
                $services = Task::select()
                    ->where('clientId', '=', $clientId->clientId)
                    ->where('taskDate', '=', $lastDate->taskDate)
                    ->get();

                $listaStatus = []; // Inicialize o array antes do loop foreach

                foreach ($services as $service) {
                    $statusAtendimentos = Questionarie::where('taskId', $service->auvoId)
                        ->where(function ($query) {
                            $query->where('questionDescription', 'STATUS GERAL DO GRUPO GERADOR')
                                ->orWhere('questionDescription', 'Status geral do gerador')
                                ->orWhere('questionDescription', 'Status geral do grupo gerador e QTA')
                                ->orWhere('questionDescription', 'Status geral dos equipamentos (Farol)')
                                ->orWhere('questionDescription', 'Status geral do equipamento (Farol)');
                        })
                        ->get() // Use get() para obter todas as colunas
                        ->map(function ($item) {
                            return mb_strtolower($item->reply, 'UTF-8'); // Acesse a coluna 'reply' de cada item e aplique mb_strtolower()
                        })
                        ->toArray(); // Converta a coleção para um array simples

                    // Adicione o array de status ao array $listaStatus
                    $listaStatus = array_merge($listaStatus, $statusAtendimentos);
                }

                // Verifique os status obtidos
                if (in_array("inoperante", $listaStatus)) {
                    $totalVermelho++;
                    $service->statusFarol = 'inoperante';
                } elseif (in_array("operando com restrição", $listaStatus)) {
                    $totalAmarelo++;
                    $service->statusFarol = 'operando com restrição';
                } else {
                    $totalVerde++;
                    $service->statusFarol = 'operando normalmente';
                }

                //busca os dados do cliente
                $dadosCliente = Client::select('razaoSocial', 'nome')
                    ->where('idAuvo', '=', $clientId->clientId)
                    ->first();

                if ($dadosCliente) {
                    $service->razaoSocial = $dadosCliente->razaoSocial;
                    $service->nome = $dadosCliente->nome;
                } else {
                    $service->razaoSocial = "Sem cliente cadastrado";
                    $service->nome = "Sem cliente cadastrado";
                }

                $service->dataAtendimento = $service->created_at->format('d/m/Y');

                $tasks[] = $service; // Adiciona o resultado ao array $tasks

            }
        }
        return response()->json([
            'tasks' => $tasks,
            'totalVerde' => $totalVerde,
            'totalAmarelo' => $totalAmarelo,
            'totalVermelho' => $totalVermelho,

        ]);
    }

    public function montaFarol()
    {
        $semaphores = Semaphore::select()->get();

        foreach ($semaphores as $semaphore) {
            $semaphore->delete();
        }

        // Busca todos os clientes com tarefas
        $clientsId = Task::select('clientId')->distinct()->get();

        foreach ($clientsId as $clientId) {

            // Buscar última data de atendimento
            $task = Task::select('tasks.clientId', 'tasks.taskDate', 'tasks.auvoId', 'tasks.type', 'tasks.created_at', 'clients.razaoSocial', 'clients.nome', 'clients.groups', 'tasks.obs')
                ->join('clients', 'tasks.clientId', '=', 'idAuvo')
                ->where('tasks.clientId', '=', $clientId->clientId)
                ->orderBy('tasks.created_at', 'desc')
                ->first();

            // Verifica se $task não é nulo antes de prosseguir com a busca por $questionarie
            if ($task !== null) {
                $questionarie =  Questionarie::where('taskId', $task->auvoId)
                    ->where(function ($query) {
                        $query->where('questionDescription', 'STATUS GERAL DO GRUPO GERADOR')
                            ->orWhere('questionDescription', 'Status geral do gerador')
                            ->orWhere('questionDescription', 'Status geral do grupo gerador e QTA')
                            ->orWhere('questionDescription', 'Status geral dos equipamentos (Farol)')
                            ->orWhere('questionDescription', 'Status geral do equipamento (Farol)');
                    })
                    ->first();

                // Verifica se $questionarie não é nulo antes de prosseguir
                if ($questionarie !== null) {
                    $auvoId = $task->auvoId;
                    $taskType = $task->type;
                    $taskMade = $task->taskDate;
                    $taskReplyId = $questionarie->replyId;
                    $taskReply = $questionarie->reply;
                    $taskStatus = $questionarie->reply;
                    $taskRazaoSocial = $task->razaoSocial;
                    $taskNome =  $task->nome;
                    $taskGroups = $task->groups;
                    $taskObs = $task->obs;

                    $entrada = new Semaphore();
                    $entrada->taskId = $auvoId;
                    $entrada->type = $taskType;
                    $entrada->made_at = $taskMade;
                    $entrada->replyId = $taskReplyId;
                    $entrada->reply = $taskReply;
                    $entrada->status = $taskStatus;
                    $entrada->razaoSocial = $taskRazaoSocial;
                    $entrada->nome = $taskNome;
                    $entrada->groups = $taskGroups;
                    $entrada->obs = $taskObs;
                    $entrada->save();
                } else {
                    // Se $questionarie for nulo, você pode lidar com essa situação aqui
                    echo "Não foi encontrado um questionário correspondente para taskId: $task->auvoId.";
                }
            } else {
                // Se $task for nulo, você pode lidar com essa situação aqui
                echo "Não foi encontrada uma tarefa correspondente para clientId: $clientId->clientId.";
            }
        }
    }


    public function farol5()
    {


        // Recalcular os totais de cores
        $totalVerde = 0;
        $totalAmarelo = 0;
        $totalVermelho = 0;

        $tasks = Semaphore::select()->get();

        foreach ($tasks as $task) {
            if (mb_strtolower($task->status === 'INOPERANTE')) {
                $totalVermelho++;
            } elseif (mb_strtolower($task->status) === 'operando com restrição') {
                $totalAmarelo++;
            } else {
                $totalVerde++;
            }
        }
/*
        var_dump($tasks);
 */


        return view(
            'Admin.farol4',
            [
                'tasks' => $tasks,
                'totalVerde' => $totalVerde,
                'totalAmarelo' => $totalAmarelo,
                'totalVermelho' => $totalVermelho,


            ]
        );
    }

    public function taskDodia(){

        $startDate = date('2024-05-16 00:00:01');
        $endDate = date('2024-05-16 23:59:59');
/*
        $startDate = date('Y-m-d 00:00:01');
        $endDate = date('Y-m-d 23:59:59'); */

        $tasks = Task::select('tasks.*','clients.groups', 'clients.nome')
        ->join('clients', 'clients.idAuvo', '=', 'tasks.clientId')
        ->whereBetween('taskDate', [$startDate, $endDate])
        ->get();

         // Array para armazenar todas as respostas
         $allAnswers = [];

         foreach ($tasks as $answer) {
             // Converte cada resposta para array e adiciona ao array principal
             $allAnswers[] = $answer->toArray();
         }

         // Converte o array de respostas para JSON
         $jsonAnswers = json_encode($allAnswers);

         // Imprime o JSON na tela
         echo $jsonAnswers;


    }
}
