<?php 
   use \App\Entity\Vaga;


   //Cria uma instancia da classe e aciona o método getVagas()
   $vagas = Vaga::getVagas(null,null,null,'*');

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
 
   $resultados = '';

   foreach ($vagas as $vaga) {
    $resultados .='<tr>
                    <td>'.$vaga->id_vaga.'</td>
                    <td>'.$vaga->titulo.'</td>
                    <td>'.$vaga->descricao.'</td>
                    <td>'.($vaga->ativo =='s'? 'Ativo' : 'Inativo').'</td>
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
$resultados = !empty($resultados)? $resultados : '<tr> <td colspan="6" class="text-center">Nenhuma Vaga encontrada!</td> </tr>';
?>

<main>
<?=$mensagem?>
    <section>
        <a href="cadastrar.php">
            <button class="btn btn-success">Nova Vaga</button>
        </a>
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
                <?=$resultados ?>
            </tbody>
        </table>
    </section>

</main>