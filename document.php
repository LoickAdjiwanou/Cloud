<?php
    session_start();
    $_SESSION['nom'] = $_GET['personne'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" lang=fr/>
    <title>Upload-Document</title>
    <link rel="stylesheet" href="style4.css">
</head>
<body>
    <header class="haut">
        <p class="haut_gauche"><font size="8px">Importation de document</font></p>
        <p class="haut_droit1">
            <u><strong>Profil</strong></u><br/>
            Utilisateur: <?php echo $_GET['personne']; ?><br/>
        </p>
        <p class="haut_droit2">
            <?php echo'<img src="uploads/'.$_GET['personne'].'.'.'jpg'.' " width="120" height="120">';?>
        </p>
    </header>
    <br/><br/><br/>
    <main>
        <div class="principal">
            <u><font size="4px"><strong>Choisissez le fichier à importer</strong></font></u><br/><br/>
            <form method="post" action="" enctype="multipart/form-data">
                <label for="file">Document (pdf, docx, pptx)</label><br/><br/>
                <input type="file" name="doc" id="file"/><br/><br/><br/>
                <input type="submit" value="Importer"/>
            </form>
        </div>
        <div class="menu">
            <u><center><font size="3px"><strong>Importer un fichier</strong></font></center></u>
            <ul class="liens">
                <li><a class="li" href="<?php echo "image.php?personne=".$_SESSION['nom'].""?>">Fichier image </a>(png. jpeg, jpg, gif)</li>
                <li><a class="li" href="<?php echo "document.php?personne=".$_SESSION['nom'].""?>">Fichier document </a>(pdf, docx, pptx, txt)</li>
                <li><a class="li" href="<?php echo "musique.php?personne=".$_SESSION['nom'].""?>">Fichier musique </a>(mp3)</li>
                <li><a class="li" href="<?php echo "video.php?personne=".$_SESSION['nom'].""?>">Fichier video </a>(mp4)</li><br/>
                <li><a class="li" href="<?php echo "mon_cloud.php?personne=".$_SESSION['nom'].""?>">Mon cloud</a></li>
            </ul>
        </div>
    </main>
    <br/>
    <footer>
        <center><font size="2px">C2023 Copyright - All rights reserved</font></center>
    </footer>
</body>
</html> 
<?php
    require_once('connect.php');
    $taille = 0;
    $req=$bdd->prepare("INSERT INTO cloud2(utilisateur_inscrit, imag, musique, video, pdf, taille) VALUES(:ut, :im, :mu, :vi, :pd, :ta)");
    if(isset($_FILES['doc']) AND $_FILES['doc']['error']==0){
        if($_FILES['doc']['size']<=1000000000){
            $infosfichier=pathinfo($_FILES['doc']['name']);
            $extention_upload=$infosfichier['extension'];
            $exten_auto=array('pdf','docx','pptx', 'txt', 'PDF');
            if(in_array($extention_upload,$exten_auto)){
                move_uploaded_file($_FILES['doc']['tmp_name'],'documents/'.basename($_FILES['doc']['name']));
                $taille = $_FILES['doc']['size']/1024;
                $req->execute(array(
                    'ut' => $_GET['personne'],
                    'im' => '',
                    'mu' => '',
                    'vi' => '',
                    'pd' => $_FILES['doc']['name'],
                    'ta' => $taille
                ));
            }
        }
    }
?>