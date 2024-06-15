<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;


use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ControleController;
use App\Http\Controllers\Admin\ComercialController;
use App\Http\Controllers\Admin\EstoqueController;
use App\Http\Controllers\Admin\LocacoesController;
use App\Http\Controllers\Admin\ComprasController;

use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\RegisterController;
use App\Http\Controllers\Authentication\PasswordController;
use App\Http\Controllers\Controller;
use App\Providers\AuthServiceProvider;
use App\Http\Controllers\CustomAuthController;




    Route::get('contatos', [ComercialController::class, 'inicioContatos'])->name('homeContatos');
    Route::get('contato/detalhe/{id}', [ComercialController::class, 'detalheContato'])->name('detalheContato');
    Route::get('prospeccoes/automatica', [ComercialController::class, 'inicioProspecoes'])->name('homeProspecoes');
    Route::get('prospeccao/automatica/detalhes/{contato}', [ComercialController::class, 'detalheDaProspeccao'])->name('detalheprospeccao');
    Route::post('prospeccao/automatica/detalhes/{contato}', [ComercialController::class, 'insereobsprospect']);
    Route::get('buscadecnpjenviada/{cidade}/{segmento}', [ComercialController::class, 'buscacnpjenviada'])->name('buscacnpjenviada');


    Route::get('prospecta', [ComercialController::class, 'formprospeccao'])->name('telaprospeccao');
    Route::post('prospecta', [ComercialController::class, 'processaprospeccao']);
    Route::get('prospeccaoenviada/{busca}/{email}', [ComercialController::class, 'prospeccaoenviada'])->name('prospeccaoenviada');

    Route::get('buscacnpjs', [ComercialController::class, 'formbuscacnpj'])->name('telabuscacnpj');
    Route::post('buscacnpjs', [ComercialController::class, 'buscaCnpj']);

    Route::get('filtrocnpj', [ComercialController::class, 'telafiltrocnpj'])->name('filtrocnpj');
    Route::post('filtrocnpj', [ComercialController::class, 'processafiltro']);
    Route::get('resultadofiltro/{cidade}/{seg}', [ComercialController::class, 'resultadofiltro'])->name('resultadofiltro');
    Route::get('resultadofiltro/download/{cidade}/{uf}/{seg}', [ComercialController::class, 'baixaplanilhaprospectos'])->name('baixaplanilhaprospectos');





    Route::get('revisao-cadastro', [ControleController::class, 'revisaoCadastro']);
    Route::post('revisao-cadastro', [ControleController::class, 'novaRevisao']);
    Route::get('clients', [ControleController::class, 'clients']);
    Route::get('client/{client}', [ControleController::class, 'clientdata']);
    Route::get('clientes', [ControleController::class, 'clientes'])->name('clientes');
    Route::get('clientes/detalhes/{client}', [ControleController::class, 'detalhescliente'])->name('detalhecliente');
    Route::get('clientes/altera/{client}', [ControleController::class, 'alteracliente'])->name('alteracliente');
    Route::post('clientes/altera/{client}', [ControleController::class, 'alteracaocliente']);
    Route::get('imagens/alteracao/{id}', [ControleController::class, 'alteracaoimagem'])->name('alteracaoimagem');
    Route::post('imagens/alteracao/{id}', [ControleController::class, 'processaimagem']);
    Route::get('maquinas', [ControleController::class, 'listamaquinas'])->name('listamaquinas');
    Route::get('maquinas/detalhes/{maquina}', [ControleController::class, 'detalhemaquina'])->name('detalhemaquina');
    Route::get('maquinas/alterar/{maquina}', [ControleController::class, 'telaAlteramaquina'])->name('alteramaquina');
    Route::post('maquinas/alterar/{maquina}', [ControleController::class, 'processaAlteracaoMaquina']);
    Route::get('maquinas/monitoramento/{maquina}', [ControleController::class, 'telamonitoramento'])->name('telamonitoramento');



    Route::get('estoque', [EstoqueController::class, 'index'])->name('homeestoque');
    Route::get('estoque/novoproduto', [EstoqueController::class, 'novoProduto'])->name('novoprodutoestoque');
    Route::post('estoque/novoproduto', [EstoqueController::class, 'criaProduto']);

    Route::get('estoque/detalheproduto/{produto}', [EstoqueController::class, 'detalheProduto'])->name('detalheproduto');
    Route::get('estoque/alteraproduto/{produto}', [EstoqueController::class, 'alteraProduto'])->name('alteraproduto');
    Route::post('estoque/alteraproduto/{produto}', [EstoqueController::class, 'salvaAlteracaoProduto']);
    Route::get('estoque/imagens/alteracao/{id}', [EstoqueController::class, 'alteracaoimagem'])->name('alteracaoimagemproduto');
    Route::post('estoque/imagens/alteracao/{id}', [EstoqueController::class, 'processaimagem']);
    Route::get('estoque/entradaproduto/{produto}', [EstoqueController::class, 'entradaProduto'])->name('entradaproduto');
    Route::post('estoque/entradaproduto/{produto}', [EstoqueController::class, 'processaEntrada']);

    Route::get('estoque/saidaproduto/{produto}', [EstoqueController::class, 'saidaProduto'])->name('saidaproduto');
    Route::post('estoque/saidaproduto/{produto}', [EstoqueController::class, 'processaSaida']);

    Route::get('estoque/total', [EstoqueController::class, 'telaTotalEstoque'])->name('telaTotalEstoque');
    Route::get('estoque/baixar', [EstoqueController::class, 'exportaProdutos'])->name('exportaEstoque');

    Route::get('estoque/movimentacoes', [EstoqueController::class, 'telamovimentacoes'])->name('telamovimentacoes');
    Route::get('estoque/entradaxml', [EstoqueController::class, 'telaEntradaXml'])->name('telaEntradaXml');
    Route::post('estoque/entradaxml', [EstoqueController::class, 'processaEntradaXml']);
    Route::post('estoque/entradaviaxml', [EstoqueController::class, 'finalizaEntradaXml'])->name('finalizaEntradaXml');
    Route::get('estoque/fechamentodiario', [EstoqueController::class, 'telaFechamentoDiario'])->name('telaFechamentoDiario');
    Route::get('estoque/retorno', [EstoqueController::class, 'telaRetorno'])->name('telaRetorno');
    Route::post('estoque/retorno', [EstoqueController::class, 'entradaLote']);
    Route::get('estoque/saidalote', [EstoqueController::class, 'telaSaidaLote'])->name('telaSaidaLote');
    Route::post('estoque/saidalote', [EstoqueController::class, 'saidaLote']);
    Route::get('exportamovimentacoes/{dataini}/{datafim}', [EstoqueController::class, 'exportaMovimentacoes'])->name('exportaMovimentacoes');


    Route::get('novocliente', [EstoqueController::class, 'novoCliente'])->name('novocliente');
    Route::post('novocliente', [ControleController::class, 'setNewClient']);


