<?php
    include 'contato.class.php';
    $contato = new Contato();

    if(!empty($_GET['id'])) {
        $id = $_GET['id'];

        $info = $contato->getInfo($id);

        if(!empty($indo['email'])) {
            header("Location: index.php");
            exit;
        }
    } else {
        header("Location: index.php");
        exit;
    }
?>

<meta charset = "utf-8" />
<h1>Editar</h1>

<form method="POST" action="editar_submit.php">
    <input type="hidden" name="id" value="<?php echo $info['id']; ?>" />
    Nome:<br/>
    <input type="text" name="nome" value="<?php echo $info['nome']; ?>" /><br/><br/>

    E-mail:<br/>
    <input type="email" name="email" value="<?php echo $info['email']; ?>" /> <br/><br/>

    <input type="submit" value="Editar" />
</form>