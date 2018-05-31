<?php
session_start();
function barMenu($etat){
if(empty($_SESSION['NouvelleSession'])){ ?>
<?php
}elseif($etat == 'etudiant'){
?>
  <li class="nav-item dropdown <?= isset($etudiant)? $etudiant: ''; ?>">
    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Espace étudiant
    </a>
    <div class="dropdown-menu dropright" aria-labelledby="navbarDropdownMenuLink">
      <a class="dropdown-item" href="espaceetudiant.php">
        Mon Espace
        </a>
      <a class="dropdown-item" href="#">
        Notes
      </a>
      <a class="dropdown-item" href="#">
        Emploi du temps
      </a>
      <a class="dropdown-item" href="#">
        Projets tuteurés
      </a>
      <a class="dropdown-item" href="#">
        Offres d/alternance</a>
      <a class="dropdown-item" href="#">
        Support de cours
      </a>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link <?= isset($deconnexion)? $deconnexion: ''; ?>"  href="deconnexion.php">
      Deconnexion
    </a>
  </li>
<?php
}elseif ($etat == 'entreprise') { ?>
      <li class="nav-item dropdown <?= isset($entreprise)? $entreprise: ''; ?>">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Espace entreprise
        </a>
        <div class="dropdown-menu dropright" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Projet tuteuré
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="add_projet_tut.php">
              Ajouter un projet tuteuré
            </a>
            <a class="dropdown-item" href="#">
              Consulter ses projets tuteurés
            </a>
          </div>
          <a class="dropdown-item dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Offre d'alternance
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">
              Ajouter une offre d'alternance
            </a>
            <a class="dropdown-item" href="#">
              Consulter ses offres d'alternances
            </a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= isset($deconnexion)? $deconnexion: ''; ?>" href="deconnexion.php">
          Deconnexion
        </a>
      </li>
<?php
}elseif($etat == 'enseignant'){ ?>
  <li class="nav-item dropdown <?= isset($enseignant)? $enseignant: ''; ?>">
    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Espace enseignant
    </a>
    <div class="dropdown-menu dropright" aria-labelledby="navbarDropdownMenuLink">
      <a class="dropdown-item dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Notes
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="#">
          Ajouter une note
        </a>
        <a class="dropdown-item" href="#">
          Consulter ses notes déposées
        </a>
      </div>
      <a class="dropdown-item" href="#">
        Emploi du temps personnel
      </a>
      <a class="dropdown-item dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Support de cours
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
        <a class="dropdown-item" href="#">
          Ajouter un support de cours
        </a>
        <a class="dropdown-item" href="#">
          Consulter ses supports de cours
        </a>
      </div>
    </div>
  </li>
  <a class="nav-link <?= isset($deconnexion)? $deconnexion: ''; ?>"  href="deconnexion.php">
    Deconnexion
  </a>
<?php
  }
}

include('includes/DB.php');
function connexionEspaceEtud(){
  $pdo = DB::get();
  if(isset($_POST['connexion'])){
      if(!empty($_POST['email']) && !empty($_POST['motdepasse'])){
      $Email= $_POST['email'];
      $Motdepasse= $_POST['motdepasse'];
      $req = $pdo->prepare("SELECT * FROM `utilisateurs` WHERE  email=:email AND mdp=:motdepasse");
      $req->execute(array(':email'=>$Email,
                          ':motdepasse'=>$Motdepasse));
      if($nb = $req->fetch()){
        $_SESSION['id'] = $nb['id_users'];
        $_SESSION['NouvelleSession'] = $nb['email'];
        $_SESSION['etat'] = $nb['etat'];
        if($_SESSION['etat'] == 'etudiant'){
        echo'<br/><div class="col-sm-8 text-center contentcenter"><div class="alert alert-success" role="alert">
         Vous avez bien été connecter ! Vous allez être rediriger dans 3 secondes.
     </div></div>';
        ?><script type='text/javascript'>
        window.setTimeout('location=("espaceetudiant.php");',3000);
        </script>
        <?php
        }elseif($_SESSION['etat'] == "enseignant"){
       echo'<br/><div class="col-sm-8 text-center contentcenter"><div class="alert alert-success" role="alert">
        Vous avez bien été connecter ! Vous allez être rediriger dans 3 secondes.
    </div></div>'; ?>
        <script type='text/javascript'>
    window.setTimeout('location=("espaceenseignant.php");',3000);
    </script><?php
     }
        ?>
        <?php
      }else{
                    echo"<br/><div class='col-sm-8 text-center contentcenter'><div class='alert alert-warning' role='alert'>
                      Vous n'existez pas dans la base !
                  </div></div>";
                }
                }else{
      echo'<br/><div class="col-sm-8 text-center contentcenter"><div class="alert alert-danger" role="alert">
    Tout les champs dovent etre remplis !
</div></div>';
    }
  }
}
function deconnexion(){
  session_unset ();
  session_destroy();
  ?><br/>
  <div class="col-sm-8 text-center contentcenter">
  <div class="alert alert-info" role="alert">
  Vous êtes à présent déconnecté, et serez rediriger dans 2 secondes
  </div>
</div>
  <script type='text/javascript'>
window.setTimeout('location=("authentification.php");',2000);
</script>

<?php
}
function ifIsConnected(){
  if(!empty($_SESSION['etat']) && $_SESSION['etat'] == "enseignant"){
  }elseif(!empty($_SESSION['etat']) && $_SESSION['etat'] == "etudiant"){
  }elseif(!empty($_SESSION['etat']) && $_SESSION['etat'] == "entreprise"){
  }elseif(!empty($_SESSION['etat']) && $_SESSION['etat'] == "personnel miaw") {
  }else{
    header("location:authentification.php");
  }
}
function notes(){
  $pdo= DB::get();
  $req = $pdo->prepare('SELECT notes,matieres FROM notes,utilisateurs WHERE notes.id_etudiant = utilisateurs.id_users AND notes.id_etudiant ='.$_SESSION["id"].'');
  $req->execute();
  $nb = $req->rowCount();
  //tableaux des notes
  if($nb > 0){
  echo'<table class="table">';
  echo'<tr><th>Matière</th>
      <th>Notes</th></tr>';
  while($row = $req->fetch()){
      echo'<tr><td>'.$row['matieres'].'</td><td>'.$row['notes'].'</td></tr>';
  }
      echo'</table>';
  }else{
    echo"Aucune notes dans la base.";
  }
}
?>