Route::post('compras/atualizavalor', [ComprasController::class, 'atualizaValor'])->name('atualizaValorRequisicao');
Route::get('estoque/listaprodutos', [EstoqueController::class, 'listaProdutos'])->name('listaProdutos');
Route::get('estoque/fechamento', [EstoqueController::class, 'fechamentoDiario']);
Route::get('estoque/atualizamovimentacoes', [EstoqueController::class, 'atualizaMovimentacoes'])->name('atualizaMovimentacoes');
Route::get('api/listacategoriasprodutos', [EstoqueController::class, 'listaCategoriasProdutos'])->name('listaCategoriasProdutos');
Route::get('api/listaprodutos', [EstoqueController::class, 'listaProdutosAuvo']);
Route::get('api/criaimgbase/{id}', [EstoqueController::class, 'criaImagemBase']);
Route::get('api/imagembase/{id}', [EstoqueController::class, 'imagemBase']);
Route::get('api/produto/{id}', [EstoqueController::class, 'prodJson'])->name('prodJson');
Route::get('api/cli', [ControleController::class, 'listaClientes'])->name('listaCli');
Route::get('api/syncStok', [EstoqueController::class, 'syncStok'])->name('syncStok');
Route::get('api/categorie/{id}', [EstoqueController::class, 'listCategorie']);
Route::get('api/sendrd', [EstoqueController::class, 'sendRd'])->name('sendRd');

