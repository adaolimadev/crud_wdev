<?php 
    use \App\Entity\Vaga;
     use \App\Db\Pagination;

    //Verifica se existe algo do GET e atribui as variáveis $busca e $status
    $busca = array_key_exists('busca', $_GET) ? $_GET['busca'] : '';
    $status = array_key_exists('filtroStatus', $_GET) ? $_GET['filtroStatus'] : '';
    $where = null;

   if(!empty($busca)){
    $busca = htmlspecialchars($_GET['busca'], ENT_QUOTES, 'UTF-8');
   }
   if(!empty($status)){
    $status = htmlspecialchars($_GET['filtroStatus'], ENT_QUOTES, 'UTF-8');
   }

    if(isset($busca) || isset($status)){
        $status = in_array($status,['s','n'])? $status : '';
        
        //Adiciona a $busca e $status a um array de $condições
        $condicoes = [
            !empty($busca) ? 'titulo LIKE "%'.str_replace(' ','%',$busca).'%"' : null,
            !empty($status) ? 'ativo = "'.$status.'"' : null
        ];

        //Caso não tenha filtro limpa as condições $busca e $status
        $condicoes = array_filter($condicoes);

        //Pega as condições adiciona a string $where colocando 'AND' entre as condições
        $where = implode(' AND ', $condicoes);
    }

    $qtdVagas = Vaga::getQtdVagas($where);

    $ObPagination = new Pagination($qtdVagas,$_GET['pagina'] ?? 1,5);
   

    //Chama o método getVagas() passando o $where por parametro
    $vagas = Vaga::getVagas($where,null,$ObPagination->getLimit(),'*');

    //Mensagem de sucesso ou erro acima do FORM
    $mensagem = '';
    if(isset($_GET['status']))
    {
        switch($_GET['status'])
        {
            case 'success':
                $mensagem= '<div class="alert alert-success">Ação realizada com sucesso!</div>';
                break;
            case 'error':
                $mensagem= '<div class="alert alert-danger">Ação não realizada!</div>';
                break;
        }
    }
 
    //Adiciona o resultado do getVagas() a uma variável $resultados juntamente com a confecção da tabela
    $resultados = '';
    foreach ($vagas as $vaga) {
        $resultados .='<tr>
                    <td>'.$vaga->id_vaga.'</td>
                    <td>'.$vaga->titulo.'</td>
                    <td>'.$vaga->descricao.'</td>
                    <td>'.($vaga->ativo =='s'? 'Ativa' : 'Inativa').'</td>
                    <td>'.date('d/m/Y à\s H:i:s', strtotime($vaga->data) ).'</td>
                    <td>
                        <a href = "editar.php?id_vaga='.$vaga->id_vaga.'">
                        <button type="button" class="btn btn-primary">Editar</button>
                        </a> 
                        <a href = "excluir.php?id_vaga='.$vaga->id_vaga.'">
                        <button type="button" class="btn btn-danger">Excluir</button>
                        </a>
                    </td>
                    </tr>';
}
    //Caso não tenha resultados retorna mensagem de vazio
    $resultados = !empty($resultados)? $resultados : '<tr> <td colspan="6" class="text-center">Nenhuma Vaga encontrada!</td> </tr>';

    //GETS (mantém os filtros enquanto navega entre as paginas)
    unset($_GET['status']);
    unset($_GET['pagina']);
    $gets = http_build_query($_GET);

    
    //Paginação
    $paginacao = '';
    $paginas = $ObPagination->getPages();
    foreach ($paginas as $key => $pagina) {
        $class = $pagina['atual'] ? 'btn-primary' : 'btn-light';
        $paginacao .='<a href="?pagina='.$pagina['pagina'].'&'.$gets.'">
                        <button type="button" class="btn '.$class.'">'.$pagina['pagina'].'</button>
                        </a>';
    }
?>


<main>
<?=$mensagem?>
    <section>
        <a href="cadastrar.php">
            <button class="btn btn-success">Nova Vaga</button>
        </a>
    </section>

    <section>
        <form action="" method="get">
            <div class="row my-4">
                <div class="col">
                    <label>Buscar por título</label>
                    <input type="text" name="busca" class="form-control" value="<?=$busca?>">
                </div>
                <div class="col">
                    <label>Status</label>
                    <select name="filtroStatus" class="form-select">
                        <option value="">Ativa/Inativa</option>
                        <option value="s" <?=$status == 's' ? 'selected' :''?>>Ativa</option>
                        <option value="n" <?=$status == 'n' ? 'selected' :''?>>Inativa</option>
                    </select>
                </div>
                <div class="col d-flex align-items-end">
                    <button type="submit" class="btn btn-primary" >Aplicar Filtros</button>
                </div>
            </div>
        </form>
    </section>

    <section>
        <table class="table bg-light mt-3 text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?=$resultados?>
            </tbody>
        </table>
    </section>

    <section>
        <?=$paginacao?>
    </section>

</main>