<?php 
    require __DIR__.'/vendor/autoload.php';

    define('TITTLE', 'Editar Vaga');

    use \App\Entity\Vaga;

    //Validação do ID
    if(!isset($_GET['id_vaga']) or (!is_numeric($_GET['id_vaga'])))
    {
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


    //Validação do post
    if(isset($_POST['excluir'])){
        
        $ObVaga->excluir();

        header('location: index.php?status=success');
        
        exit;
    }

    include __DIR__.'/includes/header.php';
    include __DIR__.'/includes/confirmar-exclusao.php';
    include __DIR__.'/includes/footer.php';
?>