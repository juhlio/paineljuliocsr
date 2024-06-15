<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Relatorio;
use App\Models\Imagemrelatorio;
use App\Models\Genset;
use App\Models\Atendimentoreport;
use App\Models\Obsatendimentoreport;
use App\Models\Locacaoavulsareport;
use App\Models\AtendimentoEntrega;
use App\Models\Maquina;
use App\Models\Image;
use Mail;
use App\Mail\NovoRelatorio;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Jobs\Enviaemail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DateTime;



use Illuminate\Http\Request;

class LocacoesController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');

    }


    public function index()
    {
        return view('Locacoes.home');
    }

    public function inicioAtendimento()
    {

        return view('Locacoes.inicioatendimento');
    }

    public function relatorioPm1($id)
    {
        $cliente  = Genset::select()
            ->join('clients', 'clients.id', '=', 'gensets.idCliente')
            ->where('gensets.id', $id)
            ->first();

        /* var_dump($cliente); */

        return view('Locacoes.pm1', [
            'cliente' => $cliente,
        ]);
    }

    public function processaPm1($id)
    {
        $nomeAutor = Auth::user()->name;



        $data = date('Y-m-d', strtotime(filter_input(INPUT_POST, 'data')));
        $atendimento = filter_input(INPUT_POST, 'atendimento');
        $quantidadeOleoLubrificante = filter_input(INPUT_POST, 'quantidadeOleoLubrificante');
        $modeloFiltroOleo = filter_input(INPUT_POST, 'modeloFiltroOleo');
        $quantidadeFiltroOleo = filter_input(INPUT_POST, 'quantidadeFiltroOleo');
        $modeloFiltroCombustivel = filter_input(INPUT_POST, 'modeloFiltroCombustivel');
        $quantidadeFiltroCombustivel = filter_input(INPUT_POST, 'quantidadeFiltroCombustivel');
        $modeloFiltroAgua = filter_input(INPUT_POST, 'modeloFiltroAgua');
        $quantidadeFiltroAgua = filter_input(INPUT_POST, 'quantidadeFiltroAgua');
        $modeloFiltroAr = filter_input(INPUT_POST, 'modeloFiltroAr');
        $quantidadeFiltroAr = filter_input(INPUT_POST, 'quantidadeFiltroAr');
        $tipo = filter_input(INPUT_POST, 'tipo');
        $kwh = filter_input(INPUT_POST, 'kwh');
        $horimetro = filter_input(INPUT_POST, 'horimetro');
        $colmeia = filter_input(INPUT_POST, 'colmeia');
        $aguaRadiador = filter_input(INPUT_POST, 'aguaRadiador');
        $obsAguaRadiador = filter_input(INPUT_POST, 'obsAguaRadiador');
        $aditivoArrefecedor = filter_input(INPUT_POST, 'aditivoArrefecedor');
        $obsAditivoArrefecedor = filter_input(INPUT_POST, 'obsAditivoArrefecedor');
        $oleoCarter = filter_input(INPUT_POST, 'oleoCarter');
        $obsOleoCarter = filter_input(INPUT_POST, 'obsOleoCarter');
        $mangotes = filter_input(INPUT_POST, 'mangotes');
        $obsMangotes = filter_input(INPUT_POST, 'obsMangotes');
        $preAquecimento = filter_input(INPUT_POST, 'preAquecimento');
        $obsPreAquecimento = filter_input(INPUT_POST, 'obsPreAquecimento');
        $limpezaSensorRotacao = filter_input(INPUT_POST, 'limpezaSensorRotacao');
        $obsLimpezaSensorRotacao = filter_input(INPUT_POST, 'obsLimpezaSensorRotacao');
        $vazamentoJuntas = filter_input(INPUT_POST, 'vazamentoJuntas');
        $obsVazamentoJuntas = filter_input(INPUT_POST, 'obsVazamentoJuntas');
        $nivelCombustivel = filter_input(INPUT_POST, 'nivelCombustivel');
        $obsNivelCombustivel = filter_input(INPUT_POST, 'obsNivelCombustivel');
        $filtroDeAr = filter_input(INPUT_POST, 'filtroDeAr');
        $obsFiltroDeAr = filter_input(INPUT_POST, 'obsFiltroDeAr');
        $correias = filter_input(INPUT_POST, 'correias');
        $obsCorreias = filter_input(INPUT_POST, 'obsCorreias');
        $gradesTampas = filter_input(INPUT_POST, 'gradesTampas');
        $obsGradesTampas = filter_input(INPUT_POST, 'obsGradesTampas');
        $baterias = filter_input(INPUT_POST, 'baterias');
        $reguladorDeTensao = filter_input(INPUT_POST, 'reguladorDeTensao');
        $obsReguladorDeTensao = filter_input(INPUT_POST, 'obsReguladorDeTensao');
        $bornes = filter_input(INPUT_POST, 'bornes');
        $obsBornes = filter_input(INPUT_POST, 'obsBornes');
        $tensaoContinuaCarregador = filter_input(INPUT_POST, 'tensaoContinuaCarregador');
        $ampereCarregador = filter_input(INPUT_POST, 'ampereCarregador');
        $tensaoContinuaAlternador = filter_input(INPUT_POST, 'tensaoContinuaAlternador');
        $ampereAlternador = filter_input(INPUT_POST, 'ampereAlternador');
        $f1F2 = filter_input(INPUT_POST, 'f1F2');
        $obsF1F2 = filter_input(INPUT_POST, 'obsF1F2');
        $f2F3 = filter_input(INPUT_POST, 'f2F3');
        $obsF2F3 = filter_input(INPUT_POST, 'obsF2F3');
        $f1F3 = filter_input(INPUT_POST, 'f1F3');
        $obsF1F3 = filter_input(INPUT_POST, 'obsF1F3');
        $frequencia = filter_input(INPUT_POST, 'frequencia');
        $pressaoOleo = filter_input(INPUT_POST, 'pressaoOleo');
        $temperaturaMotor = filter_input(INPUT_POST, 'temperaturaMotor');
        $vazamentosConexoes = filter_input(INPUT_POST, 'vazamentosConexoes');
        $obsVazamentosConexoes = filter_input(INPUT_POST, 'obsVazamentosConexoes');
        $ruidosAnormais = filter_input(INPUT_POST, 'ruidosAnormais');
        $obsRuidosAnormais = filter_input(INPUT_POST, 'obsRuidosAnormais');
        $densidadeFumaca = filter_input(INPUT_POST, 'densidadeFumaca');
        $obsDensidadeFumaca = filter_input(INPUT_POST, 'obsDensidadeFumaca');
        $limpezaSuperficial = filter_input(INPUT_POST, 'limpezaSuperficial');
        $obsLimpezaSuperficial = filter_input(INPUT_POST, 'obsLimpezaSuperficial');
        $testeEmCarga = filter_input(INPUT_POST, 'testeEmCarga');
        $obsTesteEmCarga = filter_input(INPUT_POST, 'obsTesteEmCarga');
        $estadoGeralEquipamento = filter_input(INPUT_POST, 'estadoGeralEquipamento');
        $obsGerais = filter_input(INPUT_POST, 'obsGerais');

        $kwhFormatado = str_replace(',', '.', $kwh);
        $horimeroFormatado = str_replace(',', '.', $horimetro);
        $tensaoContinuaAlternadorFormatada = str_replace(',', '.', $tensaoContinuaAlternador);
        $ampereAlternadorFormatado = str_replace(',', '.', $ampereAlternador);
        $tensaoContinuaCarregadorFormatado =  str_replace(',', '.', $tensaoContinuaCarregador);
        $ampereCarregadorFormatado = str_replace(',', '.', $ampereCarregador);
        $frequenciaFormatado = str_replace(',', '.', $frequencia);
        $pressaoOleoFormatado = str_replace(',', '.', $pressaoOleo);
        $temperaturaMotorFormatado = str_replace(',', '.', $temperaturaMotor);


        $relatorio = new Relatorio();
        $relatorio->idMaquina = $id;
        $relatorio->data = $data;
        $relatorio->atendimento = $atendimento;
        $relatorio->quantidadeOleoLubrificante = $quantidadeOleoLubrificante;
        $relatorio->modeloFiltroOleo = $modeloFiltroOleo;
        $relatorio->quantidadeFiltroOleo = $quantidadeFiltroOleo;
        $relatorio->modeloFiltroCombustivel = $modeloFiltroCombustivel;
        $relatorio->quantidadeFiltroCombustivel = $quantidadeFiltroCombustivel;
        $relatorio->modeloFiltroAgua = $modeloFiltroAgua;
        $relatorio->quantidadeFiltroAgua = $quantidadeFiltroAgua;
        $relatorio->modeloFiltroAr = $modeloFiltroAr;
        $relatorio->quantidadeFiltroAr = $quantidadeFiltroAr;
        $relatorio->tipo = $tipo;
        $relatorio->horimetro = $horimeroFormatado;
        $relatorio->kwh = $kwhFormatado;
        $relatorio->colmeia = $colmeia;
        $relatorio->aguaRadiador = $aguaRadiador;
        $relatorio->obsAguaRadiador = $obsAguaRadiador;
        $relatorio->aditivoArrefecedor = $aditivoArrefecedor;
        $relatorio->obsAditivoArrefecedor = $obsAditivoArrefecedor;
        $relatorio->oleoCarter = $oleoCarter;
        $relatorio->obsOleoCarter = $obsOleoCarter;
        $relatorio->mangotes = $mangotes;
        $relatorio->obsMangotes = $obsMangotes;
        $relatorio->preAquecimento = $preAquecimento;
        $relatorio->obsPreAquecimento = $obsPreAquecimento;
        $relatorio->limpezaSensorRotacao = $limpezaSensorRotacao;
        $relatorio->obsLimpezaSensorRotacao = $obsLimpezaSensorRotacao;
        $relatorio->vazamentoJuntas = $vazamentoJuntas;
        $relatorio->obsVazamentoJuntas = $obsVazamentoJuntas;
        $relatorio->nivelCombustivel = $nivelCombustivel;
        $relatorio->obsNivelCombustivel = $obsNivelCombustivel;
        $relatorio->filtroDeAr = $filtroDeAr;
        $relatorio->obsFiltroDeAr = $obsFiltroDeAr;
        $relatorio->correias = $correias;
        $relatorio->obsCorreias = $obsCorreias;
        $relatorio->gradesTampas = $gradesTampas;
        $relatorio->obsGradesTampas = $obsGradesTampas;
        $relatorio->baterias = $baterias;
        $relatorio->reguladorDeTensao = $reguladorDeTensao;
        $relatorio->obsReguladorDeTensao = $obsReguladorDeTensao;
        $relatorio->bornes = $bornes;
        $relatorio->obsBornes = $obsBornes;
        $relatorio->tensaoContinuaCarregador = $tensaoContinuaCarregadorFormatado;
        $relatorio->ampereCarregador = $ampereCarregadorFormatado;
        $relatorio->tensaoContinuaAlternador = $tensaoContinuaAlternadorFormatada;
        $relatorio->ampereAlternador = $ampereAlternadorFormatado;
        $relatorio->f1F2 = $f1F2;
        $relatorio->obsF1F2 = $obsF1F2;
        $relatorio->f2F3 = $f2F3;
        $relatorio->obsF2F3 = $obsF2F3;
        $relatorio->f1F3 = $f1F3;
        $relatorio->obsF1F3 = $obsF1F3;
        $relatorio->frequencia = $frequenciaFormatado;
        $relatorio->pressaoOleo = $pressaoOleoFormatado;
        $relatorio->temperaturaMotor = $temperaturaMotorFormatado;
        $relatorio->vazamentosConexoes = $vazamentosConexoes;
        $relatorio->obsVazamentosConexoes = $obsVazamentosConexoes;
        $relatorio->ruidosAnormais = $ruidosAnormais;
        $relatorio->obsRuidosAnormais = $obsRuidosAnormais;
        $relatorio->densidadeFumaca = $densidadeFumaca;
        $relatorio->obsDensidadeFumaca = $obsDensidadeFumaca;
        $relatorio->limpezaSuperficial = $limpezaSuperficial;
        $relatorio->obsLimpezaSuperficial = $obsLimpezaSuperficial;
        $relatorio->testeEmCarga = $testeEmCarga;
        $relatorio->obsTesteEmCarga = $obsTesteEmCarga;
        $relatorio->estadoGeralEquipamento = $estadoGeralEquipamento;
        $relatorio->obsGerais = $obsGerais;
        $relatorio->feitoPor = $nomeAutor;
        $relatorio->save();

        $criado = Relatorio::select()
            ->orderBy('created_at', 'desc')
            ->first();

        if ($_FILES['fotoMotor']['name']) {


            $foto = new Imagemrelatorio();
            $nomefotocapa = $criado->id . '_fotoMotor_'  . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/relatorios/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoMotor']['tmp_name'], $nomefotocapacompleto);

            $foto->idRelatorio = $criado->id;
            $foto->url = $nomefotocapa;
            $foto->posicao = '1';
            $foto->save();
        };

        if ($_FILES['fotoCabinado']['name']) {


            $foto = new Imagemrelatorio();
            $nomefotocapa = $criado->id . '_fotoCabinado_'  . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/relatorios/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoCabinado']['tmp_name'], $nomefotocapacompleto);

            $foto->idRelatorio = $criado->id;
            $foto->url = $nomefotocapa;
            $foto->posicao = '2';
            $foto->save();
        };

        if ($_FILES['fotoGeral']['name']) {


            $foto = new Imagemrelatorio();
            $nomefotocapa = $criado->id . '_fotoGeral_'  . date('dmYHis') . '.jpeg';
            $diretorio = "assets/images/relatorios/";
            $nomefotocapacompleto = $diretorio . $nomefotocapa;
            move_uploaded_file($_FILES['fotoGeral']['tmp_name'], $nomefotocapacompleto);

            $foto->idRelatorio = $criado->id;
            $foto->url = $nomefotocapa;
            $foto->posicao = '3';
            $foto->save();
        };

        $url = route('detalherelatorio', $criado->id);

        $body = [
            'url_a' => $url,
            'name' => 'Sena',
            'to' => 'sena@essencialenergia.com'
        ];

        Enviaemail::dispatch($body);

        return redirect()->route('detalherelatorio', $criado->id);
    }

    public function listarelatorios()
    {

        $relatorios = DB::table('relatorios')
            ->join('gensets', 'gensets.id', '=', 'relatorios.idMaquina')
            ->join('clients', 'clients.id', '=', 'gensets.idCliente')
            ->select(
                'relatorios.id',
                'relatorios.data',
                'relatorios.tipo',
                'gensets.identificacao',
                'clients.nome'
            )
            ->orderBy('relatorios.id', 'desc')
            ->get();

        return view(
            'Locacoes.listarelatorios',
            [
                'relatorios' => $relatorios,
            ]
        );
    }

    public function detalherelatorio($id)
    {
        $relatorio = Relatorio::select()
            ->join('gensets', 'gensets.id', '=', 'relatorios.idMaquina')
            ->join('clients', 'clients.id', '=', 'gensets.idCliente')
            ->where('relatorios.id', $id)
            ->first();

        $foto1 = Imagemrelatorio::select()
            ->where('idRelatorio', $id)
            ->where('posicao', '1')
            ->first();

        $foto2 = Imagemrelatorio::select()
            ->where('idRelatorio', $id)
            ->where('posicao', '2')
            ->first();

        $foto3 = Imagemrelatorio::select()
            ->where('idRelatorio', $id)
            ->where('posicao', '3')
            ->first();

        return view('Locacoes.detalherelatorio', [
            'relatorio' => $relatorio,
            'id' => $id,
            'foto1' => $foto1,
            'foto2' => $foto2,
            'foto3' => $foto3,
        ]);
    }

    public function relatorioAtendimento($id)
    {

        $relatorioAberto = AtendimentoReport::where('idEquip', $id)
            ->where('statusRelatorio', '<>', 4)
            ->get();



        if ($relatorioAberto->count() > 0) {
            return redirect()->route('detalhemaquina', $id)->with('error', 'Esse equipamento possui atendimento aberto. Não é possivel criar um novo no momento');
        } else {

            $cliente  = Genset::select()
                ->join('clients', 'clients.id', '=', 'gensets.idCliente')
                ->where('gensets.id', $id)
                ->first();

            return view('Locacoes.atendimento', [
                'cliente' => $cliente,
            ]);
        }
    }

    public function processaRelatorioAtendimento($id)
    {
        $feitoPor = Auth::user()->name;
        $endereco = filter_input(INPUT_POST, 'endereco');
        $tipoAtendimento = filter_input(INPUT_POST, 'tipoAtendimento');
        $horaChamadoFormat = filter_input(INPUT_POST, 'horaChamado');
        $horaChamado =  Carbon::createFromFormat('d-m-Y H:i', $horaChamadoFormat)->format('Y-m-d H:i');
        $tipoConexao = filter_input(INPUT_POST, 'tipoConexao');
        $caminhao = filter_input(INPUT_POST, 'caminhao');
        $seccaoCondutorTransportado = filter_input(INPUT_POST, 'seccaoCondutorTransportado');
        $lancesPorFaseTransportado = filter_input(INPUT_POST, 'lancesFaseTransportado');
        $lancesNeutroTransportado = filter_input(INPUT_POST, 'lancesNeutroTransportado');
        if (filter_input(INPUT_POST, 'horimetroInicial') == '') {
            $horimetroInicial = null;
        } else {
            $horimetroInicial = filter_input(INPUT_POST, 'horimetroInicial');
        }

        if (filter_input(INPUT_POST, 'horimetroFinal') == '') {
            $horimetroFinal = null;
        } else {
            $horimetroFinal = filter_input(INPUT_POST, 'horimetroFinal');
        }

        if (filter_input(INPUT_POST, 'kwhInicial') == '') {
            $kwhInicial = null;
        } else {
            $kwhInicial = filter_input(INPUT_POST, 'kwhInicial');
        }


        if (filter_input(INPUT_POST, 'kwhFinal') == '') {
            $kwhFinal = null;
        } else {
            $kwhFinal = filter_input(INPUT_POST, 'kwhFinal');
        }

        if (filter_input(INPUT_POST, 'seccaoCondutorUtilizado') == '') {
            $seccaoCondutorUtilizado = null;
        } else {
            $seccaoCondutorUtilizado = filter_input(INPUT_POST, 'seccaoCondutorUtilizado');
        }

        if (filter_input(INPUT_POST, 'lancesPorFaseUtilizado') == '') {
            $lancesPorFaseUtilizado = null;
        } else {
            $lancesPorFaseUtilizado = filter_input(INPUT_POST, 'lancesPorFaseUtilizado');
        }

        if (filter_input(INPUT_POST, 'lancesNeutroUtilizado') == '') {
            $lancesNeutroUtilizado = null;
        } else {
            $lancesNeutroUtilizado = filter_input(INPUT_POST, 'lancesNeutroUtilizado');
        }

        $chegadaGmgFormat = filter_input(INPUT_POST, 'chegadaGmg');
        $chegadaGmg =  Carbon::createFromFormat('d-m-Y H:i', $chegadaGmgFormat)->format('Y-m-d H:i');

        $inicioOperacaoFormat = filter_input(INPUT_POST, 'inicioOperacao');
        $inicioOperacao =  Carbon::createFromFormat('d-m-Y H:i', $inicioOperacaoFormat)->format('Y-m-d H:i');

        $terminoOperacao = filter_input(INPUT_POST, 'terminoOperacao');
        $obs = filter_input(INPUT_POST, 'obsGerais');

        if (filter_input(INPUT_POST, 'status') === 'Stand By') {
            $statusRelatorio = 1;
        } elseif (filter_input(INPUT_POST, 'status') === 'Aguardando COD') {
            $statusRelatorio = 2;
        } elseif (filter_input(INPUT_POST, 'status') === 'Gerador Ligado') {
            $statusRelatorio = 3;
        } else {
            $statusRelatorio = 4;
        }


        $relatorio = new AtendimentoReport();
        $relatorio->idEquip = $id;
        $relatorio->endereco = $endereco;
        $relatorio->tipoAtendimento = $tipoAtendimento;
        $relatorio->horaChamado = $horaChamado;
        $relatorio->tipoConexao = $tipoConexao;
        $relatorio->caminhao = $caminhao;
        $relatorio->seccaoCondutorTransportado = $seccaoCondutorTransportado;
        $relatorio->lancesPorFaseTransportado = $lancesPorFaseTransportado;
        $relatorio->lancesNeutroTransportado = $lancesNeutroTransportado;
        $relatorio->horimetroInicial = $horimetroInicial;
        $relatorio->horimetroFinal = $horimetroFinal;
        $relatorio->seccaoCondutorUtilizado = $seccaoCondutorUtilizado;
        $relatorio->lancesPorFaseUtilizado = $lancesPorFaseUtilizado;
        $relatorio->lancesNeutroUtilizado = $lancesNeutroUtilizado;
        $relatorio->kwhInicial = $kwhInicial;
        $relatorio->kwhFinal = $kwhFinal;
        $relatorio->chegadaGmg = $chegadaGmg;
        $relatorio->inicioOperacao = $inicioOperacao;
        $relatorio->terminoOperacao = $terminoOperacao;
        $relatorio->obs = $obs;
        $relatorio->statusRelatorio = $statusRelatorio;
        $relatorio->save();

        $idAtendimento = Atendimentoreport::latest('id')->first();
        $obsReport = 'Novo Status: ' . filter_input(INPUT_POST, 'status') . '  | Responsável: ' . $feitoPor;

        Obsatendimentoreport::create([
            'idAtendimento' => $idAtendimento->id,
            'obs' => 'Atendimento Criado | Responsável: ' . $feitoPor,
        ]);

        Obsatendimentoreport::create([
            'idAtendimento' => $idAtendimento->id,
            'obs' => $obsReport
        ]);

        if ($obs) {

            Obsatendimentoreport::create([
                'idAtendimento' => $idAtendimento->id,
                'obs' => $obs
            ]);
        }

        return redirect()->route('detalhemaquina', $id)->with('success', 'Atendimento Criado com sucesso!');
    }

    public function alteraAtendimento($id)
    {

        $dadosRelatorio = AtendimentoReport::where('id', $id)->first();

        return view('Locacoes.alteraAtendimento', [
            'dadosRelatorio' => $dadosRelatorio,
        ]);
    }

    public function processaAlteraAtendimento($id)
    {
        $feitoPor = Auth::user()->name;

        if (filter_input(INPUT_POST, 'status') === 'Stand By') {
            $statusRelatorio = 1;
        } elseif (filter_input(INPUT_POST, 'status') === 'Aguardando COD') {
            $statusRelatorio = 2;
            $relatorio = AtendimentoReport::findOrFail($id);

            $relatorio->statusRelatorio = $statusRelatorio;
            $relatorio->save();

            $obsReport = 'Novo Status: ' . filter_input(INPUT_POST, 'status') . ' | Responsável: ' . $feitoPor;
            Obsatendimentoreport::create([
                'idAtendimento' => $id,
                'obs' => $obsReport
            ]);

            $obs = filter_input(INPUT_POST, 'obsGerais');

            if ($obs) {

                Obsatendimentoreport::create([
                    'idAtendimento' => $id,
                    'obs' => $obs,
                ]);
            }
        } elseif (filter_input(INPUT_POST, 'status') === 'Gerador Ligado') {
            $statusRelatorio = 3;
            $horimetroInicial = filter_input(INPUT_POST, 'horimetroInicial');
            $kwhInicial = filter_input(INPUT_POST, 'kwhInicial');
            $seccaoCondutorUtilizado = filter_input(INPUT_POST, 'seccaoCondutorUtilizado');
            $lancesPorFaseUtilizado = filter_input(INPUT_POST, 'lancesPorFaseUtilizado');
            $lancesNeutroUtilizado = filter_input(INPUT_POST, 'lancesNeutroUtilizado');

            $relatorio = AtendimentoReport::findOrFail($id);

            $relatorio->statusRelatorio = $statusRelatorio;
            $relatorio->horimetroInicial = $horimetroInicial;
            $relatorio->kwhInicial = $kwhInicial;
            $relatorio->seccaoCondutorUtilizado = $seccaoCondutorUtilizado;
            $relatorio->lancesPorFaseUtilizado = $lancesPorFaseUtilizado;
            $relatorio->lancesNeutroUtilizado = $lancesNeutroUtilizado;

            $relatorio->save();


            $obsReport = 'Novo Status: ' . filter_input(INPUT_POST, 'status') . ' | Responsável: ' . $feitoPor;
            Obsatendimentoreport::create([
                'idAtendimento' => $id,
                'obs' => $obsReport
            ]);

            $obs = filter_input(INPUT_POST, 'obsGerais');

            if ($obs) {

                Obsatendimentoreport::create([
                    'idAtendimento' => $id,
                    'obs' => $obs,
                ]);
            }
        } else {
            $statusRelatorio = 4;
            $horimetroFinal = filter_input(INPUT_POST, 'horimetroFinal');
            $kwhFinal = filter_input(INPUT_POST, 'kwhFinal');
            $terminoOperacao = date("Y-m-d H:i:s");

            $relatorio = AtendimentoReport::findOrFail($id);
            $relatorio->statusRelatorio = $statusRelatorio;
            $relatorio->horimetroFinal = $horimetroFinal;
            $relatorio->terminoOperacao = $terminoOperacao;
            $relatorio->kwhFinal = $kwhFinal;

            $relatorio->save();


            $obsReport = 'Novo Status: ' . filter_input(INPUT_POST, 'status') . ' | Responsável: ' . $feitoPor;
            Obsatendimentoreport::create([
                'idAtendimento' => $id,
                'obs' => $obsReport
            ]);

            $obs = filter_input(INPUT_POST, 'obsGerais');

            if ($obs) {

                Obsatendimentoreport::create([
                    'idAtendimento' => $id,
                    'obs' => $obs,
                ]);
            }
        }

        $idMaquina = AtendimentoReport::where('id', $id)->first();

        if (filter_input(INPUT_POST, 'status') === 'Atendimento Finalizado') {
            return redirect()->route('detalhemaquina', $idMaquina->idEquip)->with('success', 'Atendimento Finalizado com sucesso!');
        } else {
            return redirect()->route('detalhemaquina', $idMaquina->idEquip)->with('success', 'Atendimento Alterado com sucesso!');
        }
    }

    public function relatorioLocacaoAvulsa($id)
    {

        return view('Locacoes.locacaoavulsa', [
            'id' => $id
        ]);
    }

    public function processaRelatorioLocacaoAvulsa(Request $request, $id)
    {


        $validatedData = $request->validate([
            'cliente' => ['required', 'max:200'],
            'endereco' => ['required', 'max:200'],
            'tipoConexao' => ['required', 'max:20'],
            'caminhao' => ['required', 'numeric'],
            'seccaoCondutorTransportado' => ['required', 'numeric'],
            'seccaoCondutorUtilizado' => ['required', 'numeric'],
            'lancesFaseTransportado' => ['required', 'numeric'],
            'lancesPorFaseUtilizado' => ['required', 'numeric'],
            'lancesNeutroTransportado' => ['required', 'numeric'],
            'lancesNeutroUtilizado' => ['required', 'numeric'],
            'horimetroInicial' => ['numeric', 'nullable'],
            'horimetroFinal' => ['numeric', 'nullable'],
            'kwhInicial' => ['numeric', 'nullable'],
            'kwhFinal' => ['numeric', 'nullable'],
            'chegadaGmg' => ['date_format:d-m-Y H:i', 'nullable'],
            'inicioOperacao' => ['date_format:d-m-Y H:i', 'nullable'],
            'terminoOperacao' => ['date_format:d-m-Y H:i', 'nullable'],

        ]);




        $locacaoavulsareport = new Locacaoavulsareport([
            'idEquip' => filter_input(INPUT_POST, 'idMaquina'),
            'cliente' => filter_input(INPUT_POST, 'cliente'),
            'endereco' => filter_input(INPUT_POST, 'endereco'),
            'tipoConexao' => filter_input(INPUT_POST, 'tipoConexao'),
            'caminhao' => filter_input(INPUT_POST, 'caminhao'),
            'seccaoCondutorTransportado' => filter_input(INPUT_POST, 'seccaoCondutorTransportado'),
            'lancesPorFaseTransportado' => filter_input(INPUT_POST, 'lancesFaseTransportado'),
            'lancesNeutroTransportado' => filter_input(INPUT_POST, 'lancesNeutroTransportado'),
            'seccaoCondutorUtilizado' => filter_input(INPUT_POST, 'seccaoCondutorUtilizado'),
            'lancesPorFaseUtilizado' => filter_input(INPUT_POST, 'lancesPorFaseUtilizado'),
            'lancesNeutroUtilizado' => filter_input(INPUT_POST, 'lancesNeutroUtilizado'),
            'horimetroInicial' => filter_input(INPUT_POST, 'horimetroInicial'),
            'kwhInicial' => filter_input(INPUT_POST, 'kwhInicial'),
            'chegadaGmg' => Carbon::createFromFormat('d-m-Y H:i', filter_input(INPUT_POST, 'chegadaGmg'))->format('Y-m-d H:i'),
            'inicioOperacao' => Carbon::createFromFormat('d-m-Y H:i', filter_input(INPUT_POST, 'inicioOperacao'))->format('Y-m-d H:i'),
            'obs' => filter_input(INPUT_POST, 'obs'),
            'statusRelatorio' => '1',
        ]);

        $locacaoavulsareport->save();
        return redirect()->route('detalhemaquina', $id)->with('success', 'Atendimento Criado com sucesso!');
    }

    public function finalizaLocacaoAvulsa($id)
    {
        $dadosRelatorio = Locacaoavulsareport::where('id', $id)->first();
        return view('Locacoes.finalizalocacaoavulsa', [
            'id' => $id,
            'dadosRelatorio' => $dadosRelatorio,

        ]);
    }

    public function processaFinalizaLocacaoAvulsa(Request $request, $id)
    {

        $validatedData = $request->validate([
            'horimetroFinal' => ['numeric', 'nullable'],
            'kwhFinal' => ['numeric', 'nullable'],
        ]);

        $idMaquina = Locacaoavulsareport::where('id', $id)->first();

        $locacaoavulsareport = Locacaoavulsareport::find($id);
        $locacaoavulsareport->horimetroFinal = $request->horimetroFinal;
        $locacaoavulsareport->kwhFinal = $request->kwhFinal;
        $locacaoavulsareport->statusRelatorio = 4;
        $locacaoavulsareport->save();

        return redirect()->route('detalhemaquina', $idMaquina->id)->with('success', 'Atendimento Finalizado com sucesso!');
    }

    public function relatorioEntrega($id)
    {
        $dadosEquip = Genset::find($id);


        return view('Locacoes.relatorioentrega', [
            'id' => $id,
            'dadosEquip' => $dadosEquip,
        ]);
    }


    public function processaRelatorioEntrega(Request $request, $id)
    {
        $data = $request->validate([
            'cliente' => ['required', 'string', 'max:255'],
            'data' => ['required', 'date_format:d-m-Y h:i'],
            'endereco' => ['required', 'string', 'max:255'],
            'responsavelEntrega' => ['required', 'string', 'max:255'],
            'recebidoPor' => ['required', 'string', 'max:255'],
            'caminhao' => ['required', 'integer', 'min:1', 'max:5'],
            'tamanhoEquipe' => ['required'],
            'nf' => ['integer', 'min:1'],
            'abastecimento' => ['string', 'min:1'],
        ]);

        $atendimento = new AtendimentoEntrega;
        $atendimento->id_maquina = $id;
        $atendimento->fabricante_motor = $request->input('motor');
        $atendimento->modelo_motor = $request->input('modeloMotor');
        $atendimento->serie_motor = $request->input('serieMotor');
        $atendimento->fabricante_alternador = $request->input('alternador');
        $atendimento->modelo_alternador = $request->input('modeloAlternador');
        $atendimento->serie_alternador = $request->input('serieAlternador');
        $atendimento->cliente = $data['cliente'];
        $atendimento->data = date('Y-m-d H:i:s', strtotime($data['data']));
        $atendimento->endereco = $data['endereco'];
        $atendimento->responsavel_entrega = $data['responsavelEntrega'];
        $atendimento->recebido_por = $data['recebidoPor'];
        $atendimento->caminhao = $data['caminhao'];
        $atendimento->tamanho_equipe = $data['tamanhoEquipe'];
        $atendimento->nf = $data['nf'];
        $atendimento->abastecimento = $data['abastecimento'];
        $atendimento->save();

        return redirect()->route('detalhemaquina', $id)->with('success', 'Atendimento Gravado com sucesso!');
    }

    public function listaAtendimentos()
    {

        $atendimentos = DB::table('atendimentoreports')
            ->select(
                'id',
                'endereco',
                'horaChamado',
                'tipoAtendimento',
                'statusRelatorio',
            )
            ->get();

        return view(
            'Locacoes.listaAtendimentos',
            [
                'atendimentos' => $atendimentos,
            ]
        );
    }

    public function detalheAtendimento($id)
    {

        $atendimento = Atendimentoreport::select()
            ->where('id', $id)
            ->first();

        $atualizacoes = Obsatendimentoreport::select()
            ->where('idAtendimento', $id)
            ->get();

        return view('Locacoes.detalheAtendimento', [
            'atendimento' => $atendimento,
            'id' => $id,
            'atualizacoes' => $atualizacoes,
        ]);
    }

    public function listamaquinas()
    {

        $maquinas =  Genset::select('gensets.*', 'clients.nome')
            ->join('clients', 'gensets.idCliente', '=', 'clients.id')
            ->where('clients.nome', 'ENEL')
            ->orderByRaw('gensets.created_at DESC')
            ->get();
        return view('Locacoes.maquinas', ['maquinas' => $maquinas]);
    }

    public function telaChamados()
    {

        return view('Locacoes.telachamados');
    }

    public function telaNovoChamado()
    {

        return view('Locacoes.telanovochamado');
    }

    public function novaMaquina()
    {
        return view('Locacoes.novaMaquina');
    }


    public function insereNovaMaquina(Request $request)
    {


        $dataNota = $request->input('dataNota');
        $dataNotaFormatada = DateTime::createFromFormat('d/m/Y', $dataNota);
        $valorNota = str_replace(',', '.', $request->input('valorNota'));

        $maquina = new Maquina;
        $maquina->nf = $request->input('nf');
        $maquina->valorNota = $valorNota;
        $maquina->dataNota = $dataNotaFormatada;
        $maquina->empresaCompra = $request->input('empresaCompra');
        $maquina->classificacaoFiscal = $request->input('classificacaoFiscal');
        $maquina->tipoEquipamento = $request->input('tipoEquipamento');
        $maquina->fabricanteEquipamento = $request->input('fabricanteEquipamento');
        $maquina->serieEquipamento = $request->input('serieEquipamento');
        $maquina->potencia = $request->input('potencia');
        $maquina->dataFabricacao = $request->input('dataFabricacao');
        $maquina->fabricanteMotor = $request->input('fabricanteMotor');
        $maquina->modeloMotor = $request->input('modeloMotor');
        $maquina->serieMotor = $request->input('serieMotor');
        $maquina->fabricanteAlternador = $request->input('fabricanteAlternador');
        $maquina->modeloAlternador = $request->input('modeloAlternador');
        $maquina->serieAlternador = $request->input('serieAlternador');
        $maquina->quantidadeOleo = $request->input('quantidadeOleo');
        $maquina->modeloFiltroCombustivel = $request->input('modeloFiltroCombustivel');
        $maquina->quantidadeFiltroCombustivel = $request->input('quantidadeFiltroCombustivel');
        $maquina->modeloFiltroSeparador = $request->input('modeloFiltroSeparador');
        $maquina->quantidadeFiltroSeparador = $request->input('quantidadeFiltroSeparador');
        $maquina->modeloFiltroAgua = $request->input('modeloFiltroAgua');
        $maquina->quantidadeFiltroAgua = $request->input('quantidadeFiltroAgua');
        $maquina->modeloFiltroOleo = $request->input('modeloFiltroOleo');
        $maquina->quantidadeFiltroOleo = $request->input('quantidadeFiltroOleo');
        $maquina->modeloFiltroAr = $request->input('modeloFiltroAr');
        $maquina->quantidadeFiltroAr = $request->input('quantidadeFiltroAr');
        $maquina->fabricanteModulo = $request->input('fabricanteModulo');
        $maquina->modeloModulo = $request->input('modeloModulo');
        $maquina->save();

        return redirect()->route('telaMaquinas')->with('success', 'Atendimento Gravado com sucesso!');
    }


    public function telaMaquinas()
    {

        $maquinas = Maquina::select()->get();


        return view('Locacoes.maquinas', ['maquinas' => $maquinas]);
    }

    public function detalheMaquinaLocacao($id)
    {




        $gmg = Maquina::select()
            ->where('id', $id)
            ->first();


        $images = Image::select()
            ->where('idGmg', $id)
            ->where('trash', 0)
            ->get();



        return view('Locacoes.detalhemaquina', [
            'dados' => $gmg,
            'id' => $id,
            'imagens' => $images

        ]);
    }

    public function telaInsereImagens($id)
    {

        return view('Locacoes.imagens', [
            'id' => $id,
        ]);
    }

    public function insereImagensMaquinasLocacoes(Request $request, $id)

    {
        // Verifica se foram enviadas imagens
        if ($request->hasFile('fotos')) {
            // Itera sobre cada imagem enviada
            foreach ($request->file('fotos') as $index => $foto) {
                // Salva a imagem no servidor
                $igmIdbd = Image::select()->orderby('id', 'desc')->first();
                $imgId = $igmIdbd->id + 1;
                $nomefotocapa = $imgId . '_' . $index . '_' . date('dmYHis') . '.jpeg';
                $diretorio = "assets/images/clients/";
                $nomefotocapacompleto = $diretorio . $nomefotocapa;
                $foto->move($diretorio, $nomefotocapa);

                // Cria um novo registro de imagem no banco de dados
                $imagem = new Image();
                $imagem->idGmg = $id;
                $imagem->url = $nomefotocapa;
                $imagem->save();
            }

            // Redireciona de volta para a página do equipamento ou outra página desejada
            return redirect()->route('detalheMaquinaLocacao', $id)->with('success', 'Imagens enviadas com sucesso!');
        } else {
            // Se não foram enviadas imagens, redireciona de volta com uma mensagem de erro
            return redirect()->back()->with('error', 'Nenhuma imagem foi enviada.');
        }
    }

    public function excluiImagem($id){

        $imagem = Image::select()->where('id', $id)->first();
        $imagem->trash = 1;
        $imagem->save();

        return redirect()->route('detalheMaquinaLocacao', $imagem->idGmg);


    }
}