//Route::get('api/setclient', [EstoqueController::class, 'setClientId'])->name('setClient');

Route::post('api/upreqcompra/{id}', [ComprasController::class, 'upProdRedCompra']);

Route::get('/', [HomeController::class, 'index'])->name('dashboard');


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'authenticate']);

Route::get('registro', [RegisterController::class, 'registro'])->name('registro');
Route::get('register', [RegisterController::class, 'registro']);
Route::post('register', [RegisterController::class, 'criar']);
Route::post('alterasenha', [RegisterController::class, 'processaalterasenha'])->name('processaalterasenha');


Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('cidadesibge', [HomeController::class, 'listaCidadesIbge'])->name('listaCidadesIbge');
Route::get('codigoibge/{cidade}', [HomeController::class, 'codigoIbge'])->name('codigoIbge');





    Route::get('enel', [LocacoesController::class, 'index'])->name('homelocacoes');
    Route::get('enel/chamados', [LocacoesController::class, 'telaChamados'])->name('telachamados');
    Route::get('enel/novochamado', [LocacoesController::class, 'telaNovoChamado'])->name('telaNovoChamado');



    Route::get('locacoes/inicio', [LocacoesController::class, 'inicioAtendimento']);

    Route::get('locacoes/relatorio/pm1/{id}', [LocacoesController::class, 'relatorioPm1'])->name('relatoriopm1');
    Route::post('locacoes/relatorio/pm1/{id}', [LocacoesController::class, 'processaPm1']);
    Route::get('locacoes/relatorios', [LocacoesController::class, 'listarelatorios'])->name('relatorioslocacao');
    Route::get('locacoes/relatorio/{id}', [LocacoesController::class, 'detalherelatorio'])->name('detalherelatorio');

    Route::get('locacoes/relatorio/atendimento/{id}', [LocacoesController::class, 'relatorioAtendimento'])->name('relatorioAtendimento');
    Route::post('locacoes/relatorio/atendimento/{id}', [LocacoesController::class, 'processaRelatorioAtendimento']);
    Route::get('locacoes/relatorio/atendimento/altera/{id}', [LocacoesController::class, 'alteraAtendimento'])->name('alteraAtendimento');
    Route::post('locacoes/relatorio/atendimento/altera/{id}', [LocacoesController::class, 'processaAlteraAtendimento']);

    Route::get('locacoes/atendimentos', [LocacoesController::class, 'listaAtendimentos'])->name('listaAtendimentos');
    Route::get('locacoes/atendimento/{id}', [LocacoesController::class, 'detalheAtendimento'])->name('detalheAtendimento');

    Route::get('locacoes/relatorio/avulso/{id}', [LocacoesController::class, 'relatorioLocacaoAvulsa'])->name('relatorioLocacaoAvulsa');
    Route::post('locacoes/relatorio/avulso/{id}', [LocacoesController::class, 'processaRelatorioLocacaoAvulsa']);

    Route::get('locacoes/relatorio/avulso/finalizacao/{id}', [LocacoesController::class, 'finalizaLocacaoAvulsa'])->name('finalizaLocacaoAvulsa');
    Route::post('locacoes/relatorio/avulso/finalizacao/{id}', [LocacoesController::class, 'processaFinalizaLocacaoAvulsa']);

    Route::get('locacoes/relatorio/entrega/{id}', [LocacoesController::class, 'relatorioEntrega'])->name('relatorioEntrega');
    Route::post('locacoes/relatorio/entrega/{id}', [LocacoesController::class, 'processaRelatorioEntrega']);

    Route::get('enel/maquinas', [LocacoesController::class, 'listamaquinas'])->name('maquinasEnel');







    Route::get('compras/requisicoes', [ComprasController::class, 'telaRequisicoes'])->name('telaRequisicoes');
    Route::post('compras/requisicoes', [ComprasController::class, 'processaRequisicao']);
    Route::get('compras', [ComprasController::class, 'index'])->name('telaCompras');
    Route::get('compras/requisicao/{id}', [ComprasController::class, 'detalheRequisicao'])->name('detalheRequisicao');
    Route::post('compras/requisicao/{id}', [ComprasController::class, 'insereObsReqCompra']);
    Route::post('compras/rejeitarequisicao/{id}', [ComprasController::class, 'rejeitaRequisicao'])->name('rejeitarequisicao');
    Route::post('compras/selecionaresponsavel/{id}', [ComprasController::class, 'selecionaResponsavel'])->name('selecionaresponsavel');





    Route::get('alterasenha', [RegisterController::class, 'alterasenha'])->name('alterasenha');

    Route::get('salacontrole/requisicoescompra', [ControleController::class, 'listaRequisicoes'])->name('telaListaRequisicoes');
    Route::get('salacontrole/requisicaocompra/{id}', [ControleController::class, 'telaRequisicaoCompra'])->name('telaRequisicaoCompra');



