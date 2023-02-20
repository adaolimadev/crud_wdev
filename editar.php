<?php 
    require __DIR__.'/vendor/autoload.php';

    define('TITTLE', 'Editar Vaga');

    use \App\Entity\Vaga;

    //valida os dados do Get
    if(!isset($_GET['id_vaga']) or (!is_numeric($_GET['id_vaga']))){
        header('location: index.php?status=error');
        exit();
    }

    //Consulta a Vaga
    $ObVaga = Vaga::getVaga($_GET['id_vaga']);

    //Valida a Vaga
    if(!$ObVaga instanceof Vaga)
    {
        header('location: index.php?status=error');
        exit();
    }

    //Valida se os atributos existem
    if(isset($_POST['inputTitulo'], $_POST['inputDescricao'], $_POST['inputAtivo'])){
        
        $ObVaga->titulo = $_POST['inputTitulo'];
        $ObVaga->descricao = $_POST['inputDescricao'];
        $ObVaga->ativo = $_POST['inputAtivo'];
     
        $ObVaga->atualizar();

        header('location: index.php?status=success');
        
        exit;
    
    }

    include __DIR__.'/includes/header.php';
    include __DIR__.'/includes/formulario.php';
    include __DIR__.'/includes/footer.php';
?>