Route::get('farol', [ControleController::class, 'farol5'])->name('farol');
Route::get('farol/filtro', [ControleController::class, 'filtroFarol'])->name('filtroFarol');
Route::get('farol/filtro/atualizafiltro', [ControleController::class, 'atualizaFarolFiltro'])->name('atualizaFarolFiltro');

Route::get('farol/filtro/carrefour', [ControleController::class, 'filtroFarolCarrefour'])->name('filtroFarolCarrefour');
Route::get('farol/filtro/atualizafiltro/carrefour', [ControleController::class, 'atualizaFarolFiltroCarrefour'])->name('atualizaFarolFiltroCarrefour');

Route::get('farol/baixar', [ControleController::class, 'exportaFarol'])->name('exportaFarol');

Route::get('farol/filtro/baixar', [ControleController::class, 'exportaFarolFiltro'])->name('exportaFarolFiltro');

//Route::get('farol', [ControleController::class, 'farol'])->name('farol');

Route::get('baterias', [ControleController::class, 'baterias'])->name('baterias');
Route::get('farol2', [ControleController::class, 'farol']);

Route::get('farol4', [ControleController::class, 'farol4']);

Route::get('api/atendimentoauvo/{id}', [ControleController::class, 'atendimentoAuvo'])->name('atendimentoAuvo');
Route::get('api/saidasdatas', [EstoqueController::class, 'saidaData']);


Route::get('chamados/novo', [ControleController::class, 'novoChamado'])->name('novoChamado');
Route::post('chamados/novo', [ControleController::class, 'criaChamado']);
Route::get('chamados', [ControleController::class, 'listaChamados']);

Route::get('chamados/detalhe/{id}', [ControleController::class, 'detalheChamado'])->name('detalheChamado');

Route::get('api/novaordemsevico/{id}', [ControleController::class, 'novaOrdemServico'])->name('novaOrdemServico');
Route::get('chamados/atendimento/{id}', [ControleController::class, 'atendimentoChamado'])->name('atendimentoChamado');

route::get('semclientes', [ControleController::class, 'verificaCadastro'])->name('verificaCadastro');

route::get('locacoes/maquinas/nova', [LocacoesController::class, 'novaMaquina'])->name('novaMaquinaLocacao');
route::post('locacoes/maquinas/nova', [LocacoesController::class, 'insereNovaMaquina']);

route::get('locacoes/maquinas', [LocacoesController::class, 'telaMaquinas'])->name('telaMaquinas');
Route::get('locacoes/maquinas/detalhes/{maquina}', [LocacoesController::class, 'detalheMaquinaLocacao'])->name('detalheMaquinaLocacao');

route::get('locacoes/maquina/imagens/{maquina}', [LocacoesController::class, 'telaInsereImagens'])->name('telaInsereImagens');
route::post('locacoes/maquina/imagens/{maquina}', [LocacoesController::class, 'insereImagensMaquinasLocacoes'])->name('processaEnvioImagens');

route::get('locacoes/maquina/imagens/exlui/{imagem}', [LocacoesController::class, 'excluiImagem'])->name('excluiImagem');

route::get('api/semaphores', [ControleController::class, 'montaFarol']);
route::get( 'api/tasksdodia', [ControleController::class, 'taskDoDia']);

//rotas
